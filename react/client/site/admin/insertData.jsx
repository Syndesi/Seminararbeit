import React from 'react';
import {observer} from 'mobx-react';
import {Link} from 'react-router-dom';
import {toast} from 'react-toastify';
import axios from 'axios';
import dateFormat from 'dateformat';
import DayPickerInput from 'react-day-picker/DayPickerInput';

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
          from: false,
          to:   false,
          types: {
            o3:   false,
            no2:  false,
            so3:  false,
            co:   false,
            pm10: false
          }
        }
      },
      log:    [
        {
          status: 'ok',
          message: 'Hello world! :D'
        },
        {
          status: 'ok',
          message: 'Log message demo'
        },
        {
          status: 'error',
          message: 'Download failed'
        }
      ]
    };
  }

  downloadLog(){
    var name = 'log_'+dateFormat(new Date(), "yyyymmdd_HHMM")+'.json';
    var file = new File([JSON.stringify(this.state.log)], name, {type: "application/json;charset=utf-8"});
    saveAs(file);
  }

  loadLog(){
    var self = this;
    fileDialog({multiple: false, accept: '.json'}, files => {
      var reader = new FileReader();
      reader.onload = function(e){
        self.setState({
          log: JSON.parse(e.target.result)
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

  clearLog(){
    this.setState({
      log: []
    });
  }

  setUbaStart(day){
    console.log(day);
  }

  setUbaEnd(day){
    console.log(day);
  }

  getPanel(){
    var res = null;
    var s = this.state;
    switch(s.panel){
      case 'uba':
        res = (
          <form>
            <div className="form-group">
              <label for="dateStart">start</label>
              <DatePicker store={this.props.store}/>
            </div>
            <div className="form-group">
              <label for="dateEnd">end</label>
              <DayPickerInput className="form-control" onDayChange={day => this.setUbaEnd(day)} />
            </div>
            <div className="form-check">
              <label className="form-check-label">
                <input className="form-check-input" type="checkbox" value="" />
                O3
              </label>
            </div>
            <div className="form-check">
              <label className="form-check-label">
                <input className="form-check-input" type="checkbox" value="" />
                NO2
              </label>
            </div>
            <div className="form-check">
              <label className="form-check-label">
                <input className="form-check-input" type="checkbox" value="" />
                SO2
              </label>
            </div>
            <div className="form-check">
              <label className="form-check-label">
                <input className="form-check-input" type="checkbox" value="" />
                CO
              </label>
            </div>
            <div className="form-check">
              <label className="form-check-label">
                <input className="form-check-input" type="checkbox" value="" />
                PM10
              </label>
            </div>
            <button className="btn btn-primary" type="button">import data</button>
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
    return res;
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
    var log = [];
    for(var i in this.state.log){
      var logEntry = this.state.log[i];
      var logClass = 'list-group-item';
      switch(logEntry.status){
        case 'ok':
          logClass += ' list-group-item-success';
          break;
        case 'error':
          logClass += ' list-group-item-danger';
          break;
        default:
          break;
      }
      log.push(
        <li className={logClass}>
          <div class="d-flex w-100 justify-content-between">
            <p class="mb-1">{logEntry.message}</p>
            <small>3 days ago</small>
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
                <button className="btn btn-primary" onClick={this.downloadLog.bind(this)} title="save log"><span className="icon material">file_download</span></button>
                <button className="btn btn-primary" onClick={this.loadLog.bind(this)} title="load log"><span className="icon material">file_upload</span></button>
              </div>
              <div className="btn-group mr-2 mb-2">
                <button className="btn btn-primary" title="retry failed operations"><span className="icon material">autorenew</span></button>
                <button className="btn btn-primary" onClick={this.clearLog.bind(this)} title="clear log"><span className="icon material">clear</span></button>
              </div>
            </div>
            <ul className="list-group">
              {log}
            </ul>
          </div>
        </div>
      </div>
    );
  }
}