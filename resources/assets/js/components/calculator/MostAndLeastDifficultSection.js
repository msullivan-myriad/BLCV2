import React, { Component } from 'react';
import axios from 'axios';
import YourGoal from './YourGoal';
import { Tabs, Pagination } from 'antd';
const TabPane = Tabs.TabPane;

class MostAndLeastDifficultSection extends Component {

    constructor(props) {

        super(props);

        this.state = {
            subgoals: [],
            most_difficult: [],
            md_current_page: 1,
            least_difficult: [],
            ld_current_page: 1,
        };

        this.changeMostDifficultPage = this.changeMostDifficultPage.bind(this);
        this.changeLeastDifficultPage = this.changeLeastDifficultPage.bind(this);

    }


    componentDidMount() {


        axios.get('/api/stats/most-and-least-difficult')
            .then(response => {
                const most_difficult = response.data.data.most_difficult;
                const least_difficult = response.data.data.least_difficult;

                //Need to think about how to handle this if users have less than 10 goals... What if they have a ton of goals and would like to load more?
                this.setState({ most_difficult, least_difficult })
            })

    }

    changeLeastDifficultPage(pageNumber) {

        this.setState({
            ld_current_page: pageNumber,
        })

    }

    changeMostDifficultPage(pageNumber) {

        this.setState({
            md_current_page: pageNumber,
        })

    }

    render() {

        return (
            <div>
                <div className="row">

                        <div className="most-least-hardest-section">

                            <Tabs defaultActiveKey="1">

                                <TabPane tab="Most Difficult" key="1">

                                    {this.state.most_difficult.slice(this.state.md_current_page - 1, this.state.md_current_page + 4).map(goal =>
                                        <YourGoal goal={goal} key={goal.id}/>
                                    )}

                                    <Pagination defaultCurrent={1} total={this.state.most_difficult.length} pageSize={5} />

                                </TabPane>

                                <TabPane tab="Least Difficult" key="2">

                                    {this.state.least_difficult.map(goal =>
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

