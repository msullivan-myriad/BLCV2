import React, { Component } from 'react';
import AddGoal from './AddGoal';

import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;


class GoalsFeatured extends Component {

    constructor(props) {
        super(props);

        this.state = {
            popular_goals: {},
            all_goals: []

        }

        this.loadMore = this.loadMore.bind(this);
    }

    componentDidMount() {

        var url = '/api/popular/';

        axios.get(url)

        .then(response => {

            console.log(response);

            let popular_goals = response.data.data.popular_goals;
            let all_goals = popular_goals.data;

            this.setState({popular_goals});
            this.setState({all_goals});

        })
    }


    loadMore() {

        var url = this.state.popular_goals.next_page_url;

        axios.get(url)

        .then(response => {

            //Need to take a short break from this...
            //Still need to figure out how to do it
            console.log(response);
            let popular_goals = response.data.data.popular_goals;
            this.setState({popular_goals})


            let new_all_goals = this.state.all_goals.slice();
            new_all_goals.concat(this.state.popular_goals.data);

            console.log(this.state.popular_goals.data);

            console.log(new_all_goals);

        })

    }


    render() {

        return (
            <div className="panel goals-featured">
                <h1>Goals Featured</h1>
                <br/>
                <Tabs defaultActiveKey="1">
                    <TabPane tab="Popular" key="1">

                        {this.state.all_goals.map(goal=>
                            <AddGoal goal={goal} key={goal.id}/>
                        )}

                        <button onClick={this.loadMore}>Load More</button>

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
