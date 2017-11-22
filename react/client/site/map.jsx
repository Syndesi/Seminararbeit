import React from 'react';
import {observer} from 'mobx-react';
import axios from 'axios';

import Mapbox from '../component/mapbox.jsx';
import Diagram from '../component/diagram.jsx';

@observer
export default class Map extends React.Component {

  state = {
    stations: []
  };

  constructor(props){
    super(props);
    this.getDwdStations();
  }

  getDwdStations(){
    var url = this.props.store.apiURL + 'dwd/stations';
    var self = this;
    axios.get(url)
      .then(function (res){
        console.log(res['data']['result']);
        for(var key in res['data']['result']){
          var station = res['data']['result'][key];
          //self.props.store.map.addMarker(<p className="markerBottom">{station['name']}</p>, [station['position']['lng'], station['position']['lat']], {});
        }
        //self.setState({
        //  stations: res['data']['result']
        //});
      })
      .catch(function (error){
        console.log('error while loading the DWD-stations');
        console.log(error);
      });
  }

  render() {
    var stations = this.state.stations;
    var rows = [];
    for(var key in stations){
      var station = stations[key];
      rows.push(
        <tr>
          <th>{key}</th>
          <td>{station['name']}</td>
          <td>{station['position']['lng']}</td>
          <td>{station['position']['lat']}</td>
          <td>{station['position']['alt']}</td>
        </tr>
      );
    }

    return (
      <div className="container">
        <div className="row">
          <div className="col-md-8">
            <div className="card">
              <div className="card-img-top">
                <Mapbox store={this.props.store}/>
              </div>
              <div className="card-body">
                <h4 className="card-title">Map</h4>
                <p className="card-text">Legende etc.</p>
              </div>
            </div>
          </div>
          <div className="col-md-4">
            <div className="card">
              <div className="card-body">
                <h4 className="card-title">Stationsdaten</h4>
                <p className="card-text">Diagram etc.</p>
                <Diagram />
                <table className="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Stationsname</th>
                      <th>Lng</th>
                      <th>Lat</th>
                      <th>Alt</th>
                    </tr>
                  </thead>
                  <tbody>
                    {rows}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}