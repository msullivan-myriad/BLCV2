import React, { Component } from 'react';
import YourGoalStatsSection from './YourGoalStatsSection';
import EditYourGoal from './EditYourGoal';

import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;

class YourGoalData extends Component {

    constructor(props) {
        super(props);

        const baseSlug = window.location.pathname;
        const slug = baseSlug.split('/')[2];

        this.state = {
            slug: slug,
        }


    }

    render() {


        return (
            <div className="panel your-goal">

                <p>Need some kind of conditional if this goal exists than display it differently</p>

                <Tabs defaultActiveKey="1">

                    <TabPane tab="Goal Stats" key="1">
                        <YourGoalStatsSection slug={this.state.slug} />
                    </TabPane>

                    <TabPane tab="Edit Goal" key="2">
                        <EditYourGoal slug={this.state.slug}/>
                    </TabPane>

                </Tabs>


            </div>


        );

    }
}

export default YourGoalData;
