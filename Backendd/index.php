<?php
require_once 'config/config.php';
require_once 'helpers/ResponseHandler.php';
require_once 'middleware/AuthMiddleware.php';
require_once 'middleware/AdminMiddleware.php';
require_once 'middleware/PetugasMiddleware.php';
require_once 'middleware/MahasiswaMiddleware.php';

// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

// Get request method and URL
$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/admin/'; // Sesuaikan dengan base path Anda

// Extract the path without query parameters
$url = parse_url($request_uri, PHP_URL_PATH);
$url = str_replace($base_path, '', $url);
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url_parts = explode('/', $url);

// Get request data
$data = json_decode(file_get_contents('php://input'), true) ?? [];

// Route the request
try {
    // Validate URL structure
    if (empty($url_parts[0])) {
        ResponseHandler::sendError('API endpoint not specified', 400);
        exit();
    }

    switch($url_parts[0]) {
        // Auth routes
        case 'auth':
            require_once 'controllers/AuthController.php';
            $authController = new AuthController();
            
            if(!isset($url_parts[1])) {
                ResponseHandler::sendError('Auth action not specified', 400);
                break;
            }
            
            if($url_parts[1] === 'login' && $method === 'POST') {
                // Validate login data
                if (empty($data['username']) || empty($data['password'])) {
                    ResponseHandler::sendError('Username and password are required', 400);
                    break;
                }
                $authController->login($data);
            } elseif($url_parts[1] === 'profile' && $method === 'GET') {
                $auth = AuthMiddleware::authenticate();
                $authController->getProfile($auth->data->id);
            } else {
                ResponseHandler::sendError('Auth endpoint not found', 404);
            }
            break;
            
        // Admin routes
        case 'admin':
            require_once 'controllers/AdminController.php';
            $adminController = new AdminController();
            
            if(!isset($url_parts[1])) {
                ResponseHandler::sendError('Admin action not specified', 400);
                break;
            }
            
            if($url_parts[1] === 'users') {
                $auth = AdminMiddleware::isAdmin();
                
                if($method === 'GET') {
                    $adminController->getAllUsers();
                } elseif($method === 'POST') {
                    // Validate user creation data
                    if (empty($data['username']) || empty($data['password']) || empty($data['role'])) {
                        ResponseHandler::sendError('Username, password and role are required', 400);
                        break;
                    }
                    $adminController->createUser($data);
                } elseif($method === 'DELETE' && isset($url_parts[2])) {
                    $adminController->deleteUser($url_parts[2]);
                } else {
                    ResponseHandler::sendError('Method not allowed', 405);
                }
            } else {
                ResponseHandler::sendError('Admin endpoint not found', 404);
            }
            break;
            
        // Petugas routes
        case 'petugas':
            require_once 'controllers/PetugasController.php';
            $petugasController = new PetugasController();
            
            if(!isset($url_parts[1])) {
                ResponseHandler::sendError('Petugas action not specified', 400);
                break;
            }
            
            if($url_parts[1] === 'absensi' && $method === 'POST') {
                $auth = PetugasMiddleware::isPetugas();
                // Validate attendance data
                $requiredFields = ['mahasiswa_id', 'matkul_id', 'dosen_id', 'tanggal', 'status'];
                foreach ($requiredFields as $field) {
                    if (empty($data[$field])) {
                        ResponseHandler::sendError("Field $field is required", 400);
                        break 2;
                    }
                }
                $petugasController->recordAbsensi($data);
            } elseif($url_parts[1] === 'matkul' && $method === 'GET') {
                $auth = PetugasMiddleware::isPetugas();
                $petugasController->getMatkulList();
            } else {
                ResponseHandler::sendError('Petugas endpoint not found', 404);
            }
            break;
            
        // Mahasiswa routes
        case 'mahasiswa':
            require_once 'controllers/MahasiswaController.php';
            $mahasiswaController = new MahasiswaController();
            
            if(!isset($url_parts[1])) {
                ResponseHandler::sendError('Mahasiswa action not specified', 400);
                break;
            }
            
            if($url_parts[1] === 'profile' && $method === 'GET') {
                $auth = MahasiswaMiddleware::isMahasiswa();
                $mahasiswaController->getProfile($auth->data->id);
            } elseif($url_parts[1] === 'absensi' && $method === 'GET') {
                $auth = MahasiswaMiddleware::isMahasiswa();
                $mahasiswaController->getAbsensi($auth->data->id);
            } else {
                ResponseHandler::sendError('Mahasiswa endpoint not found', 404);
            }
            break;
            
        // Absensi routes
        case 'absensi':
            require_once 'controllers/AbsensiController.php';
            $absensiController = new AbsensiController();
            
            if($method === 'GET') {
                if(count($url_parts) === 1) {
                    $auth = AuthMiddleware::authenticate();
                    $absensiController->getAllAbsensi();
                } elseif(isset($url_parts[1]) && $url_parts[1] === 'range') {
                    $auth = AuthMiddleware::authenticate();
                    if (empty($_GET['start']) || empty($_GET['end'])) {
                        ResponseHandler::sendError('Start and end date parameters are required', 400);
                        break;
                    }
                    $absensiController->getAbsensiByDateRange($_GET['start'], $_GET['end']);
                } else {
                    ResponseHandler::sendError('Absensi endpoint not found', 404);
                }
            } else {
                ResponseHandler::sendError('Method not allowed', 405);
            }
            break;
            
        default:
            ResponseHandler::sendError('Endpoint not found', 404);
    }
} catch (Exception $e) {
    error_log($e->getMessage()); // Log error untuk debugging
    ResponseHandler::sendError('Internal server error', 500);
}
?>