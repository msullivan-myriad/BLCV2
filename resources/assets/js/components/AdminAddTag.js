import React, { Component } from 'react';

class AdminAddTag extends Component {

    constructor(props) {
        super(props);
        this.handleClick = this.handleClick.bind(this);

        this.state = {isDeleted: false}
    }


    handleClick() {

        var url = '/api/admin/goals/' + this.props.goal + '/tag';

        console.log(url);

        axios.delete(url, {
            params: {
                tag_id: this.props.tag.id
            }
        })

        .then(response => {
            this.setState({isDeleted:true});
        })
        .catch(response => {
            console.log(response);
        });


    }

    render() {

        return (
            <div className="add-tag-section">
                <input name="tag_name" type="text" placeholder="Tag for this goal" />
                <button type="submit">Tag</button>
            </div>

        );
    }
}

export default AdminAddTag;