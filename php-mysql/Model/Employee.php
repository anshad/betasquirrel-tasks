<?php

namespace OneHRMS\model;

require ('BaseModel.php');
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
        $query = 'INSERT INTO ' . $this->table . ' (first_name, last_name, email, salary, department) VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->conn->prepare($query);

        $this->sanitize();

        $stmt->bind_param('sssis', $this->first_name, $this->last_name, $this->email, $this->salary, $this->department);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function listAll($page = null, $itemsPerPage = null, $sortBy = null, $sortOrder = 'ASC', $searchField = null, $searchType = null, $searchValue = null, $searchValue2 = null)
    {
        $validSortColumns = ['id', 'first_name', 'last_name', 'email', 'salary', 'department'];
        $sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';

        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = null;
        }

        $query = 'SELECT * FROM ' . $this->table;

        $bindTypes = '';
        $bindValues = [];

        if (!empty($searchField) && !empty($searchValue) && in_array($searchField, ['first_name', 'last_name', 'email', 'salary', 'department'])) {
            switch ($searchType) {
                case 'contains':
                    $query .= " WHERE $searchField LIKE ?";
                    $bindTypes .= 's';
                    $searchValue = "%{$searchValue}%";
                    $bindValues[] = &$searchValue;
                    break;
                case 'starts_with':
                    $query .= " WHERE $searchField LIKE ?";
                    $bindTypes .= 's';
                    $searchValue = "{$searchValue}%";
                    $bindValues[] = &$searchValue;
                    break;
                case 'ends_with':
                    $query .= " WHERE $searchField LIKE ?";
                    $bindTypes .= 's';
                    $searchValue = "%{$searchValue}";
                    $bindValues[] = &$searchValue;
                    break;
                case 'equals':
                    $query .= " WHERE $searchField = ?";
                    $bindTypes .= 's';
                    $bindValues[] = &$searchValue;
                    break;
                case 'greater':
                    $query .= " WHERE $searchField > ?";
                    $bindTypes .= 's';
                    $bindValues[] = &$searchValue;
                    break;
                case 'less':
                    $query .= " WHERE $searchField < ?";
                    $bindTypes .= 's';
                    $bindValues[] = &$searchValue;
                    break;
                case 'between':
                    if ($searchValue !== null && $searchValue2 !== null) {
                        $query .= " WHERE $searchField BETWEEN ? AND ?";
                        $bindTypes .= 'ss';
                        $bindValues[] = &$searchValue;
                        $bindValues[] = &$searchValue2;
                    }
                    break;
            }
        }

        if ($sortBy) {
            $query .= " ORDER BY $sortBy $sortOrder";
        }

        if ($page !== null && $itemsPerPage !== null) {
            $offset = ($page - 1) * $itemsPerPage;
            $query .= ' LIMIT ?, ?';
            $bindTypes .= 'ii';
            $bindValues[] = &$offset;
            $bindValues[] = &$itemsPerPage;
        }

        $stmt = $this->conn->prepare($query);

        if ($bindTypes !== '') {
            $stmt->bind_param($bindTypes, ...$bindValues);
        }

        $stmt->execute();
        return $stmt->get_result();
    }

    public function findOne($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM ' . $this->table . ' WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id)
    {
        $query = 'UPDATE ' . $this->table . ' SET first_name = ?, last_name = ?, email = ?, salary = ?, department = ? WHERE id = ?';
        $stmt = $this->conn->prepare($query);

        $this->sanitize();

        $stmt->bind_param('sssisi', $this->first_name, $this->last_name, $this->email, $this->salary, $this->department, $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);

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

    public function getTotalCount()
    {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);

        if (!$stmt->execute()) {
            return 0;
        }

        $result = $stmt->get_result()->fetch_assoc();
        return (int) $result['total'];
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