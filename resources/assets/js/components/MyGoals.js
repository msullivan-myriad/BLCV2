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

        const url = '/api/subgoals/' + this.state.sort;
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

            const url = '/api/subgoals/' + this.props.sort;
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

                {this.state.subgoals.map((goal,num) =>
                    <YourGoal goal={goal} key={num}/>
                )}

            </div>

        )
    }

}

export default MyGoals;
