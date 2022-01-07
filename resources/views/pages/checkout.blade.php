@extends('landing-page')

@section('title', '| Homepage')
    
@section('stylesheets')
<style>
  /**
    * The CSS shown here will not be introduced in the Quickstart guide, but shows
    * how you can use CSS to style your Element's container.
    */
    .StripeElement {
      background-color: white;
      padding: 16px 16px;
      border: 1px solid #ccc;

    }

    .StripeElement--focus {
      // box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
      border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
      background-color: #fefde5 !important;
    }

    #card-errors {
      color: #fa755a;
    }
</style>

@section('script')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<!-- ------------------------------------- Page Content ---------------------------------------->
@section('content')  
<body>

    <div class="container" style="direction: rtl; text-align:right;">  
      <div class="row">
        <div class="col-sm-12 col-md-10 offset-1">
          <br>
          @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>        
          @endif
          
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
              </ul>               
            </div>                                   
          @endif          
        </div>    

        
        <!----------------------------- The Order or The cart ------------------------>
          <div class="col-md-4 order-md-2 mb-4">                                    
            <h4 class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-muted">عربتك</span>
            <span class="badge badge-secondary badge-pill">{{ Cart::count() }}</span>
            </h4>
            <ul class="list-group mb-3" style="padding: 0%">
                @foreach (Cart::content() as $book)
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                      <h6 class="my-0">{{ $book->model->name }}</h6>
                      <small class="text-muted">{{ $book->model->author }}</small>
                      <h6 class="text-muted">${{ $book->model->presentPrice() }}</h6>
                    </div>
                    <span class="text-muted">{{ $book->qty }}</span>
                  </li>
                @endforeach
                           
              @if (session()->has('coupon'))
                <li class="list-group-item d-flex justify-content-between bg-light">
                  <div class="text-success">
                    <h6 class="my-0">Coupon Code</h6>
                    <small>{{ session()->get('coupon')['name'] }} </small>
                    <form action="{{ route('coupon.destroy') }}" method="post" style="display: inline">
                      @csrf 
                      @method('delete')
                      <button type="submit" class="btn btn-link" style="font-size:smaller;">Remove</button>
                    </form>                
                  </div>
                  <span class="text-success">-${{ $discount }}</span>                
                </li>               
              @endif    

              <li class="list-group-item d-flex justify-content-between">
                <span>المجموع الفرعي (USD)</span>
              <strong>${{ number_format($newSubtotal, 2) }}</strong>
              </li>
              
              <li class="list-group-item d-flex justify-content-between">
                <span>الضريبة(13%)</span>
              <strong>${{ number_format($newTax, 2) }}</strong>
              </li>

              <li class="list-group-item d-flex justify-content-between">
                <span>المجموع الكلي (USD)</span>
              <strong>${{ number_format($newTotal, 2) }}</strong>
              </li>
            </ul>
      
            <form class="card p-2" action="{{route('coupon.store')}}" method="POST">
              @csrf 
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Coupon Code" name="coupon_code" id="coupon_code">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-secondary">Redeem</button>
                </div>
              </div>
            </form>
          </div>

          <!------------------------------- Billing Details ---------------------->
          <div class="col-md-8 order-md-1">
            <h4 class="mb-3">بيانات الفاتورة</h4>
            <form action="{{route('checkout.store')}}" method="POST" id="payment-form" >               
              @csrf
            <input type="hidden" name="amount" value="{{Cart::total()}}">
            <div class="mb-3">
                    <label for="firstName">الاسم</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    <div class="invalid-feedback">
                    Valid first name is required.
                    </div>
                </div>               
      
              <div class="mb-3">
                <label for="email">البريد الالكتروني</label>
                {{-- if the user logged in and chose to ckeckout like a user, so we will add his email in the field and make it readonly --}}
                @if (auth()->user())      
                  <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" readonly required>
                
                @else
                  {{-- else if the user chose to checkout like a guest --}}
                  <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                @endif                    

                <div class="invalid-feedback">
                  Please enter a valid email address for shipping updates.
                </div>
              </div>
      
              <div class="mb-3">
                <label for="address">العنوان</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                <div class="invalid-feedback">
                  Please enter your shipping address.
                </div>
              </div>
                  
      
              <div class="row" style="margin-top:0px; margin-bottom:0px;">
                <div class="col-md-6 mb-3">
                  <label for="country">الدولة</label>
                  <select class="custom-select d-block w-100" id="country" name="country" required>
                    <option value="">اختر الدولة...</option>
                      @foreach ($countries as $country)
                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                      @endforeach                    
                  </select>
                  <div class="invalid-feedback">
                    Please select a valid country.
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="address2">المدينة</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>                    
                    <div class="invalid-feedback">
                    Please provide a valid state.
                  </div>
                </div>              
                                
                <div class="col-md-6 mb-3">
                    <label for="address2">الرمز البريدي</label>
                    <input type="text" class="form-control" id="postalCode" name="postalCode" value="{{ old('postalCode') }}" required>
                    <div class="invalid-feedback">
                    Please provide a valid state.
                </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="address2">رقم الهاتف</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                    <div class="invalid-feedback">
                    Please provide a valid state.
                </div>
                </div>                

              </div>              
      
              <!---------------------------------- Payment Or Credit ----------------------------------->
              <h4 class="mb-3">بيانات الدفع</h4>
                                
                <div class="mb-3">
                  <label for="cc-name">الاسم على البطاقة</label>
                  <input type="text" class="form-control" id="name_on_card" name="name_on_card" placeholder="" value="{{ old('name_on_card') }}" required>
                  <small class="text-muted">الاسم الكامل كما يظهر على البطاقة</small>
                  <div class="invalid-feedback">
                    Name on card is required
                  </div>
                </div>                         
                
              <!-- Stripe Element -->
              <div class="form-group">
                <label for="card-element">
                  Credit or debit card
                </label>
                <div id="card-element" style="direction: ltr">                  
                  <!-- a Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors -->
                <div id="card-errors" role="alert"></div>
                </div>
                <div class="spacer"></div>

                <button type="submit" id="complete-order" class="btn btn-primary btn-lg btn-block" >Complete Order</button>              
              <!-- end stripe -->

            </form>
        </div>
      
       
      </div>
    </div>

