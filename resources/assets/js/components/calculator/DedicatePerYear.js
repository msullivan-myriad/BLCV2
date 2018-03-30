import React, { Component } from 'react';
import axios from 'axios';
import YourGoal from './../YourGoal';

import { Button } from 'antd';
import { InputNumber } from 'antd';
import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;
import {BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, Legend} from 'recharts';
import { Slider } from 'antd';
import moment from 'moment';

class DedicatePerYear extends Component {

    constructor(props) {

        super(props);

        this.state = {
            age: 0,
            cost: 0,
            hours: 0,
            days: 0,
            subgoals: [],
            first: [],
            last: [],
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
            ],
            currentAge: 0,
            targetCompletionAge: 100,
            targetCost: 0,
            targetHours: 0,
            targetDays: 0,
        };

        this.onCostChange = this.onCostChange.bind(this);
        this.onHoursChange = this.onHoursChange.bind(this);
        this.onDaysChange = this.onDaysChange.bind(this);
        this.setProfileValues = this.setProfileValues.bind(this);
        this.getMostAndLeastDifficult = this.getMostAndLeastDifficult.bind(this);
        this.getCompletionAge = this.getCompletionAge.bind(this);
        this.onTargetCompletionAgeChange = this.onTargetCompletionAgeChange.bind(this);
        this.getTargetCompletionAgeData = this.getTargetCompletionAgeData.bind(this);
        this.onTargetCompletionAgeChange = this.onTargetCompletionAgeChange.bind(this);

    }


    componentDidMount() {

        axios.get('/api/profile/profile-information')
            .then(response => {
                const profile = response.data.data.profile;

                const cost = profile.cost_per_year;
                const days = profile.days_per_year;
                const hours = profile.hours_per_year/12;
                const age = moment().diff(profile.birthday, 'years', false);

                this.setState({
                    cost: cost,
                    days: days,
                    hours: hours,
                    age: age,
                    targetCompletionAge: age,
                })

            });

        /*
        axios.get('/api/profile/dedicated-per-year')
            .then(response => {
                const data = response.data.data;

                const cost = data.cost_per_year;
                const days = data.days_per_year;
                const hours = data.hours_per_year/12;
                const age = data.age;

                this.setState({
                    cost: cost,
                    days: days,
                    hours: hours,
                    age: age,
                    targetCompletionAge: age,
                })
            });
            */

        this.getMostAndLeastDifficult();
        this.getCompletionAge();

    }

    getMostAndLeastDifficult() {

        axios.get('/api/stats/most-and-least-difficult')
            .then(response => {
                const subgoals = response.data.data.subgoals;

                //Need to think about how to handle this if users have less than 10 goals... What if they have a ton of goals and would like to load more?
                const first = subgoals.slice(0,5);
                const last = subgoals.slice(-5).reverse();

                this.setState({
                    subgoals: subgoals,
                    last: last,
                    first: first,
                })
            })

    }

    getCompletionAge() {

        axios.get('/api/stats/completion-age')
            .then(response => {

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

                this.setState({
                    barChartData: newBarChartData,
                    completionAge: newBarChartData[0].Years,
                })

            });

    }

    setProfileValues() {

        var parent = this;

        axios.post('/api/profile/dedicated-per-year', {
                //age: this.state.age,
                cost_per_year: this.state.cost,
                days_per_year: this.state.days,
                hours_per_year: this.state.hours * 12,
            })
            .then(function (response) {

                parent.getMostAndLeastDifficult();
                parent.getCompletionAge();

            })
            .catch(function (error) {
                console.log(error);
            });

    }

    onCostChange(value) {
        this.setState({
            cost: value,
        })
    }

    onHoursChange(value) {
        this.setState({
            hours: value,
        })
    }

    onDaysChange(value) {
        this.setState({
            days: value,
        })
    }

    onTargetCompletionAgeChange(value) {


        this.setState({
            targetCompletionAge: value,
        },

        this.getTargetCompletionAgeData(value)

        )
    }

    getTargetCompletionAgeData(age) {

        const url = '/api/stats/target-completion-age/' + age;

        axios.get(url)

            .then(response => {


                const data = response.data.data;
                const targetCost = data.cost_per_year;
                const targetDays = data.days_per_year;
                const targetHours = data.hours_per_year;

                this.setState({
                    targetCost: targetCost,
                    targetDays: targetDays,
                    targetHours: targetHours,
                })


            });

    }



    render() {

        //Set up the cost array for barcharts data
        var costObject = {
            name: 'Cost Per Year',
        };

        costObject.original = this.state.cost;
        costObject.target = this.state.targetCost;

        var costArray = [];
        costArray.push(costObject);

        //Set up the days array for barcharts data
        var daysObject = {
            name: 'Days Per Year',
        };

        daysObject.original = this.state.days;
        daysObject.target = this.state.targetDays;

        var daysArray = [];
        daysArray.push(daysObject);

        //Set up the hours array for barcharts data
        var hoursObject = {
            name: 'Hours Per Month',
        };

        hoursObject.original = this.state.hours;
        hoursObject.target = Math.round(this.state.targetHours/12);

        var hoursArray = [];
        hoursArray.push(hoursObject);


        return (
            <div>
                <div className="row">
                    <div className="col-md-6">

                        <div className="calibrate-section">

                            <br/>
                            <h3>First we need some basic information</h3>
                            <br/>


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

                            <Button onClick={this.setProfileValues}>Update</Button>

                        </div>

                    </div>

                    <div className="col-md-6">

                        <div className="most-least-hardest-section">

                            <Tabs defaultActiveKey="1">

                                <TabPane tab="Most Difficult" key="1">

                                    {this.state.first.map(goal =>
                                        <YourGoal goal={goal} key={goal.id}/>
                                    )}

                                </TabPane>

                                <TabPane tab="Least Difficult" key="2">

                                    {this.state.last.map(goal =>
                                        <YourGoal goal={goal} key={goal.id}/>
                                    )}

                                </TabPane>

                            </Tabs>

                        </div>

                    </div>

                </div>

                <br/>
                <h4>Estimated goal completion age: {this.state.completionAge + this.state.age}</h4>
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


                <p>At what age would you like to be completed with your goals?</p>

                <Slider value={this.state.targetCompletionAge} min={this.state.age + 1} max={100} onChange={this.onTargetCompletionAgeChange}/>

                <h2>{this.state.targetCompletionAge}</h2>

                <br/>
                <br/>

                <BarChart width={240} height={300} data={costArray}
                          margin={{top: 5, right: 30, left: 20, bottom: 5}} style={{display: 'inline-block'}}>
                    <XAxis dataKey="name"/>
                    <YAxis/>
                    <CartesianGrid strokeDasharray="3 3"/>
                    <Tooltip/>
                    <Legend />
                    <Bar dataKey="original" fill="#82ca9d" />
                    <Bar dataKey="target" fill="#8884d8" />
                </BarChart>


                <BarChart width={240} height={300} data={daysArray}
                          margin={{top: 5, right: 30, left: 20, bottom: 5}} style={{display: 'inline-block'}}>
                    <XAxis dataKey="name"/>
                    <YAxis/>
                    <CartesianGrid strokeDasharray="3 3"/>
                    <Tooltip/>
                    <Legend />
                    <Bar dataKey="original" fill="#82ca9d" />
                    <Bar dataKey="target" fill="#8884d8" />
                </BarChart>


                <BarChart width={240} height={300} data={hoursArray}
                          margin={{top: 5, right: 30, left: 20, bottom: 5}} style={{display: 'inline-block'}}>
                    <XAxis dataKey="name"/>
                    <YAxis/>
                    <CartesianGrid strokeDasharray="3 3"/>
                    <Tooltip/>
                    <Legend />
                    <Bar dataKey="original" fill="#82ca9d" />
                    <Bar dataKey="target" fill="#8884d8" />
                </BarChart>


            </div>
        );
    }
}


export default DedicatePerYear;

