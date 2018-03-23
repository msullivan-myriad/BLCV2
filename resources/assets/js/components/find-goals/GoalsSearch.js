import React, { Component } from 'react'
import axios from 'axios'

import AddGoal from './../AddGoal'
import SearchAddNewGoal from './SearchAddNewGoal'

import { Input } from 'antd'
const Search = Input.Search;

class GoalsSearch extends Component {

    constructor(props) {
        super(props);

        this.state = {
            searchTerm: '',
            searchResults: [],
            createCustomGoal: false,
            createCustomGoalTerm: '',
        }

        this.changeSearch = this.changeSearch.bind(this);
        this.toggleCreateCustomGoal = this.toggleCreateCustomGoal.bind(this);

    }

    changeSearch(event) {

        console.log(event);

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

    toggleCreateCustomGoal() {

        if (this.state.createCustomGoal) {

            this.setState({
                createCustomGoal: false,
                createCustomGoalTerm: '',
                searchTerm: '',
            })

        }

        else {

            this.setState({
                createCustomGoal: true,
                createCustomGoalTerm: this.state.searchTerm,
            })

        }

    }


    render() {

        let searchResults;

        if (this.state.createCustomGoal) {

            searchResults = (
                <div>
                    <SearchAddNewGoal term={this.state.createCustomGoalTerm}/>
                    <p>Please be sure a goal with a similar name doesn't exist before adding a goal. <br/> Go <a onClick={this.toggleCreateCustomGoal}>back</a> to searching.</p>
                </div>
            )
        }

        else if (this.state.searchTerm == '') {
            searchResults = <p>Start typing to find the goal you are looking for.  Need suggestions?  Try <a href="#">popular</a> or <a href="#">categories</a></p>;
        }

        else {

            searchResults = (

                <div>

                    {this.state.searchResults.map(goal =>
                        <AddGoal goal={goal} key={goal.id}/>
                    )}

                    <p>Can't find what you are looking for?  No worries.  To create a custom goal <a onClick={this.toggleCreateCustomGoal}>click here</a></p>

                </div>

            )

        }

        let searchInput;

        if (!this.state.createCustomGoal) {

            searchInput = (<Search
                placeholder="Goal Name"
                onChange={value => this.changeSearch(value)}
                value={this.state.searchTerm}
                style={{ width: 400 }}
            />);

        }

        return (
            <div className="panel" id="goals-search">

                {searchInput}
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
