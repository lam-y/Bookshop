@extends('landing-page')

@section('title', '| Homepage')

@section('content')  

<!-- Page Content -->
<body>

<div class="container">
    <div class="row">        
        <div class="col-sm-12 col-md-10 offset-1">

    <div class="jumbotron d-flex align-items-center" style="margin-top: 25px">
        <div class="col col-sm-12 text-center">
            <h2 class="text-center">Thank you for <br> your order</h2>                    
            <p>A confirmation email was sent</p>
            <a href="{{ URL('/') }}" class="btn btn-outline-dark"> Home Page </a>
        </div>
    </div>                

        </div>
    </div>
</div>

<br>
</body>

@endsection
