import React, { Component } from 'react';
import axios from 'axios';
import AddNewUserExperience from './AddNewUserExperience';
import SingleExperience from './SingleExperience';

class UserExperiences extends Component {

    constructor(props) {
        super(props);

        this.state = {

            experiences: [],

        }

    }

    componentDidMount() {

        var url = '/api/experiences/' + this.props.goal.id;
        axios.get(url)
            .then(response => {

                let data = response.data;

                this.setState({
                    experiences: data,
                })

            })

    }

    render() {

        return (

            <div>

                <p>Need to map over all existing experiences here and show each experience</p>

                {this.state.experiences.map(experience =>

                    <SingleExperience experience={experience} key={experience.id}/>

                )}
                <AddNewUserExperience goalId={this.props.goal.id}/>

            </div>

        );

    }
}

export default UserExperiences;
