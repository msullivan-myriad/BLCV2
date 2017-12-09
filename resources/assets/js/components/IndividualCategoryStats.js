import React, { Component } from 'react';
import axios from 'axios';

class IndividualCategoryStats extends Component {


    constructor(props) {
        super(props);

        this.state = {
            stats: [],
        }

    }

    componentDidMount() {

        const url = '/api/stats/users-tags/' + this.props.tag.id;

        axios.get(url)
            .then(response => {
                console.log(response.data);
            });

    }

    render() {

        return (
            <div>

                <p>{this.props.tag.name} stats</p>

            </div>
        );
    }
}


export default IndividualCategoryStats;
