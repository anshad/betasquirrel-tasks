import AppNavbar from "../components/AppNavbar";
import Sidebar from "../components/Sidebar";
import { Container } from "react-bootstrap";

function Main({ children }) {
  return (
    <>
      <AppNavbar />
      <div className="d-flex">
        <Sidebar />
        <Container fluid>{children}</Container>
      </div>
    </>
  );
}

export default Main;
