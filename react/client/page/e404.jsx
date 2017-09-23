import React from 'react';
import {observer} from 'mobx-react';

@observer
export default class E404 extends React.Component {

  render(){
    return (
      <p>404 - requested file not found, sry :(</p>
    );
  }
}