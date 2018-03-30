import React, { Component } from 'react';
import axios from 'axios';
import { notification } from 'antd';


class AddGoal extends Component {

    constructor(props) {
        super(props);

        this.state = {}

        this.addGoal= this.addGoal.bind(this);
    }


    componentDidMount() {

        this.setState({
            id: this.props.goal.id,
            name: this.props.goal.name,
            cost: this.props.goal.cost,
            days: this.props.goal.days,
            hours: this.props.goal.hours,
        })
    }


    addGoal() {

        var url = '/api/goals/';

        axios.post(url, {
            cost: this.props.goal.cost,
            days: this.props.goal.days,
            hours: this.props.goal.hours,
            goal_id: this.props.goal.id,
        })

        .then(response => {

            notification.open({
                message: 'Success',
                description: this.props.goal.name + ' was added to your list',
                type: 'success',
            });

        })

        .catch(error => {

            if (error.response.data.goal_id) {

                notification.open({
                    message: 'Error',
                    description: this.props.goal.name + ' is already on your list',
                    type: 'error',
                });

            }
            else {

                notification.open({
                    message: 'Error',
                    description: 'It looks like something went wrong',
                    type: 'error',
                });

            }

        });

    }

    render() {

        return (
            <div className="panel add-goal">

                <h4>{this.props.goal.name}</h4>
                <h5><i className="fa fa-usd" aria-hidden="true"></i>{' ' + this.props.goal.cost}</h5>
                <h5><i className="fa fa-clock-o" aria-hidden="true"></i> {' ' + this.props.goal.hours}</h5>
                <h5><i className="fa fa-calendar" aria-hidden="true"></i> {' ' + this.props.goal.days} </h5>
                <br/>

                <div className="right-button-area">
                    <button onClick={this.addGoal}>
                        <i className="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    <button onClick={ () => window.location = 'goal/' + this.props.goal.slug}>
                        <i className="fa fa-info-circle"></i>
                    </button>
                </div>

            </div>

        );

    }
}

export default AddGoal;
