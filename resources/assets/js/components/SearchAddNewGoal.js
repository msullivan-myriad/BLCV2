import React, { Component } from 'react';
import axios from 'axios';
import { notification } from 'antd';


class SearchAddNewGoal extends Component {

    constructor(props) {
        super(props);

        this.state = {
            cost: '',
            days: '',
            hours: '',
            initial: true,
            adding: false,
        }

        this.costChange = this.costChange.bind(this);
        this.daysChange = this.daysChange.bind(this);
        this.hoursChange = this.hoursChange.bind(this);
        this.addingGoal = this.addingGoal.bind(this);
        this.addGoal= this.addGoal.bind(this);
    }


    componentDidMount() {

        this.setState({
            name: this.props.term,
        })

    }

    costChange(event) {
        this.setState({
            cost: event.target.value,
        })
    }

    daysChange(event) {
        this.setState({
            days: event.target.value,
        })
    }

    hoursChange(event) {
        this.setState({
            hours: event.target.value,
        })
    }

    addingGoal() {
        this.setState({
            adding: !this.state.adding
        })
    }

    addGoal() {

        /*

        var url = '/api/goals/';

        axios.post(url, {
            cost: this.state.editingCost,
            days: this.state.editingDays,
            hours: this.state.editingHours,
            goal_id: this.state.id,
        })

        .then(response => {

            notification.open({
                message: 'Success',
                description: this.state.name + ' was added to your list',
                type: 'success',
            });

        })

        .catch(error => {

            if (error.response.data.goal_id) {

                notification.open({
                    message: 'Error',
                    description: this.state.name + ' is already on your list',
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

        this.setState({
            adding: false,
            editing: false
        })
        */
    }

    render() {


        var costStyle = {};
        var hoursStyle = {};
        var daysStyle = {};

        if (!this.state.cost.toString().length) {
            costStyle = {
                width: '50px'
            };
        }

        if (!this.state.hours.toString().length) {
            hoursStyle = {
                width: '50px'
            };
        }

        if (!this.state.days.toString().length) {
            daysStyle = {
                width: '50px'
            };
        }


        return (
            <div className="panel add-goal">

                <h4>{this.props.term}</h4>
                <h5><i className="fa fa-usd" aria-hidden="true"></i> <input size={this.state.cost.toString().length} value={this.state.cost} onChange={this.costChange} placeholder="???" style={costStyle} /></h5>
                <h5><i className="fa fa-clock-o" aria-hidden="true"></i> <input size={this.state.hours.toString().length} value={this.state.hours} onChange={this.hoursChange} placeholder="???" style={hoursStyle} /></h5>
                <h5><i className="fa fa-calendar" aria-hidden="true"></i> <input size={this.state.days.toString().length} value={this.state.days} onChange={this.daysChange} placeholder="???" style={daysStyle} /></h5>
                <br/>

                <div className="right-button-area">
                    <button onClick={this.addingGoal}>
                        <i className="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </div>

            </div>

        );

    }
}

export default SearchAddNewGoal;
