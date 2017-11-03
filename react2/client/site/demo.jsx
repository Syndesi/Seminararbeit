import React from 'react';
import {observer} from 'mobx-react';


@observer
export default class Demo extends React.Component {

  render() {
    console.log(this.props);
    return (
      <div>
        <p>Demo site</p>
      </div>
    );
  }
}