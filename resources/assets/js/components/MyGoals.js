import React, { Component } from 'react';
import YourGoal from './YourGoal';


class MyGoals extends Component {

    constructor(props) {
        super(props);

        this.state = {
            subgoals: []
        }

    }


    componentDidMount() {

        const url = '/api/subgoals/' + this.props.sort;
        axios.get(url)
            .then(response => {
                const subgoals = response.data.data.subgoals;
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

        )
    }

}

export default MyGoals;
