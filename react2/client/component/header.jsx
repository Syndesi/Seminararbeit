import React from 'react';
import {observer} from 'mobx-react';
import {Link} from 'react-router-dom';
import { Collapse, Navbar, NavbarToggler, NavbarBrand, Nav, NavItem, NavLink } from 'reactstrap';


@observer
export default class Header extends React.Component {

  constructor(props){
    super(props);
    this.state = {
      isOpen: false
    };
  }

  toggle(){
    this.setState({
      isOpen: !this.state.isOpen
    });
  }

  render() {
    return (
      <Navbar color="light" light expand="sm">
        <Link to="/" className="navbar-brand">Seminararbeit</Link>
        <NavbarToggler onClick={this.toggle.bind(this)} />
        <Collapse isOpen={this.state.isOpen} navbar>
          <Nav className="mr-auto" navbar>
            <NavItem>
              <Link to="/map" className="nav-item nav-link">Map</Link>
            </NavItem>
            <NavItem>
              <Link to="/icon" className="nav-item nav-link">Icons</Link>
            </NavItem>
            <NavItem>
              <Link to="/demo/id" className="nav-item nav-link">Demo</Link>
            </NavItem>
          </Nav>
        </Collapse>
      </Navbar>
    );
  }
}