<?php
class ResponseHandler {
    public static function sendResponse($data = null, $message = 'Success', $status = 200) {
        http_response_code($status);
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function sendError($message = 'Error', $status = 400, $errors = null) {
        http_response_code($status);
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'errors' => $errors
        ]);
    }
}
?>