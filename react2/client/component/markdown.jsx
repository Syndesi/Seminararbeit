import React, {createElement} from 'react';
import marksy from 'marksy/components';
import MathJax from 'react-mathjax-preview';

import Code from './code.jsx';

export default class Markdown extends React.Component {

  compile(string){
    var compiler = marksy({
      createElement,
      elements: {
        code({ language, children, code }) {
          return (
            children ? // render inline code:
              <code>{children}</code> : // render block code:
            <div>
              <Code code={code} language={language} />
            </div>
          );
        }
      },
      components: {
        Math (props){
          return <MathJax math={'`'+props.children[0]+'`'} />
        }
      }
    });
    return compiler(string, {}).tree;
  }

  render(){
    var content = this.compile(this.props.text);
    return (
      <div className="markdown">{content}</div>
    );
  }
}