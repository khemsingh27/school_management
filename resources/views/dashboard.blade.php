@include('layouts.niceAdminNav')
<main id="main" class="main">
<div class="pagetitle">
    <h1>{{$title}}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">{{$title}}</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
    <div class="name d-flex justify-content-center"><h1>Welcome {{auth()->user()->name}}</h1></div>
    @yield('content')
</main>
@include('layouts/footer')