import React from 'react';


import Markdown from '../component/markdown.jsx';
import text from './mk.md';

export default class Mk extends React.Component {

  render(){
    return (
      <div className="container">
        <Markdown text={text} />
      </div>
    );
  }
}