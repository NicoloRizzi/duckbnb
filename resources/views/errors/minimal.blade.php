@extends('layouts.error')

@section('content')
<div class="page-404">
    <div class="code">
        @yield('code')
    </div>

    <div class="message" style="padding: 10px;">
        @yield('message')
    </div>
</div>
@endsection

