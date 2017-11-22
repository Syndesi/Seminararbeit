import React from 'react';
import ReactDOM from 'react-dom';


export default class Geogebra extends React.Component {

  appletObject = null;
  loaded = false;

  constructor(props){
    super(props);
    this.state = {
      intervalId: false
    };
  }

  componentDidMount(){
    this.node = ReactDOM.findDOMNode(this);
    this.applet = new window.GGBApplet({
      filename:            this.props.url,
      prerelease:          false,
      showToolBar:         false,
      borderColor:         null,
      showMenuBar:         false,
      showAlgebraInput:    false,
      showResetIcon:       false,
      enableLabelDrags:    false,
      enableShiftDragZoom: false,
      enableRightClick:    false,
      capturingThreshold:  null,
      showToolBarHelp:     false,
      errorDialogsActive:  true,
      useBrowserForJS:     false
    }, true);
    this.applet.inject(this.node);    
    var intervalId = window.setInterval(this.checkGeogebraStatus.bind(this), 500);
    this.setState({
      intervalId: intervalId
    });
  }

  checkGeogebraStatus(){
    this.appletObject = this.applet.getAppletObject();
    if(this.appletObject !== undefined){
      if(!(this.appletObject instanceof HTMLElement)){
        this.loaded = true;
        var p = this.props;
        this.appletObject.setCoordSystem(p.minX, p.maxX, p.minY, p.maxY);
        window.clearInterval(this.state.intervalId);
      }
    }
  }

  render(){
    return (
      <div className="geogebra" />
    );
  }
}

Geogebra.defaultProps = {
  minX: 0,
  maxX: 1,
  minY: 0,
  maxY: 1,
  url: 'http://localhost:80/Seminararbeit/server/web/res/ggb/kriging_spherical.ggb'
}