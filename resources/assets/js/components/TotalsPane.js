import React, { Component } from 'react';
import axios from 'axios';


class TotalsPane extends Component {

    constructor(props) {
        super(props);

        this.state = {
            totals: {
                total_cost: '',
                total_days: '',
                total_goals: '',
                total_hours: '',
                average_cost: '',
                average_days: '',
                average_hours: '',

            }
        };

    }

    componentDidMount() {
        axios.get('/api/stats/totals')
            .then(response => {
                console.log(response)
                const totals = response.data.data;
                this.setState({ totals })
            });
    }

    render() {
        return (
            <div>
                <h3>Total Cost: {this.state.totals.total_cost}</h3>
                <h3>Total Days: {this.state.totals.total_days}</h3>
                <h3>Total Hours: {this.state.totals.total_hours}</h3>

                <h3>Average Cost: {this.state.totals.average_cost}</h3>
                <h3>Average Days: {this.state.totals.average_days}</h3>
                <h3>Average Hours: {this.state.totals.average_hours}</h3>
            </div>
        );
    }
}


export default TotalsPane;

