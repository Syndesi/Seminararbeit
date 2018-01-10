import React from 'react';
import {observer} from 'mobx-react';
import {Link} from 'react-router-dom';
import {toast} from 'react-toastify';
import axios from 'axios';
import dateFormat from 'dateformat';
import DayPickerInput from 'react-day-picker/DayPickerInput';
import moment from 'moment';

import {saveAs} from 'file-saver';
import fileDialog from 'file-dialog';

import Markdown from '../../component/markdown.jsx';
import DatePicker from '../../component/datepicker.jsx';


@observer
export default class InsertData extends React.Component {

  constructor(props){
    super(props);
    this.state = {
      panel:  'uba',
      panels: ['uba', 'dwd'],
      form: {
        uba: {
          start:  moment().subtract(1, 'days').format('DD.MM.YYYY'),
          end:    moment().format('DD.MM.YYYY'),
          types:  {
            o3:   true,
            co:   true,
            no2:  true,
            so2:  true,
            pm10: true
          }
        }
      },
      actions: []
    };
  }

  downloadActions(){
    var name = 'actions_'+dateFormat(new Date(), "yyyymmdd_HHMM")+'.json';
    var file = new File([JSON.stringify(this.state.actions, null, 2)], name, {type: "application/json;charset=utf-8"});
    saveAs(file);
  }

  loadActions(){
    var self = this;
    fileDialog({multiple: false, accept: '.json'}, files => {
      var reader = new FileReader();
      reader.onload = function(e){
        self.setState({
          actions: JSON.parse(e.target.result)
        });
      };
      reader.onerror = function(e){
        self.store.toastError('error', 'File could not read. Error code: '+e.target.error.code);
      };
      reader.readAsText(files[0]);
    })
  }

  switchPanel(el){
    var panel = el.currentTarget.getAttribute('data-panel');
    if(this.state.panel == panel){
      return true;
    }
    this.setState({
      panel: panel
    });
  }

  clearActions(){
    this.setState({
      actions: []
    });
  }

  setUbaInput(el){
    var input = el.currentTarget.value;
    this.setState({
      form: {
        ...this.state.form,
        uba: {
          ...this.state.form.uba,
          [el.currentTarget.getAttribute('type')]: input
        }
      }
    });
  }

  setUbaStart(day){
    this.setState({
      form: {
        ...this.state.form,
        uba: {
          ...this.state.form.uba,
          start: day.format('DD.MM.YYYY')
        }
      }
    });
  }

  setUbaEnd(day){
    this.setState({
      form: {
        ...this.state.form,
        uba: {
          ...this.state.form.uba,
          end: day.format('DD.MM.YYYY')
        }
      }
    });
  }

  setUbaSubstance(el){
    var substance = el.currentTarget.getAttribute('data-substance');
    this.setState({
      form: {
        ...this.state.form,
        uba: {
          ...this.state.form.uba,
          types: {
            ...this.state.form.uba.types,
            [substance]: el.currentTarget.checked
          }
        }
      }
    });
  }

  generateUbaActions(){
    var actions = [];
    var start = moment(this.state.form.uba.start, 'DD.MM.YYYY');
    var end = moment(this.state.form.uba.end, 'DD.MM.YYYY');
    if(!start._isValid || !end._isValid){
      return false; // date is incorrect
    }
    var substances = [];
    for(var substance in this.state.form.uba.types){
      if(this.state.form.uba.types[substance]){
        substances.push(substance);
      }
    }
    var tmp = moment(start);
    var action = [];
    while(tmp.isSameOrBefore(end)){
      for(var i in substances){
        actions.push({
          url:     this.props.store.apiUrl+'uba/'+substances[i]+'/'+tmp.format('YYYY-MM-DD'),
          time:    moment(tmp),
          status:  'unstarted',
          message: (substances[i]).toUpperCase()
        });
      }
      tmp.add(1, 'd');
    }
    console.log(actions);
    this.setState({
      actions: actions
    }, () => {
      this.runActions('unstarted');
    });
    this.props.store.toastInfo(false, actions.length+' actions generated.');
    var time = moment(0).subtract(1, 'hour').add(actions.length * 10, 'seconds');
    this.props.store.toastInfo(false, 'Estimated time: '+time.format('HH:mm'));
  }

  runNextAction(status){
    var self = this;
    for(var i in this.state.actions){
      var action = this.state.actions[i];
      if(action.status != status){
        continue;
      }
      axios.post(action.url, {}, {withCredentials: true})
      .then(function (res){
        if(res.data.status == 'OK'){
          self.setState({
            actions: {
              ...self.state.actions,
              [i]: {
                ...action,
                status:  'ok',
                data:    res.data,
                message: action.message + ' - ok'
              }
            }
          });
          console.log('successfully loaded '+action.url);
        } else {
          console.log(res);
        }
        self.runNextAction(status);
      });
      return true;
    }
  }

