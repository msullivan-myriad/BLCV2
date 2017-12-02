import React, { Component } from 'react';

class EditYourGoal extends Component {

    constructor(props) {
        super(props);

        this.state = {
            subgoal: '',
        }

    }

    componentWillReceiveProps() {

        const url = '/api/subgoal/' + this.props.slug;

        console.log(url);

        axios.get(url)
            .then(response => {
                    const subgoal = response.data.data.subgoal;
                    this.setState({subgoal})
            });

    }

    render() {

        const subgoal = this.state.subgoal;

        return (
            <div className="edit-your-goal">

                <h4>${subgoal.cost}</h4>
                <h4>Days: {subgoal.days}</h4>
                <h4>Hours: {subgoal.hours}</h4>

            </div>


        );

    }
}

export default EditYourGoal;
