# Markdown example

<Math>y = ln(x^2 - 1) / (x + 1)^2</Math>

and some text with [links](http://www.syndesi.de)

inline `some code` just as it can be.

$\lim_{x \to \infty} \exp(-x) = 0$


```jsx
import React from 'react';
require('something');


import Markdown from '../component/markdown.jsx';
import text from './mk.md';

export default class Mk extends React.Component {

  render(){
    var i = 1234;
    var s = "some text :D"
    console.log(text);
    return (
      <div className="container">
        <Markdown text={text} />
      </div>
    );
  }
}
```