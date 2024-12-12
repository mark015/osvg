<script>

$(document).ready(function () {
    let currentPage = 1;
    var role = "<?php echo $rowUser['role'];?>";    
    
    // Function to fetch and display data
    function fetchCrop(page = 1, search = "", cropType = "", growingSeason = "", wateringNeeds = "", plantingTeqniques = "") {
        $.ajax({
            url: "data/fetch_crop.php",
            type: "GET",
            data: { 
                page: page, 
                search: search, 
                cropType: cropType,
                growingSeason: growingSeason,
                wateringNeeds: wateringNeeds,
                plantingTeqniques: plantingTeqniques
            },
            dataType: "json",
            success: function (response) {
                let rows = "";
                response.data.forEach(function (item) {
                    console.log(item.cid)
                    if (role === 'Admin') {
                        var deleteBtn = `<button class="btn btn-danger btn-sm delete-btn" data-id="${item.cid}">Delete</button>`;
                    } else {
                        var deleteBtn = '';
                    }

                    rows += `
                        <tr>
                            <td>${item.cname || "N/A"}</td>
                            <td>${item.cttype || "N/A"}</td>
                            <td>${item.gseason || "N/A"}</td>
                            <td>${item.wneeds || "N/A"}</td>
                            <td>${item.ptechnique || "N/A"}</td>
                            <td>${item.cduration || "N/A"} Days</td>
                            <td>
                                ${deleteBtn}
                                <button class="btn btn-success btn-sm" id="update-btn" data-update-id="${item.cid}">Update</button>
                            </td>
                        </tr>
                    `;
                });
                $("#encodedTable tbody").html(rows);

                const totalPages = Math.ceil(response.total / response.limit);
                generatePagination(totalPages, response.page);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    // Function to generate pagination buttons
    function generatePagination(totalPages, currentPage) {
        let pagination = "";

        // Previous button
        if (currentPage > 1) {
            pagination += `
                <li class="page-item">
                    <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
                </li>
            `;
        } else {
            pagination += `
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
            `;
        }

        // Generate page numbers
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                pagination += `
                    <li class="page-item ${i === currentPage ? "active" : ""}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                pagination += `
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                `;
            }
        }

        // Next button
        if (currentPage < totalPages) {
            pagination += `
                <li class="page-item">
                    <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
                </li>
            `;
        } else {
            pagination += `
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
            `;
        }

        $("#pagination").html(pagination);

        // Attach click event to pagination buttons
        $("#pagination .page-link").click(function (e) {
            e.preventDefault();
            const page = $(this).data("page");
            const search = $("#searchInput").val();
            fetchCrop(page, search);
        });
    }
    
    // Handle search and filter input
    function handleFilters() {
        const search = $("#searchInput").val();
        const cropType = $("#cropType").val();
        const growingSeason = $("#growingSeason").val();
        const wateringNeeds = $("#wateringNeeds").val();
        const plantingTechniques = $("#plantingTechniques").val();
        fetchCrop(1, search, cropType, growingSeason, wateringNeeds, plantingTechniques);
    }

    // Search input keyup event
    $("#searchInput").on("keyup", function () {
        handleFilters();
    });

    // Dropdown change events
    $("#cropType, #growingSeason, #wateringNeeds, #plantingTeqniques").on("change", function () {
        handleFilters();
    });
    fetchCrop();
    
    // ADD Encoded onclick btn
    $(document).on('click', '#addBtns' , function(){
        $('#addCropInfoForm')[0].reset();
        
        $("#optionCropType").val('').text('');
        $("#optionGrowingSeason").val('').text(''); // Populate growing season dropdown
        $("#optionWateringNeeds").val('').text(''); // Populate watering needs dropdown
        $("#optionPlantingTechniques").val('').text(''); // Populate planting techniques dropdown
        $('#modalHeader').html(`<h5 class="modal-title" id="addModalLabel">Add New Encoded Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>`)
        $('#footerModal').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="saveItemButton">Save</button>`)
        
    })
    // // Function to add encoded item
    $(document).on('click', '#saveItemButton' , function(){
        
        const fcropName = $("#fcropName").val();
        const fcropType = $("#fcropType").val();
        const fgrowingSeason = $("#fgrowingSeason").val();
        const fwateringNeeds = $("#fwateringNeeds").val();
        const fplantingTechniques = $("#fplantingTechniques").val();
        const fduration = $("#fduration").val();
        
        var formData = new FormData();
        formData.append('fcropName', fcropName);
        formData.append('fcropType', fcropType);
        formData.append('fgrowingSeason', fgrowingSeason);
        formData.append('fwateringNeeds', fwateringNeeds);
        formData.append('fplantingTechniques', fplantingTechniques);
        formData.append('fduration', fduration);

        $.ajax({
            url: "data/add_crop.php",
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire(
                        'Saved!',
                        'Successfully Addded.',
                        'success'
                    );
                    $("#addModal").modal("hide");
                    fetchCrop();
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    });
    // // UPDATE  Item onclick btn
    $(document).on('click', '#update-btn', function() {
        const id = $(this).data('update-id');
        
        // Update modal footer and header
        $('#footerModal').html(`
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="updateCropButton">Save</button>
        `);

        $('#modalHeader').html(`
            <h5 class="modal-title" id="addModalLabel">Update Crop Info</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
        `);

        // Fetch crop details
        $.ajax({
            url: "data/getCropDetails.php", // Endpoint to fetch details
            type: "GET",
            data: { id: id },
            dataType: "json",
            success: function(response) {
                console.log(response);
                if (response.success) {
                    // Populate the form fields with the response data
                    $("#fcropId").val(response.data.cid);
                    $("#fcropName").val(response.data.cname);
                    $("#optionCropType").val(response.data.ctid).text(response.data.cttype);
                    $("#optionGrowingSeason").val(response.data.gsid).text(response.data.gseason); // Populate growing season dropdown
                    $("#optionWateringNeeds").val(response.data.wnid).text(response.data.wneeds); // Populate watering needs dropdown
                    $("#optionPlantingTechniques").val(response.data.ptid).text(response.data.ptechnique); // Populate planting techniques dropdown
                    $("#fduration").val(response.data.cduration)

                    // Show the modal
                    $("#addModal").modal("show");
                } else {
                    alert("Failed to fetch crop details.");
                }
            },
            error: function() {
                alert("An error occurred while fetching the crop details.");
            }
        });
    });

    
    $(document).on('click', '#updateCropButton' , function(){
        var id = $("#fcropId").val();
        
        const fcropName = $("#fcropName").val();
        const fcropType = $("#fcropType").val();
        const fgrowingSeason = $("#fgrowingSeason").val();
        const fwateringNeeds = $("#fwateringNeeds").val();
        const fplantingTechniques = $("#fplantingTechniques").val();
        const fduration = $("#fduration").val();
        
        var formData = new FormData();
        formData.append('id', id);
        formData.append('fcropName', fcropName);
        formData.append('fcropType', fcropType);
        formData.append('fgrowingSeason', fgrowingSeason);
        formData.append('fwateringNeeds', fwateringNeeds);
        formData.append('fplantingTechniques', fplantingTechniques);
        formData.append('fduration', fduration);

        $.ajax({
            url: "data/updateCrop.php",
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success === true) {
                    Swal.fire(
                        'Saved!',
                        'Successfully Addded.',
                        'success'
                    );
                    $("#addModal").modal("hide");
                    fetchCrop();
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                console.log("An error occurred: " + error);
            }
        });
    });

    
        // setInterval(updateNotif, 2000);
    // Delete encoded items using SweetAlert
    $(document).on("click", ".delete-btn", function() {
        const id = $(this).data("id");
        console.log(id)

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with delete request
                $.ajax({
                    url: "data/delete_crop.php",
                    type: "POST",
                    data: { id: id },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire(
                                'Deleted!',
                                'Your encoded item has been deleted.',
                                'success'
                            );
                            fetchCrop(currentPage); // Refresh the encoded list
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an issue deleting the encoded item.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the encoded.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    // function updateNotif(){
    //     $.ajax({
    //         url: "data/updateNotif.php",
    //         type: "POST",
    //         dataType: "json",
    //         success: function (response) {
    //             if (response.success) {
    //             }
    //         },
    //         error: function (xhr, status, error) {
    //             console.error("AJAX Error:", xhr.responseText);
    //             alert("An error occurred: " + error);
    //         }
    //     });
    // }
});


</script>