import React, { useState, useEffect } from "react";
import Main from "../layouts/Main";
import { Table, Row, Col, Button, Modal, Form } from "react-bootstrap";
import * as Icon from "react-bootstrap-icons";
import StudentForm from "./student/StudentForm";

const Student = () => {
  const [students, setStudents] = useState([]);
  const [show, setShow] = useState(false);

  useEffect(() => {
    fetch("http://localhost:4000/student")
      .then((res) => res.json())
      .then((data) => setStudents(data.data))
      .catch((err) => console.log(err));
  }, []);

  const handleClose = () => setShow(false);
  const handleShow = () => setShow(true);

  return (
    <>
      <Main>
        <Modal show={show} onHide={handleClose}>
          <Modal.Header closeButton>
            <Modal.Title>Add Student</Modal.Title>
          </Modal.Header>
          <StudentForm onClose={handleClose} />
        </Modal>
        <Row className="mt-3">
          <Col>
            <h2>Students</h2>
            <Row>
              <Col className="mb-3 text-end">
                <Button variant="success" size="sm" onClick={handleShow}>
                  <Icon.People className="mx-2" />
                  Add Student
                </Button>
              </Col>
            </Row>
            <Row>
              <Col>
                <Table striped bordered hover responsive>
                  <thead>
                    <tr>
                      <th className="text-center">#</th>
                      <th>Name</th>
                      <th>Email</th>
                    </tr>
                  </thead>
                  <tbody>
                    {students.length === 0 ? (
                      <tr>
                        <td colSpan={3} className="text-center">
                          No records found!
                        </td>
                      </tr>
                    ) : (
                      students.map((student, index) => (
                        <tr key={index}>
                          <td className="text-center">{index + 1}</td>
                          <td>{student.name}</td>
                          <td>{student.email}</td>
                        </tr>
                      ))
                    )}
                  </tbody>
                </Table>
              </Col>
            </Row>
          </Col>
        </Row>
      </Main>
    </>
  );
};

export default Student;
