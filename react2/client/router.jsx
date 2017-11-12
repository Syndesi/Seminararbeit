import React from 'react';
import {Switch, Route} from 'react-router-dom';

import Header from './component/header.jsx';


import Index from './site/index.jsx';
import Map from './site/map.jsx';
import Icon from './site/icon.jsx';
import Mk from './site/mk.jsx';

import Kriging from './site/md/kriging.jsx';
import Beta from './site/md/beta.jsx';


export default class Router extends React.Component {

  render() {
    var store = this.props.store;
    return (
      <div className="app">
        <Header store={store} />
        <Switch>
          <Route exact path='/' render={(route)=><Index route={route} store={store} />}/>
          <Route path='/map' render={(route)=><Map route={route} store={store} />}/>
          <Route path='/icon' render={(route)=><Icon route={route} store={store} />}/>
          <Route path='/wiki/demo' render={(route)=><Mk route={route} />}/>
          <Route path='/wiki/kriging' render={(route)=><Kriging route={route} />}/>
          <Route path='/wiki/beta' render={(route)=><Beta route={route} />}/>
        </Switch>
      </div>
    );
  }
}