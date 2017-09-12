import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter } from 'react-router-dom';

import 'materialize-css/dist/css/materialize.min.css';
import 'materialize-css/dist/js/materialize.min.js';

require('./style/main.scss');
import Store from './store.jsx';
import Router from './router.jsx';

ReactDOM.render((
  <BrowserRouter>
    <Router store={Store} />
  </BrowserRouter>
), document.getElementById('app'));