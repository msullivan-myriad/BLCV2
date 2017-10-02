import React, { Component } from 'react';
import axios from 'axios';


class AddGoal extends Component {

    constructor(props) {
        super(props);

        this.state = {
            id: '',
            cost: '',
            days: '',
            hours: '',
            editingCost: '',
            editingDays: '',
            editingHours: '',
            editing: false,
            adding: false,
        }

        this.costChange = this.costChange.bind(this);
        this.daysChange = this.daysChange.bind(this);
        this.hoursChange = this.hoursChange.bind(this);
        this.addingGoal = this.addingGoal.bind(this);
        this.editingGoal = this.editingGoal.bind(this);
        this.editedGoalSubmit = this.editedGoalSubmit.bind(this);
        this.editedGoalExit = this.editedGoalExit.bind(this);
        this.addGoalWithDefaults= this.addGoalWithDefaults.bind(this);
    }


    componentDidMount() {

        this.setState({
            id: this.props.goal.id,
            cost: this.props.goal.cost,
            days: this.props.goal.days,
            hours: this.props.goal.hours,
            editingCost: this.props.goal.cost,
            editingDays: this.props.goal.days,
            editingHours: this.props.goal.hours,
        })

    }

    costChange(event) {
        this.setState({
            editingCost: event.target.value,
        })
    }

    daysChange(event) {
        this.setState({
            editingDays: event.target.value,
        })
    }

    hoursChange(event) {
        this.setState({
            editingHours: event.target.value,
        })
    }

    addingGoal() {
        this.setState({
            adding: !this.state.adding
        })
    }

    editingGoal() {
        this.setState({
            editing: !this.state.editing
        })
    }

    addGoalWithDefaults() {

        var url = '/goals/' + this.state.id;

        console.log(url);

        //Left off right here
        /*
        axios.post(url)

        .then(response => {
            console.log(response);
        })

        .catch(response => {
            console.log(response);
        });
        */
    }

    editedGoalSubmit() {
        console.log("Editing goal submit");
    }

    editedGoalExit() {

        this.setState({
            editingCost: this.state.cost,
            editingDays: this.state.days,
            editingHours: this.state.hours,
            adding: false,
            editing: false,
        })

    }

    render() {

        var inputClasses = 'default';
        var fieldsAreDisabled = true;
        var overlayClasses = 'overlay hidden';

        if (this.state.adding) {
            overlayClasses = 'overlay active';
        }

        if (this.state.editing) {
            fieldsAreDisabled = false;
            inputClasses = 'editing';
        }


        var rightButtonArea = <div className="right-button-area">
                                    <button onClick={this.addingGoal}>
                                        <i className="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>;


        if (this.state.editing) {

            rightButtonArea = <div className="right-button-area">
                                <button onClick={this.editedGoalSubmit}>
                                    <i className="fa fa-check" aria-hidden="true"></i>
                                </button>
                                <button onClick={this.editedGoalExit}>
                                    <i className="fa fa-times" aria-hidden="true"></i>
                                </button>
                              </div>
        }


        return (
            <div className="panel add-goal">

                <h4>{this.props.goal.name}</h4>
                <h5><i className="fa fa-usd" aria-hidden="true"></i> <input size={this.state.editingCost.toString().length} className={inputClasses} disabled={fieldsAreDisabled} value={this.state.editingCost} onChange={this.costChange}/></h5>
                <h5><i className="fa fa-clock-o" aria-hidden="true"></i> <input size={this.state.editingHours.toString().length} className={inputClasses} disabled={fieldsAreDisabled} value={this.state.editingHours} onChange={this.hoursChange}/></h5>
                <h5><i className="fa fa-calendar" aria-hidden="true"></i> <input size={this.state.editingDays.toString().length} className={inputClasses} disabled={fieldsAreDisabled} value={this.state.editingDays} onChange={this.daysChange}/></h5>
                <br/>

                {rightButtonArea}

                <div className={overlayClasses}>
                    <button onClick={this.addGoalWithDefaults}>
                        <i className="fa fa-thumbs-up" aria-hidden="true"></i>
                        Use defaults
                    </button>
                    <button onClick={this.editingGoal}>
                        <i className="fa fa-pencil" aria-hidden="true"></i>
                        Edit values
                    </button>
                </div>
            </div>

        );

    }
}

export default AddGoal;
