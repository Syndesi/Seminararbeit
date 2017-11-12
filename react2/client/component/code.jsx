import React from 'react';
import {Button} from 'reactstrap';
import copy from 'copy-to-clipboard';
import Prism from 'prismjs';
import PrismJsx from 'prismjs/components/prism-jsx.min';
var HtmlToReactParser = require('html-to-react').Parser;


export default class Code extends React.Component {

  constructor(props){
    super(props);
    this.state = {
      isPrintMode: false,
      theme: 'material'
    };
  }

  togglePrintMode(){
    var theme = 'material';
    if(this.state.theme == 'material'){
      theme = 'coy';
    }
    this.setState({
      isPrintMode: !this.state.isPrintMode,
      theme: theme
    });
  }

  copyToClipboard(){
    copy(this.props.code);
  }

  render(){
    Prism.hooks.add('wrap', function(env){
      if (env.type !== "keyword"){
        return;
      }
      env.classes.push('keyword-' + env.content);
    });
    var html = Prism.highlight(this.props.code, Prism.languages[this.props.language]);
    var parser = new HtmlToReactParser();
    var codeClass = 'code';
    if(this.state.isPrintMode){
      codeClass += ' print';
    }
    return (
      <div className={codeClass}>
        <pre className={"language-"+this.props.language+" "+this.state.theme}>
          <code className={"language-"+this.props.language}>
            {parser.parse(html)}
          </code>
        </pre>
        <div class="btn-group" role="group" aria-label="code viewer menu">
          <Button onClick={this.copyToClipboard.bind(this)}><span className="icon material">content_copy</span></Button>
          <Button onClick={this.togglePrintMode.bind(this)}><span className="icon material">print</span></Button>
        </div>
      </div>
    );
  }
}