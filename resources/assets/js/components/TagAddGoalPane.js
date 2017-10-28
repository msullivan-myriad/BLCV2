import React, { Component } from 'react';
import axios from 'axios';
import AddGoal from './AddGoal';


class TagAddGoalPane extends Component {

    constructor(props) {

        super(props);

        this.state = {
            page: {} ,
            goals: []
        }

        this.loadMore = this.loadMore.bind(this);

    }

    componentDidMount() {

        var url = '/api/tags/' + this.props.id;

        axios.get(url)

        .then(response => {
            let page = response.data;
            let goals = page.data;
            this.setState({page})
            this.setState({goals})
        })



    }

    loadMore() {

        var url = this.state.page.next_page_url;

        axios.get(url)

        .then(response => {
            let page = response.data;
            this.setState({page})
            this.setState({ goals: [...this.state.goals, ...page.data ] })
        })


    }

    render() {

        let loadMoreBtn;

        if (this.state.page.next_page_url) {
            loadMoreBtn = <button onClick={this.loadMore}>Load More</button>;
        }

        return (
            <div className="tag-add-goal-pane">
                {this.state.goals.map(goal =>
                    <AddGoal goal={goal} key={goal.id}/>
                )}

                {loadMoreBtn}

            </div>

        );

    }
}

export default TagAddGoalPane;
