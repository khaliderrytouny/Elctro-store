<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Cart;
use App\Models\Order;

class PaypalPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function handlePayment()
    {
        $data = [];
        $data['items'] = [];

        foreach (Cart::getContent() as $item) {
            array_push($data['items'], [
                'name' => $item->name,
                'price' => (int)($item->price / 9), // Adjust pricing if needed
                'desc' => $item->associatedModel->description,
                'qty' => $item->quantity
            ]);
        }

        $data['invoice_id'] = uniqid();
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('success.payment');
        $data['cancel_url'] = route('cancel.payment');
        
        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }
        $data['total'] = $total;
        
        $paypalModule = new ExpressCheckout;
        $response = $paypalModule->setExpressCheckout($data);
        $response = $paypalModule->setExpressCheckout($data, true);

        return redirect($response['paypal_link']);
    }

    public function paymentCancel()
    {
        return redirect()->route('cart.index')->with([
            'info' => 'Vous avez annulé le paiement'
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $paypalModule = new ExpressCheckout;
        $response = $paypalModule->getExpressCheckoutDetails($request->token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            foreach (Cart::getContent() as $item) {
                Order::create([
                    'user_id' => auth()->user()->id,
                    'product_name' => $item->name,
                    'qty' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->price * $item->quantity,
                    'paid' => 1
                ]);
            }
            Cart::clear();

            return redirect()->route('cart.index')->with([
                'success' => 'Paiement effectué avec succès'
            ]);
        }

        return redirect()->route('cart.index')->with([
            'error' => 'Erreur lors du paiement'
        ]);
    }
}
