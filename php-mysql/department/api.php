<?php
require_once '../database/Database.php';
require_once '../model/Department.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // CORS 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$db = OneHRMS\database\Database::connect();
$department = new OneHRMS\model\Department($db);

$method = $_SERVER['REQUEST_METHOD'];
$response = ['success' => false, 'message' => '', 'data' => null];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $response = $department->findOne($_GET['id']);
        } else {
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $itemsPerPage = isset($_GET['itemsPerPage']) ? intval($_GET['itemsPerPage']) : 10;

            $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
            $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

            $searchField = isset($_GET['searchField']) ? $_GET['searchField'] : null;
            $searchType = isset($_GET['searchType']) ? $_GET['searchType'] : null;
            $searchValue = isset($_GET['searchValue']) ? $_GET['searchValue'] : null;
            $searchValue2 = isset($_GET['searchValue2']) ? $_GET['searchValue2'] : null;

            $departments = $department->listAll($page, $itemsPerPage, $sort, $order, $searchField, $searchType, $searchValue, $searchValue2);
            $totalCount = $department->getTotalCount($searchField, $searchType, $searchValue, $searchValue2);

            if (isset($departments['success']) && !$departments['success']) {
                $response = $departments;
            } else {
                $response = [
                    'success' => true,
                    'message' => '',
                    'data' => [
                        'departments' => $departments,
                        'current_page' => $page,
                        'total_count' => $totalCount,
                        'items_per_page' => $itemsPerPage
                    ]
                ];
            }
        }
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $errors = $department->validate($input);
        if (empty($errors)) {
            $department->name = $input['name'];
            $response = $department->add();
        } else {
            $response['message'] = join(', ', $errors);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $errors = $department->validate($data);
        if (empty($errors)) {
            $department->name = $data['name'];
            $response = $department->update($data['id']);
        } else {
            $response['message'] = join(', ', $errors);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($id) {
            $response = $department->delete($id);
        }
        break;

    default:
        $response = ['message' => 'invalid request'];
        break;
}

echo json_encode($response);

OneHRMS\database\Database::close();
?>