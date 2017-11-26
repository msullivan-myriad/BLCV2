import React, { Component } from 'react';
import axios from 'axios';
import YourGoal from './YourGoal';

import {BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, Legend} from 'recharts';


import { Button } from 'antd';
import { InputNumber } from 'antd';

class AgeSection extends Component {

    constructor(props) {

        super(props);

        this.state = {
            completionAge: 0,
            barChartData: [
                {
                    name: '',
                    Years: 0,
                },
                 {
                    name: '',
                    Years: 0,
                },
                 {
                    name: '',
                    Years: 0,
                },
            ]
        };

        this.onCompletionAgeChange = this.onCompletionAgeChange.bind(this);
        this.setAgeValues = this.setAgeValues.bind(this);

    }

    componentDidMount() {

        axios.get('/api/stats/completion-age')
            .then(response => {
                console.log(response.data.data);

                const data = response.data.data;
                const cost_years = data.cost_years;
                const days_years = data.days_years;
                const hours_years = data.hours_years;

                let newBarChartData = [];

                newBarChartData.push(
                    {name: 'Cost', Years: cost_years}
                );
                newBarChartData.push(
                    {name: 'Days', Years: days_years}
                );
                newBarChartData.push(
                    {name: 'Hours', Years: hours_years}
                );

                newBarChartData.sort(function(a, b) {
                    return a.Years < b.Years;
                });

                console.log(newBarChartData);

                this.setState({
                    barChartData: newBarChartData,
                    completionAge: newBarChartData[0].Years,
                })

            });

    }

    setAgeValues() {
        console.log('test');
    }

    onCompletionAgeChange(value) {
        this.setState({
            completionAge: value,
        })

    }

    render() {

        return (
            <div className="age-section">

                <br/>
                <h4>Estimated goal completion date: {this.state.completionAge} years</h4>
                <br/>

                <BarChart width={600} height={300} data={this.state.barChartData} layout={'vertical'}
                          margin={{top: 5, right: 5, left: 5, bottom: 5}}
                >
                    <XAxis type="number" dataKey="Years"/>
                    <YAxis type="category" dataKey="name"/>
                    <CartesianGrid strokeDasharray="3 3"/>
                    <Tooltip/>
                    <Legend />
                    <Bar dataKey="Years" fill="#8884d8" />
                </BarChart>


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

