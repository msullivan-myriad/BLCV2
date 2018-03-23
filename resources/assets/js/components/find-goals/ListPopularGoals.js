
import React, { Component } from 'react';
import AddGoal from './../AddGoal';


class ListPopularGoals extends Component {

    constructor(props) {
        super(props);

        this.state = {
            popular_goals: {},
            all_goals: [],
        }

        this.loadMore = this.loadMore.bind(this);
    }

    componentDidMount() {

        var goalsUrl = '/api/popular/';

        axios.get(goalsUrl)

        .then(response => {

            let popular_goals = response.data.data.popular_goals;
            let all_goals = popular_goals.data;

            this.setState({popular_goals});
            this.setState({all_goals});

        })

    }


    loadMore() {

        var url = this.state.popular_goals.next_page_url;

        axios.get(url)

        .then(response => {
            let popular_goals = response.data.data.popular_goals;
            this.setState({popular_goals})

            this.setState({ all_goals: [...this.state.all_goals, ...popular_goals.data ] })

        })

    }


    render() {

        let loadMoreBtn;

        if (this.state.popular_goals.next_page_url) {
            loadMoreBtn = <button onClick={this.loadMore}>Load More</button>;
        }

        return (
            <div className="panel list-popular-goals">
                <div className={'row'}>
                    <div className={'col-md-10 col-md-offset-1'}>

                        <br/>
                        <p>Here are some of our most popular goals.  Check out our <a href={'#'}>blog</a> for more popular goals and trends.</p>
                        <br/>

                        <div className={'popular-goals-wrapper'}>

                            {this.state.all_goals.map(goal=>
                                <AddGoal goal={goal} key={goal.id}/>
                            )}

                            {loadMoreBtn}

                        </div>

                    </div>
                </div>

            </div>
        );

    }
}

export default ListPopularGoals;
