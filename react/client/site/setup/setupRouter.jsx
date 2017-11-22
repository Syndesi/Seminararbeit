import React from 'react';
import {Switch, Route, Redirect} from 'react-router-dom';

import SetupAdmin from './setupAdmin.jsx';
import SetupDatabase from './setupDatabase.jsx';
import SetupEmail from './setupEmail.jsx';


export default class SetupRouter extends React.Component {

  render() {
    var store = this.props.store;
    return (
      <div>
        <Route path='/setup/database' render={(route)=><SetupDatabase route={route} store={store} />}/>
        <Route path='/setup/email' render={(route)=><SetupEmail route={route} store={store} />}/>
        <Route path='/setup/admin' render={(route)=><SetupAdmin route={route}store={store} />}/>
        <Route exact path='/setup' render={(route)=><p>Default setup site</p>}/>
        <Route exact path="/setup" render={()=><Redirect to="/setup/database"/>}/>
      </div>
    );
  }
}