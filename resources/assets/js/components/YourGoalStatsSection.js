import React, { Component } from 'react';
import { CirclePie, BarMetric } from 'react-simple-charts'


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
                        percentageMoreCost: data.percentage_more_cost,
                        percentageMoreDays: data.percentage_more_days,
                        percentageMoreHours: data.percentage_more_hours,
                    })

            })

    }

    render() {

        const statPercentageStyles = {
            display: 'inline-block',
            width: '32%',
        }

        const costMetricName = this.state.percentageMoreCost + '% of your goals';
        const daysMetricName = this.state.percentageMoreDays + '% of your goals';
        const hoursMetricName = this.state.percentageMoreHours + '% of your goals';

        return (
            <div className="your-goal-stats">

                <br/>
                <h3>This goal makes up this much of your goals total cost, days, and hours</h3>
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
                <br/>
                <br/>

                <h6>Will cost more than</h6>
                <BarMetric label="" percent={this.state.percentageMoreCost} metricName={costMetricName}/>
                <br/>

                <h6>Will take more days to complete than</h6>
                <BarMetric label="" percent={this.state.percentageMoreDays} metricName={daysMetricName}/>
                <br/>

                <h6>Will take more hours than</h6>
                <BarMetric label="" percent={this.state.percentageMoreHours} metricName={hoursMetricName}/>
                <br/>


            </div>


        );

    }
}

export default YourGoalStatsSection;
