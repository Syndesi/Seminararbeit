import {observable, action} from 'mobx';
import axios from 'axios';
import _ from 'lodash';

class Store {

  @observable applicationName = "Datenow.me";
  @observable apiURL = "http://localhost/mango5777/api/";
  @observable history = null;
  @observable langCode = 'en';
  @observable lang = false;

  constructor(){
    console.log('loaded');
    console.log(this.getL('registerDescription'));
    this.loadLang(this.langCode);
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

  /*
  sendPost(data, f){
    // AJAX-request with url-encoded data
    fetch(this.props.store.apiURL, {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
      },
      body: this.objToUrl(data)
    })
    .then((resp) => resp.json())
    .then(function(data){
      console.log(data);
      f(data);
    });
  }*/
}

var store = window.s = new Store();
export default store;