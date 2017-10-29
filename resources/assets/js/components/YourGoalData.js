import React, { Component } from 'react';


class YourGoalData extends Component {

    constructor(props) {
        super(props);

        this.state = {
            slug: ''
        }

    }

    componentDidMount() {

        const baseSlug = window.location.pathname;
        const slug = baseSlug.split('/')[2];



        this.setState({slug})

    }

    render() {

        return (
            <div className="panel your-goal">
                <p>All of the custom information about your goal will go here... These numbers will be specific to you, the who currently has this goal on their list</p>
                <p>Maybe the alternate content could be some information about creating an account to see more?</p>
            </div>


        );

    }
}

export default YourGoalData;
