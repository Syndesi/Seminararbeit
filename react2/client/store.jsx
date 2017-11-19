import {observable} from 'mobx';
import {toast} from 'react-toastify';
import axios from 'axios';

import langDe from './res/lang/de.json';
import langEn from './res/lang/en.json';

class Store {

  @observable apiUrl = 'http://localhost/Seminararbeit/server/api/';
  @observable text = 'hello world! :D';
  @observable lang = langEn;
  @observable user = {};
  
  constructor(){
    console.log('Store loaded');
  }

  updateUserData(){
    var self = this;
    axios.get(this.apiUrl+'account/status', {withCredentials: true})
    .then(function(res){
      console.log(res);
      if(res.data.status != 'OK'){
        s.toastError(res.data.status, res.data.error_message);
        return false;
      } else {
        toast('user updated');
        self.user = res.data.result;
      }
    })
    .catch(function(error){
      console.log(error);
      s.toastError(error.message, error.message);
      console.log(error);
      return false;
    });
  }

  toastError(code, message){
    if(code in this.lang.error_codes){
      message = this.lang.error_codes[code];
    }
    toast.warning(message);
  }

  switchLang(lang){
    console.log('Switching language to ['+lang+']');
    switch(lang){
      case 'de':
        this.lang = langDe;
        break;
      case 'en':
        this.lang = langEn;
        break;
      default:
        console.log('The language ['+lang+'] does not exist.');
        break;
    }
  }
  
}

var store = window.s = new Store();
export default store;