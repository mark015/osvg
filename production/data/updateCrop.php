<?php
include('../incl/config.php');
header('Content-Type: application/json');

// Get POST data
$id = isset($_POST['id']) ? intval($_POST['id']) : 0; // Ensure the ID is an integer.
$fcropName = $_POST['fcropName'];
$fcropType = $_POST['fcropType'];
$fgrowingSeason = $_POST['fgrowingSeason'];
$fwateringNeeds = $_POST['fwateringNeeds'];
$fplantingTechniques = $_POST['fplantingTechniques'];
$fduration = $_POST['fduration'];

// Check if ID is valid
if ($id <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid ID provided."]);
    exit;
}

// Update query
$sql = "UPDATE `crop_info` 
        SET `crop_name` = ?, 
            `type` = ?, 
            `growing_season` = ?, 
            `watering_needs` = ?, 
            `planting_technique` = ?, 
            `duration` = ? 
        WHERE `id` = ?";

// Prepare and bind
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(["success" => false, "message" => "Failed to prepare the SQL statement."]);
    exit;
}

$stmt->bind_param("ssssssi", $fcropName, $fcropType, $fgrowingSeason, $fwateringNeeds, $fplantingTechniques, $fduration, $id);

// Execute and check the result
if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update the Crop Info."]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
