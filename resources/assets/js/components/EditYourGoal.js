import React, { Component } from 'react';
import { Button } from 'antd';
import axios from 'axios';
import { notification } from 'antd';

class EditYourGoal extends Component {

    constructor(props) {
        super(props);

        this.state = {
            subgoal: '',
            newCost: 0,
            newDays: 0,
            newHours: 0,
        }

        this.costChange = this.costChange.bind(this);
        this.hoursChange = this.hoursChange.bind(this);
        this.daysChange = this.daysChange.bind(this);
        this.updateGoal = this.updateGoal.bind(this);
        this.deleteGoal = this.deleteGoal.bind(this);

    }

    componentDidMount() {

        const url = '/api/subgoals/single/' + this.props.slug;


        axios.get(url)
            .then(response => {
                    const subgoal = response.data.data.subgoal;

                    this.setState({
                        subgoal: subgoal,
                        newCost: subgoal.cost,
                        newHours: subgoal.hours,
                        newDays: subgoal.days,
                    })
            });

    }

    costChange(event) {

        let newCost = event.target.value;
        this.setState({ newCost })

    }

    hoursChange(event) {

        let newHours = event.target.value;
        this.setState({ newHours })

    }

    daysChange(event) {

        let newDays = event.target.value;
        this.setState({ newDays })

    }

    updateGoal() {


        var url = '/api/subgoals/' + this.state.subgoal.id;

        axios.post(url, {
            cost: this.state.newCost,
            days: this.state.newDays,
            hours: this.state.newHours,
        })

        .then(response => {

            console.log(response);

            notification.open({
                message: 'Success',
                description: this.state.subgoal.name + ' was successully updated',
                type: 'success',
            });

        })

        .catch(error => {

            console.log(error);

            notification.open({
                message: 'Error',
                description: 'Somethings not right, try editing your goal again',
                type: 'error',
            });

            this.setState({
                newCost: this.state.subgoal.cost,
                newHours: this.state.subgoal.hours,
                newDays: this.state.subgoal.days,
            })

        })

    }

    deleteGoal() {


        var url = '/api/subgoals/' + this.state.subgoal.id;

        axios.delete(url)

        .then(response => {

            console.log(response);

            notification.open({
                message: 'Success',
                description: this.state.subgoal.name + ' was succesfully removed from your list, redirecting back to your previous page',
                type: 'success',
            },
                window.setTimeout(function() { history.go(-1) } , 2000)
            );


        })

        .catch(error => {

            console.log(error);

            notification.open({
                message: 'Error',
                description: 'Something went wrong, try deleting your goal again',
                type: 'error',
            });

        })


    }

    render() {

        const inputStyles = {
            display: 'inline-block',
        }

        const subgoal = this.state.subgoal;

        return (
            <div className="edit-your-goal-section">

                <div className="panel edit-goal">
                    <h4>{subgoal.name}</h4>

                    <h5 style={inputStyles}><i className="fa fa-usd" aria-hidden="true"></i> <input size={this.state.newCost.toString().length} value={this.state.newCost} onChange={this.costChange}/></h5>
                    <h5 style={inputStyles}><i className="fa fa-clock-o" aria-hidden="true"></i> <input size={this.state.newHours.toString().length} value={this.state.newHours} onChange={this.hoursChange}/></h5>
                    <h5 style={inputStyles}><i className="fa fa-calendar" aria-hidden="true"></i> <input size={this.state.newDays.toString().length} value={this.state.newDays} onChange={this.daysChange}/></h5>

                    <br/>
                    <br/>

                    <Button onClick={this.updateGoal}>Update</Button>
                    <Button type="danger" onClick={this.deleteGoal}><i className="fa fa-trash" aria-hidden="true"></i></Button>

                    <br/>

                </div>

            </div>

        );

    }
}

export default EditYourGoal;
