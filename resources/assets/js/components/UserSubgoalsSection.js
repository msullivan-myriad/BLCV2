import React, { Component } from 'react';
import axios from 'axios';
import YourGoal from './YourGoal';
import MyGoals from './MyGoals';

import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;

class UserSubgoalsSection extends Component {


    constructor(props) {
        super(props);

        this.state = {
            subgoals: []
        }

    }

    componentDidMount() {
        axios.get('/api/subgoals')
            .then(response => {
                const subgoals = response.data.data.subgoals;

                this.setState({ subgoals });
            });
    }

    render() {
        return (

            <div className="panel">

                <h1>Your Goals</h1>

                <Tabs defaultActiveKey="1">
                    <TabPane tab="Cost" key="1">
                        <MyGoals sort={'cost'}/>
                    </TabPane>
                    <TabPane tab="Days" key="2">
                        <MyGoals sort={'days'}/>
                    </TabPane>
                    <TabPane tab="Hours" key="3">
                        <MyGoals sort={'hours'}/>
                    </TabPane>
                </Tabs>


            </div>
        );
    }
}


export default UserSubgoalsSection;


