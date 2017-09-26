import React from 'react';
import {observer} from 'mobx-react';
import { Scrollbars } from 'react-custom-scrollbars';
import C3Chart from 'react-c3js';
import 'c3/c3.css';

import CardStation from '../components/cardStation.jsx';
import CardMap from '../components/cardMap.jsx';

@observer
export default class Index extends React.Component {

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

  render() {
    const padding = {
      top: 10,
      right: 40,
      bottom: 0,
      left: 40,
    };
    const data = {
      columns: [
        ['Ozon', 30, 200, 100, 400, 150, 250],
        ['Stickoxide', 50, 20, 10, 40, 15, 25]
      ],
      axes: {
        Stickoxide: 'y2'
      }
    };
    return (
      <div className="row">
        <div className="col s12 m12">
          <div className="card">
            <div className="card-image waves-effect waves-block waves-light">
              <C3Chart data={data} padding={padding} />
            </div>
            <div className="card-content">
              <span className="card-title activator grey-text text-darken-4">Augsburg<i className="material-icons right">more_vert</i></span>
              <p><a href="#">This is a link</a></p>
            </div>
            <div className="card-reveal">
              <Scrollbars autoHide={true} renderTrackVertical={this.renderTrackVertical} renderTrackHorizontal={function(){return <div></div>}}>
                <span className="card-title grey-text text-darken-4">Augsburg<i className="material-icons right">close</i></span>
                <p>Mehr Details :D</p>
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
        <div className="col s12 m12">
          <CardStation></CardStation>
        </div>
        <div className="col s12 m12">
          <CardMap></CardMap>
        </div>
      </div>
    );
  }
}