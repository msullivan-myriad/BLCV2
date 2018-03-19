import React, { Component } from 'react';

import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;

import GoalsSearch from './GoalsSearch'
import GoalsFeatured from './GoalsFeatured'


class MainFindGoals extends Component {

    constructor(props) {
        super(props);

        this.state = {
        }

    }


    componentDidMount() {

    }

    render() {

        return (

            <Tabs defaultActiveKey="1">
                <TabPane tab="Search" key="1">
                    <GoalsSearch/>
                </TabPane>
                <TabPane tab="Popular" key="2">
                    <GoalsFeatured/>
                </TabPane>
                <TabPane tab="Categories" key="3">Content of Tab Pane 3</TabPane>
            </Tabs>

        );

    }



}

export default MainFindGoals;
