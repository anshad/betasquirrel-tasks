<?php

namespace OneHRMS\model;

require ('BaseModel.php');
require_once 'interface/CrudInterface.php';
require_once 'trait/ValidationTrait.php';

use OneHRMS\interface\CrudInterface;
use OneHRMS\trait\ValidationTrait;
use Exception;

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
        try {
            $query = 'INSERT INTO ' . $this->table . ' (first_name, last_name, email, salary, department) VALUES (?, ?, ?, ?, ?)';
            $stmt = $this->conn->prepare($query);

            $this->sanitize();

            $stmt->bind_param('sssis', $this->first_name, $this->last_name, $this->email, $this->salary, $this->department);

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception('Failed to execute the add operation.');
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function listAll($page = null, $itemsPerPage = null, $sortBy = null, $sortOrder = 'ASC', $searchField = null, $searchType = null, $searchValue = null, $searchValue2 = null)
    {
        try {
            $validSortColumns = ['id', 'first_name', 'last_name', 'email', 'salary', 'department'];
            $sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';

            if (!in_array($sortBy, $validSortColumns)) {
                $sortBy = null;
            }

            $query = 'SELECT * FROM ' . $this->table;

            $bindTypes = '';
            $bindValues = [];

            if (!empty($searchField) && !empty($searchValue) && in_array($searchField, ['first_name', 'last_name', 'email', 'salary', 'department'])) {
                $this->generateSearchQuery($searchType, $searchField, $searchValue, $searchValue2, $bindTypes, $bindValues, $query);
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
        } catch (\mysqli_sql_exception $e) {
            error_log('Database query failed: ' . $e->getMessage());
            return null;
        }
    }

    public function findOne($id)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM ' . $this->table . ' WHERE id = ?');

            if (!$stmt) {
                throw new Exception('Error preparing statement: ' . $this->conn->error);
            }

            $stmt->bind_param('i', $id);
            if (!$stmt->execute()) {
                throw new Exception('Error executing statement: ' . $stmt->error);
            }

            $result = $stmt->get_result()->fetch_assoc();
            if ($result === null) {
                throw new Exception('Record not found');
            }

            return $result;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function update($id)
    {
        try {
            $query = 'UPDATE ' . $this->table . ' SET first_name = ?, last_name = ?, email = ?, salary = ?, department = ? WHERE id = ?';

            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new Exception('Prepare failed: ' . $this->conn->error);
            }

            $this->sanitize();

            $stmt->bind_param('sssisi', $this->first_name, $this->last_name, $this->email, $this->salary, $this->department, $id);
            $result = $stmt->execute();

            if (!$result) {
                throw new Exception('Execute failed: ' . $stmt->error);
            }

            if ($stmt->affected_rows === 0) {
                throw new Exception('No rows updated, possible invalid ID or data unchanged.');
            }

            return true;
        } catch (Exception $e) {
            error_log('Update operation failed: ' . $e->getMessage());

            return false;
        }
    }

    public function delete($id)
    {
        try {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';

            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new Exception('Prepare failed: ' . $this->conn->error);
            }

            $stmt->bind_param('i', $id);
            $result = $stmt->execute();

            if (!$result) {
                throw new Exception('Execute failed: ' . $stmt->error);
            }

            if ($stmt->affected_rows === 0) {
                throw new Exception('No rows deleted, possibly invalid ID.');
            }

            return true;
        } catch (Exception $e) {
            error_log('Delete operation failed: ' . $e->getMessage());

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

    public function getTotalCount($searchField = null, $searchType = null, $searchValue = null, $searchValue2 = null)
    {
        try {
            $query = 'SELECT COUNT(*) as total FROM ' . $this->table;

            $bindTypes = '';
            $bindValues = [];

            if (!empty($searchField) && !empty($searchValue) && in_array($searchField, ['first_name', 'last_name', 'email', 'salary', 'department'])) {
                $this->generateSearchQuery($searchType, $searchField, $searchValue, $searchValue2, $bindTypes, $bindValues, $query);
            }

            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new Exception('Prepare failed: ' . $this->conn->error);
            }

            if ($bindTypes !== '') {
                $stmt->bind_param($bindTypes, ...$bindValues);
            }

            if (!$stmt->execute()) {
                throw new Exception('Execute failed: ' . $stmt->error);
            }

            $result = $stmt->get_result()->fetch_assoc();
            return (int) $result['total'];
        } catch (Exception $e) {
            error_log('Failed to get total count: ' . $e->getMessage());

            return 0;
        }
    }

    private function sanitize()
    {
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->salary = htmlspecialchars(strip_tags($this->salary));
        $this->department = htmlspecialchars(strip_tags($this->department));
    }

    private function generateSearchQuery($searchType, $searchField, $searchValue, $searchValue2, &$bindTypes, &$bindValues, &$query)
    {
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
}