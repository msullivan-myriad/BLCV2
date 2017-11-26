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
        };

        this.onCompletionAgeChange = this.onCompletionAgeChange.bind(this);
        this.setAgeValues = this.setAgeValues.bind(this);

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

        const data = [
            {name: 'Page A', value: 4000 },
            {name: 'Page B', value: 3000},
            {name: 'Page C', value: 2000},
            {name: 'Page D', value: 2780},
            {name: 'Page E', value: 1890},
            {name: 'Page F', value: 2390},
            {name: 'Page G', value: 3490},
        ];

        return (
            <div className="age-section">
                <h2>Age Section</h2>

                <BarChart width={600} height={300} data={data} layout={'vertical'}
                          margin={{top: 5, right: 5, left: 5, bottom: 5}}
                >
                    <XAxis type="number" dataKey="value"/>
                    <YAxis type="category" dataKey="name"/>
                    <CartesianGrid strokeDasharray="3 3"/>
                    <Tooltip/>
                    <Legend />
                    <Bar dataKey="value" fill="#8884d8" />
                </BarChart>

                <h4>Estimated goal completion date: </h4>

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

