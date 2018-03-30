import React, { Component } from 'react';
import DedicatePerYear from './DedicatePerYear';
import TagsStats from './TagsStats';
import SetBirthdate from './SetBirthdate';
import UserSubgoalsSection from './UserSubgoalsSection'
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
                            </TabPane>

                            <TabPane tab="Your Goals" key="3">
                                <UserSubgoalsSection/>
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
