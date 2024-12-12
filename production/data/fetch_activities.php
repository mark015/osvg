<?php
    // Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Connect to the database
    include('../incl/config.php');
    header('Content-Type: application/json');

    // Retrieve parameters from the GET request
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $crop_ids = isset($_GET['crop_ids']) ? $_GET['crop_ids'] : '';
    $from = isset($_GET['from']) ? $_GET['from'] : '';
    $to = isset($_GET['to']) ? $_GET['to'] : '';
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : ''; // Sanitize search input

    // SQL query (use placeholders to prevent SQL injection)
    $sql = "SELECT act.id as aid, type_act, date_time, crop_name, particulars, pictures 
            FROM activities as act 
            INNER JOIN crop_info as ci ON act.crop_id = ci.id 
            WHERE 1";

    // Add filters if provided
    if ($crop_ids) {
        $sql .= " AND crop_id IN ($crop_ids)";
    }
    if ($from) {
        $sql .= " AND date_time >= '$from'";
    }
    if ($to) {
        $sql .= " AND date_time <= '$to'";
    }
    if ($search) {
        $sql .= " AND (type_act LIKE '%$search%'";
    }

    // Pagination logic (adjust as needed)
    $limit = 10; // Adjust limit as necessary
    $offset = ($page - 1) * $limit;
    $sql .= " LIMIT $limit OFFSET $offset";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check for query errors
    if (!$result) {
        echo json_encode(["error" => "Query failed: " . mysqli_error($conn)]);
        exit;
    }

    // Fetch data
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Get total count for pagination
    $totalQuery = "SELECT COUNT(*) AS total FROM activities WHERE 1";

    // Add the same filters to the total count query
    if ($crop_ids) {
        $totalQuery .= " AND crop_id IN ($crop_ids)";
    }
    if ($from) {
        $totalQuery .= " AND date_time >= '$from'";
    }
    if ($to) {
        $totalQuery .= " AND date_time <= '$to'";
    }
    if ($search) {
        $totalQuery .= " AND (type_act LIKE '%$search%')";
    }

    $totalResult = mysqli_query($conn, $totalQuery);
    if (!$totalResult) {
        echo json_encode(["error" => "Total query failed: " . mysqli_error($conn)]);
        exit;
    }
    $totalRow = mysqli_fetch_assoc($totalResult);
    $total = $totalRow['total'];

    // Return data as JSON
    echo json_encode([
        'data' => $data,
        'total' => $total,
        'page' => $page,
        'limit' => $limit
    ]);

    mysqli_close($conn);
?>