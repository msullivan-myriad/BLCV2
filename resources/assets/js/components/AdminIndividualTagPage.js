import React, { Component } from 'react';
import axios from 'axios';

import AdminGoal from './AdminGoal';

class AdminIndividualTagPage extends Component {


    constructor(props) {
        super(props);

        var idHash = '';

        if (window.location.hash) {
            idHash = window.location.hash.substring(1);
        }

        this.state = {
            goals: [],
            tag: [],
            errors: [],
            hash: idHash,
        };
    }

    componentDidMount() {

        var url = '/api/admin/api-tags/' + this.state.hash;
        axios.get(url)
            .then(response => {
                const goals = response.data.data.goals;
                const tag = response.data.data.tag;
                this.setState({ goals });
                this.setState({ tag });
            });
    }

    render() {
        return (
            <div className="row">
                <div className="col-md-9">
                    <ul>

                    {this.state.goals.map((goal, num) =>
                        <AdminGoal key={num} goal={goal}/>
                    )}

                    </ul>
                </div>
                <div className="col-md-3">
                    <div className="panel">
                        <p>Something may go here in the future</p>
                    </div>
                </div>
            </div>
        );
    }
}


export default AdminIndividualTagPage;


