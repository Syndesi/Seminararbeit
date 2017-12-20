import React from 'react';
import {observer} from 'mobx-react';
import {Link} from 'react-router-dom';
import {toast} from 'react-toastify';
import axios from 'axios';
import { Collapse, Navbar, NavbarToggler, NavbarBrand, Nav, NavItem, NavLink, Dropdown, DropdownToggle, DropdownMenu, DropdownItem } from 'reactstrap';


@observer
export default class Header extends React.Component {

  constructor(props){
    super(props);
    this.state = {
      isOpen: false,
      wikiDropdownOpen: false,
      settingsDropdownOpen: false,
      userDropdownOpen: false
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

  toggleSettingsDropdown(){
    this.setState({
      settingsDropdownOpen: !this.state.settingsDropdownOpen
    });
  }

  toggleUserDropdown(){
    this.setState({
      userDropdownOpen: !this.state.userDropdownOpen
    });
  }

  switchLang(el){
    //this.refs["language"].classList.toggle('fullscreen');
    var lang = el.currentTarget.getAttribute('data-lang');
    this.props.store.switchLang(lang);
    this.toggleSettingsDropdown();
  }

  render() {
    var l = this.props.store.lang.components.header;
    var isLogedIn = true;
    var isAdmin = true;
    var adminSettings = (
      <div>
        <DropdownItem divider />
        <Link to="/admin/update" className="dropdown-item text-danger">{l.adminUpdate}</Link>
        <Link to="/admin/insertData" className="dropdown-item text-danger">{l.adminInsertData}</Link>
        <Link to="/admin/user" className="dropdown-item text-danger">{l.adminUser}</Link>
      </div>
    );
    if(!isAdmin || !isLogedIn){
      adminSettings = null;
    }
    var settings = (
      <NavItem>
        <Dropdown nav isOpen={this.state.settingsDropdownOpen} toggle={this.toggleSettingsDropdown.bind(this)}>
          <DropdownToggle nav><span className="icon material">settings</span></DropdownToggle>
          <DropdownMenu right>
            <div className="dropdown-item">
              <a className="text-muted" href="#" data-lang="de" onClick={this.switchLang.bind(this)}>DE</a> / <a className="text-muted" href="#" data-lang="en" onClick={this.switchLang.bind(this)}>EN</a>
            </div>
            {adminSettings}
          </DropdownMenu>
        </Dropdown>
      </NavItem>
    );
    var userMenu = (
      <Nav className="ml-auto" navbar>
        <NavItem>
          <Link to="/account/login" className="nav-item nav-link">{l.login}</Link>
        </NavItem>
        <NavItem>
          <Link to="/account/register" className="nav-item nav-link">{l.register}</Link>
        </NavItem>
        {settings}
      </Nav>
    );
    if('id' in this.props.store.user){
      userMenu = (
        <Nav className="ml-auto" navbar>
          <NavItem>
            <Dropdown nav isOpen={this.state.userDropdownOpen} toggle={this.toggleUserDropdown.bind(this)}>
              <DropdownToggle nav>Syndesi</DropdownToggle>
              <DropdownMenu right>
                <Link to="/account" onClick={this.toggleUserDropdown.bind(this)} className="dropdown-item">{l.account}</Link>
                <Link to="/account/logout" onClick={this.toggleUserDropdown.bind(this)} className="dropdown-item">{l.logout}</Link>
              </DropdownMenu>
            </Dropdown>
          </NavItem>
          {settings}
        </Nav>
      );
    }
    return (
      <Navbar color="light" light expand="sm">
        <Link to="/" className="navbar-brand">{l.title}</Link>
        <NavbarToggler onClick={this.toggle.bind(this)} />
        <Collapse isOpen={this.state.isOpen} navbar>
          <Nav className="mr-auto" navbar>
            <NavItem>
              <Link to="/map" className="nav-item nav-link">{l.map}</Link>
            </NavItem>
            <NavItem>
              <Dropdown nav isOpen={this.state.wikiDropdownOpen} toggle={this.toggleWikiDropdown.bind(this)}>
                <DropdownToggle nav caret>{l.wiki}</DropdownToggle>
                <DropdownMenu>
                  <Link to="/wiki/kriging" onClick={this.toggleWikiDropdown.bind(this)} className="dropdown-item">{l.kriging}</Link>
                  <Link to="/wiki/beta" onClick={this.toggleWikiDropdown.bind(this)} className="dropdown-item">{l.beta}</Link>
                  <DropdownItem divider />
                  <Link to="/wiki/demo" onClick={this.toggleWikiDropdown.bind(this)} className="dropdown-item">{l.demo}</Link>
                </DropdownMenu>
              </Dropdown>
            </NavItem>
            <NavItem>
              <Link to="/admin/insertData" className="nav-item nav-link">tmp</Link>
            </NavItem>
            <NavItem>
              <Link to="/setup" className="nav-item nav-link">{l.setup}</Link>
            </NavItem>
            <NavItem>
              <a className="nav-link" target="_blank" href="https://github.com/Syndesi/Seminararbeit">{l.github}</a>
            </NavItem>
          </Nav>
          {userMenu}
        </Collapse>
      </Navbar>
    );
  }
}