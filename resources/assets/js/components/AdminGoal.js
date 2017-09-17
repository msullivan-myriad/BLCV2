import React, { Component } from 'react';

import AdminTag from './AdminTag';

class AdminGoal extends Component {

    constructor(props) {
        super(props);
        this.handleTagInputSubmit = this.handleTagInputSubmit.bind(this);
        this.handleTagInputChange = this.handleTagInputChange.bind(this);
        var tags = [];
        this.props.goal.tags.map(val => {
            tags.push(
                {
                    name: val.name,
                    id: val.id
                }
            );
        })
        this.state = {
            newTag: '',
            tags: tags
        }
    }

    handleTagInputSubmit() {

        var url = '/api/admin/goals/' + this.props.goal.id + '/tag';

        axios.post(url, {
            tag_name: this.state.newTag
        })

        .then(response => {
            if(response.data.data.success) {
                console.log(response.data.data);
                var newId = response.data.data.tag_id;
                var newTags = this.state.tags.slice();
                newTags.push(
                    {
                        name: this.state.newTag,
                        id: newId
                    }
                );
                this.setState({tags:newTags})
                this.setState({newTag:''})
            }
        })

        .catch(response => {
            console.log(response);
        });

    }

    handleTagInputChange(event) {
        this.setState({newTag: event.target.value});
    }


    render() {
        var goalLink = '/blc-admin/goals/' + this.props.goal.id;

        return (
            <div className="panel">
                <p>{JSON.stringify(this.props.goal)}</p>
                <h2><a href={goalLink}>{this.props.goal.name}</a></h2>
                <h4>Cost: {this.props.goal.cost}</h4>
                <h4>Days: {this.props.goal.days}</h4>
                <h4>Hours: {this.props.goal.hours}</h4>
                <h4>Subgoal Count: {this.props.goal.subgoals_count}</h4>

                {this.state.tags.map((tag, num) =>

                    <AdminTag tag={tag} key={num} goal={this.props.goal.id}/>

                )}
                <br/>

                <div className="add-tag-section">
                    <input name="tag_name" type="text" placeholder="Tag name" onChange={this.handleTagInputChange} value={this.state.newTag}/>
                    <button onClick={this.handleTagInputSubmit} type="submit">Add</button>
                </div>


            </div>

        );

    }
}

export default AdminGoal;
