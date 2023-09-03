import { createBrowserRouter } from "react-router-dom";
import Dashboard from "./views/Dashboard";
import Student from "./views/Student";
import Staff from "./views/Staff";
import Library from "./views/Library";
import Account from "./views/Account";

const router = createBrowserRouter([
  {
    path: "/",
    element: <Dashboard />,
  },
  {
    path: "/student",
    element: <Student />,
  },
  {
    path: "/staff",
    element: <Staff />,
  },
  {
    path: "/library",
    element: <Library />,
  },
  {
    path: "/account",
    element: <Account />,
  },
]);

export default router;
