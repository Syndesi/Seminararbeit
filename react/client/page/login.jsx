import React from 'react';
import {observable} from 'mobx';
import {observer} from 'mobx-react';
import axios from 'axios';

import Input from '../components/input.jsx';

@observer
export default class Login extends React.Component {

  @observable data = {
      email: '',
      password: ''
  };

  @observable message = "";

  register(){
    var self = this;
    axios.post(this.props.store.apiURL+'user/login', this.data)
    .then(function (r){
      console.log(r);
      if(r.data.status == 'OK'){
        console.log('user login');
        self.props.history.push('/user');
      } else {
        self.message = r.data.error_message;
      }
    })
    .catch(function (error){
      console.log(error);
    });
  }

  changeInput(e){
    if(e.target.name in this.data){
      this.data[e.target.name] = e.target.value;
    }
  }

  render() {
    var s = this.props.store;
    return (
      <div>
        <h1 className="title">{s.getL('loginTitle')}</h1>
        <br/>
        <p>{s.getL('loginDescription')}</p>
        <div className="form">
          <Input title={s.getL('loginFormEmail')}>
            <input onChange={this.changeInput.bind(this)} type="text" name="email" value={this.data.email}/>
          </Input>
          <br/>
          <Input title={s.getL('loginFormPassword')}>
            <input onChange={this.changeInput.bind(this)} type="text" name="password" value={this.data.password}/>
          </Input>
        </div>
        <button onClick={this.register.bind(this)}>{s.getL('loginFormSubmit')}</button>
        <p>{this.message}</p>
      </div>
    );
  }
}
