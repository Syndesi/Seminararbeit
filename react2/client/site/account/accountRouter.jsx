import React from 'react';
import {Switch, Route} from 'react-router-dom';

import Login from './login.jsx';
import Register from './register.jsx';


export default class AccountRouter extends React.Component {

  render() {
    var store = this.props.store;
    return (
      <div>
        <Route path='/account/login' render={(route)=><Login route={route} store={store} />}/>
        <Route path='/account/register' render={(route)=><Register route={route} store={store} />}/>
        <Route exact path='/account' render={(route)=><p>Own account</p>}/>
      </div>
    );
  }
}