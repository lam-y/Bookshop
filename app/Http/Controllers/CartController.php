<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Cart;
use Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.cart');
    }

    /** ***********************************************************************************
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /** ***********************************************************************************
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // بالأول رح نشوف اذا ضايفين هالعنصر من قبل على العربة، لأنه ساعتها ما في داعي نضيفه
        // التابع موجود متل ما هو بالـ documentation تبع المكتبة
        $duplicates = Cart::search(function($cartItem, $rowId) use($request){
            return $cartItem->id === $request->id;
        });

        if($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with('success', 'Book is already in your cart');
        }

        // شفنا شو المتغيرات المطلوبة بالتابع من 
        // documentation
        // المكتبة اللي استعملناها
        Cart::add($request->id, $request->name, 1, $request->price)->associate('App\Book');

        return redirect()->route('cart.index')->with('success', 'Book was added to your cart');

    }

    /** ***********************************************************************************
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /** ***********************************************************************************
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /** ***********************************************************************************
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // بدنا نحدد انه العدد الأقصى للنسخ اللي ممكن يشتريها الشخص من كتاب معين هي 100 كتاب مثلاً
        $validator = Validator::make($request->all(), [
            'qty' => 'required|numeric|between:1,100'
        ]);

        if($validator->fails()){
            session()->flash('errors', 'Quanitity must be between 1 and 100');
            return response()->json(['success' => false], 400);     // 400 = bad request in http requests code
        }


        Cart::update($id, $request->qty);

        session()->flash('success', 'Quantity was updated');

        // because it is AJax request we can't return route, we will return json response
        return response()->json(['success' => true]);
    }

    /** ***********************************************************************************
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);
        
        return back()->with('sucess', 'Book has been removed');
    }

    /** ***********************************************************************************
     * لتحويل الكتاب من عربة التسوق، الى عربة تانية بتحفظ الكتب اللي بدنا نشتريهن بعدين
     */
    public function switchToSaveForLater($id){
        $book = Cart::get($id);

        Cart::remove($id);

        // check for duplicate
        // يعني نختبر اذا كنا ضايفين العنصر من قبل لقائمة الـ 
        //saved for later
        $duplicates = Cart::instance('savedForLater')->search(function($cartItem, $rowId) use($id){
            return $rowId === $id;
        });

        if($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with('success', 'Book is already saved for later');
        }

        Cart::instance('savedForLater')->add($book->id, $book->name, 1, $book->price)->associate('App\Book');

        return redirect()->route('cart.index')->with('success', 'Book has been saved for later');

    }
}
