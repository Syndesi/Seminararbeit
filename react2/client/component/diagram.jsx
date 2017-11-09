import React from 'react';
import ReactDOM from 'react-dom';
import Plotly from 'plotly.js/dist/plotly-cartesian';
import ReactResizeDetector from 'react-resize-detector';
import {Button} from 'reactstrap';


export default class Diagram extends React.Component {

  resize(){
    Plotly.Plots.resize(this.node);
  }

  fullscreen(){
    this.refs["container"].classList.toggle('fullscreen');
    this.refs["nodeContainer"].classList.toggle('plotlyRatio');
    this.resize();
    //Plotly.relayout(this.node, {
    //  autosize: true,
    //  margin: {
    //    l: 100,
    //    r: 100,
    //    b: 100,
    //    t: 100,
    //  }
    //});
  }

  componentDidMount(){
    //this.node = ReactDOM.findDOMNode(this).getElementById('plotly');
    this.node = this.refs["node"];
    console.log(this.node);
    this.pl = Plotly.plot(this.node, [{
      x: [1, 2, 3, 4, 5],
      y: [1, 2, 4, 8, 16] }], {
        //autosize: true,
        //height: 300,
        margin: {
          l: 20,
          r: 20,
          b: 40,
          t: 40,
          pad: 4
        }
      },
      {
        displaylogo: false,
        modeBarButtonsToRemove: [
          'lasso2d',
          'toggleSpikelines',
          'zoom2d',
          'autoScale2d'
        ]
      }
    );
  }

  render(){
    return (
      <div ref="container" className="plotly">
        <Button onClick={this.fullscreen.bind(this)}><span className="icon material">fullscreen</span></Button>
        <div ref="nodeContainer" className="plotlyRatio">
          <div ref="node" />
        </div>
        <div>
          <ReactResizeDetector handleWidth handleHeight onResize={this.resize.bind(this)} />
        </div>
      </div>
    );
  }
}