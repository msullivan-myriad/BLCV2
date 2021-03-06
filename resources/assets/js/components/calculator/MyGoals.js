import React, { Component } from 'react';
import YourGoal from './YourGoal';


class MyGoals extends Component {

    constructor(props) {
        super(props);

        this.state = {
            subgoals: [],
            sort: this.props.sort,
        }

    }

    componentDidMount() {

        const url = '/api/subgoals/sort/' + this.state.sort;
        axios.get(url)
            .then(response => {
                const subgoals = response.data.data.subgoals;
                this.setState({ subgoals });
            });
    }

    componentDidUpdate() {

        //This if statement ensures that the ajax request only runs when the prop is changed to something new
        if (this.props.sort != this.state.sort) {

            this.setState({
                sort: this.props.sort,
            })

            const url = '/api/subgoals/sort/' + this.props.sort;
            axios.get(url)
                .then(response => {
                    const subgoals = response.data.data.subgoals;
                    this.setState({ subgoals });
                });

        }

    }


    render() {
        return (

            <div>

                {this.state.subgoals.map(goal =>
                    <YourGoal goal={goal} key={goal.id}/>
                )}

            </div>

        )
    }

}

export default MyGoals;
