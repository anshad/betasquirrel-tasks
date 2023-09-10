import { useState } from "react";
import { Form, Modal, Button } from "react-bootstrap";

const StudentForm = ({ onClose }) => {
  const [educations] = useState([
    { id: 1, name: "SSLC" },
    { id: 2, name: "Plus Two" },
    { id: 3, name: "Diploma" },
    { id: 4, name: "Degree" },
    { id: 5, name: "Post Graduate" },
  ]);

  const [form, setForm] = useState({
    name: "",
    email: "",
    education: "",
    is_degree_completed: true,
    address: "",
    skills: [],
  });

  const handleChange = (e) => {
    setForm((prevForm) => ({
      ...prevForm,
      [e.target.name]: e.target.value,
    }));
  };

  const handleRadio = (e) => {
    setForm((prevForm) => ({
      ...prevForm,
      [e.target.name]: Boolean(Number(e.target.value)),
    }));
  };

  const handleCheck = (value) => {
    if (form.skills.includes(value)) {
      setForm((prevForm) => ({
        ...prevForm,
        skills: prevForm.skills.filter((skill) => skill !== value),
      }));
    } else {
      setForm((prevForm) => ({
        ...prevForm,
        skills: [...prevForm.skills, value],
      }));
    }
  };

  const handleFormSubmit = (e) => {
    e.preventDefault();

    console.log(form);
  };

  return (
    <Form onSubmit={handleFormSubmit}>
      <Modal.Body>
        <Form.Group className="mb-3" controlId="name">
          <Form.Label>Full Name</Form.Label>
          <Form.Control
            type="text"
            name="name"
            placeholder="Enter Full Name"
            value={form.name}
            onChange={handleChange}
          />
        </Form.Group>

        <Form.Group className="mb-3" controlId="email">
          <Form.Label>Email</Form.Label>
          <Form.Control
            type="email"
            name="email"
            value={form.email}
            onChange={handleChange}
            placeholder="Enter Email"
          />
        </Form.Group>

        <Form.Group className="mb-3" controlId="address">
          <Form.Label>Address</Form.Label>
          <Form.Control
            as="textarea"
            rows={3}
            name="address"
            value={form.address}
            onChange={handleChange}
          />
        </Form.Group>

        <Form.Group className="mb-3" controlId="education">
          <Form.Label>Highest Education</Form.Label>
          <Form.Select
            value={form.education}
            name="education"
            onChange={handleChange}
          >
            <option>Select</option>
            {educations.map((education) => (
              <option value={education.id} key={education.id}>
                {education.name}
              </option>
            ))}
          </Form.Select>
        </Form.Group>

        <Form.Group className="mb-3" controlId="is-degree-completed">
          <Form.Label>Is Degree Completed?</Form.Label>
          <div>
            <Form.Check
              inline
              label="Yes"
              name="is_degree_completed"
              type="radio"
              value={1}
              checked={form.is_degree_completed}
              onChange={handleRadio}
            />
            <Form.Check
              inline
              label="No"
              name="is_degree_completed"
              type="radio"
              checked={!form.is_degree_completed}
              value={0}
              onChange={handleRadio}
            />
          </div>
        </Form.Group>

        <Form.Group className="mb-3" controlId="skills">
          <Form.Label>Skills</Form.Label>
          <div>
            <Form.Check
              inline
              label="HTML 5"
              name="skills[]"
              type="checkbox"
              value="HTML 5"
              checked={form.skills.includes("HTML 5")}
              onChange={(e) => {
                handleCheck(e.target.value);
              }}
            />
            <Form.Check
              inline
              label="JavaScript"
              name="skills[]"
              type="checkbox"
              checked={form.skills.includes("JavaScript")}
              value="JavaScript"
              onChange={(e) => {
                handleCheck(e.target.value);
              }}
            />
            <Form.Check
              inline
              label="CSS 3"
              name="skills[]"
              type="checkbox"
              checked={form.skills.includes("CSS 3")}
              value="CSS 3"
              onChange={(e) => {
                handleCheck(e.target.value);
              }}
            />
          </div>
        </Form.Group>
      </Modal.Body>
      <Modal.Footer>
        <Button variant="secondary" onClick={onClose} type="reset">
          Reset
        </Button>
        <Button variant="primary" type="submit">
          Save
        </Button>
      </Modal.Footer>
    </Form>
  );
};

export default StudentForm;
