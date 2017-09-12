import {observable, action} from 'mobx';
import axios from 'axios';
import _ from 'lodash';

class Store {

  @observable string = "Datenow.me";

  constructor(){
    console.log('loaded');
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