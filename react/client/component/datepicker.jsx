import React from 'react';
import {observer} from 'mobx-react';
import dateFormat from 'dateformat';
import {Popover, PopoverHeader, PopoverBody} from 'reactstrap';
import moment from 'moment';



@observer
export default class DatePicker extends React.Component {

  constructor(props){
    super(props);
    var day = moment();
    if(this.props.value !== false){
      day = moment(this.props.value, this.props.format);
    }
    this.state = {
      currentDay:     day,
      displayedMonth: moment(day).startOf('month'),
      isPopoverOpen:  false
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

  previousMonth(){
    this.setState({
      displayedMonth: this.state.displayedMonth.subtract(1, 'month')
    });
  }

  nextMonth(){
    this.setState({
      displayedMonth: this.state.displayedMonth.add(1, 'month')
    });
  }

  getDays(year, month){
    var res = [];
    moment.locale('de');
    var start = moment().year(year).month(month).startOf('month').startOf('week');
    var end = moment().year(year).month(month).endOf('month').endOf('week');
    var tmp = start;
    while(tmp.isSameOrBefore(end)){
      res.push(moment(tmp));
      tmp.add(1, 'd');
    }
    return res;
  }

  setDay(el){
    var date = el.currentTarget.getAttribute('data-date');
    this.setState({
      currentDay: moment(date)
    });
    this.props.onChange(moment(date));
    this.closePopover();
  }

  render() {
    var l = this.props.store.lang.components.datepicker;
    var state = this.state;
    var current = moment(this.state.currentDay);
    var days = this.getDays(this.state.displayedMonth.year(), this.state.displayedMonth.month());
    var weeks = [];
    for(var i in days){
      var week = Math.floor(i / 7);
      if(!weeks[week]){
        weeks[week] = [];
      }
      var dayClass = '';
      if(!this.state.displayedMonth.isSame(days[i], 'month')){
        dayClass += ' text-secondary';
      }
      if(days[i].isSame(current, 'day')){
        dayClass += ' active';
      }
      weeks[week].push(<li className={dayClass} data-date={days[i].format()} onClick={this.setDay.bind(this)}>{days[i].format('D')}</li>);
    }
    var calendar = [];
    for(var i in weeks){
      calendar.push(<ul className="week">{weeks[i]}</ul>);
    }
    //<li>
    //  2
    //  <div className="dots">
    //    <div className="dot" />
    //    <div className="dot bg-success" />
    //    <div className="dot bg-danger" />
    //  </div>
    //</li>
    var today = this.state.displayedMonth.format('MMMM YYYY');
    var inputValue = this.state.currentDay.format('DD.MM.YYYY');
    return (
      <div className="form-group datepicker">
        <label for="datepicker">{this.props.label}</label>
        <input type="text" className="form-control" id="datepicker" placeholder="Datepicker" onClick={this.openPopover.bind(this)} value={inputValue} />
        <Popover className="datePickerPopover" placement="bottom" isOpen={this.state.isPopoverOpen} target="datepicker" toggle={this.closePopover.bind(this)}>
          <div className="row">
            <ul className="nav d-flex w-100 justify-content-between">
              <li className="nav-item">
                <a className="nav-link" onClick={this.previousMonth.bind(this)} href="#"><span className="icon material">keyboard_arrow_left</span></a>
              </li>
              <li className="nav-item">
                {today}
              </li>
              <li className="nav-item">
                <a className="nav-link" onClick={this.nextMonth.bind(this)} href="#"><span className="icon material">keyboard_arrow_right</span></a>
              </li>
            </ul>
          </div>
          <div className="row">
            {calendar}
          </div>
        </Popover>
      </div>
    );
  }
}

DatePicker.defaultProps = {
  label:    '',
  onChange: function(date){console.log(date.format('DD.MM.YYYY'));},
  value:    false,
  format:   ''
}