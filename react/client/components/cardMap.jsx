import React from 'react';
import ReactDOM from 'react-dom';
import {observer} from 'mobx-react';
import mapboxgl from 'mapbox-gl';

@observer
export default class CardMap extends React.Component {

  componentDidMount(){
    var node = window.$(ReactDOM.findDOMNode(this));
    var mapNode = node.find('.map')[0];
    this.map = new mapboxgl.Map({
      container: mapNode,
      style: 'mapbox://styles/soerenklein/cj7w3vd633odx2st4l2mcti2h',
      center: [8.4728347, 49.5196336],
      zoom: 4,
    });
    this.map.fitBounds([[
      5.8663425,
      47.2701115
    ], [
      15.0418962,
      55.0815
    ]]);
    //var tabs = node.find('.tabs');
  }

  render() {
    return (
      <div className="card">
        <div className="card-image">
          <div className="map"></div>
        </div>
        <div className="card-content">
          <span className="card-title activator grey-text text-darken-4">Deutschland<i className="material-icons right">more_vert</i></span>
        </div>
        <div className="card-reveal">
          <span className="card-title grey-text text-darken-4">Deutschland<i className="material-icons right">close</i></span>
        </div>
      </div>
    );
  }
}