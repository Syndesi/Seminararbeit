import React from 'react';
import {observer} from 'mobx-react';


@observer
export default class Index extends React.Component {

  render() {
    return (
      <div>
        <p>{'text: '+this.props.store.text}</p>
      </div>
    );
  }
}