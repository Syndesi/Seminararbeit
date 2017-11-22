import React from 'react';
import {Link} from 'react-router-dom';


export default class SetupDatabase extends React.Component {

  render() {
    return (
      <div className="container">
        <h2>Setup - Datenbank</h2>
        <form>
          <div className="form-row">
            <div className="form-group col-md-6">
              <label for="host">Host:</label>
              <input type="text" className="form-control" id="host" aria-describedby="database host" placeholder="localhost" />
            </div>
            <div className="form-group col-md-6">
              <label for="host">Database:</label>
              <input type="text" className="form-control" id="name" aria-describedby="database name" placeholder="dusty_box" />
            </div>
          </div>
          <div className="form-row">
            <div className="form-group col-md-6">
              <label for="host">User:</label>
              <input type="text" className="form-control" id="host" aria-describedby="database user" placeholder="Syndesi" />
            </div>
            <div className="form-group col-md-6">
              <label for="password">Password:</label>
              <input type="password" className="form-control" id="password" aria-describedby="database password" placeholder="not 1234" />
            </div>
          </div>
          <div className="btn-group" role="group" aria-label="navigation">
            <Link to="/" className="btn btn-secondary">home</Link>
            <Link to="/setup/email" className="btn btn-secondary">next</Link>
          </div>
        </form>
      </div>
    );
  }
}