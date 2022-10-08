<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\shopping;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PurchaseController extends Controller
{

    //  PAYPAL PAYMENT---------------

    private $provider;


    function __construct()
    {
        $this->provider = new PayPalClient();
        $this->provider->setApiCredentials(Config('paypal'));
        $token = $this->provider->getAccessToken();
        $this->provider->setAccessToken($token);
    }



    public function createPayment(Request $request)
    {
        $data = json_decode($request->getContent() , true);
        $books = User::find($data['userId'])->booksInCart;
        $total = 0;

        foreach ($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies;
        }

        $order = $this->provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => "USD",
                        'value' => $total,
                    ],
                    'description' => 'Order Description'
                ]
            ]
        ]);

        return response()->json($order);
    }



    public function executePayment(Request $request)
    {
        $data = json_decode($request->getContent() , true);
        $result = $this->provider->capturePaymentOrder($data['orderId']);

        if ($result['status' === 'COMPLETED']) {
            $user = User::find($data['userId']);
            $books = $user->booksInCart;
            $this->sendOrderConfirmationMail($books , auth()->user());

            foreach ($books as $book) {
                $bookPrice = $book->price;
                $purchaseTime = Carbon::now();
                $user->booksInCart()->updateExistingPivot($book->id, ['bought' => TRUE , 'price' => $bookPrice , 'created_at' => $purchaseTime]);
                $book->save();
            }
        }
        return response()->json($result);
    }



    // CASHIER CART PAYMENT -------------


    public function creditCheckout(Request $request)
    {
        $intent = auth()->user()->createSetupIntent();
        $userId = auth()->user()->id;
        $books = User::find($userId)->booksInCart;
        $total = 0;
        foreach ($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies; 
        }
        return view('credit.checkout' , compact('total' , 'intent'));
    }


    public function purchase(Request $request)
    {
        $user = $request->user();
        $paymentMethod = $request->input('payment_method');

        $userId = auth()->user()->id;
        $books = User::find($userId)->booksInCart;
        $total = 0;
        foreach ($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies; 
        }

        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->charge($total * 100 , $paymentMethod);
        } catch (\Exception $exception) {
            return back()->with('warning','An error occurred while purchasing the product, please check the card information' , $exception->getMessage());
        }

        $this->sendOrderConfirmationMail($books , auth()->user());

        foreach ($books as $book) {
            $bookPrice = $book->price;
            $purchaseTime = Carbon::now();
            $user->booksInCart()->updateExistingPivot($book->id, ['bought' => TRUE , 'price' => $bookPrice , 'created_at' => $purchaseTime]);
            $book->save();
        }
        return redirect('/cart')->with('message','Product purchased successfully');
    }


    // mail 

    public function sendOrderConfirmationMail($orders , $user)
    {
        Mail::to($user->email)->send(new OrderMail($orders , $user));
    }

    public function MyProduct()
    {
        $userId = auth()->user()->id;
        $myBooks = User::find($userId)->PurchedProduct;
        return view('project.myPurchases' , compact('myBooks'));
    }

    public function adminProduct()
    {
        $allBooks = shopping::with(['user' , 'book'])->where('bought' , true)->get();
        return view('admin.indexPurchases' , compact('allBooks'));
    }

}
