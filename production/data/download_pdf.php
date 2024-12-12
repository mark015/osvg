<?php
require '../../vendor/autoload.php'; // Include DOMPDF using Composer autoload

use Dompdf\Dompdf;

// Connect to the database
include('../incl/config.php');

// Retrieve parameters
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$crop_ids = isset($_GET['crop_ids']) ? $_GET['crop_ids'] : '';
$from = isset($_GET['from']) ? $_GET['from'] : '';
$to = isset($_GET['to']) ? $_GET['to'] : '';

// Build the SQL query
$sql = "SELECT act.id as aid, type_act, date_time, crop_name, particulars, pictures 
        FROM activities as act 
        INNER JOIN crop_info as ci ON act.crop_id = ci.id 
        WHERE 1";

if ($search) {
    $sql .= " AND (type_act LIKE '%$search%' OR particulars LIKE '%$search%' OR crop_name LIKE '%$search%')";
}
if ($crop_ids) {
    $sql .= " AND crop_id IN ($crop_ids)";
}
if ($from) {
    $sql .= " AND date_time >= '$from'";
}
if ($to) {
    $sql .= " AND date_time <= '$to'";
}

// Execute the query
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

// Generate HTML content
$html = '<h3>Activities Report</h3>';
$html .= '<table border="1" style="width:100%; border-collapse: collapse;">';
$html .= '<thead>
            <tr>
                <th>Type of Activity</th>
                <th>Date and Time</th>
                <th>Crop Name</th>
                <th>Particulars</th>
            </tr>
          </thead>';
$html .= '<tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>
                <td>' . htmlspecialchars($row['type_act']) . '</td>
                <td>' . htmlspecialchars($row['date_time']) . '</td>
                <td>' . htmlspecialchars($row['crop_name']) . '</td>
                <td>' . htmlspecialchars($row['particulars']) . '</td>
              </tr>';
}
$html .= '</tbody>';
$html .= '</table>';

// Create PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Stream the PDF to the browser
$dompdf->stream("activities_report.pdf", ["Attachment" => 1]);

mysqli_close($conn);
?>
