import React, { Component } from 'react';

import AdminTag from './AdminTag';
import AdminAddTag from './AdminAddTag';

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

            {this.props.goal.tags.map((tag, num) =>

                <AdminTag tag={tag} key={num} goal={this.props.goal.id}/>

            )}
            <br/>

            <AdminAddTag/>

        </div>

    );
    }
}

export default AdminGoal;