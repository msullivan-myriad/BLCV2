import React, { Component } from 'react';
import TotalsPane from './TotalsPane';
import DedicatePerYear from './DedicatePerYear';

import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;


class CalculateSection extends Component {


    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>
                <h1>Calculator</h1>

                <Tabs defaultActiveKey="1">

                    <TabPane tab="Calculate" key="1">
                        <DedicatePerYear/>
                    </TabPane>

                    <TabPane tab="Tags" key="2">
                        <p>Do stuff with tags here, how many of each.  Which tags will take the most time, which cost the most etc</p>
                    </TabPane>

                    <TabPane tab="Fun Facts" key="3">
                        <p>Fun facts section here, also have the totals and that kind of info in this section</p>
                        <TotalsPane/>
                    </TabPane>
                </Tabs>

            </div>
        );
    }
}


export default CalculateSection;
