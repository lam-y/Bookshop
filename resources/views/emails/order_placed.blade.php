@component('mail::message')
# Order Received

**Order ID:** {{ $order->id }} <br>
**Order Email:** {{ $order->billing_email }} <br>
**Order Billing Name:** {{ $order->billing_name }} <br>
**Order Total:** ${{ $order->billing_total }} <br>

**Items Ordered** <br>
@foreach ($order->books as $book)
    Name: {{ $book->name }} <br>
    Price: ${{ $book->price }} <br>
    Quantity: {{ $book->pivot->quantity }} <br> 
    <br>   
@endforeach

You can get further details about your order by logging into our website.

@component('mail::button', ['url' => config('app.url'), 'color' => 'green'])
Go To Website
@endcomponent

Thank you again for choosing us.

Regards,<br>
{{ config('app.name') }}
@endcomponent