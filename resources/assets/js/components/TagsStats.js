import React, { Component } from 'react';
import axios from 'axios';
import { Collapse } from 'antd';
const Panel = Collapse.Panel;

class TagsStats extends Component {


    constructor(props) {
        super(props);

        this.state = {
            tags: [],
        }

    }

    componentDidMount() {

        axios.get('/api/stats/users-tags')

        axios.get('/api/stats/users-tags')
            .then(response => {
                const tags = response.data.tags;
                this.setState({ tags });
            });

    }

    render() {
        return (
            <div>

                <Collapse defaultActiveKey={['1']}>

                    {this.state.tags.map((tag, num) =>

                        <Panel header={tag.name} key={num + 1}>
                            <p>{tag.name}</p>
                        </Panel>

                    )}

                </Collapse>


            </div>
        );
    }
}


export default TagsStats;
