<?php
include('../incl/config.php');
header('Content-Type: application/json');

// Ensure valid ID is passed as a GET parameter
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id) {
    // Prepare SQL statement
    $sql = "SELECT act.id as aid, 
                ci.id as cid,
                type_act,
                date_time, 
                crop_name,
                particulars,
                pictures
            FROM activities as act inner join crop_info as ci on act.crop_id=ci.id where act.id = ?";

    // Check if the statement is prepared successfully
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("i", $id);
        
        // Execute the query
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            // Check if the record exists
            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                echo json_encode(["success" => true, "data" => $data]);
            } else {
                echo json_encode(["success" => false, "message" => "Item not found."]);
            }
        } else {
            // Error executing query
            echo json_encode(["success" => false, "message" => "Error executing query."]);
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Error preparing statement
        echo json_encode(["success" => false, "message" => "Error preparing the query."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid Item ID."]);
}

// Close the database connection
$conn->close();
?>
