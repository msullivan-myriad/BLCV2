import React, { Component } from 'react';


class YourGoal extends Component {

    constructor(props) {
        super(props);

        this.state = {
        }

    }

    render() {

        var href= '/goal/' + this.props.goal.slug;

        var goalInfoStyle = {
            display: 'inline-block',
            padding: '4px 8px',
        }

        return (
            <div className="panel your-goal">
                <a href={href}>

                    <h4>{this.props.goal.name}</h4>

                    <h5 className="goal-info" style={goalInfoStyle}><i className="fa fa-usd" aria-hidden="true"></i> {this.props.goal.cost}</h5>
                    <h5 className="goal-info" style={goalInfoStyle}><i className="fa fa-calendar" aria-hidden="true"></i> {this.props.goal.days}</h5>
                    <h5 className="goal-info" style={goalInfoStyle}><i className="fa fa-clock-o" aria-hidden="true"></i> {this.props.goal.hours}</h5>
                    <h5 className="goal-info" style={goalInfoStyle}><i className="fa fa-user" aria-hidden="true"></i> {this.props.goal.goal.subgoals_count}</h5>

                    <br/>

                </a>

            </div>


        );

    }
}

export default YourGoal;
