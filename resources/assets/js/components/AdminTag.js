import React, { Component } from 'react';

class AdminTag extends Component {

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

        var beenDeletedStyle = {};

        if (this.state.isDeleted) {
            beenDeletedStyle = {'display':'none'};
        }

        return (

            <span className="label label-default" style={beenDeletedStyle}>{this.props.tag.name}
                <button onClick={this.handleClick}>x</button>
            </span>

        );
    }
}

export default AdminTag;