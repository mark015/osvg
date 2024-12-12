<?php
include('../incl/config.php');
header('Content-Type: application/json');

// Get POST data
$cropIds = isset($_POST['crops']) ? $_POST['crops'] : [];
$fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : '';
$toDate = isset($_POST['toDate']) ? $_POST['toDate'] : '';

// Prepare SQL query to fetch filtered activities
$sql = "SELECT act.id as aid, type_act, act.date_time as adate, ci.crop_name, act.particulars, act.pictures
        FROM activities AS act 
        INNER JOIN crop_info AS ci ON act.crop_id = ci.id 
        WHERE 1=1";

// Add filter conditions
if (!empty($cropIds)) {
    $placeholders = implode(',', array_fill(0, count($cropIds), '?'));
    $sql .= " AND act.crop_id IN ($placeholders)";
}

if (!empty($fromDate)) {
    $sql .= " AND act.date_time >= ?";
}

if (!empty($toDate)) {
    $sql .= " AND act.date_time <= ?";
}

// Prepare and execute the query
$stmt = $conn->prepare($sql);

// Dynamically build the bind_param format string
$types = str_repeat('i', count($cropIds)) . 'ss';
$params = array_merge($cropIds, [$fromDate, $toDate]);
$stmt->bind_param($types, ...$params);

$stmt->execute();
$result = $stmt->get_result();

// Fetch results and return as JSON
$activities = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
}

echo json_encode($activities);

$stmt->close();
$conn->close();
?>