</body>

@endsection


<!-- ------------------------------------- Java Script for Stripe ---------------------------------------->
@section('footer-scripts')
<script src="{{asset('js/app.js')}}"></script>
<script>
  window.onload = function() {
            // Create a Stripe client
            var stripe = Stripe('pk_test_51I9tLWGoEG9rrfr0bup5tKOhmd0sQrLk3FcWbKKNsrN7L7TNu9oQlrzsiF9OfdIMicxKD2xAM19b5rrj8YZ9ztF300tsYZaPCw');
            // Create an instance of Elements
            var elements = stripe.elements();
        
            // Custom styling can be passed to options when creating an Element.           
            var style = {
              base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                  color: '#aab7c4'
                }
              },
              invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
              }
            };
            
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });

            // Add an instance of the card UI component into the `card-element` <div>
            card.mount('#card-element');

            // Handle real-time validation errors from the card element
            card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
              displayError.textContent = event.error.message;
            } else {
              displayError.textContent = '';
            }
          });


          // handle form submission
          var form = document.getElementById('payment-form');
          form.addEventListener('submit', function(e) {
            e.preventDefault();     

            // Disable the submit button to prevent repeated clicks
            document.getElementById('complete-order').disabled = true;

            // Data object - optional to send to createToken
            // أسماء القيم بالداتا أخدناهن بالظبط من موقع سترايب، يعني هنن هيك مكتوبين، فلذلك أنا سميتهن هيك
            var data = {              
              name: document.getElementById('name_on_card').value,              
              address_line1: document.getElementById('address').value,            
              //address_country: document.getElementById('country').value,    // لأنه هي لازم تنبعت بس US
              address_city: document.getElementById('city').value,
              address_zip: document.getElementById('postalCode').value ,          
            }           
            
            stripe.createToken(card, data).then(function(result) {
              if (result.error) {
                // Inform the user if there was an error
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;

                // Enable the submit button again
                document.getElementById('complete-order').disabled = false;

              } else {
                // Send the token to your server
                stripeTokenHandler(result.token);
              }
            });
          });

          function stripeTokenHandler(token) {
          // Insert the token ID into the form so it gets submitted to the server
          var form = document.getElementById('payment-form');
          var hiddenInput = document.createElement('input');
          hiddenInput.setAttribute('type', 'hidden');
          hiddenInput.setAttribute('name', 'stripeToken');
          hiddenInput.setAttribute('value', token.id);
          form.appendChild(hiddenInput);

          // Submit the form
          form.submit();
        }        
                   
  };

</script>
    
@endsection