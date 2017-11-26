import React, { Component } from 'react';
import axios from 'axios';
import YourGoal from './YourGoal';

import { Button } from 'antd';
import { InputNumber } from 'antd';
import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;

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
        };

        this.onCostChange = this.onCostChange.bind(this);
        this.onHoursChange = this.onHoursChange.bind(this);
        this.onDaysChange = this.onDaysChange.bind(this);
        this.onAgeChange = this.onAgeChange.bind(this);
        this.setProfileValues = this.setProfileValues.bind(this);
        this.getMostAndLeastDifficult = this.getMostAndLeastDifficult.bind(this);

    }

    componentDidMount() {

        axios.get('/api/profile/dedicated-per-year')
            .then(response => {
                console.log(response.data.data);
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
                })
            });

        this.getMostAndLeastDifficult();

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

    setProfileValues() {

        var parent = this;

        axios.post('/api/profile/dedicated-per-year', {
                age: this.state.age,
                cost_per_year: this.state.cost,
                days_per_year: this.state.days,
                hours_per_year: this.state.hours * 12,
            })
            .then(function (response) {

                console.log(response);
                parent.getMostAndLeastDifficult();

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

    onAgeChange(value) {
        this.setState({
            age: value,
        })
    }


    render() {
        return (
            <div>
                <div className="row">
                    <div className="col-md-6">

                        <div className="calibrate-section">

                            <br/>
                            <h3>First we need some basic information</h3>
                            <br/>
                            <p>How old are you?</p>

                            <InputNumber
                                min={0}
                                max={200}
                                value={this.state.age}
                                onChange={this.onAgeChange}
                            />


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

            </div>
        );
    }
}


export default DedicatePerYear;

