import React, { Component } from 'react';
import MyGoals from './../MyGoals';

import { Select } from 'antd';
const Option = Select.Option;

class UserSubgoalsSection extends Component {


    constructor(props) {
        super(props);

        this.state = {
            subgoals: [],
            sortType: 'cost-desc',
        }

        this.handleChange = this.handleChange.bind(this);

    }

    handleChange(value) {
        console.log(`selected ${value}`);

        this.setState({
            sortType: value,
        })
    }


    render() {

        return (

            <div className="panel">

                <h1>Your Goals</h1>

                <h5>Sort By</h5>

                <Select defaultValue="Most Expensive" style={{ width: 120 }} onChange={this.handleChange}>
                    <Option value="cost-desc">Most Expensive</Option>
                    <Option value="cost-asc">Cheapest</Option>
                    <Option value="hours-desc">Most Hours</Option>
                    <Option value="hours-asc">Fewest Hours</Option>
                    <Option value="days-desc">Most Days</Option>
                    <Option value="days-asc">Fewest Days</Option>
                    <Option value="popular-desc">Most Popular</Option>
                    <Option value="popular-asc">Least Popular</Option>
                </Select>

                <div className="my-goals-pane">
                    <MyGoals sort={this.state.sortType}/>
                </div>

            </div>
        );

    }
}


export default UserSubgoalsSection;


