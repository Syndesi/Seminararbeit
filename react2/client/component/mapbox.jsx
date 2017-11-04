import React from 'react';
import ReactDOM from 'react-dom';
import mapboxgl from 'mapbox-gl';

export default class Mapbox extends React.Component {

  isFullscreen = false;

  componentDidMount(){
    var self = this;
    this.node = ReactDOM.findDOMNode(this);
    var node = ReactDOM.findDOMNode(this).querySelectorAll('[data-element="map"]')[0];
    mapboxgl.accessToken = 'pk.eyJ1Ijoic29lcmVua2xlaW4iLCJhIjoiTFhjai1qcyJ9.JvmV0WKbbrySeFyHJQYRfg';
    var map = new mapboxgl.Map({
      container: node,
      style: 'mapbox://styles/mapbox/streets-v9',
      center: [10.451526, 51.165691],
      zoom: 5
    });
    map.fitBounds([[5.8663425, 47.2701115], [15.0418962, 55.0815]]);
    // [[-73.9876, 40.7661], [-73.9397, 40.8002]];
    this.map = map;
    //this.map.on('rotate', function(e){
    //  self.handleRotation();
    //});
  }

  home(){
    this.map.fitBounds([[5.8663425, 47.2701115], [15.0418962, 55.0815]], {
      pitch: 0,
      bearing: 0
    });
  }

  zoomIn(){
    this.map.zoomIn();
  }

  zoomOut(){
    this.map.zoomOut();
  }

  rotate(){
    this.map.rotateTo(0);
  }

  pitch(){
    this.map.easeTo({
      pitch: 0
    });
  }

  componentDidUpdate(){
    this.map.resize();
  }

  fullscreen(){
    console.log('fullscreen');
    this.isFullscreen = !this.isFullscreen;
    this.forceUpdate();
  }

  style(){
    this.map.setStyle('mapbox://styles/mapbox/light-v9');
  }

  render() {
    var mapClass = '';
    if(this.isFullscreen){
      mapClass = 'fullscreen';
    }
    return (
      <div className={'mapComponent '+mapClass} >
        <div className="map" data-element="map"></div>
        <div className="overlay">
          <div className="btn-group-vertical" role="group" aria-label="Basic example">
            <button type="button" className="btn btn-secondary" onClick={this.home.bind(this)}><span className="icon material">near_me</span></button>
            <button type="button" className="btn btn-secondary" onClick={this.zoomIn.bind(this)}><span className="icon material">add</span></button>
            <button type="button" className="btn btn-secondary" onClick={this.zoomOut.bind(this)}><span className="icon material">remove</span></button>
            <button type="button" className="btn btn-secondary" onClick={this.rotate.bind(this)}>O</button>
            <button type="button" className="btn btn-secondary" onClick={this.pitch.bind(this)}>/</button>
            <button type="button" className="btn btn-secondary" onClick={this.style.bind(this)}><span className="icon material">layers</span></button>
            <button type="button" className="btn btn-secondary" onClick={this.fullscreen.bind(this)}><span className="icon material">fullscreen</span></button>
            <a href="https://www.mapbox.com/" target="_blank" className="btn btn-secondary"><span className="icon icomoon">mapbox</span></a>
          </div>
        </div>
      </div>
    );
  }
}