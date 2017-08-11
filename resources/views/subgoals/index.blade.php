
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <search-goals></search-goals>
            <br>
            <!--
            <form action="/goals/" method="POST">
                {{ csrf_field() }}
                <input type="text" placeholder="Goal Title" name="title">
                <input type="number" placeholder="Cost" name="cost">
                <input type="number" placeholder="Days" name="days">
                <input type="number" placeholder="Hours" name="hours">
                <button type="submit">Submit</button>
            </form>
            <br>
            <br>
            <form action="/search" method="GET">
                {{ csrf_field() }}
                <input type="text" placeholder="Find Goal" name="search">
                <button type="submit">Submit</button>
            </form>
            -->

        </div>
        <div class="col-md-6">

                <ul>
               @foreach($subgoals as $sub)
                    <li>
                        <a href="/subgoals/{{$sub->id}}">{{ $sub->name }}</a>
                    </li>
                @endforeach
                </ul>

        </div>
    </div>
</div>
@endsection
