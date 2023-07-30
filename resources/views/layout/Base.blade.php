<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.Top')
</head>

<body>
    <div id="app">
        @include('layout.Sidebar')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
        @yield('content')
    @include('layout.Bootom')
    @yield('script')
</body>

</html>