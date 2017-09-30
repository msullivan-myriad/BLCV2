import React, { Component } from 'react';


class AddGoal extends Component {

    constructor(props) {
        super(props);

        this.state = {
            cost: '',
            days: '',
            hours: '',
        }

        this.costChange = this.costChange.bind(this);
        this.daysChange = this.daysChange.bind(this);
        this.hoursChange = this.hoursChange.bind(this);

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


    render() {

        return (
            <div className="panel add-goal">

                <h2>{this.props.goal.name}</h2>
                <h4><i className="fa fa-usd" aria-hidden="true"></i> <input value={this.state.cost} onChange={this.costChange}/></h4>
                <h4><i className="fa fa-calendar" aria-hidden="true"></i> <input value={this.state.days} onChange={this.daysChange}/></h4>
                <h4><i className="fa fa-clock-o" aria-hidden="true"></i> <input value={this.state.hours} onChange={this.hoursChange}/></h4>
                <br/>
            </div>

        );

    }
}

export default AddGoal;
