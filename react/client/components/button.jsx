import React from 'react';


export default class Button extends React.Component {
  render() {
    return (
      <button className={this.props.className} onClick={this.props.onClick.bind(this)}>
        {this.props.children}
      </button>
    );
  }
}

Button.defaultProps = {
  className: '',
  onClick: function(){
    console.log('button clicked :D');
  }
}