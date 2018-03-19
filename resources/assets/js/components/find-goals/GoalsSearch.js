import React, { Component } from 'react';
import axios from 'axios';

import AddGoal from './../AddGoal';

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

        let searchResults;

        if (this.state.searchTerm == '') {
            searchResults = <p>Start typing to find the goal you are looking for.  Need suggestions?  Try <a href="#">popular</a> or <a href="#">categories</a></p>;
        }

        else {

            searchResults = (

                <div>

                    {this.state.searchResults.map(goal =>
                    <AddGoal goal={goal} key={goal.id}/>
                    )}

                    <p>Can't find what you are looking for?  No worries.  To create a custom goal <a href="#">click here</a></p>

                </div>

            )

        }

        return (
            <div className="panel" id="goals-search">
                <input type="text" value={this.state.searchTerm} onChange={this.changeSearch} placeholder="Your Goal Name"/>
                <br/>
                <br/>

                <div className="search-results">

                    {searchResults}

                </div>

            </div>
        );

    }
}

export default GoalsSearch;
