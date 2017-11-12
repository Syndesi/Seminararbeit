import React from 'react';


import Geogebra from '../component/geogebra.jsx';

export default class Icon extends React.Component {

  render() {
    return (
      <div className="container">
        <h2>Material Icons</h2>
        <Geogebra />
        <p className="icon material">
          lock
        </p>
        <h2>Icomoon Icons (custom)</h2>
        <p className="icon icomoon">
          uba dlr dwd webpack css html php propel mysql react mobx bootstrap materialize python tensorflow github mapbox
        </p>
        <h2>Weather Icons</h2>
        <p>Daytime</p>
        <p className="icon icomoon weather">
          day-sunny day-cloudy day-cloudy-gusts day-cloudy-windy
          day-fog day-hail day-haze day-lightning
          day-rain day-rain-mix day-rain-wind day-showers
          day-sleet day-sleet-storm day-snow day-snow-thunderstorm
          day-snow-wind day-sprinkle day-storm-showers day-sunny-overcast
          day-thunderstorm day-windy solar-eclipse hot
          day-cloudy-high day-light-wind
        </p>
        <p>Nighttime</p>
        <p className="icon icomoon weather">
          night-clear night-alt-cloudy night-alt-cloudy-gusts night-alt-cloudy-windy
          night-alt-hail night-alt-lightning night-alt-rain night-alt-rain-mix
          night-alt-rain-wind night-alt-showers night-alt-sleet night-alt-sleet-storm
          night-alt-snow night-alt-snow-thunderstorm night-alt-snow-wind night-alt-sprinkle
          night-alt-storm-showers night-alt-thunderstorm night-cloudy night-alt-cloudy-gusts
          night-cloudy-windy night-fog night-hail night-lightning
          night-partly-cloudy night-rain night-rain-mix night-rain-wind
          night-showers night-sleet night-sleet-storm night-snow<br/>
          night-snow-thunderstorm night-snow-wind night-sprinkle night-storm-showers
          night-thunderstorm lunar-eclipse stars storm-showers
          thunderstorm night-alt-cloudy-high night-cloudy-high night-alt-partly-cloudy
        </p>
        <p>Neutral</p>
        <p className="icon icomoon weather">
          cloud cloudy cloudy-gusts cloudy-windy
          fog hail rain rain-mix
          rain-wind showers sleet snow
          sprinkle storm-showers thunderstorm snow-wind
          snow smog smoke lightning
          raindrops raindrop dust snowflake-cold
          windy strong-wind sandstorm
          fire flood meteor
          tornado small-craft-advisory
          gale-warning storm-warning hurricane-warning
        </p>
      </div>
    );
  }
}