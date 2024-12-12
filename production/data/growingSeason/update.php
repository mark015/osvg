<?php
include('../../incl/config.php');
header('Content-Type: application/json');

// Get POST data
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$fcropType = $_POST['fcropType'] ?? '';

// Validate input
if ($id && !empty($fcropType)) {
    // Update query
    $sql = "UPDATE growing_season 
            SET  season = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $fcropType, $id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => " Updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Failed to prepare the query."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid input. Please provide all required fields."]);
}

$conn->close();
?>