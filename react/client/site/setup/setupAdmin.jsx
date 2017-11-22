import React from 'react';
import {Link} from 'react-router-dom';


export default class SetupAdmin extends React.Component {

  render() {
    return (
      <div className="container">
        <h2>Setup - Admin</h2>
        <form>
          <div className="form-row">
            <div className="form-group col-md-6">
              <label for="forename">Forename:</label>
              <input type="text" className="form-control" id="forename" aria-describedby="admin forename" placeholder="Enter admin forename" />
            </div>
            <div className="form-group col-md-6">
              <label for="surname">Surname:</label>
              <input type="text" className="form-control" id="surname" aria-describedby="admin surname" placeholder="Enter admin surname" />
            </div>
          </div>
          <div className="form-group">
            <label for="email">Email:</label>
            <input type="email" className="form-control" id="email" aria-describedby="admin email" placeholder="Enter admin email" />
          </div>
          <div className="form-row">
            <div className="form-group col-md-6">
              <label for="password">Password:</label>
              <input type="password" className="form-control" id="password" aria-describedby="admin password" placeholder="not 1234" />
            </div>
            <div className="form-group col-md-6">
              <label for="password_check">Password (check):</label>
              <input type="password" className="form-control" id="password_check" aria-describedby="admin password (check)" placeholder="seriously, don't use 1234" />
            </div>
          </div>
          <div className="btn-group" role="group" aria-label="navigation">
            <Link to="/setup/email" className="btn btn-secondary">back</Link>
            <Link to="/" className="btn btn-secondary">finish</Link>
          </div>
        </form>
      </div>
    );
  }
}