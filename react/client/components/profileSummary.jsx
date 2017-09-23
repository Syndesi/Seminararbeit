import React from 'react';
import Link from 'react-router-dom';


export default class ProfileSummary extends React.Component {
  render() {
    return (
      <div className="profileSummary">
        <div className="view front">
          <img className="profileImage" src=""></img>
        </div>
        <div className="view back">
          <img className="backgroundImage" src=""></img>
          <img className="profileImage" src=""></img>
          <h1>Venla <span className="surname">Manninen</span></h1>
        </div>
      </div>
    );
  }
}