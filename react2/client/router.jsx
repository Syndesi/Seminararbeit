import React from 'react';
import {observer} from 'mobx-react';
import {Switch, Route} from 'react-router-dom';

import Index from './site/index.jsx';
import Demo from './site/demo.jsx';

@observer
export default class Router extends React.Component {

  render() {
    var store = this.props.store;
    var text = 'text: '+store.text;
    return (
      <div className="app">
        <Switch>
          <Route exact path='/' render={()=><Index store={store} />}/>
          <Route path='/:id' component={Demo}/>
        </Switch>
      </div>
    );
  }
}