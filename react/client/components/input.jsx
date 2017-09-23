import React from 'react';


export default class Input extends React.Component {

  render() {
    return (
      <div className="row">
        <div className="left">
          <p>{this.props.title}</p>
        </div>
        <div className="right">
          {this.props.children}
        </div>
      </div>
    );
  }
}

Input.defaultProps = {
  title: 'Description'
}