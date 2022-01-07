@extends('landing-page')

@section('title', '| Homepage')

@section('content')  

<!-- Page Content -->
<body>

<!--Section: Block Content-->
<section class="container">
  
  <!-- Show Success message when save changes successfuly -->
  <br>
  @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
  @endif  

  <div class="row" style="">
  
    {{-- معلومات الكتاب --}}
    <div class="col-md-8 text-right" style="direction: rtl">
      <h5>{{ $book->name }}</h5>
      <p class="mb-2 text-muted">{{ $book->author }}</p>
      
      <p ><span class="mr-1"><strong>${{ $book->presentPrice() }}</strong></span></p>
      <p class="pt-1">{!! $book->description !!}</p>
      <br><br>
      <div class="table-responsive" style="direction: rtl">
        <table class="table table-sm table-borderless mb-0">
          <tbody>
            <tr>
              <th class="pl-0 w-25" scope="row" ><strong>عدد الصفحات:</strong></th>
              <td>{{ $book->pages }}</td>
            </tr>
            <tr>
              <th class="pl-0 w-25" scope="row"><strong>التصنيف:</strong></th>
              <td> {{ $book->category->name }}</td>
            </tr>                        
            <tr>
              <th class="pl-0 w-25" scope="row"><strong>الناشر:</strong></th>
            <td>{{ $book->publisher }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <br>
      <hr>

      <form action="{{route('cart.store')}}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{$book->id}}">
        <input type="hidden" name="name" value="{{$book->name}}">
        <input type="hidden" name="price" value="{{$book->price}}">
        <div class="text-right">
          <button type="submit" class="btn btn-outline-primary btn-lg">
            <i class="fas fa-shopping-cart pr-2"></i> أضف إلى العربة </button>
        </div>
      </form>
       
    </div>

    {{-- صورة الكتاب --}}    
    <div class="col-md-4">
      <div id="image">
      {{-- <img src="{{ asset('images/'.$book->image) }}" width="300" height="450"/> --}}
      <img src="{{ Voyager::image($book->image) }}" width="300" height="450"/>
      </div>      

    </div>

  </div>

</section>
<!--Section: Block Content-->
  

</body>

@endsection