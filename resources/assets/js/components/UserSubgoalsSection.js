import React, { Component } from 'react';
import axios from 'axios';
import YourGoal from './YourGoal';

class UserSubgoalsSection extends Component {


    constructor(props) {
        super(props);

        this.state = {
            subgoals: []
        }

    }

    componentDidMount() {
        axios.get('/api/subgoals')
            .then(response => {
                const subgoals = response.data.data.subgoals;

                console.log(subgoals);
                this.setState({ subgoals });
            });
    }

    render() {
        return (
            <div>

            {this.state.subgoals.map((goal,num) =>
                <YourGoal goal={goal} key={num}/>
            )}

            </div>
        );
    }
}


export default UserSubgoalsSection;


