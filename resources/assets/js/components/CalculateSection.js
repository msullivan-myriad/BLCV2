import React, { Component } from 'react';
import TotalsPane from './TotalsPane';
import DedicatePerYear from './DedicatePerYear';
import TagsStats from './TagsStats';
import SetBirthdate from './SetBirthdate';
import axios from 'axios';

import { Tabs } from 'antd';
const TabPane = Tabs.TabPane;


class CalculateSection extends Component {


    constructor(props) {
        super(props);

        this.state = {
            checkedForBirthday: false,
            hasBirthdate: false,
        }

    }

    componentDidMount() {

        axios.get('/api/profile/profile-information')
            .then(response => {

                const profile = response.data.data.profile;

                if (profile.birthday) {

                    this.setState({
                        hasBirthdate: true,
                        checkedForBirthday: true,
                    })

                }

                else {

                    this.setState({
                        hasBirthdate: false,
                        checkedForBirthday: true,
                    });

                }
            })
    }

    render() {

        if (this.state.checkedForBirthday) {


            if (this.state.hasBirthdate) {

                return (
                    <div>
                        <h1>Calculator</h1>

                        <Tabs defaultActiveKey="1">

                            <TabPane tab="Calculate" key="1">
                                <DedicatePerYear/>
                            </TabPane>

                            <TabPane tab="Categories" key="2">
                                <TagsStats/>
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

            else {
                return <SetBirthdate/>;
            }

        }

        else {

            return <div></div>;
        }

    }
}


export default CalculateSection;
