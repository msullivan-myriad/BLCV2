
import React, { Component } from 'react';
import AddGoal from './AddGoal';
import TagAddGoalPane from './TagAddGoalPane';

import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;


class GoalsFeatured extends Component {

    constructor(props) {
        super(props);

        this.state = {
            popular_goals: {},
            all_goals: [],
            tags: [],
        }

        this.loadMore = this.loadMore.bind(this);
    }

    componentDidMount() {

        var goalsUrl = '/api/popular/';

        axios.get(goalsUrl)

        .then(response => {

            let popular_goals = response.data.data.popular_goals;
            let all_goals = popular_goals.data;

            this.setState({popular_goals});
            this.setState({all_goals});

        })


        var tagsUrl = '/api/tags';

        axios.get(tagsUrl)

        .then(response => {

            let tags = response.data.data.tags;
            this.setState({tags})

        })


    }


    loadMore() {

        var url = this.state.popular_goals.next_page_url;

        axios.get(url)

        .then(response => {
            let popular_goals = response.data.data.popular_goals;
            this.setState({popular_goals})

            this.setState({ all_goals: [...this.state.all_goals, ...popular_goals.data ] })

        })

    }


    render() {

        let loadMoreBtn;

        if (this.state.popular_goals.next_page_url) {
            loadMoreBtn = <button onClick={this.loadMore}>Load More</button>;
        }

        return (
            <div className="panel goals-featured">
                <h1>Goals Featured</h1>
                <br/>
                <Tabs defaultActiveKey="1">
                    <TabPane tab="Popular" key="1">

                        {this.state.all_goals.map(goal=>
                            <AddGoal goal={goal} key={goal.id}/>
                        )}

                        {loadMoreBtn}

                    </TabPane>
                    <TabPane tab="Tags" key="2">

                        <Tabs
                            defaultActiveKey="1"
                            tabPosition="left"
                        >

                        {this.state.tags.map(tag =>

                            <TabPane tab={tag.name} key={tag.id}>

                                <TagAddGoalPane id={tag.id}/>

                            </TabPane>

                        )}

                        </Tabs>

                    </TabPane>
                </Tabs>
            </div>
        );

    }
}

export default GoalsFeatured;
