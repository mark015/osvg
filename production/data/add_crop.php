<?php
    include('../incl/config.php');
    header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get POST data
    $fcropName = $_POST['fcropName'];
    $fcropType = $_POST['fcropType'];
    $fgrowingSeason = $_POST['fgrowingSeason'];
    $fwateringNeeds = $_POST['fwateringNeeds'];
    $fplantingTechniques = $_POST['fplantingTechniques'];
    $fduration = $_POST['fduration'];

    // Insert the item into the database
    $sql = "INSERT INTO `crop_info`(`crop_name`, `type`, `growing_season`, `watering_needs`, `planting_technique`, `duration`)
            VALUES (?, ?, ?, ? , ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssssss", $fcropName, $fcropType, $fgrowingSeason, $fwateringNeeds, $fplantingTechniques, $fduration);
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->affected_rows > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Crop added successfully!'
            ];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to add document.'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Database error.'];
    }

    // Send the response as JSON
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
