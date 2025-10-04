<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function create()
    {
        activity()
            ->causedBy(auth()->user())
            ->log('Accessed page to create a new order.');

        return Inertia::render('Orders/Create', [
            'products' => Product::all()
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'products'   => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'integer|min:1',
            'status'     => 'required|string',
            'price'      => 'required|numeric|min:0',
            'date'       => 'required|date',
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'status'  => $validated['status'],
            'price'   => $validated['price'],
            'date'    => $validated['date'],
        ]);

        foreach ($validated['products'] as $product) {
            $order->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
            ]);
        }

        activity()
            ->causedBy($user)
            ->withProperties([
                'order_id' => $order->id,
                'amount'   => $order->price,
            ])
            ->log('Created a new order.');

        return redirect()->route('orders.index')
            ->with('status', 'Order created successfully.');
    }

    public function edit(Order $order)
    {
        $this->authorize('update', $order);

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['order_id' => $order->id])
            ->log('Accessed page to edit an order.');

        return Inertia::render('Orders/Edit', [
            'order'    => $order->load('products'),
            'products' => Product::all(),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'products'   => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'integer|min:1',
            'status'     => 'required|string',
            'price'      => 'required|numeric|min:0',
            'date'       => 'required|date',
        ]);

        $order->update([
            'status' => $validated['status'],
            'price'  => $validated['price'],
            'date'   => $validated['date'],
        ]);

        $order->products()->sync(
            collect($validated['products'])->mapWithKeys(function ($product) {
                return [$product['id'] => ['quantity' => $product['quantity']]];
            })
        );

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['order_id' => $order->id])
            ->log('Updated an order.');

        return redirect()->route('orders.index')
            ->with('status', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        $order->products()->detach();
        $order->delete();

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['order_id' => $order->id])
            ->log('Deleted an order.');

        return redirect()->route('orders.index')
            ->with('status', 'Order deleted successfully.');
    }
}
