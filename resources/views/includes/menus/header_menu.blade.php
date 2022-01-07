<ul class="navbar-nav ml-auto">
    @foreach($items as $menu_item)
        <li class="nav-item" style="margin: 9px">
            @if ($menu_item->title == 'Cart')
                <a class="nav-link" href="{{route('cart.index')}}"><i class="fas fa-shopping-cart pr-2"></i>
                    @if (Cart::instance('default')->count() > 0)
                        <span class="badge badge-warning">{{ Cart::instance('default')->count() }}</span>                        
                    @endif
                </a>

            @else
            <a class="nav-link" href="{{ $menu_item->link() }}">
                {{ $menu_item->title }} 
            </a>
            @endif    
        </li>
    @endforeach

    @guest
    <li class="nav-item" style="margin: 9px">
        <a class="nav-link" href="{{route('register')}}">إنشاء حساب جديد</a>
    </li>

    <li class="nav-item" style="margin: 9px">
        <a class="nav-link" href="{{route('login')}}">تسجيل الدخول</a>
    </li>

    @else 
    <li class="nav-item" style="margin: 9px">
        <a class="nav-link" href="{{ route('users.index') }}">ملفي الشخصي</a>
    </li>

    <li class="nav-item" style="margin: 9px">
        <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            {{-- {{ __('Logout') }} --}}
            تسجيل الخروج
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>

    @endguest
    

</ul>



{{-- 
    هي الشكل القديم قبل ما نخليها
    Dynamic menus
    باستخدام
    Voyager

    <ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{URL('/')}}">Home</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="#">About</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="{{route('cart.index')}}"><i class="fas fa-shopping-cart pr-2"></i><span class="badge badge-warning">{{ Cart::instance('default')->count() }}</span></a>
    </li>          
</ul> --}}

