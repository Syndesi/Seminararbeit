import React from 'react';
import {observer} from 'mobx-react';
import {Link} from 'react-router-dom';
import {toast} from 'react-toastify';
import axios from 'axios';
import format from 'date-format';

import Markdown from '../../component/markdown.jsx';


@observer
export default class InsertData extends React.Component {

  constructor(props){
    super(props);
    this.state = {
      panel:  'uba',
      panels: ['uba', 'dwd'],
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

  getPanel(){
    var res = null;
    switch(this.state.panel){
      case 'uba':
        res = (
          <form>
            <div className="form-group">
              <label for="dateStart">start</label>
              <input type="text" className="form-control" id="dateStart" aria-describedby="dateStart" />
            </div>
            <div className="form-group">
              <label for="dateEnd">end</label>
              <input type="text" className="form-control" id="dateEnd" aria-describedby="dateEnd" />
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
                <button className="btn btn-primary" title="save log"><span className="icon material">file_download</span></button>
                <button className="btn btn-primary" title="load log"><span className="icon material">file_upload</span></button>
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