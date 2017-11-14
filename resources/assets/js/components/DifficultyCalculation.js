import React, { Component } from 'react';
import axios from 'axios';

import { Button } from 'antd';
import { InputNumber } from 'antd';

class DifficultyCalculation extends Component {

    constructor(props) {

        super(props);

        this.state = {
            difficulty: '',
            costPerDay: 0,
            dayCost: 0,
            costPerHour: 0,
            hoursCost: 0,
        };

        this.onPerDayChange = this.onPerDayChange.bind(this);
        this.onPerHourChange = this.onPerHourChange.bind(this);
        this.calculateDifficulty = this.calculateDifficulty.bind(this);

    }

    componentDidMount() {
        axios.get('/api/stats/difficulty')
            .then(response => {
                console.log(response)
                const difficulty = response.data;
                this.setState({ difficulty })
            });
    }

    onPerDayChange(value) {
        this.setState({
            dayCost: value,
            costPerDay: value/10
        })
    }

    onPerHourChange(value) {
        this.setState({
            hoursCost: value,
            costPerHour: value/20
        })
    }

    calculateDifficulty() {
        console.log('Getting here');
    }

    render() {
        return (
            <div>
                <div className="calibrate-section">

                    <p>In order to help you find out which goals will be the most difficult we need to do a little calibration.</p>
                    <br/>
                    <p>Dedicating 10 straight days to traveling is roughly as difficult for you as saving</p>

                    <InputNumber
                        value={this.state.dayCost}
                        formatter={value => `$ ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')}
                        parser={value => value.replace(/\$\s?|(,*)/g, '')}
                        onChange={this.onPerDayChange}
                    />

                    <p>Spending 20 hours a per month about as difficult as saving </p>
                    <InputNumber
                        value={this.state.hoursCost}
                        formatter={value => `$ ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')}
                        parser={value => value.replace(/\$\s?|(,*)/g, '')}
                        onChange={this.onPerHourChange}
                    />

                    <Button onClick={this.calculateDifficulty}>Default</Button>


                </div>
            </div>
        );
    }
}


export default DifficultyCalculation;

