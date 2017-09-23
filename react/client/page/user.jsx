import React from 'react';
import {Switch, Route} from 'react-router-dom';
import {observer} from 'mobx-react';

import UserDetail from './userDetail.jsx';
import ProfileSummary from '../components/profilesummary.jsx';

@observer
export default class User extends React.Component {

  render() {
    var store = this.props.store;
    console.log(this.props);
    return (
      <div>
        <p>User</p>
        <p>This is the updated version :D</p>
        <div className="userGrid">
          <ProfileSummary></ProfileSummary>
        </div>
      </div>
    );
  }
}