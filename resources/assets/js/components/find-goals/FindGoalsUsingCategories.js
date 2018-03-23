import React, { Component } from 'react';
import { Tag, Input } from 'antd'
const Search = Input.Search;

class FindGoalsUsingCategories extends Component {

    constructor(props) {
        super(props);

        this.state = {
            tags: [],
        }

    }

    componentDidMount() {

        var tagsUrl = '/api/tags?count=10';

        axios.get(tagsUrl)

            .then(response => {
                const tags = response.data.data.tags;
                this.setState({tags})
            })

    }


    render() {


        return (
            <div className="panel find-goals-using-categories">

                <br/>

                <Search
                    placeholder="Search Categories"
                    onSearch={value => console.log(value)}
                    style={{ width: 400 }}
                />

                <br/>
                <br/>

                <p>Search for a category or select from the most popular ones below</p>
                <br/>

                {this.state.tags.map(tag =>
                    <Tag key={tag.id}>{tag.name}</Tag>
                )}
            </div>
        );

    }
}

export default FindGoalsUsingCategories;
