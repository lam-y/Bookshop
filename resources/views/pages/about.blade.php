@extends('landing-page')

@section('title', '| About')

@section('stylesheets')
<link href="{{ asset('css/custom.css') }}" rel="stylesheet" />


@section('content')  

<!-- Page Content -->
<body>
<div class="container">

  <div class="row">
    <div class="col-md-8 col-md-10 mx-auto" style="direction:rtl; text-align:center;">
        
        <div class="spacer"></div>
        
        <div><img src="{{asset('img/logo.jpg')}}"> </div>

        <div class="spacer"></div>

        <div>
            <p> متجر عربي متخصص في بيع الكتب العربية الأكثر انتشارًا ولأشهر المؤلفين من خلال التعاون مع دور النشر.
                <br>
                يهدف موقعنا أن يكون المنصة الأولى لتوفير الكتب العربية عبر الإنترنت والعمل على تسهيل شراء الكتب أونلاين.
                <br>
                ويحرص الموقع على توفير أفضل الكتب المطلوبة بشكل دوري للعملاء من خلال التعاون مع عدة دور نشر رائدة في مجالها.
                <br>
                كما يحاول الموقع توفير الكتب بأسعار مناسبة للجميع.
                <br>
                يقوم الموقع بتوصيل الكتب لجميع الأماكن من خلال شركات شحن عالمية وخلال أيام معدودة. </p>
        </div>        

        <div class="spacer"></div>


    </div>
    <!-- /.col-lg-8 -->
 
 </div>
 <!-- /.row -->

</div>
<!-- /.container -->
</body>

<!-- end content -->