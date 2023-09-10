import { Nav, NavItem } from "react-bootstrap";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faHouse,
  faBookOpen,
  faFileInvoiceDollar,
  faUserGraduate,
  faUserTie,
} from "@fortawesome/free-solid-svg-icons";
import { Link } from "react-router-dom";

const Sidebar = () => {
  return (
    <div className="sidebar">
      <Nav defaultActiveKey="/" className="flex-column">
        <NavItem href="/">
          <Nav.Link to="/" as={Link}>
            <FontAwesomeIcon icon={faHouse} />
            <span className="d-none d-md-inline">Dashboard</span>
          </Nav.Link>
        </NavItem>
        <NavItem href="/student">
          <Nav.Link to="/student" as={Link}>
            <FontAwesomeIcon icon={faUserGraduate} />
            <span className="d-none d-md-inline">Students</span>
          </Nav.Link>
        </NavItem>
        <NavItem href="/staff">
          <Nav.Link to="/staff" as={Link}>
            <FontAwesomeIcon icon={faUserTie} />
            <span className="d-none d-md-inline">Staff</span>
          </Nav.Link>
        </NavItem>
        <NavItem href="/account">
          <Nav.Link to="/account" as={Link}>
            <FontAwesomeIcon icon={faFileInvoiceDollar} />
            <span className="d-none d-md-inline">Accounts</span>
          </Nav.Link>
        </NavItem>
        <NavItem href="/library">
          <Nav.Link to="/library" as={Link}>
            <FontAwesomeIcon icon={faBookOpen} />
            <span className="d-none d-md-inline">Library</span>
          </Nav.Link>
        </NavItem>
      </Nav>
    </div>
  );
};

export default Sidebar;
