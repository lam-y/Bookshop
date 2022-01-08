<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders1 = auth()->user()->orders;       

        $orders = $orders1->reverse();          

        //$orders = auth()->user()->orders->with('books')->get()->reverse();      

        return view('users.profile')->with(['orders'=> $orders ,
                                            'user'=> auth()->user()]);
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
    public function show()      // we removed the $id and will get it from the session
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()      // we removed the $id and will get it from the session
    {
        //return view('users.profile')->with('user', auth()->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.auth()->id(),
            'password' => 'sometimes|nullable|string|min:6|confirmed',
            'password_confirmation' => 'sometimes',
        ]);

        $user = auth()->user();
        $input = $request->except('password', 'password_confirmation');     // because we have to encrept them


        if(!$request->filled('password')){       
            $user->fill($input)->save();

            return back()->with('success','profile updated successfully');
        }

        // if he change the password, we will encrypt it
        $user->password = bcrypt($request->password);
        $user->fill($input)->save();

        return back()->with('success','profile and password updated successfully');

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
