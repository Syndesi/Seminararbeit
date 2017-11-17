import React from 'react';
import {Link} from 'react-router-dom';


export default class SetupEmail extends React.Component {

  render() {
    return (
      <div className="container">
        <h2>Setup - Email</h2>
        <form>
          <div className="form-row">
            <div className="form-group col-md-6">
              <label for="host">Host:</label>
              <input type="text" className="form-control" id="host" aria-describedby="email host" placeholder="domain.com" />
            </div>
            <div className="form-group col-md-6">
              <label for="port">Port:</label>
              <input type="text" className="form-control" id="port" aria-describedby="email port" placeholder="587" />
            </div>
          </div>
          <div className="form-row">
            <div className="form-group col-md-6">
              <label for="username">Username:</label>
              <input type="text" className="form-control" id="username" aria-describedby="email username" placeholder="info@domain.com" />
            </div>
            <div className="form-group col-md-6">
              <label for="password">Password:</label>
              <input type="password" className="form-control" id="password" aria-describedby="email password" placeholder="not 1234" />
            </div>
          </div>
          <div class="form-group">
            <label for="encryption">Encryption (SMTPSecure)</label>
            <select class="form-control" id="encryption">
              <option>TLS</option>
              <option>SSL</option>
            </select>
          </div>
          <div className="btn-group" role="group" aria-label="navigation">
            <Link to="/setup/database" className="btn btn-secondary">back</Link>
            <Link to="/setup/admin" className="btn btn-secondary">next</Link>
          </div>
        </form>
      </div>
    );
  }
}