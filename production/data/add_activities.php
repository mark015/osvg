<?php
include('../incl/config.php'); // Include database connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ["status" => "error", "message" => ""];

    $fAct = isset($_POST['fAct']) ? $conn->real_escape_string($_POST['fAct']) : '';
    $fcropName = isset($_POST['fcropName']) ? $conn->real_escape_string($_POST['fcropName']) : '';
    $fparticular = isset($_POST['fparticular']) ? $conn->real_escape_string($_POST['fparticular']) : '';
    $fdateTime = isset($_POST['fdateTime']) ? $conn->real_escape_string($_POST['fdateTime']) : '';

    $targetDir = "../uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0775, true);
    }

    $fpicture = isset($_FILES['fpicture']['name']) ? $_FILES['fpicture']['name'] : '';
    $targetFile = $targetDir . basename($fpicture);

    if (isset($_FILES['fpicture']) && $_FILES['fpicture']['error'] === UPLOAD_ERR_OK) {
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ["jpg", "png", "jpeg", "gif"];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['fpicture']['tmp_name'], $targetFile)) {
                $sql = "INSERT INTO activities (type_act, crop_id, particulars, date_time, pictures) 
                        VALUES ('$fAct', '$fcropName', '$fparticular', '$fdateTime', '$fpicture')";

                if ($conn->query($sql) === TRUE) {
                    $response["status"] = "success";
                    $response["message"] = "Activity added successfully.";
                } else {
                    $response["message"] = "Database error: " . $conn->error;
                }
            } else {
                $response["message"] = "Failed to move uploaded file.";
            }
        } else {
            $response["message"] = "Invalid file type. Allowed types: JPG, JPEG, PNG, GIF.";
        }
    } else {
        $response["message"] = "File upload error: " . $_FILES['fpicture']['error'];
    }

    echo json_encode($response);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>