  runActions(status){
    this.runNextAction(status);
    //var self = this;
    //for(var i in this.state.actions){
    //  var action = this.state.actions[i];
    //  if(action.status != status){
    //    continue;
    //  }
    //  axios.post(action.url, {}, {withCredentials: true})
    //  .then(function (res){
    //    if(res.data.status == 'OK'){
    //      self.setState({
    //        actions: {
    //          ...self.state.actions,
    //          [i]: {
    //            ...action,
    //            status:  'ok',
    //            data:    res.data,
    //            message: action.message + ' - ok'
    //          }
    //        }
    //      });
    //      console.log('state updated');
    //    } else {
    //      console.log(res);
    //    }
    //  });
    //  console.log(action);
    //}
    //console.log('Actions finished');
    //console.log(this.state);
  }

  restartActions(){
    this.runActions('failed');
  }

  getPanel(){
    var res = null;
    var s = this.state;
    switch(s.panel){
      case 'uba':
        var substanceCheckboxes = [];
        for(var substance in this.state.form.uba.types){
          var type = this.state.form.uba.types[substance];
          substanceCheckboxes.push(
            <div className="form-check">
              <label className="form-check-label">
                <input className="form-check-input" type="checkbox" onClick={this.setUbaSubstance.bind(this)} data-substance={substance} defaultChecked={this.state.form.uba.types[substance]}/>
                {substance.toUpperCase()}
              </label>
            </div>
          );
        }
        res = (
          <form>
            <div class="form-group">
              <label for="ubaStart">Start</label>
              <div class="input-group">
                <input type="text" id="ubaStart" className="form-control" type="start" onChange={this.setUbaInput.bind(this)} placeholder="Datepicker" value={this.state.form.uba.start}/>
                <span class="input-group-btn">
                  <DatePicker date={this.state.form.uba.start} onChange={this.setUbaStart.bind(this)}/>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label for="ubaEnd">End</label>
              <div class="input-group">
                <input type="text" id="ubaEnd" className="form-control" type="end" onChange={this.setUbaInput.bind(this)} placeholder="Datepicker" value={this.state.form.uba.end}/>
                <span class="input-group-btn">
                  <DatePicker date={this.state.form.uba.end} onChange={this.setUbaEnd.bind(this)}/>
                </span>
              </div>
            </div>
            <p className="mb-1">Zu importierende Substanzen:</p>
            {substanceCheckboxes}
            <button className="btn btn-primary" type="button" onClick={this.generateUbaActions.bind(this)}>import data</button>
          </form>
        );
        break;
      case 'dwd':
        res = <p>dwd</p>;
        break;
      default:
        res = <p>this panel does not exist.</p>
        break;
    }
    return <div className="py-3">{res}</div>;
  }

  render() {
    var l = this.props.store.lang.site.admin.insertData;
    var panels = [];
    for(var i in this.state.panels){
      var id = this.state.panels[i];
      var panelClass = 'nav-link';
      if(id == this.state.panel){
        panelClass += ' active';
      }
      panels.push(
        <li className="nav-item">
          <a href="#" className={panelClass} data-panel={id} onClick={this.switchPanel.bind(this)}>{l.panel[id]}</a>
        </li>
      );
    }
    var actions = [];
    for(var i in this.state.actions){
      var entry = this.state.actions[i];
      var actionsClass = 'list-group-item';
      switch(entry.status){
        case 'unstarted':
          //actionsClass += ' ';
          break;
        case 'ok':
          actionsClass += ' list-group-item-success';
          break;
        case 'failed':
          actionsClass += ' list-group-item-danger';
          break;
        default:
          break;
      }
      actions.push(
        <li className={actionsClass}>
          <div class="d-flex w-100 justify-content-between">
            <p class="mb-1">{entry.message}</p>
            <small>{entry.time.format('DD.MM.YYYY')}</small>
          </div>
        </li>
      );
    }
    return (
      <div className="container">
        <h1 className="mb-4">Import Data</h1>
        <div className="row">
          <div className="col-md-8">
            <ul className="nav nav-tabs">
              {panels}
            </ul>
            {this.getPanel()}
          </div>
          <div className="col-md-4">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
              <div className="btn-group mr-2 mb-2">
                <button className="btn btn-primary" onClick={this.downloadActions.bind(this)} title="save action"><span className="icon material">file_download</span></button>
                <button className="btn btn-primary" onClick={this.loadActions.bind(this)} title="load action"><span className="icon material">file_upload</span></button>
              </div>
              <div className="btn-group mr-2 mb-2">
                <button className="btn btn-primary" onClick={this.restartActions.bind(this)} title="retry failed operations"><span className="icon material">autorenew</span></button>
                <button className="btn btn-primary" onClick={this.clearActions.bind(this)} title="clear action"><span className="icon material">clear</span></button>
              </div>
            </div>
            <ul className="list-group">
              {actions}
            </ul>
          </div>
        </div>
      </div>
    );
  }
}