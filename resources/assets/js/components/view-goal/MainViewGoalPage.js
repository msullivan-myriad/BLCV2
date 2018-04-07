import React, { Component } from 'react'
import IndividualGoalGeneralStats from '../IndividualGoalGeneralStats'
import YourGoalData from '../YourGoalData'


class MainViewGoalPage extends Component {

    constructor(props) {
        super(props);
        this.state = {}
    }

    render() {

        return (

            <div className="row">

                <div className="col-md-6">

                    <IndividualGoalGeneralStats/>

                </div>

                <div className="col-md-6">

                    <YourGoalData/>

                </div>

            </div>

        );

    }
}

export default MainViewGoalPage;
