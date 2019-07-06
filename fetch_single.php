<?php
require_once 'database.php';
require_once 'function.php';
if (isset($_POST['user_id'])) {
    $output = array();
    $stmt = $conn->prepare(
        "SELECT * FROM authors 
        WHERE id = '" . $_POST["user_id"] . "'  LIMIT 1 "
    );
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $row) {
        $output['first_name'] = $row['first_name'];
        $output['last_name']  = $row['last_name'];
        if ($row['image'] != '') {
            $output['user_image'] = ' <img src="' . $row['image'] . '" alt="" class="img-thumbnail" width="50" height="35" >
            <input type="hidden" class="" value="' . $row['image'] . '" >
            ';
        } else {
            $output['user_image'] = '<input value="" type="hidden" name="hidden_user_image" >
            <p>No image.</p>';
        }
    }
    echo json_encode($output); //convert php array to json string
}
