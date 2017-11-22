import React from 'react';
import {observer} from 'mobx-react';
import {Link} from 'react-router-dom';
import {toast} from 'react-toastify';
import axios from 'axios';


@observer
export default class Login extends React.Component {

  constructor(props){
    super(props);
    this.state = {
      form: {
        email:    '',
        password: ''
      }
    };
  }

  updateFormData(el){
    this.setState({
      form: {
        ...this.state.form,
        [el.currentTarget.id]: el.currentTarget.value
      }
    });
  }

  sendLoginRequest(){
    var s = this.props.store;
    var l = s.lang.site.account.login;
    var f = this.state.form;
    var quit = false;
    if(f.email == ''){
      toast.error(l['warningEmailEmpty']);
      quit = true;
    }
    if(f.password == ''){
      toast.error(l['warningPasswordEmpty']);
      quit = true;
    }
    if(quit){
      return false;
    }
    var route = this.props.route;
    axios.post(this.props.store.apiUrl+'account/login', f, {withCredentials: true})
    .then(function(res){
      console.log(res);
      if(res.data.status != 'OK'){
        s.toastError(res.data.status, res.data.error_message);
        return false;
      } else {
        toast(l['logedIn']);
        s.updateUserData();
        route.history.push('/');
        //window.setTimeout(() => {
        //  s.updateUserData();
        //  route.history.push('/');
        //}, 2000);
      }
    })
    .catch(function(error){
      s.toastError(error.message, error.message);
      console.log(error);
      return false;
    });
  }

  render() {
    var l = this.props.store.lang.site.account.login;
    return (
      <div className="container">
        <h2>{l.title}</h2>
        <form>
          <div className="form-group">
            <label for="email">{l.email}</label>
            <input type="email" onChange={this.updateFormData.bind(this)} className="form-control" id="email" aria-describedby="email" placeholder={l.emailPlaceholder} value={this.state.form.email}/>
          </div>
          <div className="form-group">
            <label for="password">{l.password}</label>
            <input type="password" onChange={this.updateFormData.bind(this)} className="form-control" id="password" aria-describedby="password" placeholder={l.passwordPlaceholder} value={this.state.form.password}/>
          </div>
          <button onClick={this.sendLoginRequest.bind(this)} className="btn btn-primary" type="button">{l.login}</button>
        </form>
      </div>
    );
  }
}