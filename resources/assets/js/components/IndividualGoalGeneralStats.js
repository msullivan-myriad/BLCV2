import React, { Component } from 'react';
import { CirclePie, BarMetric, Area } from 'react-simple-charts';
import axios from 'axios';
import {LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend} from 'recharts';
import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;




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
            tags: [],
        }

    }

    componentDidMount() {

        const url = '/api/stats/individual-goal-general-stats/' + this.state.slug;

        axios.get(url)
            .then(response => {

                const goalCountChartData = response.data.goal_count_data;
                const costChartData = response.data.cost_array;
                const daysChartData = response.data.days_array;
                const hoursChartData = response.data.hours_array;
                const tags = response.data.tags;

                this.setState({
                    goalCountChartData,
                    costChartData,
                    daysChartData,
                    hoursChartData,
                    tags,
                })

            });

    }

    render() {

        return (

            <div className="individual-goal-genera-stats">
                <br/>
                <br/>
                <h4>How this goal is trending:</h4>
                <br/>

                <Tabs defaultActiveKey="1">

                    <TabPane tab="Popularity" key="1">

                        <LineChart width={500} height={220} data={this.state.goalCountChartData}  >
                            <CartesianGrid strokeDasharray="3 3" />
                            <YAxis />
                            <XAxis dataKey="Date" hide="true"/>
                            <Tooltip />
                            <Line type="monotone" dataKey="Goals" stroke="#8884d8" />
                        </LineChart>
                        <br/>

                    </TabPane>


                    <TabPane tab="Cost" key="2">

                        <LineChart width={500} height={220} data={this.state.costChartData}  >
                            <CartesianGrid strokeDasharray="3 3" />
                            <YAxis />
                            <XAxis dataKey="Date" hide="true"/>
                            <Tooltip />
                            <Line type="monotone" dataKey="Cost" stroke="#8884d8" />
                        </LineChart>
                        <br/>

                    </TabPane>


                    <TabPane tab="Hours" key="3">

                        <LineChart width={500} height={220} data={this.state.hoursChartData}  >
                            <CartesianGrid strokeDasharray="3 3" />
                            <YAxis />
                            <XAxis dataKey="Date" hide="true"/>
                            <Tooltip />
                            <Line type="monotone" dataKey="Hours" stroke="#8884d8" />
                        </LineChart>
                        <br/>

                    </TabPane>


                    <TabPane tab="Days" key="4">

                        <LineChart width={500} height={220} data={this.state.daysChartData}  >
                            <CartesianGrid strokeDasharray="3 3" />
                            <YAxis />
                            <XAxis dataKey="Date" hide="true"/>
                            <Tooltip />
                            <Line type="monotone" dataKey="Days" stroke="#8884d8" />
                        </LineChart>
                        <br/>

                    </TabPane>


                </Tabs>

                <h4>This goal has the following tags:</h4>
                {this.state.tags.map(tag =>
                    <a href={'/category/' + tag.slug} className="label label-primary">{tag.name}</a>
                )}


            </div>
        );

    }
}

export default IndividualGoalGeneralStats;
