import React, { Component } from 'react';
import AddGoal from './AddGoal';

import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;


class GoalsFeatured extends Component {

    constructor(props) {
        super(props);

        this.state = {
            popular_goals: []
        }
    }

    componentDidMount() {

        var url = '/api/popular/10';

        axios.get(url)

        .then(response => {

            let popular_goals = response.data.data.popular_goals;

            this.setState({popular_goals})

        })

    }

    render() {

        return (
            <div className="panel goals-featured">
                <h1>Goals Featured</h1>
                <br/>
                <Tabs defaultActiveKey="1">
                    <TabPane tab="Popular" key="1">

                        {this.state.popular_goals.map(goal =>
                            <AddGoal goal={goal} key={goal.id}/>
                        )}

                    </TabPane>
                    <TabPane tab="Tags" key="2">

                        <Tabs
                            defaultActiveKey="1"
                            tabPosition="left"
                            style={{ height: 400 }}
                        >
                            <TabPane tab="Tab 1" key="1">Content of tab 1</TabPane>
                            <TabPane tab="Tab 2" key="2">Content of tab 2</TabPane>
                            <TabPane tab="Tab 3" key="3">Content of tab 3</TabPane>
                            <TabPane tab="Tab 4" key="4">Content of tab 4</TabPane>
                            <TabPane tab="Tab 5" key="5">Content of tab 5</TabPane>
                            <TabPane tab="Tab 6" key="6">Content of tab 6</TabPane>
                            <TabPane tab="Tab 7" key="7">Content of tab 7</TabPane>
                            <TabPane tab="Tab 8" key="8">Content of tab 8</TabPane>
                            <TabPane tab="Tab 9" key="9">Content of tab 9</TabPane>
                            <TabPane tab="Tab 10" key="10">Content of tab 10</TabPane>
                            <TabPane tab="Tab 11" key="11">Content of tab 11</TabPane>

                        </Tabs>

                    </TabPane>
                </Tabs>
            </div>
        );

    }
}

export default GoalsFeatured;
