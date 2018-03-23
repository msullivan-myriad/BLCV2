import React, { Component } from 'react';
import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;

import GoalsSearch from './GoalsSearch'
import GoalsFeatured from './GoalsFeatured'
import ListPopularGoals from './ListPopularGoals'

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
                    <ListPopularGoals/>
                </TabPane>
                <TabPane tab="Categories" key="3">
                    <GoalsFeatured/>
                </TabPane>
            </Tabs>

        );

    }

}

export default MainFindGoals;
