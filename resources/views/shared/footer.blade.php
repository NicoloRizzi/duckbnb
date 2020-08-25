
</div>

<footer class="main-footer container-fluid">
    <div class="main-footer--ctn">
        <div class="main-footer--ctn-left">
            <a href="{{ url('/') }}" class="main-footer--ctn-left--logo">
            <img src="{{ asset('img/logo-footer.png') }}" alt="logo" class="img-fluid">
            </a>
            <div class="main-footer--ctn-left--copy">
                <p>Copyright &copy;2020</p> 
            </div>
        </div>
        <ul class="main-footer--ctn-menu">
            @Auth 
                <li><a href="{{ route('user.apartments.index') }}">Dashboard</a></li>     
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Iscriviti</a></li>
            @endauth
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ route("search") }}">Cerca</a></li>
        </ul>
    </div>
</footer>

{{-- Script Ionicons --}}
<script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
</body>
</html>
