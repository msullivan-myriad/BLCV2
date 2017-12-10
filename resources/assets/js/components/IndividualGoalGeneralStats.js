import React, { Component } from 'react';
import { CirclePie, BarMetric, Area } from 'react-simple-charts'
import axios from 'axios';


class IndividualGoalGeneralStats extends Component {

    constructor(props) {
        super(props);

        const baseSlug = window.location.pathname;
        const slug = baseSlug.split('/')[2];

        this.state = {
            slug: slug,
        }

    }

    componentDidMount() {

        const url = '/api/stats/individual-goal-general-stats/' + this.state.slug;

        axios.get(url)
            .then(response => {
                console.log(response);
            });

    }

    render() {

        /*
        //Table this for now, more complex than I though... Numbers also need to go down rather than just up.  What if there are 1000 dates, they can't all fit on the graph.
        //There are a lot of things to think about when considering this graph
        let data = [
            {time:1422766800000, value: 1, label: "goals"},
            {time:1422853200000, value: 2, label: "goals"},
            {time:1422939600000, value: 3, label: "goals"},
            {time:1422939700000, value: 4, label: "goals"},
            {time:1422937600000, value: 5, label: "goals"},
            {time:1422939700000, value: 6, label: "goals"},
        ];
        */

        return (

            <div className="individual-goal-genera-stats">
                <br/>
                <p>Individual goal general stats</p>

                {/*
                //Can't do this yet... See comments above
                <Area width={900} height={300} data={data}/>
                */}

            </div>
        );

    }
}

export default IndividualGoalGeneralStats;
