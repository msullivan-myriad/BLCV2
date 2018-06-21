import React, { Component } from 'react';
import axios from 'axios';
import AddNewUserExperience from './AddNewUserExperience';

class UserExperiences extends Component {

    constructor(props) {
        super(props);

        this.state = {
        }

    }

    componentDidMount() {

        var url = '/api/experiences/' + this.props.goal.id;
        axios.get(url)
            .then(response => {

                let data = response.data;
                console.log(data);

            })

    }

    render() {

        return (

            <div>

                <p>Need to map over all existing experiences here and show each experience</p>
                <AddNewUserExperience goalId={this.props.goal.id}/>

            </div>

        );

    }
}

export default UserExperiences;
