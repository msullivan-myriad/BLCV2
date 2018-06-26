import React, { Component } from 'react';
import { Card, Icon, notification } from 'antd';


class SingleExperience extends Component {

    constructor(props) {
        super(props);

        this.state = {
            cost: '',
            days: '',
            hours: '',
            text: '',
        }

    }

    render() {

        console.log(this.props.experience);

        const experience = this.props.experience;

        return (

                <Card>
                    <Icon type="like-o" />
                    <p>{experience.votes}</p>
                    <Icon type="dislike-o" />
                    <p>Cost: {experience.cost}</p>
                    <p>Days: {experience.days}</p>
                    <p>Hours: {experience.hours}</p>
                    <p>Text: {experience.text}</p>

                </Card>


        );

    }
}

export default SingleExperience;
