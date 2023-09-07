<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommandeItem;
use Inertia\Inertia;
use Inertia\Response;

class CommandeItemController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        $items = $request->input('items');
        $totalAmount = $request->input('total_amount');
        $address = $request->input('address');
        $phone = $request->input('phone');
    
        // Save the order in the database
        $commande = Commande::create([
            'total_amount' => $totalAmount,
            'address' => $address,
            'phone' => $phone,
            'user_id' => $user->id,
        ]);
    
        // Insert order items into the `order_items` table
        foreach ($items as $item) {
            $commande->items()->create([
                'product_id' => $item['product']['id'],
                'quantity' => $item['quantity'],
            ]);
        }
    
        // Clear the cart
        session()->forget('cart');
    
        return redirect()->route('commandes.show', $commande)->with('success', 'Order placed successfully.');
    }
}
