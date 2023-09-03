import AppNavbar from "../components/AppNavbar";
import Sidebar from "../components/Sidebar";

function Main(props) {
  return (
    <>
      <AppNavbar />
      <div className="d-flex">
        <Sidebar />
        <div className="container-fluid">{props.children}</div>
      </div>
    </>
  );
}

export default Main;
