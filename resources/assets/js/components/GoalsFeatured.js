import React, { Component } from 'react';
import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;


class GoalsFeatured extends Component {

    constructor(props) {
        super(props);

        this.state = {
        }
    }

    render() {

        return (
            <div className="panel goals-featured">
                <h1>Goals Featured</h1>
                <Tabs defaultActiveKey="1">
                    <TabPane tab="Most Popular" key="1">
                        Content of Tab Pane 1
                    </TabPane>
                    <TabPane tab="Ta" key="2">
                        Content of Tab Pane 2
                    </TabPane>
                    <TabPane tab="Tags" key="3">
                        Content of Tab Pane 3
                    </TabPane>
                </Tabs>
            </div>
        );

    }
}

export default GoalsFeatured;
