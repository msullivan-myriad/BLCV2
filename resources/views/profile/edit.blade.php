
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <form action="/profile/" method="POST">

                {{csrf_field()}}

                <input name="age" type="text" placeholder="{{ $profile->age }}"/>

                <input type="submit" value="Submit"/>

                @if ($errors)

                    <p>There were some errors</p>

                @endif


            </form>

        </div>
    </div>
</div>
@endsection