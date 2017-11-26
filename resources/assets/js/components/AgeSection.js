import React, { Component } from 'react';
import axios from 'axios';
import YourGoal from './YourGoal';

import { Button } from 'antd';
import { InputNumber } from 'antd';

class AgeSection extends Component {

    constructor(props) {

        super(props);

        this.state = {
            currentAge: 1,
            completionAge: 1,
        };

        this.onCurrentAgeChange = this.onCurrentAgeChange.bind(this);
        this.onCompletionAgeChange = this.onCompletionAgeChange.bind(this);
        this.setAgeValues = this.setAgeValues.bind(this);

    }

    setAgeValues() {
        console.log('test');
    }

    onCurrentAgeChange(value) {
        this.setState({
            currentAge: value,
        })

    }

    onCompletionAgeChange(value) {
        this.setState({
            completionAge: value,
        })

    }

    render() {
        return (
            <div className="age-section">
                <h2>Age Section</h2>

                    <p>What is your current age?</p>

                    <InputNumber
                        min={1}
                        max={120}
                        value={this.state.currentAge}
                        onChange={this.onCurrentAgeChange}
                    />

                    <p>At what age would you like to be completed with your list?</p>

                    <InputNumber
                        min={1}
                        max={200}
                        value={this.state.completionAge}
                        onChange={this.onCompletionAgeChange}
                    />

                    <Button onClick={this.setAgeValues}>Update</Button>



            </div>
        );
    }
}


export default AgeSection;

