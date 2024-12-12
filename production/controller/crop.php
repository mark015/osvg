<style>
.pagination .page-item.disabled .page-link {
    color: #6c757d;
    cursor: not-allowed;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}
.w-50{
    width: 50%;
}
.forms{
    flex: auto;
    margin: 2px;
    width: 150px;
    height: 40px;
    border-radius: 10%;
}
</style>

<?php
    // Fetch planting techniques
    function plantingTechniques($conn){
        $sql = "SELECT * FROM `planting_technique`";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Assuming the table has `id` and `technique_name` columns
                echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['technique']) . '</option>';
            }
        } else {
            echo '<option value="">No techniques available</option>';
        }
    }
    
    // Fetch crop
    function CropType($conn) {
        $type = ''; // Initialize variable to accumulate options
        $sqlCrop = "SELECT * FROM `crop_type`";
        $resultCrop = $conn->query($sqlCrop);
        
        if ($resultCrop->num_rows > 0) {
            while ($rowCrop = $resultCrop->fetch_assoc()) {
                // Append each option to the $type variable
                $type .= '<option value="' . htmlspecialchars($rowCrop['id']) . '">' . htmlspecialchars($rowCrop['type']) . '</option>';
            }
        } else {
            // If no data, show a default option
            $type .= '<option value="">No crop types available</option>';
        }
        
        return $type; // Return all the accumulated options
    }

    function growingSeason($conn){
        $sqlSeason = "SELECT * FROM `growing_season`";
        $resultSeason = $conn->query($sqlSeason);
        if ($resultSeason->num_rows > 0) {
            while ($rowSeason = $resultSeason->fetch_assoc()) {
                // Assuming the table has `id` and `technique_name` columns
                echo '<option value="' . htmlspecialchars($rowSeason['id']) . '">' . htmlspecialchars($rowSeason['season']) . '</option>';
            }
        } else {
            echo '<option value="">No techniques available</option>';
        } 

    }

    function wateringNeeds($conn){
        $sqlNeeds = "SELECT * FROM `watering_needs`";
        $resultNeeds = $conn->query($sqlNeeds);
        if ($resultNeeds->num_rows > 0) {
            while ($rowNeeds = $resultNeeds->fetch_assoc()) {
                // Assuming the table has `id` and `technique_name` columns
                echo '<option value="' . htmlspecialchars($rowNeeds['id']) . '">' . htmlspecialchars($rowNeeds['needs']) . '</option>';
            }
        } else {
            echo '<option value="">No techniques available</option>';
        }  

    } 
?>
<div class="container mt-5">
    <h3>Crop Information</h3>
    <div class="row mb-3 align-items-center">
        <div class="col-md-2">
            <input type="text" id="searchInput" class="forms" placeholder="Search Crop Name" />
        </div>
        <div class="col-md-2">
            <select name="" class="forms form-cotrol" id="cropType">
                <option value="">Crop Type</option>
                <?php
                    echo CropType($conn)        
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="" class="forms form-cotrol" id="growingSeason">
                <option value="">Growing Season</option>
                <?php
                        echo growingSeason($conn);             
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="" class="forms form-cotrol" id="wateringNeeds">
                <option value="">Watering Needs</option>
                <?php
                    echo wateringNeeds($conn);                 
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="" class="forms form-cotrol" id="plantingTechniques">
                <option value="">Planting Technique</option>
                <?php
                    echo plantingTechniques($conn);          
                ?>
            </select>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-1" id="addBtn">
            <button class="btn btn-primary" id="addBtns" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    
    <table id="encodedTable" class="table table-striped">
        <thead>
            <tr>
                <th>Crop Name</th>
                <th>Crop Type</th>
                <th>Growing Season</th>
                <th>Watering Needs</th>
                <th>Planting Technique</th>
                <th>Duration</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic rows will be injected here -->
        </tbody>
    </table>
    <nav>
        <ul class="pagination justify-content-end" id="pagination">
            <!-- Pagination buttons will be injected here -->
        </ul>
    </nav>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" id="modalHeader">
                
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                    <form id="addCropInfoForm">
                        <!-- Hidden Input for Document ID -->
                        <input type="text" id="fcropId" name="fcropId"  />
                        <!-- Hidden Input for Status -->
                        <div class="row mb-3 align-items-center">
                            <label for="fcropName" class="col-md-2 col-form-label">Name of Crop:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="fcropName" name="fcropName" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="cropName" class="col-md-2 col-form-label">Crop Type</label>
                            <div class="col-md-10">
                                <select name="" class="form-control" id="fcropType">
                                    <option value="" id="optionCropType"></option>
                                    <?php
                                        echo CropType($conn);           
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="cropName" class="col-md-2 col-form-label">Growing Season:</label>
                            <div class="col-md-10">
                                <select name="" class="form-control" id="fgrowingSeason">
                                    <option value="" id="optionGrowingSeason"></option>
                                    <?php
                                       echo growingSeason($conn);                  
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="cropName" class="col-md-2 col-form-label">Watering Needs:</label>
                            <div class="col-md-10">
                                <select name="" class="form-control" id="fwateringNeeds">
                                    <option value="" id="optionWateringNeeds"></option>
                                    <?php
                                        echo wateringNeeds($conn);                 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="fplantingTechniques" class="col-md-2 col-form-label">Planting Techniques:</label>
                            <div class="col-md-10">
                                <select name="" class="form form-control" id="fplantingTechniques">
                                    <option value="" id="optionPlantingTechniques"></option>
                                    <?php
                                        echo plantingTechniques($conn);                  
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="fDuration" class="col-md-2 col-form-label">Duration befor harvest (days)</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="fduration" name="fduration" required />
                            </div>
                        </div>
                    </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer" id="footerModal">
                
            </div>
        </div>
    </div>
</div>