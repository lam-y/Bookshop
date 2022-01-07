@extends('landing-page')

@section('title', '| Homepage')

@section('content')  

<!-- Page Content -->
<body>
<div class="container">

    <div class="row">

      <div class="col-lg-9">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
            <img class="d-block img-fluid" src="{{asset('img/1.png')}}" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="{{asset('img/2.png')}}" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="{{asset('img/3.png')}}" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <div class="row">

          @foreach ($books as $book)                    
            <div class="col-lg-4 col-md-6 mb-4 text-right">
              <div class="card h-100">
                  <a href="{{ route('book.show', $book->id) }}"><img class="card-img-top" src="{{  Voyager::image($book->image) }}" alt=""></a>
              
                <div class="card-body">
                  <h4 class="card-title">
                    <a href="{{ route('book.show', $book->id) }}">{{$book->name}}</a>
                  </h4>
                  <p class="mb-2 text-muted">{{$book->author}}</p>
                  <h5>${{$book->presentPrice() }}</h5>
                <p class="card-text">{!! substr($book->description, 0, 300) !!} {!! strlen(strip_tags($book->description)) > 300 ? "..." : "" !!}</p>
                </div>
                <div class="card-footer">
                  <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                </div>
              </div>
            </div>
          @endforeach          

        </div>
        <!-- /.row -->

        <!-- Pagination -->
        <div style="text-align: center">
          <div class="pagination justify-content-center">
            {!! $books->links() !!}
          </div>
        </div>

      </div>
      <!-- /.col-lg-9 -->

      <div class="col-lg-3">
        <div><a href="{{ URL('/') }}"><img src="{{asset('img/logo.jpg')}}" width="260" height="80"></a> </div>        
        <div class="list-group" style="text-align: right">
          @foreach ($categories as $category)
          <a href="{{ route('books.category', $category->id) }}" class="list-group-item">{{$category->name}}</a>
          @endforeach          
        </div>

      </div>
      <!-- /.col-lg-3 -->
      

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->
</body>

<!-- end content -->


@endsection