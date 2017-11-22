import React from 'react';


import Markdown from '../../component/markdown.jsx';
import text from './kriging.md';

export default class Kriging extends React.Component {

  render(){
    return (
      <div className="container">
        <Markdown text={text} />
      </div>
    );
  }
}