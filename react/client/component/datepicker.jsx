import React from 'react';
import {observer} from 'mobx-react';
import dateFormat from 'dateformat';
import {Popover, PopoverHeader, PopoverBody} from 'reactstrap';



@observer
export default class DatePicker extends React.Component {

  constructor(props){
    super(props);
    this.state = {
      currentDay: false,
      isPopoverOpen: false
    };
  }

  openPopover(){
    this.setState({
      isPopoverOpen: true
    });
  }

  closePopover(){
    this.setState({
      isPopoverOpen: false
    });
  }

  render() {
    var l = this.props.store.lang.components.datepicker;
    var state = this.state;
    var date = new Date();
    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    var lastDay  = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    console.log(firstDay);
    console.log(firstDay.getDay());
    return (
      <div class="form-group datepicker">
        <label for="datepicker">DatePicker</label>
        <input type="text" class="form-control" id="datepicker" placeholder="Datepicker" onClick={this.openPopover.bind(this)} />
        <Popover className="datePickerPopover" placement="bottom" isOpen={this.state.isPopoverOpen} target="datepicker" toggle={this.closePopover.bind(this)}>
          <div className="row">
            <ul class="nav d-flex w-100 justify-content-between">
              <li class="nav-item">
                <a class="nav-link active" href="#">-</a>
              </li>
              <li class="nav-item">
                19.12.2017
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">-</a>
              </li>
            </ul>
          </div>
          <div className="row">
            <ul class="week">
              <li>1</li>
              <li>
                2
                <div className="dots">
                  <div className="dot" />
                  <div className="dot" />
                  <div className="dot" />
                  <div className="dot bg-success" />
                  <div className="dot bg-success" />
                  <div className="dot bg-success" />
                  <div className="dot bg-success" />
                  <div className="dot bg-danger" />
                  <div className="dot bg-danger" />
                  <div className="dot bg-danger" />
                  <div className="dot bg-danger" />
                </div>
              </li>
              <li>3</li>
              <li>4</li>
              <li>5</li>
              <li>6</li>
              <li>7</li>
            </ul>
            <ul class="week">
              <li>8</li>
              <li className="active">9</li>
              <li>10</li>
              <li>11</li>
              <li>
                12
                <div className="dots">
                  <div className="dot bg-success" />
                  <div className="dot bg-danger" />
                </div>
              </li>
              <li>
                13
                <div className="dots">
                  <div className="dot" />
                </div>
              </li>
              <li>14</li>
            </ul>
            <ul class="week">
              <li>15</li>
              <li>16</li>
              <li>17</li>
              <li>18</li>
              <li>19</li>
              <li>20</li>
              <li>21</li>
            </ul>
            <ul class="week">
              <li>22</li>
              <li>23</li>
              <li>24</li>
              <li>25</li>
              <li>26</li>
              <li>27</li>
              <li>28</li>
            </ul>
            <ul class="week">
              <li>29</li>
              <li>30</li>
              <li>31</li>
              <li className="text-secondary">1</li>
              <li className="text-secondary">2</li>
              <li className="text-secondary">3</li>
              <li className="text-secondary">4</li>
            </ul>
            <ul class="week">
              <li className="text-secondary">5</li>
              <li className="text-secondary">6</li>
              <li className="text-secondary">7</li>
              <li className="text-secondary">8</li>
              <li className="text-secondary">9</li>
              <li className="text-secondary">10</li>
              <li className="text-secondary">11</li>
            </ul>
          </div>
        </Popover>
      </div>
    );
  }
}