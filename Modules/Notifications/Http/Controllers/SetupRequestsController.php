<?php

namespace Modules\Notifications\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe as StripeGateway;
use Omnipay\Omnipay;
use Modules\Notifications\Entities\SetupRequest;
class SetupRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $requests = SetupRequest::with("user")->orderBy("created_at", "desc")->get();
        return view('notifications::setup_requests.index', ["requests" => $requests]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('notifications::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('notifications::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('notifications::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkout(Request $request) {
        $paymentMethod = "stripe";
        if ($request->has("payment_method")) {
            $type = ["stripe", "paypal"];
            if (!in_array($request->payment_method, $type)) {
                return redirect()->back()->withErrors([
                    "msg" => "Not found type payment"
                ]);
            }
            $paymentMethod = $request->payment_method;
        } else {
            return redirect()->back()->withErrors([
                "msg" => "Not found payment method."
            ]);
        }
        $amount = (int) $request->amount;
        
        if ($paymentMethod == "stripe") {
            StripeGateway::setApiKey(config("services.stripe.secret"));
            $stripeSession = StripeSession::create([
                "payment_method_types" => ["card"],
                "line_items" => [[
                    "price_data" => [
                        "currency" => "usd",
                        "product_data" => [
                            "name" => "Setup & Configuration Service"
                        ],
                        "unit_amount" => $amount * 100,
                    ],
                    "quantity" => 1
                ]],
                "mode" => "payment",
                "success_url" => route("setup-request.checkout-success") . "?payment_method=stripe&session_id={CHECKOUT_SESSION_ID}",
                "cancel_url" => route("setup-request.checkout-cancel")
            ]);
            return redirect($stripeSession->url);
        } else if ($paymentMethod == "paypal") {
            $paypal = Omnipay::create('PayPal_Rest');
            $paypal->initialize([
                "clientId" => config("services.paypal.client_id"),
                "secret" => config("services.paypal.secret"),
                "testMode" => config("services.paypal.sandbox"),
                "brandName" => "InstructorsDash"
            ]);
            $response = $paypal->purchase([
                "amount" => $amount,
                "currency" => "usd",
                "description" => "SMS Service",
                "cancelUrl" => route('setup-request.checkout-cancel'),
                "returnUrl" => route("setup-request.checkout-success") . '?payment_method=paypal',
                "nofityUrl" => route('setup-request.checkout-notify')
            ])->send();
            if ($response->isRedirect()) {
                return redirect()->to($response->getRedirectUrl());
            } else {
                return redirect()->back()->withErrors([
                    "msg" => $response->getMessage()
                ]);
            }
        }
    }

    public function checkoutSuccess(Request $request) {
        $paymentMethod = $request->payment_method;
        if ($paymentMethod == "stripe") {
            StripeGateway::setApiKey(config("services.stripe.secret"));
            $payment = StripeSession::retrieve($request->session_id);
            if ($payment->status == "complete") {
                $amount = $payment->amount_total / 100;
                SetupRequest::create([
                    "user_id" => auth()->id(),
                    "amount" => $amount,
                    "payment_method" => $paymentMethod
                ]);
            } 
        } else if ($paymentMethod == "paypal") {
            $paypal = Omnipay::create("PayPal_Rest");
            $paypal->initialize([
                "clientId" => config("services.paypal.client_id"),
                "secret" => config("services.paypal.secret"),
                "testMode" => config("services.paypal.sandbox"),
                "brandName" => "InstructorsDash"
            ]);
            $response = $paypal->completePurchase([
                "payer_id" => $request->PayerID,
                "transactionReference" => $request->paymentId,
                "cancelUrl" => route('setup-request.checkout-cancel'),
                "returnUrl" => route("setup-request.checkout-success") . '?payment_method=paypal',
                "nofityUrl" => route('setup-request.checkout-notify')
            ])->send();
            if ($response->isSuccessful()) {
                $data = $response->getData();
                $amount = $data["transactions"][0]["amount"]["total"];
                SetupRequest::create([
                    "user_id" => auth()->id(),
                    "amount" => $amount,
                    "payment_method" => $paymentMethod
                ]);
            }
        }
        return redirect()->route("dashboard")->with("success", "Successfully purchased. please wait until administrator config the setup.");
    }

    public function checkoutCancel(Request $request) {
        return redirect()->route("dashboard")->withErrors([
            "msg" => "The payment charge operation was cancelled."
        ]);
    }

    public function checkoutNotify(Request $request) {

    }
}

