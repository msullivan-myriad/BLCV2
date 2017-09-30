import React, { Component } from 'react';


class YourGoal extends Component {

    constructor(props) {
        super(props);

        this.state = {
        }
    }

    render() {

        var href= '/subgoals/' + this.props.goal.id;

        return (
            <div className="panel front-end-goal">
                <a href={href}>

                <h2>{this.props.goal.name}</h2>

                <h4><i className="fa fa-usd" aria-hidden="true"></i> {this.props.goal.cost}</h4>
                <h4><i className="fa fa-calendar" aria-hidden="true"></i> {this.props.goal.days}</h4>
                <h4><i className="fa fa-clock-o" aria-hidden="true"></i> {this.props.goal.hours}</h4>
                <h4><i className="fa fa-user" aria-hidden="true"></i> {this.props.goal.goal.subgoals_count}</h4>
                <br/>
                </a>

            </div>

        );

    }
}

export default YourGoal;
