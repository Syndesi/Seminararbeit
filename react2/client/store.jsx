import {observable} from 'mobx';
import axios from 'axios';

class Store {

  @observable apiURL = 'http://localhost/Seminararbeit/server/api/';
  @observable text = 'hello world! :D';
  
  constructor(){
    console.log('Store loaded');
  }
  
}

var store = window.s = new Store();
export default store;