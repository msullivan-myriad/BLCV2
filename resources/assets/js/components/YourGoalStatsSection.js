import React, { Component } from 'react';

class YourGoalStatsSection extends Component {

    constructor(props) {
        super(props);

        this.state = {
            daysPercentage: 0,
            hoursPercentage: 0,
            costPercentage: 0,
        }

    }

    componentWillReceiveProps() {

        const url = '/api/stats/individual-goal-stats/' + this.props.slug;

        axios.get(url)
            .then(response => {
                    const data = response.data.data;

                    console.log(data);

                    this.setState({
                        costPercentage: data.cost_percentage,
                        hoursPercentage: data.hours_percentage,
                        daysPercentage: data.days_percentage,
                    })

            })

    }

    render() {

        return (
            <div className="your-goal-stats">

                <p>{this.state.daysPercentage} of your days</p>
                <p>{this.state.hoursPercentage} of your hours</p>
                <p>{this.state.costPercentage} of your cost</p>
                <br/>
                <br/>
                <p>Based off the number you currently have entered in your difficulty calculations it is the nth hardest goal on your entire list </p>

            </div>


        );

    }
}

export default YourGoalStatsSection;
