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
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    padding: 10px;
    max-height: 200px;
    overflow-y: auto;
}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown-item {
    padding: 8px 12px;
    cursor: pointer;
}

.dropdown-item:hover {
    background-color: #ddd;
}

.checkbox-group {
    display: block;
}

</style>

<?php
    // Fetch planting techniques
    function cropInfo($conn){
        $sql = "SELECT * FROM `crop_info`";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Assuming the table has `id` and `technique_name` columns
                echo '<label>
                            <input type="checkbox" value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['crop_name']) . '</label><br>';
            }
        } else {
            echo '<label>
                    <input type="checkbox" value="Option 2"> Option 2
                </label><br>';
        }
    }

    function cropInfoo($conn){
        $sqls = "SELECT * FROM `crop_info`";
        $results = $conn->query($sqls);
        if ($results->num_rows > 0) {
            while ($rows = $results->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($rows['id']) . '">' . htmlspecialchars($rows['crop_name']) . '</option>';
            }
        } else {
            echo '<option value="">No crops  available</option>';
        }
    }
    
   
?>
<div class="container mt-5">
    <h3>Activities Information</h3>
    <div class="row mb-2 align-items-center">
        <div class="col-md-2">
            <input type="text" class="form-control" name="searchActivity" id="searchActivity"  placeholder="Search Activity">
        </div>
        <div class="col-md-3">
            <div class="dropdown" style="width: 100%;" >
                <button class="dropbtn form-control" style="font-size: 16px;">Select Crop Name</button>
                <div class="dropdown-content" style="width: 100%;" id="cropCheckbox">
                    <div class="checkbox-group" >
                        <?php
                             cropInfo($conn);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="row">
                <div class="col-md-2">
                    <label for="from">From:</label>
                </div>
                <div class="col-md-10">
                    <input type="date" id="from" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="row">
                <div class="col-md-2">
                    <label for="from">to:</label>
                </div>
                <div class="col-md-10">
                    <input type="date" id="to" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-1" id="addBtn">
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-success" id="downloadPdf"><i class="fa fa-file-pdf-o"></i></button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary" id="addBtns" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            
        </div>
    </div>
    <table id="activityTable" class="table table-striped">
        <thead>
            <tr>
                <th>Type of Activity </th>
                <th>Date and time</th>
                <th>Crop Name</th>
                <th>Particulars</th>
                <th>Picture</th>
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
                        <input type="text" id="factId" name="factId" hidden />
                        <!-- Hidden Input for Status -->
                        <div class="row mb-3 align-items-center">
                            <label for="fAct" class="col-md-2 col-form-label">Activities:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="fAct" name="fcropName" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="cropName" class="col-md-2 col-form-label">Crop Name</label>
                            <div class="col-md-10">
                                <select name="" class="form-control" id="fcropName">
                                    <option value="" id="optionCropName"></option>
                                    <?php
                                         cropInfoo($conn);
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="fparticular" class="col-md-2 col-form-label">Particulars: </label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="fparticular" name="fparticular" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="fdateTime" class="col-md-2 col-form-label">Date and Time: </label>
                            <div class="col-md-10">
                                <input type="datetime-local" class="form-control" id="fdateTime" name="fdateTime" required />
                            </div>
                        </div>
                        
                        <div class="row mb-3 align-items-center">
                            <label for="fpicture" class="col-md-2 col-form-label">Image: </label>
                            <div class="col-md-10">
                                <input type="file" class="form-control" id="fpicture" name="fpicture" required />
                                <span id="fpicture-placeholder">No file selected</span>
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