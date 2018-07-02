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
        this.voteCount = this.voteCount.bind(this);

    }

    componentDidMount() {

        this.setState({
            votes: Number(this.props.experience.votes)
        })

    }

    voteCount() {

        let count = 0;

        this.state.all_votes.forEach(function(vote) {
            count += vote.vote;
        });

        return count;

    }

    upvoteExperience() {

        axios.post('/api/experience/' + this.props.experience.id + '/upvote')

        .then(response => {

            this.setState({
                votes: this.state.votes + 1,
                all_votes: [...this.state.all_votes, {
                    user_id: this.props.user.id,
                    id: response.data.vote_id,
                    vote: 1,
                }],
            })

        })

    }

    downvoteExperience() {

        axios.post('/api/experience/' + this.props.experience.id + '/downvote')

        .then(response => {

            this.setState({
                votes: this.state.votes - 1,
                all_votes: [...this.state.all_votes, {
                    user_id: this.props.user.id,
                    id: response.data.vote_id,
                    vote: -1,
                }],
            })

        })

    }

    removeVoteFromExperience() {

        axios.post('/api/experience/' + this.props.experience.id + '/remove-vote')

        .then(response => {

            let allVotes = this.state.all_votes;

            allVotes.splice(allVotes.findIndex(function(i){
                return i.id === response.deleted_vote_id;
            }), 1);


            this.setState({
                all_votes: allVotes,
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
                    <p>{this.voteCount()}</p>
                    { downvoteIcon }
                    <p>Cost: {experience.cost}</p>
                    <p>Days: {experience.days}</p>
                    <p>Hours: {experience.hours}</p>
                    <p>Text: {experience.text}</p>
                </Card>

        );

    }
}

export default SingleExperience;
