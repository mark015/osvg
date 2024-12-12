<script>

$(document).ready(function () {    
    
    // Function to fetch and display data
    let currentPage = 1;
    var role = "<?php echo $rowUser['role'];?>";

    // Function to fetch and display activities
    function fetchActivities(page = 1, crop_ids = [], to = '', from = '', search = '') {
        $.ajax({
            url: "data/fetch_activities.php",
            type: "GET",
            data: { 
                page: page, 
                crop_ids: crop_ids.join(','), // Join selected crop IDs to send in a single string
                to: to,
                from: from,
                search: search // Pass the search value
            },
            dataType: "json",
            success: function (response) {
                let rows = "";
                response.data.forEach(function (item) {
                    let deleteBtn = '';
                    if (role === 'Admin') {
                        deleteBtn = `<button class="btn btn-danger btn-sm delete-btn" data-id="${item.aid}">Delete</button>`;
                    }

                    rows += `
                        <tr>
                            <td>${item.type_act || "N/A"}</td>
                            <td>${item.date_time || "N/A"}</td>
                            <td>${item.crop_name || "N/A"}</td>
                            <td>${item.particulars || "N/A"}</td>
                            <td><img src="uploads/${item.pictures}" alt="Image 1" style="width: 50px; height: 50px;"></td>
                            <td>
                                ${deleteBtn}
                                <button class="btn btn-success btn-sm" id="update-btn" data-update-id="${item.aid}">Update</button>
                                <button class="btn btn-primary btn-sm" id="view-btn" data-view-id="${item.aid}">View</button>
                            </td>
                        </tr>
                    `;
                });
                $("#activityTable tbody").html(rows);

                const totalPages = Math.ceil(response.total / response.limit);
                generatePagination(totalPages, response.page);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }
    // Function to generate pagination buttons
    function generatePagination(totalPages, currentPage){
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
            fetchActivities(page);
        });
    }
    // Handle search and filter input
    function handleFilters() {
        const search = $("#searchActivity").val(); // Get the search value
        console.log(search)
        const cropIds = [];
        $('#cropCheckbox input[type="checkbox"]:checked').each(function () {
            cropIds.push($(this).val()); // Collect checked crop IDs
        });
        const from = $("#from").val();
        const to = $("#to").val();

        fetchActivities(1, cropIds, to, from, search);
    }

    // Attach keyup event for search input
    $("#searchActivity").on("keyup", function () {
        handleFilters();
    });

    // Dropdown change events
    $("#cropCheckbox input[type='checkbox']").on("change", function () {
        handleFilters();
    });

    // Date picker change events
    $("#from, #to").on("change", function () {
        handleFilters();
    });

    fetchActivities(currentPage);
    
    $("#downloadPdf").on("click", function () {
        const params = {
            search: $("#searchActivity").val(),
            crop_ids: $('#cropCheckbox input[type="checkbox"]:checked').map(function () {
                return $(this).val();
            }).get().join(','),
            from: $("#from").val(),
            to: $("#to").val()
        };

        const queryString = $.param(params);

        window.open(`data/download_pdf.php?${queryString}`, '_blank');
    });

    // ADD Encoded onclick btn
    $(document).on('click', '#addBtns' , function(){
        $('#addCropInfoForm')[0].reset();
        $("#fpicture-placeholder").text('');
        
        $("#optionCropName").val('').text('');
        $('#modalHeader').html(`<h5 class="modal-title" id="addModalLabel">Add New Encoded Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>`)
        $('#footerModal').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="saveItemButton">Save</button>`)
        
    })
    // // Function to add encoded item
    $(document).on('click', '#saveItemButton' , function(){
        const fAct = $("#fAct").val();
        const fcropName = $("#fcropName").val();
        const fparticular = $("#fparticular").val();
        const fdateTime = $("#fdateTime").val();
        const fpicture = $("#fpicture")[0].files[0];
        var formData = new FormData();
        formData.append('fcropName', fcropName);
        formData.append('fparticular', fparticular);
        formData.append('fdateTime', fdateTime);
        formData.append('fpicture', fpicture);
        formData.append('fAct', fAct);

        $.ajax({
            url: "data/add_activities.php",
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response)
                if (response.status === "success") {
                    Swal.fire(
                        'Saved!',
                        'Successfully Addded.',
                        'success'
                    );
                    $("#addModal").modal("hide");
                    fetchActivities();
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
            <button type="submit" class="btn btn-primary" id="updateActButton">Save</button>
        `);

        $('#modalHeader').html(`
            <h5 class="modal-title" id="addModalLabel">Update Crop Info</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
        `);

        // Fetch crop details
        $.ajax({
            url: "data/getActDetails.php", // Endpoint to fetch details
            type: "GET",
            data: { id: id },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    // Populate the form fields with the response data
                    $("#factId").val(response.data.aid);
                    
                    $("#fAct").val(response.data.type_act);
                    $("#optionCropName").val(response.data.cid).text(response.data.crop_name);
                    $("#fparticular").val(response.data.particulars);
                    $("#fdateTime").val(response.data.date_time);

                    // File inputs cannot have their value set directly. Provide a placeholder or display the filename elsewhere.
                    if (response.data.pictures) {
                        $("#fpicture-placeholder").text(response.data.pictures); // Example: Display filename in a span
                    }

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

    
    $(document).on('click', '#updateActButton', function () {
        // Retrieve form field values
        const id = $("#factId").val(); // Hidden input to identify the record
        const fAct = $("#fAct").val();
        const fcropName = $("#fcropName").val();
        const fparticular = $("#fparticular").val();
        const fdateTime = $("#fdateTime").val();
        const fpicture = $("#fpicture")[0].files[0]; // File input
        
        console.log(fparticular)
        // Validate input fields (optional but recommended)
        if (!fAct || !fcropName || !fparticular || !fdateTime) {
            Swal.fire('Error', 'Please fill all required fields.', 'error');
            return;
        }

        // Create FormData for AJAX request
        const formData = new FormData();
        formData.append('id', id); // Append record ID
        formData.append('fcropName', fcropName);
        formData.append('fparticular', fparticular);
        formData.append('fdateTime', fdateTime);
        if (fpicture) {
            formData.append('fpicture', fpicture); // Add file only if selected
        }
        formData.append('fAct', fAct);

        // AJAX request to the server
        $.ajax({
            url: "data/updateAct.php", // Endpoint for updating the crop
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: function (response) {
                console.log(response)
                if (response.success) {
                    // Display success message using SweetAlert2
                    Swal.fire('Saved!', 'Successfully updated.', 'success');

                    // Hide the modal
                    $("#addModal").modal("hide");

                    // Refresh data
                    fetchActivities();
                } else {
                    // Display server-provided error message
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                Swal.fire('Error', 'An error occurred while processing the request.', 'error');
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
                    url: "data/delete_activity.php",
                    type: "POST",
                    data: { id: id },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire(
                                'Deleted!',
                                'Your activity has been deleted.',
                                'success'
                            );
                            fetchActivities(currentPage); // Refresh the encoded list
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an issue deleting the activity.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the activity.',
                            'error'
                        );
                    }
                });
            }
        });
    });
    $(document).on("click", "#view-btn", function() {
        const id = $(this).data("view-id");
        const targetUrl = "index?link=viewActivity&&id=" + id;
        // Open the URL in a new tab
        window.open(targetUrl);
    })

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