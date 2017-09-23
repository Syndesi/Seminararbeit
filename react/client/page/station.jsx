import React from 'react';
import {observer} from 'mobx-react';
import {observable} from 'mobx';
import { Scrollbars } from 'react-custom-scrollbars';
import C3Chart from 'react-c3js';
import axios from 'axios';
import 'c3/c3.css';

import CardStation from '../components/cardStation.jsx';
import CardMap from '../components/cardMap.jsx';

@observer
export default class Station extends React.Component {

  @observable.ref stationData = {
    'o3': {},
    'no2': {},
    'so2': {},
    'co': {},
    'pm10': {}
  };

  renderTrackVertical({ style, ...props }) {
    const finalStyle = {
        ...style,
        right: 2,
        bottom: 2,
        top: 30,
        borderRadius: 3
    };
    return <div style={finalStyle} {...props} />;
  }

  componentDidMount(){
    var station = '150';
    var date = '2017-09-14';
    var self = this;
    axios.get(self.props.store.apiURL+'uba/station/'+station+'/'+date)
    .then(function(res){
      if(res.data.status == 'OK'){
        self.stationData = res.data.result;
      }
    })
    .catch(function(res){
      console.log('Station couldn´t be loaded.');
    });
  }

  convertData(name, array){
    var res = [];
    res.push(name);
    for(var date in array){
      res.push(array[date]);
    }
    return res;
  }

  render() {
    const padding = {
      top: 10,
      right: 40,
      bottom: 0,
      left: 40,
    };
    const data = {
      columns: [
        this.convertData('Ozon', this.stationData.o3),
        this.convertData('Stickoxide', this.stationData.no2),
        this.convertData('Schwefeloxid', this.stationData.so2),
        //this.convertData('Kohlenmonoxid', this.stationData.co),
        this.convertData('Feinstaub', this.stationData.pm10),
      ],
      type: 'spline',
      axes: {
        Kohlenmonoxid2: 'y1'
      }
    };
    const tooltip = {
      format: {
        title: function(d){
          return 'Data '+d;
        },
        value: function(value, ratio, id){
          return value+' µg/m³';
        }
      }
    };
    return (
      <div className="row">
        <div className="col s12 m6">
          <div className="card">
            <div className="card-image waves-effect waves-block waves-light">
              <C3Chart data={data} padding={padding} tooltip={tooltip}/>
            </div>
            <div className="card-content">
              <span className="card-title activator grey-text text-darken-4">Augsburg<i className="material-icons right">more_vert</i></span>
              <p><a href="#">This is a link</a></p>
            </div>
            <div className="card-reveal">
              <Scrollbars autoHide={true} renderTrackVertical={this.renderTrackVertical} renderTrackHorizontal={function(){return <div></div>}}>
                <span className="card-title grey-text text-darken-4">Augsburg<i className="material-icons right">close</i></span>
                <p>Mehr Details :D</p>
                <p>hi</p>
                <table>
                  <thead>
                    <tr>
                      <th>Tag</th>
                      <th>Ozon</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>09.09.2017</td>
                      <td>35</td>
                    </tr>
                    <tr>
                      <td>10.09.2017</td>
                      <td>47</td>
                    </tr>
                    <tr>
                      <td>11.09.2017</td>
                      <td>42</td>
                    </tr>
                    <tr>
                      <td>09.09.2017</td>
                      <td>35</td>
                    </tr>
                    <tr>
                      <td>10.09.2017</td>
                      <td>47</td>
                    </tr>
                    <tr>
                      <td>11.09.2017</td>
                      <td>42</td>
                    </tr>
                    <tr>
                      <td>09.09.2017</td>
                      <td>35</td>
                    </tr>
                    <tr>
                      <td>10.09.2017</td>
                      <td>47</td>
                    </tr>
                    <tr>
                      <td>11.09.2017</td>
                      <td>42</td>
                    </tr>
                  </tbody>
                </table>
              </Scrollbars>
            </div>
          </div>
        </div>
      </div>
    );
  }
}