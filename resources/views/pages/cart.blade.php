@extends('landing-page')

@section('title', '| Homepage')

@section('content')  

<!-- Page Content -->
<body>

<div class="container">
    <div class="row">        
        <div class="col-sm-12 col-md-10 offset-1">

     <!-- Show Success message when we add a book to the cart -->
    <br>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif  

    @if ($message = Session::get('errors'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif  

    <!-- -------------------------------- Shopping Cart ------------------------------------->
    @if(Cart::count() > 0)    
    <h3> {{ Cart::count() }} book(s) in shopping cart</h3>
    <br>

    <table class="table table-hover">                                
            <thead>
                <tr>
                    <th>Books</th>
                    <th class="text-cente">Price</th>
                    <th>Quantity</th>                    
                    <th class="text-center">Total</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                @foreach (Cart::content() as $book)
                <tr>
                    <td class="col-sm-8 col-md-6">
                    <div class="media">
                    <a class="thumbnail pull-left" href="{{ route('book.show', $book->id) }}"> <img class="media-object" src="{{ Voyager::image($book->model->image)}}" style="width: 90px; height: 130px;"> </a>
                        <div class="media-body">
                        <h4 style="margin-left: 25px"><a href="{{ route('book.show', $book->id) }}">{{ $book->name }}</a></h4>
                        <h6 style="margin-left: 25px"> by: {{ $book->model->author}}</h6>                            
                        </div>
                    </div></td>
                    
                    <td class="col-sm-1 col-md-1 text-center"><strong>${{ $book->price }}</strong></td>

                    <td class="col-sm-1 col-md-1" style="text-align: center">
                        <input type="number" class="quantity form-control" value="{{$book->qty}}" name="qty" id="qty" data-id="{{$book->rowId}}">                    
                    </td>

                    <td class="col-sm-1 col-md-1 text-center"><strong>${{ $book->subtotal}}</strong></td>
                    <td class="col-sm-1 col-md-1">
                    <form action="{{route('cart.destroy', $book->rowId)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </form>  

                    <form action="{{route('cart.switchToSaveForLater', $book->rowId)}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link btn-sm" style="margin-top: 8px">
                            <i class="fas fa-save"></i> Save for later</button>                    
                    </form>
                </td>                                              
            </tr>                       
            @endforeach

            <tr>
                <td>   </td>
                <td>   </td>
                <td>   </td>
                <td><h5>Subtotal</h5></td>
                <td class="text-center"><h5><strong>${{ number_format(Cart::subtotal(), 2) }}</strong></h5></td>
            </tr>
            <tr>
                <td>   </td>
                <td>   </td>
                <td>   </td>
                <td><h5>Tax (13%)</h5></td>
            <td class="text-center"><h5><strong>${{ number_format(Cart::tax(), 2)  }}</strong></h5></td>
            </tr>
            <tr>
                <td>   </td>
                <td>   </td>
                <td>   </td>
                <td><h3>Total</h3></td>
                <td class="text-center"><h3><strong>${{ number_format(Cart::total(), 2) }}</strong></h3></td>
            </tr>
            <tr>                 
                <td colspan="3">
                <a href="{{URL('/')}}" type="button" class="btn btn-outline-info float-right">
                    <i class="fas fa-shopping-cart"></i> Continue Shopping
                </a></td>
                <td colspan="2">
                <a href="{{URL('checkout')}}" type="button" class="btn btn-success btn-block">
                    Checkout <i class="fas fa-play"></i>
                </a></td>
            </tr>
        </tbody>                
    </table>

    <!-- ------------------------------ if cart is empty -------------------------------->
    @else

    <div class="jumbotron d-flex align-items-center" style="margin-top: 25px">
        <div class="col col-sm-12 text-center">
            <h3 class="text-center">No books in your cart</h3>                    
            <br>
            <a href="{{ URL('/') }}" class="btn btn-outline-dark">
                <i class="fas fa-shopping-cart"></i> Continue Shopping
            </a>
        </div>
    </div>                
    @endif

    <!-- ------------------------ saved for later items --------------------------------------- -->
    <hr style="margin-top: 70px; margin-bottom: 70px">
    
    @if(Cart::instance('savedForLater')->count() > 0)    
    <h3> {{ Cart::instance('savedForLater')->count() }} Book(s) saved for later </h3>
    <br>

    <table class="table table-hover">                                
            <thead>
                <tr>
                    <th>Books</th>
                    <th></th>
                    <th class="text-center">Price</th>                    
                    <th></th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                @foreach (Cart::instance('savedForLater')->content() as $book)
                <tr>
                    <td>
                    <div class="media">
                    <a class="thumbnail pull-left" href="{{ route('book.show', $book->id) }}"> <img class="media-object" src="{{ Voyager::image($book->model->image)}}" style="width: 90px; height: 130px;"> </a>
                        <div class="media-body">
                        <h4 style="margin-left: 25px"><a href="{{ route('book.show', $book->id) }}">{{ $book->name }}</a></h4>
                        <h6 style="margin-left: 25px"> by: {{ $book->model->author}}</h6>                            
                        </div>
                    </div></td>

                    <td></td>
                    <td class="text-center"><strong>${{ $book->price }}</strong></td>                    

                   

                    <td colspan="2" class="text-center">
                    <form action="{{route('saveForLater.destroy', $book->rowId)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </form>      
                    
                    <form action="{{route('saveForLater.moveToCart', $book->rowId)}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link btn-sm" style="margin-top: 8px">
                            <i class="fas fa-shopping-cart"></i> Move to cart</button>                    
                    </form>
                </td> 
                </tr>                       
                @endforeach
                
        </tbody>                
    </table>    
    @endif      <!-- end if there are books saved for later -->

        </div>
    </div>
</div>

<br>
</body>

@endsection

@section('footer-scripts')
<script src="{{asset('js/app.js')}}"></script>
<script>

    // to change qunatity with javascript
    // we will add eventListener to the quantity input element, and when it changes we will send the value to CartController@update to update the qanitity in the cart itself
    // if the change is acceptable we will reload the page and show success message
    // else we will show error message

    (function(){
        const classname = document.querySelectorAll('.quantity');

        Array.from(classname).forEach(function(element){
            element.addEventListener('change', function(){
                const id = element.getAttribute('data-id');
                axios.patch(`/cart/${id}`, {            // cart/$id with patch = cart.update in route
                    qty: this.value
                })
                .then(function (response) {
                    console.log(response);
                    // when successful reload the page to show success message and change some values
                    window.location.href = '{{ route('cart.index')}}'
                })
                .catch(function (error) {
                    console.log(error);
                    // reload the page to show error message and change some values
                    window.location.href = '{{ route('cart.index')}}'
                });
            });
        });
    })();
</script>


@endsection