import React, { Component } from 'react';
import { CirclePie, BarMetric, Area } from 'react-simple-charts';
import axios from 'axios';
import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;
import EditYourGoal from './EditYourGoal';


class IndividualGoalGeneralStats extends Component {

    constructor(props) {
        super(props);

        const baseSlug = window.location.pathname;
        const slug = baseSlug.split('/')[2];

        this.state = {
            slug: slug,
            tags: [],
        }

    }

    componentDidMount() {

    }

    render() {

        return (

            <div className="individual-goal-general-stats">

                <Tabs defaultActiveKey="1">

                    <TabPane tab="Estimated Costs" key="1">
                        <p>Need some general info about your goal here</p>
                    </TabPane>

                    <TabPane tab="Edit Goal" key="2">
                        <EditYourGoal slug={this.state.slug}/>
                    </TabPane>

                </Tabs>


                <br/>
                {this.state.tags.map(tag =>
                    <a href={'/category/' + tag.slug} className="label label-primary">{tag.name}</a>
                )}

            </div>
        );

    }
}

export default IndividualGoalGeneralStats;
