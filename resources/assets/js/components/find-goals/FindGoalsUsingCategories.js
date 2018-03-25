import React, { Component } from 'react'
import { Tag, Input } from 'antd'
const Search = Input.Search
import axios from 'axios'
import AddGoal from '../AddGoal'

class FindGoalsUsingCategories extends Component {

    constructor(props) {
        super(props);

        this.state = {
            tags: [],
            searchTerm: '',
            searchResults: [],
            aCategoryIsSelected: false,
            selectedCategoryName: '',
            selectedCategoryGoals: [],
        }

        this.onSearch = this.onSearch.bind(this);
        this.updateResults = this.updateResults.bind(this);
        this.setThisTagAsCategory = this.setThisTagAsCategory.bind(this);
        this.returnToAllCategories = this.returnToAllCategories.bind(this);

    }

    componentDidMount() {

        var tagsUrl = '/api/tags?count=10';

        axios.get(tagsUrl)

            .then(response => {
                const tags = response.data.data.tags;
                this.setState({tags})
            })

    }

    updateResults(term) {

        if (term.length > 0) {

        axios.get('api/tags/search?term=' + term)

            .then(response => {
                const searchResults = response.data;
                this.setState({searchResults})
            })

        }

        else {
            this.setState({searchResults: []})
        }

    }

    onSearch(e) {

        this.updateResults(e.target.value);

    }

    setThisTagAsCategory(id, name) {

        axios.get('api/tags/' + id)
            .then(response => {

                console.log(response.data);

                this.setState({
                    selectedCategoryName: name,
                    aCategoryIsSelected: true,
                    selectedCategoryGoals: response.data.data,
                    searchResults: [],
                })
            })

    }

    returnToAllCategories() {
        this.setState({
            aCategoryIsSelected: false,
        })
    }

    render() {

        let bottomContent;

        if (this.state.searchResults.length) {

            bottomContent = (

                 <div>
                    <p>Select a category of goals to view</p>
                    <br/>

                    {this.state.searchResults.map(tag =>
                        <Tag key={tag.id} onClick={() => this.setThisTagAsCategory(tag.id, tag.name)}>{tag.name}</Tag>
                    )}
                </div>

            )

        }

        else {

            bottomContent = (
                <div>
                    <p>Search for a category or select from the most popular ones below</p>
                    <br/>

                    {this.state.tags.map(tag =>
                        <Tag key={tag.id} onClick={() => this.setThisTagAsCategory(tag.id, tag.name)}>{tag.name}</Tag>
                    )}
                </div>
           );


        }

        let categoriesContent;

        if (this.state.aCategoryIsSelected) {
           categoriesContent = (

               <div>
                   <br/>
                   <h3>{this.state.selectedCategoryName}</h3>
                   <p>return to <a onClick={this.returnToAllCategories}>all categories</a></p>
                   {this.state.selectedCategoryGoals.map(goal =>
                       <AddGoal goal={goal} key={goal.id}/>
                   )}
               </div>
           );
        }

        else {


            categoriesContent = (
                <div>
                    <br/>

                     <Search
                        placeholder="Search Categories"
                        onChange={this.onSearch}
                        style={{ width: 400 }}
                    />

                    <br/>

                    {bottomContent}

                </div>

            );



        }

        return (
            <div className="panel find-goals-using-categories">
                {categoriesContent}
            </div>
        );

    }
}

export default FindGoalsUsingCategories;
