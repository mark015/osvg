<?php
include('../incl/config.php');
header('Content-Type: application/json');

// Fetch query parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$cropType = isset($_GET['cropType']) ? $conn->real_escape_string($_GET['cropType']) : '';
$growingSeason = isset($_GET['growingSeason']) ? $conn->real_escape_string($_GET['growingSeason']) : '';
$wateringNeeds = isset($_GET['wateringNeeds']) ? $conn->real_escape_string($_GET['wateringNeeds']) : '';
$plantingTechniques = isset($_GET['plantingTechniques']) ? $conn->real_escape_string($_GET['plantingTechniques']) : '';

$limit = 10; // Number of records per page
$offset = ($page - 1) * $limit;

// Base SQL query for fetching records
$sql = "SELECT  ci.id as cid, ci.crop_name as  cname,ct.type as cttype, gs.season as gseason, pt.technique as ptechnique, wn.needs as wneeds, ci.duration as cduration
        FROM `crop_info` as ci
        inner JOIN 
            crop_type as ct on ci.type = ct.id
        inner JOIN
            growing_season as gs on ci.growing_season = gs.id
        inner JOIN
            planting_technique as pt on ci.planting_technique = pt.id
        inner JOIN
            watering_needs as wn on ci.watering_needs = wn.id
        WHERE 1=1";
// Add filters dynamically
if (!empty($search)) {
    $sql .= " AND ci.crop_name LIKE '%$search%'";
}
if (!empty($cropType)) {
    $sql .= " AND ci.type = '$cropType'";
}
if (!empty($growingSeason)) {
    $sql .= " AND ci.growing_season = '$growingSeason'";
}
if (!empty($wateringNeeds)) {
    $sql .= " AND ci.watering_needs = '$wateringNeeds'";
}
if (!empty($plantingTechniques)) {
    $sql .= " AND ci.planting_teqnique = '$plantingTechniques'";
}

// Pagination
$sql .= " LIMIT $limit OFFSET $offset";

// Count total records
$count_sql = "SELECT COUNT(*) as total FROM `crop_info` WHERE 1=1";
if (!empty($search)) {
    $count_sql .= " AND crop_name LIKE '%$search%'";
}
if (!empty($cropType)) {
    $count_sql .= " AND type = '$cropType'";
}
if (!empty($growingSeason)) {
    $count_sql .= " AND growing_season = '$growingSeason'";
}
if (!empty($wateringNeeds)) {
    $count_sql .= " AND watering_needs = '$wateringNeeds'";
}
if (!empty($plantingTechniques)) {
    $count_sql .= " AND planting_teqnique = '$plantingTechniques'";
}

// Execute queries
$result = $conn->query($sql);
$count_result = $conn->query($count_sql);
$total_records = $count_result->fetch_assoc()['total'];

// Fetch data
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Prepare response
$response = [
    "success" => true,
    "data" => $data,
    "total" => $total_records,
    "page" => $page,
    "limit" => $limit,
    "search" => $plantingTechniques,
];

// Output response
echo json_encode($response);

// Close connections
$conn->close();
?>
