import React from 'react';
import {Switch, Route} from 'react-router-dom';

import Index from    './page/index.jsx';

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
          </Switch>
        </Page>
      </div>
    );
  }
}