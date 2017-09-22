import {observable, action} from 'mobx';
import axios from 'axios';
import _ from 'lodash';
import mapboxgl from 'mapbox-gl';

class Store {

  @observable string = "Datenow.me";
  @observable mapboxApiKey = 'pk.eyJ1Ijoic29lcmVua2xlaW4iLCJhIjoiY2o3dzBvYWx5NTI3YzJ3bnQ0MjQ3a2sxeSJ9.6jye-1MdKmbCy3GTS1ATGg';

  constructor(){
    console.log('loaded');
    mapboxgl.accessToken = 'pk.eyJ1Ijoic29lcmVua2xlaW4iLCJhIjoiTFhjai1qcyJ9.JvmV0WKbbrySeFyHJQYRfg';
  }

  loadLang(code){
    var self = this;
    axios.get(self.apiURL+'lang/get&lang='+code)
    .then(function(res){
      if(res.data.status == 'OK'){
        self.lang = res.data.result;
        console.log('Language ['+res.data.result.code+'] loaded.');
        console.log(self.getL('registerDescription'));
      }
    })
    .catch(function(res){
      console.log('Language couldn´t be loaded.');
    });
  }

  getL(key){
    if(_.has(this.lang.content, key)){
      return this.lang.content[key];
    }
    return '';
  }
  
}

var store = window.s = new Store();
export default store;