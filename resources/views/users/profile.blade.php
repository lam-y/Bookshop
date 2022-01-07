@extends('landing-page')

@section('title', '| My Profile')

@section('stylesheets')
<link href="{{ asset('css/custom.css') }}" rel="stylesheet" />

@section('script')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


@section('content')  

<!-- Page Content -->
<body>
<div class="container">

  <div class="row">
    <div class="col-md-8 col-md-10 mx-auto">  

      <h3>{{ $user->name}}</h3>
   
      <!-- Show Success message when we add a book to the cart -->
      <br>
      @if ($message = Session::get('success'))
          <div class="alert alert-success">
              <p>{!! $message !!}</p>
          </div>
      @endif  

      @if ($message = Session::get('errors'))
          <div class="alert alert-danger">
              <p>{!! $message !!}</p>
          </div>
      @endif  

        <div class="container">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">طلباتي</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">تعديل الملف الشخصي</a>
              </li>
              
          </ul>
          <div class="tab-content" id="myTabContent">

            {{-- ---------------------------------- orders tab --------------------------------------------------- --}}
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <br>
              <div class="my-orders container">
              <div class="my-profile">                

                @foreach ($orders as $order)
                <div class="order-container" style="direction: rtl; text-align:right">
                    <div class="order-header">
                        <div class="order-header-items">
                            <div>
                                <div class="uppercase font-bold">تاريخ الطلب</div>
                                <div>{{  \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</div>
                            </div>
                            <div>
                                <div class="uppercase font-bold">رقم الطلب</div>
                                <div>{{ $order->id }}</div>
                            </div><div>
                                <div class="uppercase font-bold">المبلغ الإجمالي</div>
                                <div>${{ number_format($order->billing_total,2) }}</div>
                            </div>
                        </div>
                        <div>
                            <div class="order-header-items">
                                <div><a href="{{ route('order.show', $order->id) }}">تفاصيل الطلب</a></div>                              
                            </div>
                        </div>
                    </div>
                    <div class="order-books">
                        @foreach ($order->books as $book)
                            <div class="order-book-item">
                                <div><img src="{{ Voyager::image($book->image) }}" alt="Book Image" width="70px" height="100px"></div>
                                <div style="margin-right: 25px">
                                    <div>
                                        <a href="{{ route('book.show', $book->id) }}">{{ $book->name }}</a>
                                    </div>
                                    <div>${{ $book->price }}</div>
                                    <div>العدد: {{ $book->pivot->quantity }}</div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div> <!-- end order-container -->
                @endforeach
            </div>
            </div>
            </div>


            {{-- ------------------------------ edit profile tab ----------------------------------------------------- --}}
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <br>
              <form action="{{route('users.update')}}" method="POST">
                @method('patch')
                @csrf 
                <div class="form-group">
                  <label for="title">Name</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{old('name', $user->name)}}" required>
                </div>
    
                <div class="form-group">
                  <label for="title">Email</label>
                  <input type="text" class="form-control" id="email" name="email" value="{{old('email', $user->email)}}" required>
                </div>
    
                <div class="form-group">
                  <label for="title">Password</label>
                  <input type="password" class="form-control" id="password" name="password">
                  <p>Leave password blank to keep current password</p>
                </div>
    
                <div class="form-group">
                  <label for="title">Confirm Password</label>
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" >
                </div>
    
                <div>
                  <button type="submit" class="btn btn-dark" style="width: 200px">Update Profile</button>
                </div>      
              </form>    
            </div>
                                                
          </div>
      </div>
        
                
  
      </div>
       <!-- /.col-lg-8 -->
    
    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->
</body>

<!-- end content -->


@section('footer-scripts')
    <script>
      $('#myTab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
      })
    </script>
@endsection

@endsection