@include('includes.header')
@yield('content')
<div class="container">
    {{ $slot }}
</div>
@include('includes.footer')
