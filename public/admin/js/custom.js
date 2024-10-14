$(document).ready(function () {
    // call datatable class
    $("#sections").DataTable();
    $("#categories").DataTable();
    $("#brands").DataTable();
    $("#admins").DataTable();
    // end datatable class

    $(".nav-link").removeClass("active");
    $(".nav-item").removeClass("active");
    //check Admin Password is correct or not
    $("#current_password").keyup(function () {
        var current_password = $("#current_password").val();

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url: "check-admin-password",
            data: { current_password: current_password },
            success: function (resp) {
                if (resp == "false") {
                    $("#check_password").html(
                        "<font color='red'>Current Password is Incorrent!</font>"
                    );
                } else if (resp == "true") {
                    $("#check_password").html(
                        "<font color='green'>Current Password is Corrent! </font>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    //update Admin status
    $(document).on("click", ".updateAdminStatus", function () {
        var status = $(this).children("i").attr("status");
        var admin_id = $(this).attr("admin_id");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url: "/admin/update-admin-status",
            data: {
                status: status,
                admin_id: admin_id,
            },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#admin-" + admin_id).html(
                        "<i style='font-size: x-large' class='mdi mdi-bookmark-outline' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#admin-" + admin_id).html(
                        "<i style='font-size: x-large' class='mdi mdi-bookmark-check' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    // confirm deletion (sweetalert library)
    $(".confirmDelete").click(function () {
        var module = $(this).attr("module");
        var moduleid = $(this).attr("moduleid");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success",
                });
                window.location = "/admin/delete-" + module + "/" + moduleid;
            }
        });
    });

    // Append categories level
    $("#section_id").change(function () {
        var section_id = $(this).val();
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type:'get',
            url: '/admin/append-categories-level',
            data:{
                section_id:section_id
            },
            success:function(resp){
                $('#appendCategoriesLevel').html(resp);
            }, error:function(){
                alert("Error");
            }
        });
    });

    //update Brands active/inactive status
    $(document).on("click", ".updateBrandStatus", function () {
        var brand_id = $(this).attr("brand_id");
        updateStatus("/admin/update-brand-status", "brand", "brand_id", brand_id, this);
    });

    //update section active/inactive status
    $(document).on("click", ".updateSectionStatus", function () {
        var section_id = $(this).attr("section_id");
        updateStatus("/admin/update-section-status", "section", "section_id", section_id, this);
    });

    //update categories active/inactive status
    $(document).on("click", ".updateCategoryStatus", function () {
        var category_id = $(this).attr("category_id");
        updateStatus("/admin/update-category-status", "category", "category_id", category_id, this);
    });

    // Reusable function to update active/inactive status
    function updateStatus(updateUrl,idType, dataKey, dataValue, element) {
        var status = $(element).children("i").attr("status");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url: updateUrl,
            data: {
                status: status,
                [dataKey]: dataValue, // Dynamic ID key (admin_id, section_id, etc.)
            },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#" + idType + "-" + dataValue).html(
                        "<i style='font-size: x-large' class='mdi mdi-bookmark-outline' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#" + idType + "-" + dataValue).html(
                        "<i style='font-size: x-large' class='mdi mdi-bookmark-check' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("Error updating status");
            },
        });
    }

});
