import React, { Component } from 'react';
import axios from 'axios';
import { CirclePie, BarMetric } from 'react-simple-charts'
import YourGoal from './YourGoal';

class IndividualCategoryStats extends Component {


    constructor(props) {
        super(props);

        this.state = {
            stats: {
              tag_subgoals: [],
              tag_subgoals_count: 0,
              tag_subgoals_cost: 0,
              tag_subgoals_days: 0,
              tag_subgoals_hours: 0,
              subgoals_count: 1,
              subgoals_cost: 1,
              subgoals_hours: 1,
              subgoals_days: 1,
            },
        }

    }

    componentDidMount() {

        const url = '/api/stats/users-tags/' + this.props.tag.id;

        axios.get(url)
            .then(response => {
                const stats = response.data;
                console.log(stats);
                this.setState({ stats });
            });

    }

    render() {

        let countPercentage = Math.round((this.state.stats.tag_subgoals_count/this.state.stats.subgoals_count)*100);
        let metricText = countPercentage + '% of your list';

        let costPercentage = Math.round((this.state.stats.tag_subgoals_cost/this.state.stats.subgoals_cost)* 100);
        let daysPercentage = Math.round((this.state.stats.tag_subgoals_days/this.state.stats.subgoals_days)* 100);
        let hoursPercentage = Math.round((this.state.stats.tag_subgoals_hours/this.state.stats.subgoals_hours)* 100);

        console.log(countPercentage);

        const statPercentageStyles = {
            display: 'inline-block',
            width: '32%',
        }


        return (
            <div className="individual-category-stats">

                <h6>{this.props.tag.name} makes up</h6>
                <BarMetric label="" percent={countPercentage} metricName={metricText}/>
                <br/>

                <div className="circles-block">

                    <div className="circle-div" style={statPercentageStyles}>

                         <CirclePie
                                percent={costPercentage}
                                width={100}
                                height={100}
                                strokeWidth={5}
                                labelFontSize={'16px'}/>
                         <h4>of Cost</h4>

                    </div>

                    <div className="circle-div" style={statPercentageStyles}>

                         <CirclePie
                                percent={daysPercentage}
                                width={100}
                                height={100}
                                strokeWidth={5}
                                labelFontSize={'16px'}/>
                         <h4>of Days</h4>

                    </div>

                     <div className="circle-div" style={statPercentageStyles}>

                         <CirclePie
                                percent={hoursPercentage}
                                width={100}
                                height={100}
                                strokeWidth={5}
                                labelFontSize={'16px'}/>
                         <h4>of Hours</h4>

                     </div>

                </div>

                <br/>
                <br/>
                <br/>

                <div className="row">
                    <div className="col-md-8 col-md-offset-2">

                        {this.state.stats.tag_subgoals.map(subgoal =>
                            <YourGoal goal={subgoal} key={subgoal.id}/>
                        )}

                    </div>
                </div>

            </div>
        );
    }
}


export default IndividualCategoryStats;
