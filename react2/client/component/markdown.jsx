import React, {createElement} from 'react';
import ReactDOM from 'react-dom';
const md = require('markdown-it')();
const katex = require('markdown-it-katex');
const prism = require('markdown-it-prism');
const HtmlToReactParser = require('html-to-react').Parser;


export default class Markdown extends React.Component {

  render(){
    md.use(katex);
    md.use(prism, {
      plugins: ['highlight-keywords']
    });
    md.renderer.rules.table_open = function(tokens, idx){
      return '<table class="table">';
    };
    var html = md.render(this.props.text);
    var parser = new HtmlToReactParser();
    return (
      <div className="markdown">{parser.parse(html)}</div>
    );
  }
}