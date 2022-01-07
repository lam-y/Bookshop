@extends('landing-page')

@section('title', '| Order Details')

@section('stylesheets')
<link href="{{ asset('css/custom.css') }}" rel="stylesheet" />


@section('content')  

<!-- Page Content -->
<body>
<div class="container" style="direction: rtl; text-align:right">

  <div class="row">
    <div class="col-md-8 col-md-10 mx-auto"> 

        <div class="my-orders container">
            <div>
            <div style="direction:ltr ;text-align: left">
                <a href="{{ url()->previous() }}"> <i class="fas fa-angle-double-left"></i> Back </a>
            </div>                 
                <div class="spacer"></div>
                <h3>تفاصيل الطلب</h3><br>
                <div class="order-container">
                    <div class="order-header">
                        <div class="order-header-items">
                            <div>
                                <div class="uppercase font-bold">تاريخ الطلب</div>
                                <div>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y')  }}</div>
                            </div>
                            <div>
                                <div class="uppercase font-bold">رقم الطلب</div>
                                <div>{{ $order->id }}</div>
                            </div><div>
                                <div class="uppercase font-bold">المبلغ الإجمالي</div>
                                <div>${{ number_format($order->billing_total, 2) }}</div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="order-books">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">الاسم:</td>
                                    <td>{{ $order->billing_name }}</td>
                                </tr>
                                <tr>
                                    <td>العنوان:</td>
                                    <td>{{ $order->billing_address }}</td>
                                </tr>
                                <tr>
                                    <td>المدينة:</td>
                                    <td>{{ $order->billing_city }}</td>
                                </tr>
                                <tr>
                                    <td>المجموع الفرعي:</td>
                                    <td>${{ number_format($order->billing_subtotal, 2)  }}</td>
                                </tr>
                                <tr>
                                    <td>الضريبة:</td>
                                    <td>${{ number_format($order->billing_tax, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>المجموع الكلي:</td>
                                    <td>${{ number_format($order->billing_total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div> <!-- end order-container -->

                <div class="order-container" style="text-align: right">
                    <div class="order-header">
                        <div class="order-header-items">
                            <div>
                                الكتب المطلوبة
                            </div>

                        </div>
                    </div>
                    <div class="order-books">
                        @foreach ($books as $book)
                            <div class="order-book-item">
                                <div><img src="{{ Voyager::image($book->image) }}" alt="Book Cover" width="100px" height="140px"></div>
                                <div>
                                    <div>
                                        <a href="{{ route('book.show', $book->id) }}">{{ $book->name }}</a>
                                    </div>
                                    <div>${{ number_format($book->price, 2) }}</div>
                                    <div>العدد: {{ $book->pivot->quantity }}</div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div> <!-- end order-container -->
            </div>            
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