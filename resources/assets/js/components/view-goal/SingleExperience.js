import React, { Component } from 'react';
import axios from 'axios';
import { Card, Icon, notification } from 'antd';


class SingleExperience extends Component {

    constructor(props) {
        super(props);

        this.state = {
            votes: 0,
            all_votes: this.props.experience.all_votes,
        }

        this.upvoteExperience = this.upvoteExperience.bind(this);
        this.downvoteExperience = this.downvoteExperience.bind(this);
        this.removeVoteFromExperience = this.removeVoteFromExperience.bind(this);

    }

    componentDidMount() {

        this.setState({
            votes: Number(this.props.experience.votes)
        })

    }

    upvoteExperience() {

        axios.post('/api/experience/' + this.props.experience.id + '/upvote')

        .then(response => {

            notification.open({
                message: 'Success',
                description: 'Successfully upvoted experience',
                type: 'success',
            });

            this.setState({
                votes: this.state.votes + 1,
                all_votes: [...this.state.all_votes, {
                    user_id: this.props.user.id,
                    vote: 1,
                    id: 0,
                    //This dummy id could be given more thought
                }],
            })

        })

    }

    downvoteExperience() {

        axios.post('/api/experience/' + this.props.experience.id + '/downvote')

        .then(response => {

            notification.open({
                message: 'Success',
                description: 'Successfully downvoted experience',
                type: 'success',
            });

            this.setState({
                votes: this.state.votes - 1,
                all_votes: [...this.state.all_votes, {
                    user_id: this.props.user.id,
                    vote: -1,
                    id: 0,
                    //This dummy id could be given more thought
                }],
            })

        })

    }

    removeVoteFromExperience() {

        axios.post('/api/experience/' + this.props.experience.id + '/remove-vote')

        .then(response => {

            notification.open({
                message: 'Success',
                description: 'Successfully removed vote from experience',
                type: 'success',
            });

            this.setState({
                votes: this.state.votes + 1,
                all_votes: [...this.state.all_votes, {
                    user_id: this.props.user.id,
                    vote: 1,
                    id: 0,
                    //This dummy id could be given more thought
                }],
            })

        })

    }

    render() {

        const userId = this.props.user.id;
        const experience = this.props.experience;

        let upvoteIcon = <Icon type="like-o" onClick={this.upvoteExperience}/>;
        let downvoteIcon = <Icon type="dislike-o" onClick={this.downvoteExperience}/>;

        this.state.all_votes.forEach(vote => {

            if (vote.user_id == userId) {

                if (vote.vote == 1) {
                    upvoteIcon = <Icon type="like" onClick={this.removeVoteFromExperience}/>;
                }
                else if (vote.vote == -1) {
                    downvoteIcon = <Icon type="dislike" onClick={this.removeVoteFromExperience}/>;
                }

            }

        })

        return (

                <Card>
                    { upvoteIcon }
                    <p>{this.state.votes}</p>
                    { downvoteIcon }
                    <p>Cost: {experience.cost}</p>
                    <p>Days: {experience.days}</p>
                    <p>Hours: {experience.hours}</p>
                    <p>Text: {experience.text}</p>
                </Card>

        );


        //If I returned the id of the vote upon successful creation as well as the id of the vote upon successfull deleteion
        //I could use the actual vote ids instead of the dummy ones that I am doing currently
        //After this is set up I should have a computed property to figure out the current vote count rather than a hard coded one
        //Like I am doing now

    }
}

export default SingleExperience;
