import React from 'react';
import {Switch, Route} from 'react-router-dom';

import Header from './component/header.jsx';


import Index from './site/index.jsx';
import Demo from './site/demo.jsx';
import Map from './site/map.jsx';
import Icon from './site/icon.jsx';
import Mk from './site/mk.jsx';


export default class Router extends React.Component {

  render() {
    var store = this.props.store;
    return (
      <div className="app">
        <Header store={store} />
        <Switch>
          <Route exact path='/' render={(route)=><Index route={route} store={store} />}/>
          <Route path='/demo/:id' render={(route)=><Demo route={route} store={store} />}/>
          <Route path='/map' render={(route)=><Map route={route} store={store} />}/>
          <Route path='/icon' render={(route)=><Icon route={route} store={store} />}/>
          <Route path='/mk' render={(route)=><Mk route={route} />}/>
        </Switch>
      </div>
    );
  }
}