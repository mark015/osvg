<div class="container mt-5">
    <h3>Crop Type</h3>
    
    <div class="row">
        <div class="col-md-8">
            <div class="row mb-3 align-items-center">
                <div class="col-md-10">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search..." />
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" id="addBtns"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <table id="cropTypeTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Type</th>
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
        <div class="col-md-4">
            <form id="cropForm">
                <!-- Hidden Input for Status -->
                <div class="mb-3">
                    <input type="text" class="form-control" id="cropId" name="cropId" hidden />
                </div>
                <div class="mb-3">
                    <label for="schoolName" class="form-label">*Type</label>
                    <input type="text" class="form-control" id="fcropType" name="fcropType" required />
                </div>
            </form>
            
            <div id="formFooter">
                    <button type="submit" class="btn btn-primary" id="savecropButton">Save</button>
                </div>
        </div>
    </div>
</div>