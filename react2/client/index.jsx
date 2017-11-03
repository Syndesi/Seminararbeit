import React from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter} from 'react-router-dom';

require('./font/roboto/stylesheet.scss');
require('./font/robotoMono/stylesheet.scss');
require('./style/main.scss');


import Store from './store.jsx';
import Router from './router.jsx';

ReactDOM.render((
  <BrowserRouter>
    <Router store={Store} />
  </BrowserRouter>
), document.getElementById('app'));