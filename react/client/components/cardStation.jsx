import React from 'react';
import ReactDOM from 'react-dom';
import {observer} from 'mobx-react';

@observer
export default class CardStation extends React.Component {

  componentDidMount(){
    //console.log(window.$(ReactDOM.findDOMNode(this)).find('ul.tabs'));
    var node = window.$(ReactDOM.findDOMNode(this));
    var tabs = node.find('.tabs');
    //tabs.tabs();
    //console.log(tabs);
  }

  render() {
    return (
      <div className="card">
        <div className="card-image waves-effect waves-block waves-light"></div>
        <div className="card-content">
          <span className="card-title activator grey-text text-darken-4">Augsburg<i className="material-icons right">more_vert</i></span>
          <ul className="tabs">
            <li className="tab"><a className="active blue-text text-darken-4" href="#test1">Daten</a></li>
            <li className="tab"><a className="blue-text text-darken-4" href="#test2">Bearbeiten</a></li>
            <li className="indicator  blue darken-4"></li>
          </ul>
          <div id="test1" className="col s12">Daten</div>
          <div id="test2" className="col s12">Bearbeiten</div>
        </div>
        <div className="card-reveal">
          <span className="card-title grey-text text-darken-4">Augsburg<i className="material-icons right">close</i></span>
          <p>Mehr content...</p>
        </div>
      </div>
    );
  }
}