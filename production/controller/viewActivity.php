<?php
$id = $_GET['id'];
$stmtActivity = $conn->prepare("SELECT act.id,
                                    `type_act`,
                                    `date_time`,
                                    `crop_name`,
                                    `particulars`,
                                    `pictures`,
                                    season,
                                    needs,
                                    technique,duration, 
                                    ct.type as ctype
                                    FROM activities as act 
                                    inner join crop_info as ci on act.crop_id=ci.id
                                    inner join crop_type as ct on ci.type = ct.id
                                    inner join growing_season as gs on ci.growing_season = gs.id
                                    inner join watering_needs as wn on ci.watering_needs = wn.id
                                    inner join planting_technique as pt on ci.planting_technique = pt.id
                                    WHERE act.id = ? LIMIT 1");
$stmtActivity->bind_param("s", $id);
$stmtActivity->execute();
$resultActivity = $stmtActivity->get_result();
$rowActivity = $resultActivity->fetch_assoc();
?>

<div class="card shadow-lg rounded" style="overflow: hidden; border: none; margin: 20px;">
    <div class="card-header text-white bg-primary" style="padding: 20px; text-align: center;">
        <h2>Activity Details</h2>
    </div>
    <div class="card-body row" style="padding: 20px;">
        <!-- Image Section -->
        <div class="col-md-4 d-flex flex-column align-items-center">
            <img 
                src="uploads/<?php echo htmlspecialchars($rowActivity['pictures']); ?>" 
                class="shadow rounded-circle img-thumbnail" 
                style="width: 200px; height: 200px; object-fit: cover;" 
                alt="Activity Image"
            >
            <p style="margin-top: 10px; font-size: 16px; color: #6c757d;">Uploaded Image</p>
        </div>

        <!-- Activity Details Section -->
        <div class="col-md-4">
            <h4 class="text-primary mb-3">Activity Information</h4>
            <div class="mb-3">
                <strong>Activity:</strong>
                <p style="margin: 0; font-size: 16px; color: #333;"><?php echo htmlspecialchars($rowActivity['type_act']); ?></p>
            </div>
            <div class="mb-3">
                <strong>Particulars:</strong>
                <p style="margin: 0; font-size: 16px; color: #333;"><?php echo htmlspecialchars($rowActivity['particulars']); ?></p>
            </div>
            <div class="mb-3">
                <strong>Date & Time:</strong>
                <p style="margin: 0; font-size: 16px; color: #333;"><?php echo htmlspecialchars($rowActivity['date_time']); ?></p>
            </div>
        </div>

        <!-- Crop Information Section -->
        <div class="col-md-4">
            <h4 class="text-primary">Crop Information</h4>
            <div class="mb-3">
                <strong>Crop Name</strong>
                <p style="margin: 0; font-size: 16px; color: #333;"><?php echo htmlspecialchars($rowActivity['crop_name']); ?></p>
            </div>
            <div class="mb-3">
                <strong>Crop Type</strong>
                <p style="margin: 0; font-size: 16px; color: #333;"><?php echo htmlspecialchars($rowActivity['ctype']); ?></p>
            </div>
            <div class="mb-3">
                <strong>Growing Season</strong>
                <p style="margin: 0; font-size: 16px; color: #333;"><?php echo htmlspecialchars($rowActivity['season']); ?></p>
            </div>
            <div class="mb-3">
                <strong>Watering Needs</strong>
                <p style="margin: 0; font-size: 16px; color: #333;"><?php echo htmlspecialchars($rowActivity['needs']); ?></p>
            </div>
            <div class="mb-3">
                <strong>Planting Technique</strong>
                <p style="margin: 0; font-size: 16px; color: #333;"><?php echo htmlspecialchars($rowActivity['technique']); ?></p>
            </div>
            <div class="mb-3">
                <strong>Duration</strong>
                <p style="margin: 0; font-size: 16px; color: #333;"><?php echo htmlspecialchars($rowActivity['duration']); ?> Days</p>
            </div>
        </div>
    </div>
</div>
