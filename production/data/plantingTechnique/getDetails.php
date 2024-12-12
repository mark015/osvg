<?php
include('../../incl/config.php');
header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id) {
    $sql = "SELECT * FROM `planting_technique`
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(["success" => true, "data" => $data]);
    } else {
        echo json_encode(["success" => false, "message" => "Item not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid crop ID."]);
}
?>
