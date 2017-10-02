import React, { Component } from 'react';
import axios from 'axios';

import AddGoal from './AddGoal';

class GoalsSearch extends Component {

    constructor(props) {
        super(props);

        this.state = {
            searchTerm: '',
            searchResults: []
        }

        this.changeSearch = this.changeSearch.bind(this);

    }

    componentDidMount() {
        //No need for this at the moment, although I envision needing it....
        console.log('Component did mount');
    }

    changeSearch(event) {

        this.setState({
            searchTerm: event.target.value,
        })

        axios.get('/api/search/', {
                params: {
                    search: this.state.searchTerm,
                }
            })
            .then(response => {
                this.setState({
                    searchResults: response.data,
                })
            })

    }


    render() {

        return (
            <div className="panel" id="goals-search">
                <input type="text" value={this.state.searchTerm} onChange={this.changeSearch} placeholder="Your Goal Name"/>
                <div className="search-results">
                    {this.state.searchResults.map(goal =>
                        <AddGoal goal={goal} key={goal.id}/>
                    )}
                </div>
            </div>
        );

    }
}

export default GoalsSearch;
