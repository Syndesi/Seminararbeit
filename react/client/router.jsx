import React from 'react';
import {Switch, Route} from 'react-router-dom';

import E404 from     './page/e404.jsx';
import Index from    './page/index.jsx';
import Login from    './page/login.jsx';
import Register from './page/register.jsx';
import Search from   './page/search.jsx';
import User from   './page/user.jsx';

import Bar from './components/bar.jsx';
import Page from './components/page.jsx';

export default class Router extends React.Component {

  render() {
    var store = this.props.store;
    store.history = this.props.history;
    return (
      <div className="app">
        <Bar store={store} />
        <Page>
          <Switch>
            <Route exact path='/' render={()=><Index store={store}/>}/>
            <Route path='/login' render={()=><Login store={store}/>}/>
            <Route path='/register' render={()=><Register store={store}/>}/>
            <Route exact path='/search' render={()=><Search store={store}/>}/>
            <Route path='/search/:page' render={()=><Search store={store}/>}/>
            <Route path='/user' component={User}/>
            <Route path='/user2/a' render={()=><p>User 2 [a]</p>}/>
            <Route path='/user2' render={()=><p>User 2</p>}/>
            <Route path='/404' render={()=><E404 store={store}/>}/>
            <Route path='/:id' render={()=><p>id in url</p>}/>
          </Switch>
        </Page>
      </div>
    );
  }
}