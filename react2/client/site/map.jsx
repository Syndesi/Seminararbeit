import React from 'react';
import {observer} from 'mobx-react';

import Mapbox from '../component/mapbox.jsx';

@observer
export default class Map extends React.Component {

  render() {
    return (
      <div className="container">
        <div className="row">
          <div className="col-md-8">
            <div className="card">
              <div className="card-img-top">
                <Mapbox />
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
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}