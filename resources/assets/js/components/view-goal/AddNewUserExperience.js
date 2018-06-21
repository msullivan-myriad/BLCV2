import React, { Component } from 'react';
import { Input, Button } from 'antd';
const { TextArea } = Input;
import axios from 'axios';

class AddNewUserExperience extends Component {

    constructor(props) {
        super(props);

        this.state = {
            cost: '',
            days: '',
            hours: '',
            text: '',
        }

        this.changeCost = this.changeCost.bind(this);
        this.changeDays = this.changeDays.bind(this);
        this.changeHours = this.changeHours.bind(this);
        this.changeText = this.changeText.bind(this);
        this.submitExperience = this.submitExperience.bind(this);

    }

    changeCost(event) {
        this.setState({
            cost: event.target.value,
        })
    }

    changeDays(event) {
        this.setState({
            days: event.target.value,
        })
    }

    changeHours(event) {
        this.setState({
            hours: event.target.value,
        })
    }

    changeText(event) {
        this.setState({
            text: event.target.value,
        })
    }

    submitExperience() {

        axios.post('/api/experiences/' + this.props.goalId, {
            cost:  this.state.cost,
            days: this.state.days,
            hours: this.state.hours,
            text: this.state.text
        })
    }

    render() {

        return (

            <div>

                <p>Have you done this before?  Have experience?  Please add it below!</p>

                <Input placeholder="Cost" value={this.state.cost} onChange={this.changeCost}/>
                <Input placeholder="Days" value={this.state.days} onChange={this.changeDays}/>
                <Input placeholder="Hours" value={this.state.hours} onChange={this.changeHours}/>
                <TextArea rows={4} value={this.state.text} onChange={this.changeText}/>
                <Button onSubmit={this.submitExperience}>Submit</Button>

            </div>

        );

    }
}

export default AddNewUserExperience;
