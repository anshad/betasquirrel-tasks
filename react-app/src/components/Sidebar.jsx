import { Nav } from "react-bootstrap";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faHouse,
  faBookOpen,
  faFileInvoiceDollar,
  faUserGraduate,
  faUserTie,
} from "@fortawesome/free-solid-svg-icons";

const Sidebar = () => {
  return (
    <div className="sidebar">
      <Nav defaultActiveKey="/" className="flex-column">
        <Nav.Link href="/">
          <FontAwesomeIcon icon={faHouse} />
          <span className="d-none d-md-inline">Dashboard</span>
        </Nav.Link>
        <Nav.Link href="/student">
          <FontAwesomeIcon icon={faUserGraduate} />
          <span className="d-none d-md-inline">Students</span>
        </Nav.Link>
        <Nav.Link href="/staff">
          <FontAwesomeIcon icon={faUserTie} />
          <span className="d-none d-md-inline">Staff</span>
        </Nav.Link>
        <Nav.Link href="/account">
          <FontAwesomeIcon icon={faFileInvoiceDollar} />
          <span className="d-none d-md-inline">Accounts</span>
        </Nav.Link>
        <Nav.Link href="/library">
          <FontAwesomeIcon icon={faBookOpen} />
          <span className="d-none d-md-inline">Library</span>
        </Nav.Link>
      </Nav>
    </div>
  );
};

export default Sidebar;
