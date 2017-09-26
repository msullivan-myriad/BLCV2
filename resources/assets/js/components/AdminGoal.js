import React, { Component } from 'react';
import { Modal } from 'antd';
import 'antd/dist/antd.css';

import AdminGoalTag from './AdminGoalTag';


class AdminGoal extends Component {

    constructor(props) {
        super(props);
        this.handleTagInputSubmit = this.handleTagInputSubmit.bind(this);
        this.handleTagInputChange = this.handleTagInputChange.bind(this);
        this.deleteGoalModal = this.deleteGoalModal.bind(this);
        this.deleteGoal = this.deleteGoal.bind(this);

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
            tags: tags,
            isDeleted: false
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

    deleteGoalModal() {

        var thisGoal = this;

        Modal.confirm({
            title: 'Are you sure delete this goal?',
            okText: 'Yes',
            okType: 'danger',
            cancelText: 'No',
            onOk() {
                //Left off right here, not sure why I'm getting deleteGoalModal undefined
                //This function should be deleteGoal once I figure out why it isn't working

                thisGoal.deleteGoal();
            },
            onCancel() {
                console.log('Cancel');
            },
        });


    }

    deleteGoal() {

        var url = '/api/admin/goals/' + this.props.goal.id;

        axios.delete(url)
        .then(response => {

            if (response.data.data.success) {
                this.setState({isDeleted:true});
            }

        })
        .catch(response => {
            console.log(response);
        });


    }

    render() {
        var goalLink = '/blc-admin/goals/' + this.props.goal.id;
        var beenDeletedStyle = {};

        if (this.state.isDeleted) {
            beenDeletedStyle = {'display':'none'};
        }

        var iconStyle = {
            fontSize: '22px',
        };

        return (
            <div className="panel" style={beenDeletedStyle}>
                <h2><a href={goalLink}>{this.props.goal.name}</a></h2>
                <h4>Cost: {this.props.goal.cost}</h4>
                <h4>Days: {this.props.goal.days}</h4>
                <h4>Hours: {this.props.goal.hours}</h4>
                <h4>Subgoal Count: {this.props.goal.subgoals_count}</h4>
                <button onClick={this.deleteGoalModal} type="submit">
                    <i className="fa fa-trash text-danger" aria-hidden="true" style={iconStyle}></i>
                </button>

                {this.state.tags.map((tag, num) =>

                    <AdminGoalTag tag={tag} key={num} goal={this.props.goal.id}/>

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
