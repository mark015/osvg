<?php
include('../incl/config.php');
header('Content-Type: application/json');

// Check if required fields are set
if (!isset($_POST['id'], $_POST['fAct'], $_POST['fdateTime'], $_POST['fcropName'], $_POST['fparticular'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields."]);
    exit;
}

// Retrieve POST data
$id = $_POST['id'];
$typeAct = $_POST['fAct'];
$dateTime = $_POST['fdateTime'];
$cropId = $_POST['fcropName'];
$particulars = $_POST['fparticular'];

// Handle file upload if a file was provided
$filePath = null;
if (isset($_FILES['fpicture']) && $_FILES['fpicture']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/'; // Path to your uploads directory
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
    }

    // Ensure a unique file name
    $fileName = uniqid('img_') . '_' . basename($_FILES['fpicture']['name']);
    $targetFilePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['fpicture']['tmp_name'], $targetFilePath)) {
        $filePath = $fileName; // Save only the file name in the database
    } else {
        echo json_encode(["success" => false, "message" => "Failed to upload file."]);
        exit;
    }
}

// Build SQL query
$sql = "UPDATE activities SET 
            type_act = ?, 
            date_time = ?, 
            crop_id = ?, 
            particulars = ?" . ($filePath ? ", pictures = ?" : "") . " 
        WHERE id = ?";

$stmt = $conn->prepare($sql);

// Bind parameters dynamically
if ($filePath) {
    $stmt->bind_param("sssssi", $typeAct, $dateTime, $cropId, $particulars, $filePath, $id);
} else {
    $stmt->bind_param("ssssi", $typeAct, $dateTime, $cropId, $particulars, $id);
}

// Execute the query
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => $particulars]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update activity."]);
}

// Clean up
$stmt->close();
$conn->close();
?>
