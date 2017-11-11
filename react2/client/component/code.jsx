import React from 'react';
import Prism from 'prismjs';
import PrismJsx from 'prismjs/components/prism-jsx.min';
var HtmlToReactParser = require('html-to-react').Parser;


export default class Code extends React.Component {

  render(){
    Prism.hooks.add('wrap', function(env){
      if (env.type !== "keyword"){
        return;
      }
      env.classes.push('keyword-' + env.content);
    });
    var html = Prism.highlight(this.props.code, Prism.languages[this.props.language]);
    var parser = new HtmlToReactParser();
    return (
      <pre className={"language-"+this.props.language}>
        <code className={"language-"+this.props.language}>
          {parser.parse(html)}
        </code>
      </pre>
    );
  }
}