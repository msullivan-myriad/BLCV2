import React, { Component } from 'react';
import axios from 'axios';
import YourGoal from './YourGoal';
import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;

class MostAndLeastDifficultSection extends Component {

    constructor(props) {

        super(props);

        this.state = {
            subgoals: [],
            first: [],
            last: [],
        };

        this.getMostAndLeastDifficult = this.getMostAndLeastDifficult.bind(this);

    }


    componentDidMount() {

        this.getMostAndLeastDifficult();

    }

    getMostAndLeastDifficult() {

        axios.get('/api/stats/most-and-least-difficult')
            .then(response => {
                const subgoals = response.data.data.most_difficult;

                //Need to think about how to handle this if users have less than 10 goals... What if they have a ton of goals and would like to load more?
                const first = subgoals.slice(0,5);
                const last = subgoals.slice(-5).reverse();

                this.setState({
                    subgoals: subgoals,
                    last: last,
                    first: first,
                })
            })

    }


    render() {

        return (
            <div>
                <div className="row">

                        <div className="most-least-hardest-section">

                            <Tabs defaultActiveKey="1">

                                <TabPane tab="Most Difficult" key="1">

                                    {this.state.first.map(goal =>
                                        <YourGoal goal={goal} key={goal.id}/>
                                    )}

                                </TabPane>

                                <TabPane tab="Least Difficult" key="2">

                                    {this.state.last.map(goal =>
                                        <YourGoal goal={goal} key={goal.id}/>
                                    )}

                                </TabPane>

                            </Tabs>

                        </div>

                </div>

            </div>
        );
    }
}


export default MostAndLeastDifficultSection;

