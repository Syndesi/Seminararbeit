import React from 'react';
import {observer} from 'mobx-react';
import {Link} from 'react-router-dom';
import { Collapse, Navbar, NavbarToggler, NavbarBrand, Nav, NavItem, NavLink, Dropdown, DropdownToggle, DropdownMenu, DropdownItem } from 'reactstrap';


@observer
export default class Header extends React.Component {

  constructor(props){
    super(props);
    this.state = {
      isOpen: false,
      wikiDropdownOpen: false
    };
  }

  toggle(){
    this.setState({
      isOpen: !this.state.isOpen
    });
  }

  toggleWikiDropdown(){
    this.setState({
      wikiDropdownOpen: !this.state.wikiDropdownOpen
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
              <Dropdown nav isOpen={this.state.wikiDropdownOpen} toggle={this.toggleWikiDropdown.bind(this)}>
                <DropdownToggle nav caret>Wiki</DropdownToggle>
                <DropdownMenu>
                  <Link to="/wiki/kriging" onClick={this.toggleWikiDropdown.bind(this)} className="dropdown-item">Kriging</Link>
                  <DropdownItem divider />
                  <Link to="/wiki/demo" onClick={this.toggleWikiDropdown.bind(this)} className="dropdown-item">Demo</Link>
                </DropdownMenu>
              </Dropdown>
            </NavItem>
            <NavItem>
              <a className="nav-link" target="_blank" href="https://github.com/Syndesi/Seminararbeit">Github</a>
            </NavItem>
          </Nav>
        </Collapse>
      </Navbar>
    );
  }
}