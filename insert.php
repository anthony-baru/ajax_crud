<?php
include 'database.php';
include 'function.php';
if (isset($_POST['operation'])) {
    if ($_POST['operation'] == 'Add') {
        $image = '';
        if ($_FILES['user_image']['name'] != '') {
            $image = upload_image();
        }
        $stmt = $conn->prepare("INSERT INTO authors( `first_name`,`last_name`,`image` )   VALUES(:first_name, :last_name, :image) 
        ");
        $result = $stmt->execute(
            array(
                ':first_name' => $_POST['first_name'],
                ':last_name' => $_POST['last_name'],
                ':image' => $image
            )
        );
        if (!empty($result)) {
            echo 'Data inserted successfully.';
        } else {
            echo 'Nothing happened';
        }
    }

    if ($_POST['operation'] == 'Edit') {
        $image = '';
        if ($_FILES['user_image']['name'] != '') {
            $image = upload_image();
        } else {
            $image = $_POST['hidden_user_image'];
        }
        $stmt = $conn->prepare("UPDATE authors 
        SET first_name = :first_name, last_name= :last_name, image = :image
        WHERE id = :id 
        ");
        $stmt->execute(
            array(
                ':first_name' => $_POST['first_name'],
                ':last_name' => $_POST['last_name'],
                ':image' => $image,
                ':id' => $_POST['user_id']
            )
        );
        echo  'Data Updated';
    }
}
