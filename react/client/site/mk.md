# Markdown example

Betaverteilung:

$f(x) = \frac{1}{B(p, q)}x^{p-1}(1-x)^{q-1}$

Normalisierung:

$f(x) = \frac{x - min}{max - min}$

mit

$W \in [0, 1]$

and some text with [links](http://www.syndesi.de)

inline `some code` just as it can be^[Inlines notes are easier to write, since you don't have to pick an identifier and move down to type the note.].



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