import React, { Component } from 'react';
import YourGoalStatsSection from './YourGoalStatsSection';

class YourGoalData extends Component {

    constructor(props) {
        super(props);

        const baseSlug = window.location.pathname;
        const slug = baseSlug.split('/')[2];

        this.state = {
            slug: slug,
        }


    }

    render() {


        return (
            <div className="panel your-goal">
                <YourGoalStatsSection slug={this.state.slug} />
            </div>


        );

    }
}

export default YourGoalData;
