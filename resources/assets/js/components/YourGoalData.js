import React, { Component } from 'react';


class YourGoalData extends Component {

    constructor(props) {
        super(props);

        this.state = {
            slug: '',
            subgoal: '',
        }

    }

    componentDidMount() {

        const baseSlug = window.location.pathname;
        const slug = baseSlug.split('/')[2];

        const url = '/api/subgoal/' + slug;

        axios.get(url)
            .then(response => {
                    const subgoal = response.data.data.subgoal;
                    this.setState({subgoal})
            });

        this.setState({slug})

    }

    render() {

        const subgoal = this.state.subgoal;

        return (
            <div className="panel your-goal">
                <h4>Your Goal Data</h4>
                <h4>${subgoal.cost}</h4>
                <h4>Days: {subgoal.days}</h4>
                <h4>Hours: {subgoal.hours}</h4>
            </div>

        );

    }
}

export default YourGoalData;
