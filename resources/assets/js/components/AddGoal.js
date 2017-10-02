import React, { Component } from 'react';


class AddGoal extends Component {

    constructor(props) {
        super(props);

        this.state = {
            cost: '',
            days: '',
            hours: '',
            editing: false,
            adding: false,
        }

        this.costChange = this.costChange.bind(this);
        this.daysChange = this.daysChange.bind(this);
        this.hoursChange = this.hoursChange.bind(this);
        this.addingGoal = this.addingGoal.bind(this);
        this.editingGoal = this.editingGoal.bind(this);

    }

    componentDidMount() {

        this.setState({
            cost: this.props.goal.cost,
            days: this.props.goal.days,
            hours: this.props.goal.hours,
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

    editingGoal() {
        this.setState({
            editing: !this.state.editing
        })
    }

    editedGoalSubmit() {
        console.log("Editing goal submit");
    }

    editedGoalExit() {
        console.log("Exiting editing goal pane");
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
                <h5><i className="fa fa-usd" aria-hidden="true"></i> <input size={this.state.cost.toString().length} className={inputClasses} disabled={fieldsAreDisabled} value={this.state.cost} onChange={this.costChange}/></h5>
                <h5><i className="fa fa-clock-o" aria-hidden="true"></i> <input size={this.state.hours.toString().length} className={inputClasses} disabled={fieldsAreDisabled} value={this.state.hours} onChange={this.hoursChange}/></h5>
                <h5><i className="fa fa-calendar" aria-hidden="true"></i> <input size={this.state.days.toString().length} className={inputClasses} disabled={fieldsAreDisabled} value={this.state.days} onChange={this.daysChange}/></h5>
                <br/>

                {rightButtonArea}

                <div className={overlayClasses}>
                    <button>
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
