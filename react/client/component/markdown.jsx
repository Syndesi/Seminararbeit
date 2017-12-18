import React, {createElement} from 'react';
import ReactDOM from 'react-dom';
const katex = require('markdown-it-katex');
const prism = require('markdown-it-prism');
const fn = require('markdown-it-footnote');
const HtmlToReactParser = require('html-to-react').Parser;


export default class Markdown extends React.Component {

  getMd(){
    var md = require('markdown-it')({html:true});
    md.use(require('markdown-it-katex'));
    md.use(require('markdown-it-footnote'));
    md.use(require('markdown-it-prism'), {
      plugins: ['highlight-keywords']
    });
    md.renderer.rules.table_open = function(tokens, idx){
      return '<table class="table">';
    };
    md.renderer.rules.blockquote_open = function(tokens, idx){
      return '<blockquote class="blockquote">';
    };
    return md;
  }

  render(){
    var md = this.getMd();
    var text = this.props.text;
    if(!text){
      text = ''; // e.g. site is still loading
    }
    var html = md.render(text);
    var parser = new HtmlToReactParser();
    return (
      <div className="markdown">{parser.parse(html)}</div>
    );
  }
}