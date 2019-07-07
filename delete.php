<?php
header('Content-type: application/json; charset=UTF-8');
require_once 'database.php';
require_once 'function.php';
$response = array();
if (isset($_POST['user_id'])) {
    $stmt = $conn->prepare("DELETE FROM authors WHERE id= :id ");
    $result = $stmt->execute(
        array(
            ':id' => $_POST['user_id']
        )
    );
    if ($result) {
        $response['status'] = 'success';
        $response['message'] = 'Product Deleted Successfully';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Unable to delete product ...';
    }
    echo json_encode($response);
}
