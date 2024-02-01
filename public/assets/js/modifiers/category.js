$(document).ready(function () {
    //dataTables
    $("#example").DataTable({
        info: true,
        ordering: true,
        paging: true,
    });

    $("#deleteAllCategories").on("click", function () {
        var categoriesDeleteUrl = $(this).data("categories-delete-url");
        // Perform AJAX request to delete all products
        $.ajax({
            url: categoriesDeleteUrl,
            type: "get",
            success: function (response) {
                if (response.status == true) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Delete all data successfully...!!!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong....",
                    });
                }
            },
            error: function (error) {
                console.error("Error deleting all products: ", error);
            },
        });
    });

    $("#addNewCategory").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
            },
            description: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please enter a value",
                minlength: "Value must be at least 3 characters long",
            },
            description: {
                required: "Please enter a value",
            },
        },
        submitHandler: function (form) {
            // Serialize the form data
            var formData = $(form).serializeArray();
            $.ajax({
                type: "POST",
                url: "/store-category",
                data: formData,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (data) {
                    if (data.status == true) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: "Added successfully...!!!",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $(form).trigger("reset");
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong....",
                        });
                    }
                },
                error: function (error) {
                    // Handle error response
                    console.error("Error:", error);
                    // You can add your error handling logic here
                },
            });
        },
    });

    $('input[type="checkbox"]').change(function () {
        // Determine if the checkbox is checked or not
        var isChecked = $(this).is(":checked");
        var categoryID = $(this).attr("data-id");

        // Your AJAX call
        $.ajax({
            url: "/update-status",
            type: "POST",
            data: {
                category_id: categoryID,
                is_active: isChecked,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.status == true) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Update status successfully...!!!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong....",
                    });
                }
            },
            error: function (error) {
                // Handle the error response
                console.error(error);
            },
        });
    });

    //edit modal pop-up for category
    $(".edit-btn").on("click", function () {
        var categoryId = $(this).data("category-id");

        // Fetch category data using AJAX
        $.ajax({
            // url: '{{ route('category.get', ['id' => '__categoryId__']) }}'.replace(
            //     '__categoryId__', categoryId),
            url: "/category/" + categoryId,
            type: "GET",
            data: {
                id: categoryId,
            },
            success: function (response) {
                if (response.status == true) {
                    $("#editModal #categoryID").val(response.category.id);
                    $("#editModal #name").val(response.category.name);
                    $("#editModal #description").val(
                        response.category.description
                    );
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Failed to fetch category data.",
                    });
                }
            },
            error: function (error) {
                // Handle the error response
                console.error(error);
            },
        });
    });

    $("#EditCategory").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
            },
            description: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please enter a value",
                minlength: "Value must be at least 3 characters long",
            },
            description: {
                required: "Please enter a value",
            },
        },
        submitHandler: function (form) {
            event.preventDefault();
            // Serialize the form data
            var formData = $(form).serializeArray();
            var categoryID = $("#categoryID").val();

            $.ajax({
                type: "POST",
                url: "/category/update/" + categoryID,
                data: formData,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (data) {
                    if (data.status == true) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: "Update successfully...!!!",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $(form).trigger("reset");
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong....",
                        });
                    }
                },
                error: function (error) {
                    // Handle error response
                    console.error("Error:", error);
                    // You can add your error handling logic here
                },
            });
        },
    });

    // Delete button click event
    $(".delete-btn").on("click", function () {
        var categoryId = $(this).data("category-id");
        $("#deleteModal .btn-danger").on("click", function () {
            deleteCategory(categoryId);
        });
    });

    function deleteCategory(categoryId) {
        $.ajax({
            type: "POST",
            url: "/category/delete/"+categoryId,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.status == true) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Category deleted successfully.",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Optionally, reload the page or update the UI
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Failed to delete category.",
                    });
                }
            },
            error: function (error) {
                console.error("Error:", error);
                // Handle the error response
            },
        });
    }

    $(".view-product-btn").on("click", function () {
        var categoryId = $(this).data("category-id");

        // Fetch category data using AJAX
        $.ajax({
            url: "/category/product/view",
            type: "GET",
            data: {
                id: categoryId,
            },
            success: function (response) {
                if (response.status == true) {
                    $("#viewProduct #categoryName").text(
                        response.categories.name
                    );
                    $("#viewProduct #productCount").text(response.productCount);
                    // Populate DataTable with product data
                    populateDataTable(response.categories.products);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Failed to fetch category data.",
                    });
                }
            },
            error: function (error) {
                // Handle the error response
                console.error(error);
            },
        });
    });

    $(".view-history").on("click", function () {
        var categoryId = $(this).data("category-id");

        // Fetch category log data using AJAX
        $.ajax({
            url: "/category/activity/log",
            type: "GET",
            data: {
                id: categoryId,
            },
            success: function (response) {
                if (response.status == true) {
                    var category_name = response.categories.category_name;
                    var products_history = response.categories.products_history;
                    // Populate DataTable with product data
                    getProductHistoryData(category_name, products_history);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Failed to fetch category data.",
                    });
                }
            },
            error: function (error) {
                // Handle the error response
                console.error(error);
            },
        });
    });

    //display product data when user click on view product btn
    function populateDataTable(products) {
        var table = $("#productDataTable").DataTable({
            destroy: true,
            processing: true,
            serverSide: false,
            pageLength: 25,
            responsive: false,
            autoWidth: false,
            paging: true,
            ordering: true,
            info: true,
            data: products,
            columns: [
                { title: "ID", data: "id" },
                { title: "Name", data: "name" },
                { title: "Price", data: "price" },
                { title: "Quantity", data: "quantity" },
                { title: "Description", data: "description" },
                // Add more columns as needed
            ],
        });
    }

    //display getProductHistoryData
    function getProductHistoryData(category_name, products_history) {
        // Add category_name to each product history object
        products_history.forEach(function (history) {
            history.category_name = category_name;
        });

        var table = $("#activityLogTable").DataTable({
            destroy: true,
            processing: true,
            serverSide: false,
            pageLength: 10,
            responsive: false,
            autoWidth: false,
            paging: true,
            ordering: false,
            info: true,
            searching: false, // Disable search functionality
            data: products_history,
            scrollX: "200px",
            columns: [
                { title: "ID", data: "id" },
                { title: "Category", data: "category_name" },
                { title: "Action", data: "field_name" },
                {
                    title: "Old Value",
                    data: "old_value",
                    render: function (data, type, row, meta) {
                        // Add a button to trigger the modal
                        return (
                            '<button type="button" class="btn btn-link btn-show-history" data-toggle="modal" data-target="#historyModal" style="text-align: -webkit-match-parent;" data-id="' +
                            row.id +
                            '">' +
                            data +
                            "</button>"
                        );
                    },
                },
                { title: "New Value", data: "new_value" },
                { title: "Updated at", data: "updated_at" },
                // Add more columns as needed
            ],
            columnDefs: [
                // Define the modal content in the createdCell callback for the Old Value column
                {
                    targets: 3, // Index of the Old Value column
                    createdCell: function (td, cellData, rowData, row, col) {
                        var oldData = JSON.parse(rowData.old_value);
                        var newData = JSON.parse(rowData.new_value);
                        var updatedAt = new Date(rowData.updated_at); // Assuming rowData.updated_at is a valid date string

                        // Format the date and time
                        var formattedDate = updatedAt.toLocaleDateString(
                            "en-US",
                            {
                                day: "2-digit",
                                month: "2-digit",
                                year: "numeric",
                            }
                        );

                        var formattedTime = updatedAt.toLocaleTimeString(
                            "en-US",
                            {
                                hour12: false,
                                hour: "2-digit",
                                minute: "2-digit",
                                second: "2-digit",
                            }
                        );

                        // Add the modal content here (replace this with your modal HTML)
                        var modalContent =
                            '<div class="modal fade bd-example-modal-xl" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="oldValueModalLabel" aria-hidden="true">';
                        modalContent +=
                            '<div class="modal-dialog modal-xl" role="document">';
                        modalContent += '<div class="modal-content">';
                        modalContent += '<div class="modal-header">';
                        modalContent +=
                            '<h5 class="modal-title" id="oldValueModalLabel"> Log - ' +
                            formattedDate +
                            " " +
                            formattedTime +
                            "</h5>";
                        modalContent +=
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                        modalContent +=
                            '<span aria-hidden="true">&times;</span>';
                        modalContent += "</button>";
                        modalContent += "</div>";
                        modalContent +=
                            '<div class="modal-body" style="max-height: 70vh; overflow-y: auto;">' +
                            JSON.stringify(newData, null, 2) +
                            "</div>";
                        modalContent += '<div class="modal-footer">';
                        modalContent +=
                            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                        modalContent += "</div>";
                        modalContent += "</div>";
                        modalContent += "</div>";
                        modalContent += "</div>";

                        // Append the modal content to the body
                        $("body").append(modalContent);
                    },
                },
            ],
        });
    }
    // Event listener for Old Value button click
    $("#activityLogTable").on("click", ".btn-show-history", function () {
        var rowId = $(this).data("id");
        $.ajax({
            url: "get-history-data/" + rowId,
            method: "GET",
            data: { rowId: rowId },
            success: function (response) {
                if (!response.data || typeof response.data !== 'object') {
                    console.error("Invalid or empty 'data' property in the API response");
                    return;
                }
    
                var oldData = typeof response.data.old_value === 'string' ? JSON.parse(response.data.old_value) : response.data.old_value;
                var newData = typeof response.data.new_value === 'string' ? JSON.parse(response.data.new_value) : response.data.new_value;
    
                var modalBody = $("#historyModal .modal-body");
                modalBody.empty(); // Clear existing content
    
                var table = $('<table class="table table-bordered">');
    
                // Create table rows
                for (var key in oldData) {
                    if (oldData.hasOwnProperty(key)) {
                        var row = $("<tr>");
    
                        var oldVal = oldData[key];
                        var newVal = newData.hasOwnProperty(key) ? newData[key] : "";
    
                        // Format is_active values
                        if (key === 'is_active') {
                            oldVal = oldVal === 1 ? 'true' : 'false';
                            newVal = newVal === 1 ? 'true' : 'false';
                        }
    
                        var oldColorClass = '';
                        var newColorClass = '';
    
                        // Check conditions for different fields
                        if ((key === 'name' || key === 'is_active' || key === 'description' || key === 'category_id') && oldVal !== newVal) {
                            oldColorClass = 'old-changed';
                            newColorClass = 'new-changed';
                        }
    
                        row.append("<td>" + key + "</td>"); // Field name
                        row.append("<td class='" + oldColorClass + "'>" + oldVal + "</td>"); // Old Value
                        row.append("<td class='" + newColorClass + "'>" + newVal + "</td>"); // New Value
    
                        table.append(row);
                    }
                }
    
                modalBody.append(table);
            },
            error: function (error) {
                console.error("API call failed", error);
            },
        });
    });
    
});
