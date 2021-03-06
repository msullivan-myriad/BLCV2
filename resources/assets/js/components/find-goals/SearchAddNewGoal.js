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
            title: this.props.term,
        }

        this.costChange = this.costChange.bind(this);
        this.daysChange = this.daysChange.bind(this);
        this.hoursChange = this.hoursChange.bind(this);
        this.titleChange = this.titleChange.bind(this);
        this.addGoal= this.addGoal.bind(this);
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

    titleChange(event) {
        this.setState({
            title: event.target.value,
        })
    }



    addGoal() {


        var url = '/api/goals/create';

        axios.post(url, {

            cost: this.state.cost,
            days: this.state.days,
            hours: this.state.hours,
            title: this.props.term,
        })

        .then(response => {

            notification.open({
                message: 'Success',
                description: this.props.term + ' was added to your list, redirecting back to goals page',
                type: 'success',
            });

            window.setTimeout(function() { window.location = '/goals' } , 2000)

        })

        .catch(error => {

            notification.open({
                message: 'Something went wrong',
                description: this.props.term + ' was not added to your list',
                type: 'error',
            });

        });

    }

    render() {


        var costStyle = {};
        var hoursStyle = {};
        var daysStyle = {};
        var buttonDisabled = true;

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


        if (this.state.cost.toString().length && this.state.hours.toString().length && this.state.days.toString().length) {
            buttonDisabled = false;
        }

        return (
            <div className="panel add-goal">

                <input size={this.state.cost.toString().length} value={this.state.title} onChange={this.titleChange} placeholder="???"/>
                <br/>
                <h5><i className="fa fa-usd" aria-hidden="true"></i> <input size={this.state.cost.toString().length} value={this.state.cost} onChange={this.costChange} placeholder="???" style={costStyle} /></h5>
                <h5><i className="fa fa-clock-o" aria-hidden="true"></i> <input size={this.state.hours.toString().length} value={this.state.hours} onChange={this.hoursChange} placeholder="???" style={hoursStyle} /></h5>
                <h5><i className="fa fa-calendar" aria-hidden="true"></i> <input size={this.state.days.toString().length} value={this.state.days} onChange={this.daysChange} placeholder="???" style={daysStyle} /></h5>
                <br/>

                <div className="right-button-area">
                    <button onClick={this.addGoal} disabled={buttonDisabled}>
                        <i className="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </div>

            </div>

        );

    }
}

export default SearchAddNewGoal;
