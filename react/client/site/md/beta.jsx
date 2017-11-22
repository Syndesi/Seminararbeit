import React from 'react';


import Markdown from '../../component/markdown.jsx';
import text from './beta.md';

export default class Beta extends React.Component {

  render(){
    return (
      <div className="container">
        <Markdown text={text} />
      </div>
    );
  }
}