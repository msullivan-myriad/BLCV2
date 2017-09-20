import React, { Component } from 'react';

class AdminPageTag extends Component {


    render() {

        var url = '/blc-admin/tags/individual#' + this.props.tag.id;
        var spanStyles = {
            display: 'inline-block',
            margin: '2px'
        }
        var linkStyles = {
            color: '#fff'
        }

        return (

            <span className="label label-default" style={spanStyles}>
                <a style={linkStyles} href={url}>{this.props.tag.name}</a>
            </span>

        );
    }
}

export default AdminPageTag;