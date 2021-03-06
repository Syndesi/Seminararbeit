import React from 'react';
import {Switch, Route} from 'react-router-dom';

import Update from './update.jsx';


export default class AdminRouter extends React.Component {

  render() {
    var store = this.props.store;
    return (
      <div>
        <Route path='/admin/update' render={(route)=><Update route={route} store={store} />}/>
      </div>
    );
  }
}