import { Navbar, Container, Nav, NavDropdown } from "react-bootstrap";
import Logo from "../assets/logo.svg";

const AppNavbar = () => (
  <Navbar variant="dark" bg="dark" expand="lg">
    <Container fluid>
      <Navbar.Brand href="#home" className="text-light">
        <img
          alt="Logo"
          src={Logo}
          width="30"
          height="30"
          className="d-inline-block align-top"
        />
        Oneschool
      </Navbar.Brand>
      <Navbar.Toggle aria-controls="navbar-dark" />
      <Navbar.Collapse id="navbar-dark" className="justify-content-end">
        <Nav>
          <NavDropdown
            id="nav-dropdown-dark"
            title="Anshad Vattapoyil"
            menuVariant="dark"
          >
            <NavDropdown.Item href="#action/3.1">Profile</NavDropdown.Item>
            <NavDropdown.Divider />
            <NavDropdown.Item href="#action/3.4">Logout</NavDropdown.Item>
          </NavDropdown>
        </Nav>
      </Navbar.Collapse>
    </Container>
  </Navbar>
);

export default AppNavbar;
