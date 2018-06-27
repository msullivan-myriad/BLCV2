import React, { Component } from 'react'
import IndividualGoalGeneralStats from './IndividualGoalGeneralStats'
import YourGoalData from '../YourGoalData'
import UserExperiences from './UserExperiences'


class MainViewGoalPage extends Component {

    constructor(props) {
        super(props);
        this.state = {}
    }

    render() {

        //Set up right side of main view goals logic
        let rightSide;

        if (this.props.loggedIn) {

            if (this.props.userHasGoals) {

                if (this.props.hasProfileInfo) {

                    if (this.props.userHasThisGoalOnList) {
                        rightSide = <YourGoalData/>
                    }

                    else {
                        rightSide = <p>Based on your current <a>profile information</a> adding this goal to your list will do the following......</p>
                    }

                }

                else {
                    rightSide = <p>Fill out your profile information to see more goal stats</p>
                }

            }
            else {
                rightSide = <p>Add some goals to your list to see more goal statistics</p>
            }

        }
        else {
            rightSide = <p>Login to see more goal statistics</p>
        }


        return (

            <div className="row">

                <div className="col-md-6">

                    <IndividualGoalGeneralStats/>

                    <UserExperiences goal={this.props.goal} user={this.props.user}/>

                </div>

                <div className="col-md-6">

                    {rightSide}

                </div>

            </div>

        );

    }
}

export default MainViewGoalPage;
