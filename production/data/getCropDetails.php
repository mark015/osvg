<?php
include('../incl/config.php');
header('Content-Type: application/json');

// Ensure valid ID is passed as a GET parameter
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id) {
    // Prepare SQL statement
    $sql = "SELECT  ci.id as cid,
                    ci.crop_name as cname,
                    ct.type as cttype,
                    ct.id as ctid,
                    gs.season as gseason,
                    gs.id as gsid,
                    pt.technique as ptechnique,
                    pt.id as ptid,
                    wn.needs as wneeds,
                    wn.id as wnid,
                    ci.duration as cduration
            FROM `crop_info` as ci
            INNER JOIN crop_type as ct ON ci.type = ct.id
            INNER JOIN growing_season as gs ON ci.growing_season = gs.id
            INNER JOIN planting_technique as pt ON ci.planting_technique = pt.id
            INNER JOIN watering_needs as wn ON ci.watering_needs = wn.id 
            WHERE ci.id = ?";

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
