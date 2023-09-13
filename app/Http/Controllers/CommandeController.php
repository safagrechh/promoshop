<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use App\Models\Commande;
use App\Models\User;
use App\Models\CommandeItem;
use Illuminate\Support\Facades\Storage;

use PDF;


use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function store(Request $request)
{
    try {
        $user = auth()->user();
        $items = $request->input('items');
        $totalAmount = $request->input('total_amount');
        $address = $request->input('address');
        $phone = $request->input('phone');

        Log::info('Request data:', $request->all());

        // Save the order in the database
        $commande = Commande::create([
            'total_amount' => $totalAmount,
            'address' => $address,
            'phone' => $phone,
            'user_id' => auth()->id(),
        ]);

        // Add order items
        foreach ($items as $item) {
            // Create CommandeItem records and associate them with the Commande
            $commandeItem = new CommandeItem([
                'product_id' => $item['product']['id'],
                'quantity' => $item['quantity'],
            ]);
            $commande->items()->save($commandeItem);
        }

        // Clear the cart
        session()->forget('cart');

        return redirect()->route('commandes.show', ['id' => $commande->id])->with('success', 'Order placed successfully.');

    } catch (\Exception $e) {
        // Log the error
        Log::error('Error in store method: ' . $e->getMessage());

        // Handle the error as needed
        // For debugging purposes, you can return the error message as a response
        return response()->json(['error' => 'An error occurred.'], 500);
    }
}

    
public function index()
{
    $cart = session()->get('cart', []);
    $cartData = [];

    foreach ($cart as $productId => $cartItem) {
        $cartData[] = [
            'product' => $cartItem['product'],
            'quantity' => $cartItem['quantity'],
        ];
    }

    return Inertia::render('Commandes/Checkout', [
        'cart' => $cartData,
    ]);
}

    public function show($id)
    {
        $commande = Commande::with('items.product')->findOrFail($id);

        return Inertia::render('Commandes/Show', [
            'commande' => $commande,
        ]);
    }

    public function showUserCommandes()
{
    $user = auth()->user();
    $commandes = $user->commandes;

    return Inertia::render('Commandes/UserCommandes', [
        'user' => $user,
        'commandes' => $commandes,
    ]);
}

public function generatePdf($commandeId)
{
    try {
        Log::info("Generating PDF for Commande ID: $commandeId");
        $commande = Commande::with('items')->findOrFail($commandeId);
      
        // Generate the PDF view with the commande data
        $pdf = PDF::loadView('pdfs.commande', ['commande' => $commande]);

        // Set the PDF filename (without path)
        $pdfFileName = "commande_{$commande->id}.pdf";

        // Store the PDF in the public storage's attachments folder
        Storage::disk('public')->put('attachments/'.$pdfFileName, $pdf->output());

        // Store the PDF path in the database
        $commande->update(['commande_pdf' => 'attachments/'.$pdfFileName]);

        // Return the PDF file path (public URL)
        $pdfFilePath = 'storage/attachments/'.$pdfFileName;
        Log::info('PDF generated successfully');

        return response()->json(['pdf_url' => asset($pdfFilePath)]);
    } catch (\Exception $e) {
        Log::error('Error generating PDF: ' . $e->getMessage());
        // Handle the error if needed
    }
}

}