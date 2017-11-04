import React from 'react';
import {observer} from 'mobx-react';
import {Link} from 'react-router-dom';


@observer
export default class Header extends React.Component {

  render() {
    return (
      <nav className="navbar navbar-expand-lg navbar-light bg-light">
        <Link to="/" className="navbar-brand">Seminararbeit</Link>
        <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span className="navbar-toggler-icon"></span>
        </button>
        <div className="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div className="navbar-nav">
            <Link to="/map" className="nav-item nav-link">Map</Link>
            <Link to="/icon" className="nav-item nav-link">Icons</Link>
            <Link to="/demo/id" className="nav-item nav-link">Demo</Link>
          </div>
        </div>
      </nav>
    );
  }
}