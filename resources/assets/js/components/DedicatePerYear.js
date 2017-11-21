import React, { Component } from 'react';
import axios from 'axios';
import YourGoal from './YourGoal';

import { Button } from 'antd';
import { InputNumber } from 'antd';

class DedicatePerYear extends Component {

    constructor(props) {

        super(props);

        this.state = {
            cost: 0,
            hours: 0,
            days: 0,
        };

        this.onCostChange = this.onCostChange.bind(this);
        this.onHoursChange = this.onHoursChange.bind(this);
        this.onDaysChange = this.onDaysChange.bind(this);
        this.setProfileValues = this.setProfileValues.bind(this);

    }

    componentDidMount() {
        axios.get('/api/profile/dedicated-per-year')
            .then(response => {
                console.log(response.data.data);
                const data = response.data.data;

                const cost = data.cost_per_year;
                const days = data.days_per_year;
                const hours = data.hours_per_year/12;

                this.setState({
                    cost: cost,
                    days: days,
                    hours: hours,
                })
            });
    }

    setProfileValues() {

        //This value is getting set, but is delayed by one onChange action

        axios.post('/api/profile/dedicated-per-year', {
                cost_per_year: this.state.cost,
                days_per_year: this.state.days,
                hours_per_year: this.state.hours * 12,
            })
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });

        console.log('Set profile values');
    }

    onCostChange(value) {
        this.setState({
            cost: value,
        },
            this.setProfileValues()
        )

    }

    onHoursChange(value) {
        this.setState({
            hours: value,
        },
            this.setProfileValues()
        )

    }

    onDaysChange(value) {
        this.setState({
            days: value,
        },
            this.setProfileValues()
        )

    }

    render() {
        return (
            <div>
                <div className="calibrate-section">

                    <p>I can set aside this much per year to accomplishing my bucket list goals:</p>
                    <InputNumber
                        value={this.state.cost}
                        min={0}
                        max={100000000}
                        formatter={value => `$ ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')}
                        parser={value => value.replace(/\$\s?|(,*)/g, '')}
                        onChange={this.onCostChange}
                    />

                    <p>I can set aside this many hours per month to accomplishing my bucket list goals</p>
                    <InputNumber
                        min={0}
                        max={500}
                        value={this.state.hours}
                        onChange={this.onHoursChange}
                    />

                    <p>I can set aside this many days per year to accomplishing my bucket list goals</p>
                    <InputNumber
                        min={0}
                        max={365}
                        value={this.state.days}
                        onChange={this.onDaysChange}
                    />

                </div>
            </div>
        );
    }
}


export default DedicatePerYear;

