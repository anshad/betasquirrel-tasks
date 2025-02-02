<?php

namespace OneHRMS\model;

require_once ('BaseModel.php');
require_once dirname(__FILE__) . '/../interface/CrudInterface.php';
require_once dirname(__FILE__) . '/../trait/ValidationTrait.php';

use OneHRMS\interface\CrudInterface;
use OneHRMS\trait\ValidationTrait;
use Exception;

class Department extends BaseModel implements CrudInterface
{
    use ValidationTrait;

    private $table = 'departments';
    public $name;

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function add()
    {
        try {
            $query = 'INSERT INTO ' . $this->table . ' (name) VALUES (?)';
            $stmt = $this->conn->prepare($query);

            $this->sanitize();

            $stmt->bind_param('s', $this->name);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Department created successfully', 'data' => null];
            } else {
                throw new Exception('Failed to execute the add operation.');
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => $e->getMessage(), 'data' => null];
        }
    }

    public function listAll($page = null, $itemsPerPage = null, $sortBy = null, $sortOrder = 'ASC', $searchField = null, $searchType = null, $searchValue = null, $searchValue2 = null)
    {
        try {
            $validSortColumns = ['id', 'name'];
            $sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';

            if (!in_array($sortBy, $validSortColumns)) {
                $sortBy = null;
            }

            $query = 'SELECT * FROM ' . $this->table;

            $bindTypes = '';
            $bindValues = [];

            if (!empty($searchField) && !empty($searchValue) && in_array($searchField, ['name'])) {
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
            $result = $stmt->get_result();
            $departments = $result->fetch_all(MYSQLI_ASSOC);

            $stmt->close();

            return $departments;
        } catch (\mysqli_sql_exception $e) {
            error_log('Database query failed: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage(), 'data' => ['departments' => []]];
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

            $result = $stmt->get_result();
            $department = $result->fetch_assoc();
            $stmt->close();

            if ($department) {
                return ['success' => true, 'data' => $department, 'message' => ''];
            } else {
                return ['success' => false, 'message' => 'Department not found', 'data' => null];
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => $e->getMessage(), 'data' => null];
        }
    }

    public function update($id)
    {
        try {
            $query = 'UPDATE ' . $this->table . ' SET name = ? WHERE id = ?';

            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new Exception('Prepare failed: ' . $this->conn->error);
            }

            $this->sanitize();

            $stmt->bind_param('si', $this->name, $id);
            $result = $stmt->execute();

            if (!$result) {
                throw new Exception('Execute failed: ' . $stmt->error);
            }

            if ($stmt->affected_rows === 0) {
                throw new Exception('No rows updated, possible invalid ID or data unchanged.');
            }

            return ['success' => true, 'message' => 'Department updated successfully', 'data' => null];
        } catch (Exception $e) {
            error_log('Update operation failed: ' . $e->getMessage());

            return ['success' => false, 'message' => $e->getMessage(), 'data' => null];
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

            return ['success' => true, 'message' => 'Department deleted successfully', 'data' => null];
        } catch (Exception $e) {
            error_log('Delete operation failed: ' . $e->getMessage());

            return ['success' => false, 'message' => $e->getMessage(), 'data' => null];
        }
    }

    public function validate($data)
    {
        $errors = [];
        $this->validateRequired('name', $data['name'], $errors);

        return $errors;
    }

    public function getTotalCount($searchField = null, $searchType = null, $searchValue = null, $searchValue2 = null)
    {
        try {
            $query = 'SELECT COUNT(*) as total FROM ' . $this->table;

            $bindTypes = '';
            $bindValues = [];

            if (!empty($searchField) && !empty($searchValue) && in_array($searchField, ['name'])) {
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

            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $stmt->close();

            return (int) $row['total'];
        } catch (Exception $e) {
            error_log('Failed to get total count: ' . $e->getMessage());

            return 0;
        }
    }

    private function sanitize()
    {
        $this->name = htmlspecialchars(strip_tags($this->name));
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
