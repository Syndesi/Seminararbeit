import React from 'react';
import {observable} from 'mobx';
import {observer} from 'mobx-react';
import axios from 'axios';

import Input from '../components/input.jsx';
import Button from '../components/button.jsx';

@observer
export default class Register extends React.Component {

  @observable data = {
      forename: '',
      surname: '',
      nickname: '',
      email: '',
      number: '',
      birthday: '',
      gender: '',
      description: '',
      inform_email: '',
      inform_mobile: '',
      password: ''
  };

  register(){
    var self = this;
    axios.post(this.props.store.apiURL+'user/create', this.data)
    .then(function (r){
      console.log(r);
      if(r.data.status == 'OK'){
        console.log('user created');
        self.props.history.push('/user');
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
        <h1 className="title">{s.getL('registerTitle')}</h1>
        <br/>
        <p>{s.getL('registerDescription')}</p>
        <div className="form">
          <Input title={s.getL('registerFormForename')}>
            <input onChange={this.changeInput.bind(this)} type="text" name="forename" value={this.data.forename}/>
          </Input>
          <Input title={s.getL('registerFormSurname')}>
            <input onChange={this.changeInput.bind(this)} type="text" name="surname" value={this.data.surname}/>
          </Input>
          <Input title={s.getL('registerFormNickname')}>
            <input onChange={this.changeInput.bind(this)} type="text" name="nickname" value={this.data.nickname}/>
          </Input>
          <Input title={s.getL('registerFormEmail')}>
            <input onChange={this.changeInput.bind(this)} type="text" name="email" value={this.data.email}/>
          </Input>
          <Input title={s.getL('registerFormNumber')}>
            <input onChange={this.changeInput.bind(this)} type="text" name="number" value={this.data.number}/>
          </Input>
          <Input title={s.getL('registerFormBirthday')}>
            <input onChange={this.changeInput.bind(this)} type="text" name="birthday" value={this.data.birthday}/>
          </Input>
          <Input title={s.getL('registerFormGender')}>
            <input onChange={this.changeInput.bind(this)} type="text" name="gender" value={this.data.gender}/>
          </Input>
          <Input title={s.getL('registerFormDescription')}>
            <input onChange={this.changeInput.bind(this)} type="text" name="description" value={this.data.description}/>
          </Input>
          <Input title={s.getL('registerFormInformEmail')}>
            <input onChange={this.changeInput.bind(this)} type="text" name="inform_email" value={this.data.inform_email}/>
          </Input>
          <Input title={s.getL('registerFormInformMobile')}>
            <input onChange={this.changeInput.bind(this)} type="text" name="inform_mobile" value={this.data.inform_mobile}/>
          </Input>
          <br/>
          <Input title={s.getL('registerFormPassword')}>
            <input onChange={this.changeInput.bind(this)} type="text" name="password" value={this.data.password}/>
          </Input>
        </div>
        <Button onClick={this.register.bind(this)}>{s.getL('registerFormSubmit')}</Button>
      </div>
    );
  }
}
