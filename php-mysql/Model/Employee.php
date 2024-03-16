<?php

namespace OneHRMS\model;

require('BaseModel.php');
require_once 'interface/CrudInterface.php';
require_once 'trait/ValidationTrait.php';

use OneHRMS\interface\CrudInterface;
use OneHRMS\trait\ValidationTrait;

class Employee extends BaseModel implements CrudInterface
{
    use ValidationTrait;

    private $table = 'employees';
    public $first_name;
    public $last_name;
    public $email;
    public $salary;
    public $department;

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function add()
    {
        $query = "INSERT INTO " . $this->table . " (first_name, last_name, email, salary, department) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $this->sanitize();

        $stmt->bind_param("sssis", $this->first_name, $this->last_name, $this->email, $this->salary, $this->department);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function listAll()
    {
        $query = "SELECT * FROM " . $this->table;
        return $this->conn->query($query);
    }

    public function findOne($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id)
    {
        $query = "UPDATE " . $this->table . " SET first_name = ?, last_name = ?, email = ?, salary = ?, department = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->sanitize();

        $stmt->bind_param("sssisi", $this->first_name, $this->last_name, $this->email, $this->salary, $this->department, $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function validate($data)
    {
        $errors = [];
        $this->validateRequired('first_name', $data['first_name'], $errors);
        $this->validateRequired('last_name', $data['last_name'], $errors);
        $this->validateRequired('email', $data['email'], $errors);
        $this->validateEmail('email', $data['email'], $errors);

        return $errors;
    }

    private function sanitize()
    {
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->salary = htmlspecialchars(strip_tags($this->salary));
        $this->department = htmlspecialchars(strip_tags($this->department));
    }
}
