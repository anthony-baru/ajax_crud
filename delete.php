<?php
require_once 'database.php';
require_once 'function.php';
if (isset($_POST['user_id'])) {
    $stmt = $conn->prepare("DELETE FROM authors WHERE id= " . $_POST['user_id'] . " ");
    $result = $stmt->execute();
    if ($result == true) {
        echo 'Data Deleted successfully.';
    } else {
        echo 'Error occurred';
    }
}
