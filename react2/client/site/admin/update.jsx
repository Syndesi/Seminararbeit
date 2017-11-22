import React from 'react';
import {observer} from 'mobx-react';
import {Link} from 'react-router-dom';
import {toast} from 'react-toastify';
import axios from 'axios';
import format from 'date-format';

import Markdown from '../../component/markdown.jsx';


@observer
export default class Update extends React.Component {

  constructor(props){
    super(props);
    this.state = {
      updates: null,
      currentUpdate: 0
    };
    this.getAvailableUpdates();
  }

  getAvailableUpdates(){
    var self = this;
    axios.get(this.props.store.apiUrl+'update/', null, {withCredentials: true})
    .then(function(res){
      console.log(res);
      if(res.data.status != 'OK'){
        s.toastError(res.data.status, res.data.error_message);
        return false;
      } else {
        toast('get available updates');
        self.setState({
          'updates': res.data.result
        });
      }
    })
    .catch(function(error){
      s.toastError(error.message, error.message);
      console.log(error);
      return false;
    });
  }

  openUpdateDetail(el){
    var i = el.currentTarget.getAttribute('data-i');
    this.setState({
      currentUpdate: i
    });
  }

  render() {
    var l = this.props.store.lang.site.admin.update;
    var state = this.state;
    var updates = [];
    var description = null;
    if(state.updates != null){
      for(var i in state.updates){
        var el = state.updates[i];
        var liClass = 'list-group-item d-flex justify-content-between align-items-center';
        var badgeClass = 'badge badge-pill';
        if(state.currentUpdate == i){
          liClass += ' active';
          badgeClass += ' badge-light';
        } else {
          badgeClass += ' badge-primary';
        }
        updates.push(
          <li data-i={i} onClick={this.openUpdateDetail.bind(this)} className={liClass}>
            {el.name}
            <span className={badgeClass}>{el.tag_name}</span>
          </li>
        );
      }
      if(state.currentUpdate in state.updates){
        var update = state.updates[state.currentUpdate];
        var date = format('yyyy.MM.dd hh:mm', new Date(update.published_at));
        description = (
          <div className="card-body">
            <a href={update.html_url}><h2>{update.name}</h2></a>
            <p className="text-secondary"><small><em>
              {date} by <a href={update.author.html_url} target="_blank" className="text-secondary"><u>{update.author.login}</u></a>
            </em></small></p>
            <Markdown text={update.body} />
            <hr />
            <div className="d-flex justify-content-between align-items-center">
              <div className="btn-group" role="group" aria-label="download-links">
                <div className="btn btn-secondary btn-sm"><span className="icon material">file_download</span></div>
                <a href={update.zipball_url} className="btn btn-secondary btn-sm">zip</a>
                <a href={update.tarball_url} className="btn btn-secondary btn-sm">tar.gz</a>
              </div>
              <div className="btn btn-primary">Update Server</div>
            </div>
          </div>
        );
      }
    }
    return (
      <div className="container">
        <div className="row">
          <div className="col-md-4">
            <ul class="list-group">
              {updates}
            </ul>
          </div>
          <div className="col-md-8">
            <div className="card">
              {description}
            </div>
          </div>
        </div>
      </div>
    );
  }
}