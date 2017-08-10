
@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Profile Info</div>

                <div class="panel-body">
                    <p>Need to prompt user to fill out needed profile information</p>
                    <ul>
                        <li>Age</li>
                        <li>Finish Date</li>
                    </ul>
                    <p>Maybe just require this in the basic info section?  Other sections don't show until it is filled out</p>
                </div>
            </div>
        </div>
    </div>
    <basic-stats></basic-stats>
    <top-fives></top-fives>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Most and Least Difficult</div>

                <div class="panel-body">
                    <p>Section has two halves.  Left side has a couple sliders (ie. easier to get time off or save money).  The right side has two panels, one for most difficult goals and another for least difficult goals based on what was filled out in the slider</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">More Than</div>

                <div class="panel-body">
                    <p>Like on the old website, but with fun graphics and split up better by cost, days, and hours on different panes</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Most/Least Popular Goals</div>

                <div class="panel-body">
                    <p>Goals on your list that you share with the most other users</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Individual Goal Stat!!</div>

                <div class="panel-body">
                    <p>Cool idea!  All goals that are shown on the stats page are links... But not back to your old boring goal page.  But a modal about that specific goal.  Here is some info to show up in the modal:</p>
                    <ul>
                        <li>Basic Overview (cost, hours, days)</li>
                        <li>Percentage goals makes up of cost, hours, days</li>
                        <li>Rank in most to least difficult</li>
                        <li>Number of other users with this goal</li>
                        <li>Link to main goal page</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection
