import React from 'react';
import {observer} from 'mobx-react';
import {Link, NavLink, withRouter} from 'react-router-dom';

@withRouter
@observer
export default class Bar extends React.Component {

  render() {
    return (
      <nav>
        <div className="nav-wrapper blue darken-4">
          <a href="#" className="brand-logo">Seminararbeit</a>
          <ul id="nav-mobile" className="right hide-on-med-and-down">
            <li><a href="#">Daten</a></li>
            <li><a href="https://github.com/Syndesi/Seminararbeit">GitHub</a></li>
          </ul>
        </div>
      </nav>
    );
  }
}