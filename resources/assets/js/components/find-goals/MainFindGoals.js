import React, { Component } from 'react';
import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;

import GoalsSearch from './GoalsSearch'
import FindGoalsUsingCategories from './FindGoalsUsingCategories'
import ListPopularGoals from './ListPopularGoals'

class MainFindGoals extends Component {

    constructor(props) {
        super(props);
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
                    <FindGoalsUsingCategories/>
                </TabPane>
            </Tabs>

        );

    }

}

export default MainFindGoals;
