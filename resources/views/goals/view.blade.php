
@extends('layouts.app')

@section('content')
    <script>

        const goal = <?php echo json_encode($goal); ?>;
        const loggedIn = <?php echo json_encode($loggedIn); ?>;
        const userHasGoals = <?php echo json_encode($userHasGoals); ?>;
        const hasProfileInfo = <?php echo json_encode($hasProfileInfo); ?>;
        const userHasThisGoalOnList = <?php echo json_encode($userHasThisGoalOnList); ?>;

    </script>

    <div class="container">
    <h1>{{$goal->name}}</h1>
    <br>
    <br>
    <div class="row">
        <div class="col-md-6">
                <h4>Average Goal Data</h4>
                <h4>${{$goal->cost}}</h4>

                <h4>Days: {{$goal->days}}</h4>
                <h4>Hours: {{$goal->hours}}</h4>
                <h4># of users you have this goal on their list: {{$goal->subgoals_count}}</h4>

                <!-- Consider if I should build something cool here with React or if static content is more important... -->
                <!-- Definitly should have some cool stats on this side of the page -->

                <div id="individual-goal-general-stats"></div>

       </div>
        <div class="col-md-6">
            <div id="your-goal-data"></div>
        </div>

        <div class="col-md-12">
           <div id="view-goal-page"></div>
        </div>
    </div>
</div>
@endsection