import React, { Component } from 'react';
import TagGoals from './TagGoals'

import { Select } from 'antd';
const Option = Select.Option;

class TagsSortingSection extends Component {


    constructor(props) {
        super(props);

        const baseSlug = window.location.pathname;
        const slug = baseSlug.split('/')[2];

        this.state = {
            sortType: 'cost-desc',
            slug: slug,
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

                <h1>Goals with this tag</h1>

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

                <div className="tag-goals-section">

                    <TagGoals sort={this.state.sortType} category={this.state.slug}/>

                </div>

            </div>
        );

    }
}


export default TagsSortingSection;


