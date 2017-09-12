import React from 'react';
import {observer} from 'mobx-react';

@observer
export default class Index extends React.Component {

  render() {
    return (
      <div>
        <p>Index, here is our company description</p>
        <p>App name: {this.props.store.applicationName}</p>
      </div>
    );
  }
}