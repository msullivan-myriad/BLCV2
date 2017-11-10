import React, { Component } from 'react';
import axios from 'axios';

import { Slider, Switch } from 'antd';


class DifficultyCalculation extends Component {

    constructor(props) {

        super(props);

        this.state = {
            difficulty: '',
            moneyVsTime: 0,
            hoursVsDays: 0,
        };

        this.onMVTChange = this.onMVTChange.bind(this);
        this.onHVDChange = this.onHVDChange.bind(this);

    }

    componentDidMount() {
        axios.get('/api/stats/difficulty')
            .then(response => {
                console.log(response)
                const difficulty = response.data;
                this.setState({ difficulty })
            });
    }

    onMVTChange(value) {

        this.setState({
            moneyVsTime: value,
        });

    }

    onHVDChange(value) {

        this.setState({
            hoursVsDays: value,
        });

    }

    render() {
        return (
            <div>
                <p>Is it easier for you to save money or set aside time to accomplish your goals?</p>
                <h3>Money</h3>
                <Slider min={-100} max={100} onChange={this.onMVTChange} value={this.state.moneyVsTime} />
                <h3>Time</h3>
                <br/>
                <br/>
                <p>Is it easier for you to dedicate consecutive days to accompishing your goals or set aside an hour or two every day?</p>
                <h3>Days</h3>
                <Slider min={-100} max={100} onChange={this.onHVDChange} value={this.state.hoursVsDays} />
                <h3>Hours</h3>

                <p>{JSON.stringify(this.state.difficulty)}</p>
            </div>
        );
    }
}


export default DifficultyCalculation;

