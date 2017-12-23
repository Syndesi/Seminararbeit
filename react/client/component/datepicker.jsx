import React from 'react';
import {observer} from 'mobx-react';
import dateFormat from 'dateformat';
import {Popover, PopoverHeader, PopoverBody} from 'reactstrap';
import moment from 'moment';
import FocusTrap from 'react-focus-trap';



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

  render(){
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
      var dayClass = [];
      if(!this.state.displayedMonth.isSame(days[i], 'month')){
        dayClass.push('text-secondary');
      }
      if(days[i].isSame(current, 'day')){
        dayClass.push('active');
      }
      if(dayClass.length == 0){
        dayClass = null;
      } else {
        dayClass = dayClass.join(' ');
      }
      var dots = null;
      if(days[i].format('YYYY-MM-DD') in this.props.dots){
        var dotList = this.props.dots[days[i].format('YYYY-MM-DD')];
        var dotsList = [];
        for(var d in dotList){
          var style = {
            backgroundColor: dotList[d]
          };
          dotsList.push(<div className="dot" style={style} />);
        }
        var dots = <div className="dots">{dotsList}</div>
      }
      weeks[week].push(
        <li className={dayClass} data-date={days[i].format()} onClick={this.setDay.bind(this)}>
          {days[i].format('D')}
          {dots}
        </li>
      );
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
        <input type="text" className="form-control" onClick={this.openPopover.bind(this)} ref={node => this.input = node} placeholder="Datepicker" value={inputValue} />
        <FocusTrap onExit={this.closePopover.bind(this)} active={this.state.isPopoverOpen}>
          <Popover className="datePickerPopover" placement="bottom" isOpen={this.state.isPopoverOpen} target={this.input} toggle={this.closePopover.bind(this)}>
            <nav class="navbar-nav">
              <ul className="nav d-flex w-100 justify-content-between">
                <li className="nav-item">
                  <a className="nav-link px-2" onClick={this.previousMonth.bind(this)} href="#"><span className="icon material">keyboard_arrow_left</span></a>
                </li>
                <li className="nav-item navbar-brand">
                  {today}
                </li>
                <li className="nav-item">
                  <a className="nav-link px-2" onClick={this.nextMonth.bind(this)} href="#"><span className="icon material">keyboard_arrow_right</span></a>
                </li>
              </ul>
            </nav>
            <div className="row">
              {calendar}
            </div>
          </Popover>
        </FocusTrap>
      </div>
    );
  }
}

DatePicker.defaultProps = {
  label:    '',
  onChange: function(date){console.log(date.format('DD.MM.YYYY'));},
  value:    false,
  format:   '',
  dots:     {
    '2017-12-23':  ['#ff0000', '#00ff00', '#0000ff'],
    '2018-01-13':  ['#007BFF'],
    '2018-05-19':  ['#007BFF']
  }
}