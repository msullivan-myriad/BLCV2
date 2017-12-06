import React, { Component } from 'react';
import { DatePicker } from 'antd';
import { Button } from 'antd';
import { notification } from 'antd';

import { LocaleProvider } from 'antd';
import enUS from 'antd/lib/locale-provider/en_US';



class SetBirthdate extends Component {

    constructor(props) {
        super(props);

        this.state = {
            currentDate: '',
        }

        this.updateDate = this.updateDate.bind(this);
        this.setBirthdate = this.setBirthdate.bind(this);

    }

    updateDate(datetime, date) {

        let currentDate = date;

        this.setState({ currentDate })
    }

    setBirthdate() {

        axios.post('/api/profile/set-birthdate', {
                birthdate: this.state.currentDate,
            })
            .then(function (response) {

                console.log(response);

                notification.open({
                        message: 'Success',
                        description: 'Your birthdate was successfully set',
                        type: 'success',
                    },
                    window.setTimeout(function() { location.reload() } , 2000)
                );


            })
            .catch(function (error) {

                console.log(error);

                notification.open({
                    message: 'Error',
                    description: 'Somethings not right, try entering your birthdate again',
                    type: 'error',
                });


            });

    }

    render() {

        return (

            <div className="set-birthdate">

                <h5>Please select your birth date:</h5>
                <br/>

                <LocaleProvider locale={enUS}>
                    <DatePicker onChange={this.updateDate}/>
                </LocaleProvider>

                <br/>
                <br/>

                <Button onClick={this.setBirthdate}>Submit</Button>


            </div>
        );

    }
}

export default SetBirthdate;
