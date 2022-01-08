<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Image;
use Session;
use Storage;

class BookController extends Controller
{
    /** *************************************************************************
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$books = Book::inRandomOrder()->take(9)->get();
        $books = Book::inRandomOrder()->paginate(9);

        return view('pages.index', compact('books'));    
    }

    /** *************************************************************************
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /** *************************************************************************
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1- validate the data 
        $rules = $this->rules();
        $messages = $this->messages();
        $this->validate($request, $rules, $messages);

        // 2- store in the database
        $book = new Book;
        $book->name = $request->name;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->publisher = $request->publisher;
        $book->pages = $request->pages;
        $book->price = $request->price;

        if($request->hasfile('image')){
            // save the image in public/images folder
            $image = $request->file('image');            
            $fileName = time() . '.' . $image->getclientoriginalextension();        // to rename the image with a unique name
            $location = public_path('images/'.$fileName);

            $width = Image::make($image)->width();            
            $height = Image::make($image)->height();

            if($width > 300 && $height > 500){
                Image::make($image)->resize(300, null, function ($constraint) {         
                    $constraint->aspectRatio();
                })->save($location);            
            }

            else{           // اذا ما غيرت أبعاد الصورة بحفظها مباشرة
                Image::make($image)->save($location);
            }

             // save fileName in the DB to find it later
             $book->image = $fileName;
        }

        if($request->category != 0){
            $book->category_id = $request->category;
        }

        $book->save();

        Session::flash('success', 'The book was successfully saved');

        // 3- redirect to another page
        return redirect()->route('book.show', $book->id);
        
    }

    /** *************************************************************************
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);

        return view('books.show')->with('book', $book);
    }

    /** *************************************************************************
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);

        if(!$book){
            return redirect()->route('/');
        }

        return view('books.edit', compact('book'));
    }

    /** *************************************************************************
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //1- validate values
        $rules = $this->rules();
        $messages = $this->messages();
        $this->validate($request, $rules, $messages);

        //2- check if the book exists in the database
        $book = Book::find($id);

        if(!$book){
            return redirect()->route('/');
        }

        // some work with image
        $newImage = false; 
        $fileName = ""; 
        if($request->hasfile('image') ){
            $newImage = true;
            // Add the new image           
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getclientoriginalextension();    
            $location = public_path('images/'.$fileName);        

            $width = Image::make($image)->width();
            $height = Image::make($image)->height();

            if($width > 300 && $height > 500){
                Image::make($image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($location);            
            }
            else{
                Image::make($image)->save($location);
            }

            $oldFileName = $book->image;

            // Delete old image
            Storage::delete($oldFileName);
        }

        // 3- update in database 
        if($newImage){          // update with Image
            $book->update( [
                $book->name = $request->name,
                $book->author = $request->author,
                $book->description = $request->description,
                $book->publisher = $request->publisher,
                $book->pages = $request->pages,
                $book->price = $request->price,
                $book->category_id = $request->category,
                $book->image = $fileName,                
            ]);
        }
        else{
            $book->update( [        // update without image, that means keep the old image
                $book->name = $request->name,
                $book->author = $request->author,
                $book->description = $request->description,
                $book->publisher = $request->publisher,
                $book->pages = $request->pages,
                $book->price = $request->price,
                $book->category_id = $request->category,
            ]);
        }

        //4- redirect to another page with success message
        Session::flash('success', 'Changes Saved successfully');
        return  redirect()->route('book.show', $id);

    }

    /** *************************************************************************
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //1- check if the book exists in the database
        $book = Book::find($id);

        if(!$book){             // if the book deosn't exists in DB
            return redirect()->route('pages.index');
        }

        // delete the image of the book
        Storage::delete($book->image);

        $book->delete();        

        //3- redirect to another page with success message
        Session::flash('success', 'The book deleted successfully');
        return redirect()->route('pages.index');

    }


    /** ************************************************************************
     * To retrieve all books with specific category
     */
    public function getBooksOfCategory($category_id){
        $books = Book::with('category')->where('category_id', '=', $category_id)->paginate(9);

        return view('pages.index', compact('books'));
    }

     /** ************************************************************************
     * Search in two columns, name and author
     */
    public function search(Request $request){
        $books = Book::where(function($query) use ($request){
            $query->where('name', 'LIKE', '%'.$request->term.'%')
                  ->orWhere('author', 'LIKE', '%'.$request->term.'%');
        })
        ->paginate(9);            

        return view('pages.index', compact('books'));      
    }

     /** ************************************************************************
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'author' => 'required|max:255',  
            'pages' => 'integer' ,    
            'price' => 'numeric',
            'image' => 'sometimes|image',
        ];
    }

    /** *************************************************************************
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'A book name is required',
            'author.required' => 'The author is required',
            'name.max' => 'Book name is too long',
            'author.max' => 'Author name is too long',
            'pages.integer' => 'Pages should be a number',
            'price.numeric' => 'Price should be a number',
            'image.image' => 'The image is not valid',
        ];
    }
}
