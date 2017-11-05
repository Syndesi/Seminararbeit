import React from 'react';
import ReactDOM from 'react-dom';
import mapboxgl from 'mapbox-gl';
import {Button, Popover, PopoverHeader, PopoverBody} from 'reactstrap';

export default class Mapbox extends React.Component {

  isFullscreen = false;
  accessToken = 'pk.eyJ1Ijoic29lcmVua2xlaW4iLCJhIjoiTFhjai1qcyJ9.JvmV0WKbbrySeFyHJQYRfg';

  constructor(props){
    super(props);
    this.state = {
      isLayerOpen: false
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
    map.once('moveend', function() {
      console.log(map.getCenter());
      console.log(map.getZoom());
    });
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
    console.log(this.state);
  }

  fullscreen(){
    console.log('fullscreen');
    this.isFullscreen = !this.isFullscreen;
    this.forceUpdate();
  }

  setStyle(el){
    var style = el.currentTarget.getAttribute('data-style');
    console.log(style);
    this.map.setStyle('mapbox://styles/mapbox/'+style);
  }

  toggleLayers(){
    this.setState({
      isLayerOpen: !this.state.isLayerOpen
    });
  }

  getStaticMapLink(style){
    return 'https://api.mapbox.com/styles/v1/mapbox/'+style+'/static/10.45411,51.34185,2.8/120x120?access_token='+this.accessToken;
  }

  render() {
    // mapbox-styles:
    var mapClass = '';
    if(this.isFullscreen){
      mapClass = 'fullscreen';
    }
    return (
      <div className={'mapComponent '+mapClass} >
        <div className="map" data-element="map"></div>
        <div className="overlay">
          <div className="btn-group-vertical" role="group" aria-label="Basic example">
            <Button onClick={this.home.bind(this)}><span className="icon material">near_me</span></Button>
            <Button onClick={this.zoomIn.bind(this)}><span className="icon material">add</span></Button>
            <Button onClick={this.zoomOut.bind(this)}><span className="icon material">remove</span></Button>
            <Button onClick={this.rotate.bind(this)}>O</Button>
            <Button onClick={this.pitch.bind(this)}>/</Button>
            <Button id="layers" onClick={this.toggleLayers.bind(this)}><span className="icon material">layers</span></Button>
            <Button onClick={this.fullscreen.bind(this)}><span className="icon material">fullscreen</span></Button>
            <a href="https://www.mapbox.com/" target="_blank" className="btn btn-secondary"><span className="icon icomoon">mapbox</span></a>
            <Popover className="mapLayerPopover" placement="right" isOpen={this.state.isLayerOpen} target="layers" toggle={this.toggleLayers.bind(this)}>
              <PopoverHeader>Style</PopoverHeader>
              <PopoverBody>
                <Button outline className="active m-2 p-0" data-style="streets-v9" onClick={this.setStyle.bind(this)}>
                  <div className="img">
                    <img src={this.getStaticMapLink('streets-v9')} alt="Mapbox streets" />
                  </div>
                  <p>Streets</p>
                </Button>
                <Button outline className="m-2 p-0" data-style="light-v9" onClick={this.setStyle.bind(this)}>
                  <div className="img">
                    <img src={this.getStaticMapLink('light-v9')} alt="Mapbox light" />
                  </div>
                  <p>Light</p>
                </Button>
                <Button outline className="m-2 p-0" data-style="dark-v9" onClick={this.setStyle.bind(this)}>
                  <div className="img">
                    <img src={this.getStaticMapLink('dark-v9')} alt="Mapbox dark" />
                  </div>
                  <p>Dark</p>
                </Button>
                <Button outline className="m-2 p-0" data-style="outdoors-v9" onClick={this.setStyle.bind(this)}>
                  <div className="img">
                    <img src={this.getStaticMapLink('outdoors-v9')} alt="Mapbox outdoors" />
                  </div>
                  <p>Outdoors</p>
                </Button>
                <Button outline className="m-2 p-0" data-style="satellite-v9" onClick={this.setStyle.bind(this)}>
                  <div className="img">
                    <img src={this.getStaticMapLink('satellite-v9')} alt="Mapbox satellite" />
                  </div>
                  <p>Satellite</p>
                </Button>
                <Button outline className="m-2 p-0" data-style="satellite-streets-v9" onClick={this.setStyle.bind(this)}>
                  <div className="img">
                    <img src={this.getStaticMapLink('satellite-streets-v9')} alt="Mapbox satellite-streets" />
                  </div>
                  <p>Satellite-Streets</p>
                </Button>
              </PopoverBody>
            </Popover>
          </div>
        </div>
      </div>
    );
  }
}