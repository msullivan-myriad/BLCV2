import React, { Component } from 'react';
import TotalsPane from './TotalsPane';
import DedicatePerYear from './DedicatePerYear';

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

                    <TabPane tab="Calculate" key="1">
                        <DedicatePerYear/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <p>List some very simple overview information here, and info about the average goal formatted a bit</p>
                        <p>Estimated completion date section, allow user to input their current age and what date they would like to be done with all of their goals</p>
                        <p>Maybe make this section have two panes, one that estimates starting with the date you would like to be done, the other showing what date you will be done based off of how much you can do per year</p>

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
