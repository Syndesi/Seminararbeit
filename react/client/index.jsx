import React from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter} from 'react-router-dom';

require('./res/font/roboto/stylesheet.scss');
require('./res/font/robotoMono/stylesheet.scss');
require('./res/font/material/stylesheet.scss');
require('./res/font/icomoon/stylesheet.scss');
require('./style/main.scss');


import Store from './store.jsx';
import Router from './router.jsx';

ReactDOM.render((
  <BrowserRouter basename="/">
    <Router store={Store} />
  </BrowserRouter>
), document.getElementById('app'));