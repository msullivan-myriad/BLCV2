import React, { Component } from 'react';
import { CirclePie } from 'react-simple-charts'


class YourGoalStatsSection extends Component {

    constructor(props) {
        super(props);

        this.state = {
            daysPercentage: 0,
            hoursPercentage: 0,
            costPercentage: 0,
        }

    }

    componentDidMount() {

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

        const statPercentageStyles = {
            display: 'inline-block',
            width: '32%',
        }

        return (
            <div className="your-goal-stats">

                <br/>
                <br/>

                <div style={statPercentageStyles}  className="stat-percentage-div">
                    <CirclePie
                        percent={this.state.costPercentage}
                        width={100}
                        height={100}
                        strokeWidth={5}
                        labelFontSize={'16px'}
                    />
                    <h4>% of Cost</h4>
                </div>

                <div style={statPercentageStyles} className="stat-percentage-div">
                    <CirclePie
                        percent={this.state.daysPercentage}
                        width={100}
                        height={100}
                        strokeWidth={5}
                        labelFontSize={'16px'}
                    />
                    <h4>% of Days</h4>
                </div>

                <div style={statPercentageStyles} className="stat-percentage-div">
                    <CirclePie
                        percent={this.state.hoursPercentage}
                        width={100}
                        height={100}
                        strokeWidth={5}
                        labelFontSize={'16px'}
                    />
                    <h4>% of Hours</h4>
                </div>

                <br/>
                <p>Based off the number you currently have entered in your difficulty calculations it is the nth hardest goal on your entire list </p>

            </div>


        );

    }
}

export default YourGoalStatsSection;
