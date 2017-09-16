import React, { Component } from 'react';

class AdminTag extends Component {

    constructor(props) {
        super(props);
        this.handleClick = this.handleClick.bind(this);
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
            console.log(response);
        })
        .catch(response => {
            console.log(response);
        });


    }

    render() {
        return (

            <span className="label label-default">{this.props.tag.name}
                <button onClick={this.handleClick}>x</button>
            </span>

        );
    }
}

export default AdminTag;