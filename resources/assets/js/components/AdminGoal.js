import React, { Component } from 'react';

class AdminGoal extends Component {

    render() {
    return (
        <div className="panel">
            <p>{JSON.stringify(this.props.goal)}</p>
            <h2><a href="/blc-admin/goals/id-here">{this.props.goal.name}</a></h2>
            <h4>Cost: {this.props.goal.cost}</h4>
            <h4>Days: {this.props.goal.days}</h4>
            <h4>Hours: {this.props.goal.hours}</h4>
            <h4>Subgoal Count: {this.props.goal.subgoals_count}</h4>

            {this.props.goal.tags.map(tag =>
                <span className="label label-default">{tag.name}

                    <form method="post" action="/goals/goal-id/tag">

                        <input type="hidden" name="tag_name" value={tag.id}/>
                        <button type="submit">x</button>
                    </form>

                </span>
            )}

        </div>
        /*
            <div class="panel">

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
            </div>
         */

    );
    }
}

export default AdminGoal;