import React, { Component } from 'react';
import TotalsPane from './TotalsPane';
import DifficultyCalculation from './DifficultyCalculation';

import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;


class CalculateSection extends Component {


    constructor(props) {
        super(props);
    }

    componentDidMount() {

    }

    render() {
        return (
            <div>
                <h1>Calculator</h1>

                <Tabs defaultActiveKey="1">

                    <TabPane tab="Totals" key="1">
                        <TotalsPane/>
                    </TabPane>

                    <TabPane tab="Difficulty" key="2">
                        <DifficultyCalculation/>
                    </TabPane>

                    <TabPane tab="Popularity" key="3">
                        <p>Sort goals by popularity, compare stuff against the average site user and see how their list stacks up</p>
                    </TabPane>

                    <TabPane tab="Completion" key="4">
                        <p>Estimated completion date section, allow user to input their current age and what date they would like to be done with all of their goals</p>
                    </TabPane>

                    <TabPane tab="Tags" key="5">
                        <p>Do stuff with tags here, how many of each.  Which tags will take the most time, which cost the most etc</p>
                    </TabPane>

                    <TabPane tab="Fun Facts" key="6">
                        <p>Fun facts section here</p>
                    </TabPane>
                </Tabs>

            </div>
        );
    }
}


export default CalculateSection;
