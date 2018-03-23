import React, { Component } from 'react';
import { Tag, Input } from 'antd'
const Search = Input.Search;

class FindGoalsUsingCategories extends Component {

    constructor(props) {
        super(props);

        this.state = {
            tags: [],
            searchTerm: '',
            searchResults: [],
        }

        this.onSearch = this.onSearch.bind(this);

    }

    componentDidMount() {

        var tagsUrl = '/api/tags?count=10';

        axios.get(tagsUrl)

            .then(response => {
                const tags = response.data.data.tags;
                this.setState({tags})
            })

    }

    onSearch(e) {

        //Not sure why this isn't working yet.... should be an easy fix though
        console.log(e);

    }

    render() {

        let bottomContent;

        if (this.state.searchTerm) {

        }

        else {

            bottomContent = (
                <div>
                    <p>Search for a category or select from the most popular ones below</p>
                    <br/>

                    {this.state.tags.map(tag =>
                        <Tag key={tag.id}>{tag.name}</Tag>
                    )}
                </div>
           );


        }

        return (
            <div className="panel find-goals-using-categories">

                <br/>

                <Search
                    placeholder="Search Categories"
                    onChange={this.onSearch(e)}
                    style={{ width: 400 }}
                />

                <br/>

                {bottomContent}

            </div>
        );

    }
}

export default FindGoalsUsingCategories;
