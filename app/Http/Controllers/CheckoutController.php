<?php

namespace App\Http\Controllers;

use Cart;
use App\Order;
//use Stripe;
use App\Country;
use Stripe_Error;
use App\OrderBook;
use App\Mail\OrderPlaced;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CheckoutRequest;
use Cartalyst\Stripe\Exception\CardErrorException;

class CheckoutController extends Controller
{

    /** *******************************************************************************************************
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = DB::table('countries')->orderby('name', 'asc')->get();
        
        return view('pages.checkout')->with([
            'discount' =>$this->getBillingValues()->get('discount'),
            'newSubtotal' => $this->getBillingValues()->get('newSubtotal'),
            'newTax' => $this->getBillingValues()->get('newTax'),
            'newTotal' => $this->getBillingValues()->get('newTotal'),
            
            'countries' => $countries,
        ]);
    }

    /** *******************************************************************************************************
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /** *******************************************************************************************************
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request)
    {
        //dd($request->all());
        
        // just get cart contents in string format
        $contents = Cart::content()->map(function($item){
            return $item->model->id.','.$item->qty;         // بدل الـ id هو بعت الـ name بس أنا لأنه الاسماء بالعربي صارت تطلع بموقع سترايب برموز غريبة غير مقروأة، مشان هيك بعتت الـ id
        })->values()->toJson();
        

        try {  
            /*     
            وقفته بس مشان اقدر اختبر تخزين الـ 
            order 
            بقاعدة البيانات

            $stripe = new \Stripe\StripeClient('sk_test_51I9tLWGoEG9rrfr09YbWAdmeFrtH8yUudJzixlB97P73NL18FCa4tu1ZP20focCFNVdkE4SIDrRwsuLsDERUVlJJ00v17RBEmI');
            $charge = $stripe->charges->create([
                'amount' => $this->getBillingValues()->get('newTotal') / 100,
                'currency' => 'USD',
                'source' => $request->stripeToken,
                'description' => 'Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    // change to Order ID after we start using DB
                    'contents' => $contents,        // because we don't have orders table now to send order id
                    'quantity' => Cart::instance('default')->count(),
                    'discount' => collect(session()->get('coupon'))->toJson,
                ],                
            ]);
            */

            // $chargeId = $charge['id'];

            // if($chargeId){
            //     //save order in orders table
            //}

            // helper method to insert into orders tables
            //$this->addToOrdersTables($request, null);           // error = null لأنه المفروض بهي المرحلة تكون تمت العملية بنجاح
            // غيرت شوي بالتابع وخليته يرجعلي الـ order
            // مشان ابعت بعض البيانات منها للايميل
            $order = $this->addToOrdersTables($request, null);            

            // send an email to the user
            Mail::send(new OrderPlaced($order));

            // SUCCESSFUL
            Cart::instance('default')->destroy(); 
            session()->forget('coupon');            // يعني ما ننسى نحذف الكوبون من الجلسة بعد ما تتم عملية الشراء
            return redirect()->route('confirmation.index')->with('success_message', 'Your payment has been successfully accepted');


        } catch (CardErrorException $e) {
            // Something else happened, completely unrelated to Stripe
            $this->addToOrdersTables($request, $e.getMessage());        // اذا طلع معنا خطأ، رح نخزن العملية مع رسالة الخطأ اللي طلعت

            return back()->withErrors('Error! '. $e.getMessage());

            // رحنا على ملفات شرح الـ 
            // cartalyst
            // وشفنا شو الـ exceptions 
            // اللي ممكن يطلعوا، واخترنا تبع الـ card
            // هادا بيطلع معي اذا كان في مشكلة بالكارد نفسها وكانت 
            // invalid
            
            // ملاحظة: فينا نختبر بطاقة خالصة لحتى نشوف اذا بيطلع لنا هالخطأ.. منلاقي هيك شي بصفحة 
            //testing 
            // تبع سترايب.. البطاقة الخالصة رقمها
            // 4000 0000 0000 0069

          }
    }

    /** *******************************************************************************************************
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /** *******************************************************************************************************
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /** *******************************************************************************************************
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /** *******************************************************************************************************
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /** *******************************************************************************************************
     * 
     */
    public function getBillingValues()
    {
        $tax = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;      // يعني اذا ما في خصم رح يرجع قيمة صفر
        $code = session()->get('coupon')['name'] ?? null;           // هادا مشان نخزنه بجدول الـ order
        $newSubtotal = (Cart::subtotal() - $discount);
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal + $newTax;

        return collect([
            'tax' => $tax,
            'discount' => $discount,
            'code' => $code,
            'newSubtotal' => $newSubtotal,
            'newTax' => $newTax,
            'newTotal' => $newTotal,
        ]);

    }

    /** ********************************************************************************
     * 
     */
    protected function addToOrdersTables($request, $error)
    {
        // Insert into orders table
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,        // يعني اذا كان المستخدم مسجل دخول منخزن رقمه، واذا كان مو مسجل دخول منخلي رقمه null
            'billing_name' => $request->name,
            'billing_email' => $request->email,
            'billing_address' => $request->address,
            'billing_country' => $request->country,
            'billing_city' => $request->city,
            'billing_postalcode' => $request->postalCode,
            'billing_phone' => $request->phone,
            'billing_name_on_card' => $request->name_on_card,
            'billing_discount' => $this->getBillingValues()->get('discount'),
            'billing_discount_code' => $this->getBillingValues()->get('code'),
            'billing_subtotal' => $this->getBillingValues()->get('newSubtotal'),
            'billing_tax' => $this->getBillingValues()->get('newTax'),
            'billing_total' => $this->getBillingValues()->get('newTotal'),
            'error' => $error,        // because there is not error in this case

        ]);            

        // Insert into order_book table
        foreach (Cart::content() as $item) {
            OrderBook::create([
                'order_id' => $order->id,
                'book_id' => $item->model->id,
                'quantity' => $item->qty,
            ]);
        }

        return $order;

    }
}
