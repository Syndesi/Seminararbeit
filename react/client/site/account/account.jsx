import React from 'react';
import {observer} from 'mobx-react';
import {Link} from 'react-router-dom';
import {toast} from 'react-toastify';
import axios from 'axios';


@observer
export default class Account extends React.Component {

  constructor(props){
    super(props);
  }

  sendLoginRequest(){
    var l = this.props.store.lang.site.account.account;
    var route = this.props.route;
    axios.post(this.props.store.apiUrl+'account', f)
    .then(function(res){
      if(res.data.status != 'OK'){
        s.toastError(res.data.status, res.data.error_message);
        return false;
      } else {
        toast(l['registered']);
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
    var l = this.props.store.lang.site.account.account;
    var s = this.state;
    var user = {
      forename: "Sören",
      surname:  "Klein",
      email:    "soerenklein98@gmail.com",
      created:  "20.11.2017 12:43",
      updated:  "20.11.2017 12:43"
    };
    return (
      <div className="container">
        <h2>{l.title}</h2>
        <div className="row">
          <div className="col-md-6">
            <p>{l.forename}</p>
          </div>
          <div className="col-md-6">
            <p>{user.forename}</p>
          </div>
        </div>
        <div className="row">
          <div className="col-md-6">
            <p>{l.surname}</p>
          </div>
          <div className="col-md-6">
            <p>{user.surname}</p>
          </div>
        </div>
        <div className="row">
          <div className="col-md-6">
            <p>{l.email}</p>
          </div>
          <div className="col-md-6">
            <p>{user.email}</p>
          </div>
        </div>
        <div className="row">
          <div className="col-md-6">
            <p>{l.created}</p>
          </div>
          <div className="col-md-6">
            <p>{user.created}</p>
          </div>
        </div>
        <div className="row">
          <div className="col-md-6">
            <p>{l.updated}</p>
          </div>
          <div className="col-md-6">
            <p>{user.updated}</p>
          </div>
        </div>
        <Link className="btn btn-primary" to="/account/update" >{l.toUpdate}</Link>
      </div>
    );
  }
}