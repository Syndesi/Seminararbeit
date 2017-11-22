import React from 'react';
import {observer} from 'mobx-react';
import {Link} from 'react-router-dom';
import {toast} from 'react-toastify';
import axios from 'axios';


@observer
export default class Update extends React.Component {

  constructor(props){
    super(props);
    this.state = {
      form: {
        forename:       '',
        surname:        '',
        password:       '',
        password_check: ''
      },
      passwordWarning: null
    };
  }

  updateFormData(el){
    var updated = {
      ...this.state.form,
      [el.currentTarget.id]: el.currentTarget.value
    };
    var passwordWarning = this.checkPassword(updated);
    this.setState({
      form: updated,
      passwordWarning: passwordWarning
    });
  }

  checkPassword(form){
    var pw1 = form.password;
    var pw2 = form.password_check;
    if(pw2 == ''){
      return null;
    }
    if(pw2.length < 8){
      return 'warningShortPassword';
    }
    if(pw1 != pw2){
      return 'warningMismatchingPassword';
    }
    return null;
  }

  sendUpdateRequest(){
    var l = this.props.store.lang.site.account.register;
    if(this.state.passwordWarning != null){
      toast.error(l[this.state.passwordWarning]);
      return false;
    }
    var quit = false;
    var f = this.state.form;
    if(f.forename == ''){
      toast.error(l['warningForenameEmpty']);
      quit = true;
    }
    if(f.surname == ''){
      toast.error(l['warningSurnameEmpty']);
      quit = true;
    }
    if(f.password == ''){
      toast.error(l['warningPasswordEmpty']);
      quit = true;
    }
    if(f.password_check == ''){
      toast.error(l['warningPasswordEmpty2']);
      quit = true;
    }
    if(quit){
      return false;
    }
    var route = this.props.route;
    console.log('updating...');
    axios.put(this.props.store.apiUrl+'account', f, {withCredentials: true})
    .then(function(res){
      if(res.data.status != 'OK'){
        s.toastError(res.data.status, res.data.error_message);
        return false;
      } else {
        toast(l['updated']);
        route.history.push('/');
      }
    })
    .catch(function(error){
      s.toastError(error.message, error.message);
      console.log(error);
      return false;
    });
  }

  render() {
    var l = this.props.store.lang.site.account.update;
    var s = this.state;
    return (
      <div className="container">
        <h2>{l.title}</h2>
        <form>
          <div className="form-row">
            <div className="form-group col-md-6">
              <label for="forename">{l.forename}</label>
              <input type="text" onChange={this.updateFormData.bind(this)} className="form-control" id="forename" aria-describedby="admin forename" placeholder={l.forenamePlaceholder}  value={s.form.forename}/>
            </div>
            <div className="form-group col-md-6">
              <label for="surname">{l.surname}</label>
              <input type="text" onChange={this.updateFormData.bind(this)} className="form-control" id="surname" aria-describedby="admin surname" placeholder={l.surnamePlaceholder}  value={s.form.surname}/>
            </div>
          </div>
          <div className="form-row">
            <div className="form-group col-md-6">
              <label for="password">{l.password}</label>
              <input type="password" onChange={this.updateFormData.bind(this)} className="form-control" id="password" aria-describedby="admin password" placeholder={l.passwordPlaceholder}  value={s.form.password}/>
            </div>
            <div className="form-group col-md-6">
              <label for="password_check">{l.password2}</label>
              <input type="password" onChange={this.updateFormData.bind(this)} className="form-control" id="password_check" aria-describedby="admin password (check)" placeholder={l.passwordPlaceholder2}  value={s.form.password_check}/>
            </div>
            <p className="text-danger">{l[s.passwordWarning]}</p>
          </div>
          <button className="btn btn-primary" onClick={this.sendUpdateRequest.bind(this)} type="button">{l.update}</button>
        </form>
      </div>
    );
  }
}