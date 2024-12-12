<?php
    include('../incl/config.php');
    header('Content-Type: application/json');

    // Check if the id is provided
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Prepare the SQL query to delete the document
        $query = "DELETE FROM `crop_info` WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        // Execute the query
        if ($stmt->execute([$id])) {
            // If deletion is successful, return a success response
            echo json_encode(['status' => 'success', 'message' => 'Crop Info deleted successfully.']);
        } else {
            // If deletion fails, return an error response
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete the Crop Info.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No document ID provided.']);
    }
?>
