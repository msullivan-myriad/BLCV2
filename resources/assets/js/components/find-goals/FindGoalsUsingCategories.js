import React, { Component } from 'react';
import { Tag } from 'antd'

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
                {this.state.tags.map(tag =>
                    <Tag>{tag.name}</Tag>
                )}
            </div>
        );

    }
}

export default FindGoalsUsingCategories;
