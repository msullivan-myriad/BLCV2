import React, { Component } from 'react';
import { CirclePie, BarMetric, Area } from 'react-simple-charts';
import axios from 'axios';
import {LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend} from 'recharts';




class IndividualGoalGeneralStats extends Component {

    constructor(props) {
        super(props);

        const baseSlug = window.location.pathname;
        const slug = baseSlug.split('/')[2];

        this.state = {
            slug: slug,
            costChartData: [],
            hoursChartData: [],
            daysChartData: [],
        }

    }

    componentDidMount() {

        const url = '/api/stats/individual-goal-general-stats/' + this.state.slug;

        axios.get(url)
            .then(response => {

                const costChartData = response.data.cost_array;
                const daysChartData = response.data.days_array;
                const hoursChartData = response.data.hours_array;

                this.setState({
                    costChartData,
                    daysChartData,
                    hoursChartData,
                })

            });

    }

    render() {

        //Table this for now, more complex than I though... Numbers also need to go down rather than just up.  What if there are 1000 dates, they can't all fit on the graph.
        //There are a lot of things to think about when considering this graph

        return (

            <div className="individual-goal-genera-stats">
                <br/>
                <p>Individual goal general stats</p>

                <LineChart width={500} height={220} data={this.state.costChartData}  >
                    <CartesianGrid strokeDasharray="3 3" />
                    <YAxis />
                    <XAxis dataKey="Date" hide="true"/>
                    <Tooltip />
                    <Line type="monotone" dataKey="Cost" stroke="#8884d8" />
                </LineChart>

                <br/>

                <LineChart width={500} height={220} data={this.state.daysChartData}  >
                    <CartesianGrid strokeDasharray="3 3" />
                    <YAxis />
                    <XAxis dataKey="Date" hide="true"/>
                    <Tooltip />
                    <Line type="monotone" dataKey="Days" stroke="#8884d8" />
                </LineChart>

                <br/>

                <LineChart width={500} height={220} data={this.state.hoursChartData}  >
                    <CartesianGrid strokeDasharray="3 3" />
                    <YAxis />
                    <XAxis dataKey="Date" hide="true"/>
                    <Tooltip />
                    <Line type="monotone" dataKey="Hours" stroke="#8884d8" />
                </LineChart>



            </div>
        );

    }
}

export default IndividualGoalGeneralStats;
