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
          <Link to="/" className="brand-logo">Seminararbeit</Link>
          <ul id="nav-mobile" className="right hide-on-med-and-down">
            <Link to="/station">Station</Link>
            <li><a href="https://github.com/Syndesi/Seminararbeit">GitHub</a></li>
          </ul>
        </div>
      </nav>
    );
  }
}