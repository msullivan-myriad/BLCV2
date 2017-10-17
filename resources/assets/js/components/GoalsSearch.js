import React, { Component } from 'react';
import axios from 'axios';

import AddGoal from './AddGoal';
import SearchAddNewGoal from './SearchAddNewGoal';

class GoalsSearch extends Component {

    constructor(props) {
        super(props);

        this.state = {
            searchTerm: '',
            searchResults: []
        }

        this.changeSearch = this.changeSearch.bind(this);

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
                <h1>Find Goals</h1>
                <br/>
                <input type="text" value={this.state.searchTerm} onChange={this.changeSearch} placeholder="Your Goal Name"/>
                <div className="search-results">
                    {this.state.searchResults.map(goal =>
                        <AddGoal goal={goal} key={goal.id}/>
                    )}
                    <SearchAddNewGoal term={this.state.searchTerm}/>
                </div>
            </div>
        );

    }
}

export default GoalsSearch;
