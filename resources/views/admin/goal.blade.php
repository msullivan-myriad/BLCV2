
@extends('admin.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

                <div class="panel">
                    <h2><a href="/blc-admin/goals/{{$goal->id}}">{{$goal->name}}</a></h2>
                    <h4>Cost: {{$goal->cost}}</h4>
                    <h4>Days: {{$goal->days}}</h4>
                    <h4>Hours: {{$goal->hours}}</h4>
                    <h4>Subgoal Count: {{$goal->subgoals_count}}</h4>

                    @foreach ($goal->tags as $tag)
                        <span class="label label-default">{{ $tag->name }}

                        <form method="post" action="/goals/{{$goal->id}}/tag" style="display: inline;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="tag_name" value="{{$tag->id}}"/>
                            <button type="submit">x</button>
                        </form>

                        </span>

                    @endforeach

                    <br>
                    <br>
                    <form action="/goals/{{$goal->id}}/tag" method="POST">
                       {{ csrf_field() }}
                        <input name="tag_name" type="text" placeholder="Tag for this goal" />
                        <button type="submit">Tag</button>
                    </form>
                    <br>
                    <br>
                    <h4>Edit this goals title</h4>
                    <form action="/goals/{{$goal->id}}/edit" method="POST">
                        {{ csrf_field() }}
                        <input name="new_title" type="text" placeholder="New goal title"/>
                        <button type="submit">Edit Goal</button>
                    </form>
                    <h4>Delete this goal and all subgoals</h4>
                    <form action="/goals/{{$goal->id}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit">Delete Goal</button>
                    </form>
                    </form>
                </div>

        </div>
    </div>
</div>
@endsection

