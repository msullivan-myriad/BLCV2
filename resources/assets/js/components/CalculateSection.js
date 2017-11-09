import React, { Component } from 'react';

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

                    <TabPane tab="Overview" key="1">
                        <p>Overview, general stats and numbers and things here.  King of like the fun facts section</p>
                    </TabPane>

                    <TabPane tab="Difficulty" key="2">
                        <p>Most and least difficult based on the algorithm.... Need to think about some kind of slider component that will help me to calculate this easier</p>
                    </TabPane>

                    <TabPane tab="Popularity" key="3">
                        <p>Sort goals by popularity, compare stuff against the average site user and see how their list stacks up</p>
                    </TabPane>

                    <TabPane tab="Completion" key="4">
                        <p>Estimated completion date section, allow user to input their current age and what date they would like to be done with all of their goals</p>
                    </TabPane>

                </Tabs>

            </div>
        );
    }
}


export default CalculateSection;
