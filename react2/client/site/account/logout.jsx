import React from 'react';
import {observer} from 'mobx-react';
import {Link} from 'react-router-dom';
import {toast} from 'react-toastify';
import axios from 'axios';


@observer
export default class Logout extends React.Component {

  componentDidMount(){
    this.logout();
  }

  logout(){
    var s = this.props.store;
    var l = this.props.store.lang.site.account.logout;
    var route = this.props.route;
    s.logout();
    axios.get(this.props.store.apiUrl+'account/logout', {withCredentials: true})
    .then(function(res){
      if(res.data.status != 'OK'){
        s.toastError(res.data.status, res.data.error_message);
        return false;
      } else {
        toast(l['logedOut']);
        route.history.push('/');
      }
    })
    .catch(function(error){
      s.toastError(error.message, error.message);
      console.log(error);
      return false;
    });
  }

  render(){
    var l = this.props.store.lang.site.account.logout;
    return (
      <div className="container">
        <h2>{l.title}</h2>
        <p>{l.message} <Link to="/">{l.home}</Link></p>
      </div>
    );
  }
}