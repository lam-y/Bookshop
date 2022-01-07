<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        /*
         هي حالة اذا حدا حاول يدخل على صفحة تفاصيل الطلب عن طريق الرابط،
         يعني تغيير رقم الطلب بالرابط، وبهيك ممكن يدخل لطلب مو إلو ويعرف معلوماته، 
         هالشي طبعاً غلط، لذلك لازم نتأكد انه المستخدم الحالي هو نفسه المستخدم المسجل بالطلب، يعني بيحقله يشوفه
         */
        if(auth()->id() !== $order->user_id){      
            return back()->withError('You do not have access to this!');
        }

        $books = $order->books;

        return view('orders.show')->with([
            'order' => $order,
            'books' => $books,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}