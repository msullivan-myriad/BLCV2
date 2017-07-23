@extends('layouts.app')

@section('admin-nav')

<nav class="navbar navbar-static-top navbar-inverse bg-inverse">
    <div class="container">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#admin-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="admin-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('admin-panel') }}">Admin</a></li>
                <li><a href="{{ route('admin-tags') }}">Tags</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        </div>
    </div>
</nav>



@endsection
