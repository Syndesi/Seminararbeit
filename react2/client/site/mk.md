# Markdown example

Betaverteilung:

<Math>f(x) = (1)/(B(p, q))x^(p - 1)(1 - x)^(q - 1)</Math>

Normalisierung:

<Math>f(x) = (x - min)/(max - min)</Math>

mit

<Math>\W \in [0, 1]</Math>

and some text with [links](http://www.syndesi.de)

inline `some code` just as it can be.



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