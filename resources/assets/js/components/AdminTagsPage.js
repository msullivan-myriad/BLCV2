import React, { Component } from 'react';
import axios from 'axios';

import AdminGoal from './AdminGoal';
import AdminPageTag from './AdminPageTag';

class AdminTagsPage extends Component {


    constructor(props) {
        super(props);

        this.state = {
            goals: [],
            tags: [],
            errors: []
        };
    }

    componentDidMount() {
        axios.get('/api/admin/api-tags')
            .then(response => {
                const goals = response.data.data.goals;
                const tags = response.data.data.tags;
                this.setState({ goals });
                this.setState({ tags });
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
                        {this.state.tags.map((tag, num) =>
                            <AdminPageTag tag={tag} key={num}/>
                        )}
                    </div>
                </div>
            </div>
        );
    }
}


export default AdminTagsPage;


