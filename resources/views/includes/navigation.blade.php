<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">

      <!-- Search -->
      <form class="form-inline ml-auto" action="{{URL('search')}}" method="GET" role="search">
        @csrf        
        <div class="md-form my-0">
          <input class="form-control" type="text" name="term" placeholder="Search" aria-label="Search">
        </div>
        <button type="submit" class="btn btn-warning btn-md my-0 ml-sm-2" >Search</button>
      </form>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        {{ menu('header_menu', 'includes.menus.header_menu') }}    
         {{-- هي بعد ما استخدمنا 
          voyager 
          وعملنا المينيو من هنيك --}}
      </div>    

    </div>
  </nav>