import {observable, action} from 'mobx';
import axios from 'axios';
import _ from 'lodash';
import mapboxgl from 'mapbox-gl';

class Store {

  @observable apiURL = 'http://localhost/Seminararbeit/server/api/';
  @observable mapboxApiKey = 'pk.eyJ1Ijoic29lcmVua2xlaW4iLCJhIjoiY2o3dzBvYWx5NTI3YzJ3bnQ0MjQ3a2sxeSJ9.6jye-1MdKmbCy3GTS1ATGg';

  constructor(){
    console.log('loaded');
    mapboxgl.accessToken = 'pk.eyJ1Ijoic29lcmVua2xlaW4iLCJhIjoiTFhjai1qcyJ9.JvmV0WKbbrySeFyHJQYRfg';
  }
  
}

var store = window.s = new Store();
export default store;