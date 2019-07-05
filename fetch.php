<?php
include 'database.php';
include 'function.php';
$query = "";
$output = array();
$query .= "SELECT * FROM authors ";
if (isset($_POST["search"]["value"])) {
    $parameter = $_POST["search"]["value"];
    $query .= 'WHERE first_name LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR last_name LIKE "%' . $_POST["search"]["value"] . '%" ';
}
if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY id DESC ';
}
if ($_POST["length"] != -1) {
    $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll();
$data = array();
$filtered_rows = $stmt->rowCount();


foreach ($result as $row) {
    $image = '';
    if ($row['image'] != '') {
        $image = '<img src=' . $row["image"] . ' alt="" class="img-thumbnail" width="50" height="35">';
    } else {
        $image = '';
    }
    $sub_array = array();
    $sub_array[] = $image;
    $sub_array[] = $row['first_name'];
    $sub_array[] = $row['last_name'];
    $sub_array[] = '<button type="submit" name="update" id="' . $row["id"] . '" class="btn btn-info btn-xs update">Update</button>';
    $sub_array[] = '<button type="submit" name="delete" id="' . $row["id"] . '" class="btn btn-danger btn-xs delete">Delete</button>';
    $data[] = $sub_array;
}

$output = array(
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $filtered_rows,
    "recordsFiltered" => get_total_all_records(),
    "data" => $data
);
echo json_encode($output);
