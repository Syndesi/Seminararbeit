import React from 'react';
import {observer} from 'mobx-react';

@observer
export default class UserDetail extends React.Component {

  render() {
    var store = this.props.store;
    return (
      <div>
        <p>User detail</p>
      </div>
    );
  }
}