import React, { Component } from 'react';


class MainViewGoalPage extends Component {

    constructor(props) {
        super(props);
        this.state = {}
    }


    render() {

        return (

            <div className="row">

                <div className="col-md-6">

                    <div id="individual-goal-general-stats"></div>

                </div>

                <div className="col-md-6">

                    <div id="your-goal-data"></div>

                </div>

            </div>

        );

    }
}

export default MainViewGoalPage;
