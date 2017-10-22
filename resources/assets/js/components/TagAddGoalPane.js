import React, { Component } from 'react';
import axios from 'axios';
import AddGoal from './AddGoal';


class TagAddGoalPane extends Component {

    constructor(props) {

        super(props);

        this.state = {
            goals: []
        }

    }

    componentDidMount() {

        var url = '/api/tags/' + this.props.id;

        axios.get(url)

        .then(response => {
            let goals = response.data;
            this.setState({goals})
        })



    }

    render() {

        return (
            <div className="tag-add-goal-pane">
                {this.state.goals.map(goal =>
                    <AddGoal goal={goal} key={goal.id}/>
                )}
            </div>

        );

    }
}

export default TagAddGoalPane;
