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
        this.editTitle = this.editTitle.bind(this);
        this.titleChange = this.titleChange.bind(this);

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
            isDeleted: false,
            editingTitle: false,
            initialTitle: this.props.goal.name,
            newTitle: this.props.goal.name,
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

    editTitle() {

        if(this.state.editingTitle) {

            if(this.state.initialTitle != this.state.newTitle) {
                console.log("now");

                //Set the new title right here
                //If it is a successful response then set origionalTitle equal to newTitle then emit a success notification
                //If not default back to initialTitle and emit a failure notification

            }

        }

        this.setState({
            editingTitle: !this.state.editingTitle,
        })
    }

    titleChange(event) {
        this.setState({
            newTitle: event.target.value,
        })
    }

    render() {
        var beenDeletedStyle = {};

        if (this.state.isDeleted) {
            beenDeletedStyle = {'display':'none'};
        }

        var iconStyle = {
            fontSize: '22px',
        };

        //Edit title styles
        var editInputStyles = {
            display: 'none',
        }
        var editHeadingStyles = {
            display: 'block',
        }
        var editPencilButton = {}
        var editThumbButton = {
            display: 'none',
        }

        if (this.state.editingTitle) {
            editInputStyles = {
                display: 'block',
            }
            editHeadingStyles = {
                display: 'none',
            }
            editPencilButton = {
                display: 'none',
            }
            editThumbButton = {}
        }

        return (
            <div className="panel" style={beenDeletedStyle}>
                <h2 style={editHeadingStyles}>{this.state.initialTitle}</h2>
                <input style={editInputStyles} className="edit-input" type="text" value={this.state.newTitle} onChange={this.titleChange}/>

                <button onClick={this.editTitle} type="submit">
                    <i style={editPencilButton} className="fa fa-pencil-square-o" aria-hidden="true"></i>
                    <i style={editThumbButton} className="fa fa-thumbs-up" aria-hidden="true"></i>
                </button>

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
