<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;

class SaveForLaterController extends Controller
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
    public function show($id)
    {
        //
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

    /** ******************************************************************
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::instance('savedForLater')->remove($id);

        return back()->with('sucess', 'Book has been removed');
    }

    /** ******************************************************************
     * 
     */
    public function moveToCart($id){

        $book = Cart::instance('savedForLater')->get($id);

        Cart::instance('savedForLater')->remove($id);

        // check for duplicate in cart
        $duplicates = Cart::instance('default')->search(function($cartItem, $rowId) use($id){
            return $rowId === $id;
        });

        if($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with('success', 'Book is already in your cart');
        }

        Cart::instance('default')->add($book->id, $book->name, 1, $book->price)->associate('App\Book');

        return redirect()->route('cart.index')->with('success', 'Book has been moved to cart');
        
        //ملاحظة
        // انتبهي الى 
        //instance('default')->
        // لأني لما ما كتبتها، وحطيت بس 
        // cart 
        // ما نفذ وما اشتغل

        
    }
}
