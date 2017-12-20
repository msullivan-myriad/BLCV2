import React, { Component } from 'react';
import AddGoal from './AddGoal';

class TagGoals extends Component {

    constructor(props) {
        super(props);

        this.state = {
            sort: this.props.sort,
            category: this.props.category,
            goals: [],
        }

    }

    componentDidMount() {

        const url = '/api/category-goals/' + this.state.category;
        axios.get(url, {
                params: {
                    order: this.state.sort,
                }
            })
            .then(response => {
                const goals = response.data.data.goals;
                this.setState({ goals });
            });

    }


    componentDidUpdate() {

        //This if statement ensures that the ajax request only runs when the prop is changed to something new
        if (this.props.sort != this.state.sort) {

            this.setState({
                sort: this.props.sort,
            })

            const url = '/api/category-goals/' + this.state.category;
            axios.get(url, {
                    params: {
                        order: this.state.sort,
                    }
                })
                .then(response => {
                    const goals = response.data.data.goals;
                    this.setState({ goals });
                });


        }

    }


    render() {
        return (

            <div>
                {this.state.goals.map(goal =>
                    <AddGoal goal={goal} key={goal.id} />
                )}
            </div>

        )
    }

}

export default TagGoals;
