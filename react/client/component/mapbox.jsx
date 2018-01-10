import React from 'react';
import ReactDOM from 'react-dom';
import mapboxgl from 'mapbox-gl';
import {Button, Popover, PopoverHeader, PopoverBody} from 'reactstrap';

export default class Mapbox extends React.Component {

  accessToken = 'pk.eyJ1Ijoic29lcmVua2xlaW4iLCJhIjoiTFhjai1qcyJ9.JvmV0WKbbrySeFyHJQYRfg';
  styles = {
    'Streets':           ['mapbox://styles/mapbox/streets-v9',                     'https://api.mapbox.com/styles/v1/mapbox/streets-v9/static/'],
    'Light':             ['mapbox://styles/mapbox/light-v9',                       'https://api.mapbox.com/styles/v1/mapbox/light-v9/static/'],
    'Dark':              ['mapbox://styles/mapbox/dark-v9',                        'https://api.mapbox.com/styles/v1/mapbox/dark-v9/static/'],
    'Outdoors':          ['mapbox://styles/mapbox/outdoors-v9',                    'https://api.mapbox.com/styles/v1/mapbox/outdoors-v9/static/'],
    'Satellite':         ['mapbox://styles/mapbox/satellite-v9',                   'https://api.mapbox.com/styles/v1/mapbox/satellite-v9/static/'],
    'Satellite-Streets': ['mapbox://styles/mapbox/satellite-streets-v9',           'https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v9/static/']
  };

  constructor(props){
    super(props);
    this.state = {
      isLayerOpen: false,
      currentStyle: 'Streets',
      isFullscreen: false,
      layers: []
    };
  }

  componentDidMount(){
    var self = this;
    this.node = ReactDOM.findDOMNode(this);
    var node = ReactDOM.findDOMNode(this).querySelectorAll('[data-element="map"]')[0];
    mapboxgl.accessToken = this.accessToken;
    var map = new mapboxgl.Map({
      container: node,
      style: 'mapbox://styles/mapbox/streets-v9',
      center: [10.451526, 51.165691],
      zoom: 5
    });
    map.fitBounds([[5.8663425, 47.2701115], [15.0418962, 55.0815]]);
    // [[-73.9876, 40.7661], [-73.9397, 40.8002]];
    this.map = map;
    this.props.store.map = this;
    //map.once('moveend', function() {
    //  console.log(map.getCenter());
    //  console.log(map.getZoom());
    //});
    //this.map.on('rotate', function(e){
    //  self.handleRotation();
    //});
    //console.log('1');
    //var el = <p className="icon icomoon">dwd</p>;
    //console.log('2');
    //console.log(mapboxgl);
    ////var marker = new mapboxgl.Marker('<h1>so only html?</h1>');
    //  //.setLngLat([10.942, 48.4254]);
    //  //.addTo(map);
    //var el = document.createElement('div');
    //el.className = 'marker';
    //new mapboxgl.Marker(el)
    //.setLngLat([10.942, 48.4254])
    //.addTo(this.map);
    //var marker = this.addMarker(<p className="icon icomoon markerRight">dwd</p>, [10.897716, 48.052787], {});
  }

  addMarker(react, coords, options){
    var el = document.createElement('div');
    el.className = "markerContainer";
    ReactDOM.render(react, el);
    console.log(-el.offsetHeight/2);
    var marker = new mapboxgl.Marker(el, {offset: [0, 0]})
               .setLngLat(coords)
               .addTo(this.map);
    return marker;
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
    this.setState({
      isFullscreen: !this.state.isFullscreen
    });
  }

  setStyle(el){
    var style = el.currentTarget.getAttribute('data-style');
    this.map.setStyle(this.styles[style][0]);
    this.setState({
      currentStyle: style
    });
  }

  toggleLayers(){
    this.setState({
      isLayerOpen: !this.state.isLayerOpen
    });
  }

  getStaticMapLink(key){
    return this.styles[key][1]+'10.45411,51.34185,2.8/120x120?access_token='+this.accessToken;
  }

  render() {
    var l = this.props.store.lang.components.mapbox;
    var mapClass = 'mapComponent';
    var fullscreen_icon = 'fullscreen';
    if(this.state.isFullscreen){
      mapClass += ' fullscreen';
      fullscreen_icon = 'fullscreen_exit';
    }
    var maps = [];
    for(var key in this.styles){
      var buttonClass = 'btn btn-outline-primary m-2 p-0 cursor';
      if(this.state.currentStyle == key){
        buttonClass += ' active';
      }
      maps.push(
        <button type="button" className={buttonClass} data-style={key} onClick={this.setStyle.bind(this)}>
          <div className="img">
            <img src={this.getStaticMapLink(key)} alt={key} />
          </div>
          <p>{key}</p>
        </button>
      );
    }

    return (
      <div className={mapClass} >
        <div className="map" data-element="map"></div>
        <div className="overlay">
          <div className="btn-group-vertical" role="group" aria-label="Basic example">
            <button type="button" className="btn btn-primary" onClick={this.home.bind(this)} title={l.home}><span className="icon material">near_me</span></button>
            <button type="button" className="btn btn-primary" onClick={this.zoomIn.bind(this)} title={l.zoomIn}><span className="icon material">add</span></button>
            <button type="button" className="btn btn-primary" onClick={this.zoomOut.bind(this)} title={l.zoomOut}><span className="icon material">remove</span></button>
            <button type="button" className="btn btn-primary" id="layers" onClick={this.toggleLayers.bind(this)} title={l.layers}><span className="icon material">layers</span></button>
            <button type="button" className="btn btn-primary" onClick={this.fullscreen.bind(this)} title={l.fullscreen}><span className="icon material">{fullscreen_icon}</span></button>
            <a href="https://www.mapbox.com/" target="_blank" className="btn btn-primary" title={l.mapbox}><span className="icon icomoon">mapbox</span></a>

            <Popover className="mapLayerPopover" placement="right" isOpen={this.state.isLayerOpen} target="layers" toggle={this.toggleLayers.bind(this)}>
              <PopoverHeader>Style</PopoverHeader>
              <PopoverBody>
                {maps}
              </PopoverBody>
            </Popover>
          </div>
        </div>
      </div>
    );
  }
}