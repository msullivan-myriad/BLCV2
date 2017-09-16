import React, { Component } from 'react';

class AdminAddTag extends Component {

    constructor(props) {
        super(props);
        this.handleClick = this.handleClick.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.state = {newTag: ''}

    }

    handleClick() {

        var url = '/api/admin/goals/' + this.props.goal.id + '/tag';

        axios.post(url, {
            params: {
                tag_name: this.state.newTag
            }
        })

        .then(response => {
            console.log(response);
        })

        .catch(response => {
            console.log(response);
        });

    }

    handleChange(event) {
        this.setState({newTag: event.target.value});
    }

    render() {

        return (
            <div className="add-tag-section">
                <input name="tag_name" type="text" placeholder="Tag name" onChange={this.handleChange} value={this.state.newTag}/>
                <button onClick={this.handleClick} type="submit">Add</button>
            </div>

        );
    }
}

export default AdminAddTag;