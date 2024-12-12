<?php
include('../../incl/config.php');
header('Content-Type: application/json');

// Get POST data
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$fcropType = $_POST['fcropType'] ?? '';

// Validate input
if ($id && !empty($fcropType)) {
    // Update query
    $sql = "UPDATE crop_type 
            SET  type = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $fcropType, $id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Crop updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update the Crop."]);
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
