import React from 'react';
import {observer} from 'mobx-react';
import {Link, NavLink, withRouter} from 'react-router-dom';

@withRouter
@observer
export default class Bar extends React.Component {

  render() {
    return (
      <div className="bar">
        <div className="contentWidth">
          <Link to="/" className="title">{this.props.store.applicationName}</Link>
          <NavLink to="/login" className="link" activeClassName="active"><p>Login</p><p className="icon">L</p></NavLink>
          <NavLink to="/register" className="link" activeClassName="active" className="link">Register</NavLink>
          <NavLink to="/search" className="link" activeClassName="active">Search</NavLink>
          <NavLink to="/user" className="link" activeClassName="active">User</NavLink>
        </div>
      </div>
    );
  }
}