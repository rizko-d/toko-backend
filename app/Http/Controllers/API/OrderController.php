<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()
            ->with(['orderItems.product', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|array',
            'billing_address' => 'required|array',
            'notes' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request) {
            $totalAmount = 0;
            $orderItems = [];

            // Calculate total and prepare order items
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                if (!$product->is_active) {
                    throw new \Exception("Product {$product->name} is not available");
                }

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                $itemTotal = $product->price * $item['quantity'];
                $totalAmount += $itemTotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $itemTotal,
                ];

                // Update stock
                $product->decrement('stock', $item['quantity']);
            }

            // Create order
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'shipping_cost' => 0, // Calculate shipping cost here
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }

            // Load relationships for response
            $order->load(['orderItems.product', 'user']);

            return response()->json([
                'success' => true,
                'data' => $order,
                'message' => 'Order created successfully'
            ], 201);
        });
    }

    public function show(Request $request, $id)
    {
        $order = $request->user()->orders()
            ->with(['orderItems.product', 'payment'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    public function cancel(Request $request, $id)
    {
        $order = $request->user()->orders()->findOrFail($id);

        if (!in_array($order->status, ['pending', 'paid'])) {
            return response()->json([
                'success' => false,
                'message' => 'Order cannot be cancelled'
            ], 400);
        }

        return DB::transaction(function () use ($order) {
            // Restore stock
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            $order->update(['status' => 'cancelled']);

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully'
            ]);
        });
    }
}
