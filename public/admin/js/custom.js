$(document).ready(function () {
    // call datatable class
    $('#sections').DataTable();
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

    //update Section status
    $(document).on("click", ".updateSectionStatus", function () {
        var status = $(this).children("i").attr("status");
        var section_id = $(this).attr("section_id");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url: "/admin/update-section-status",
            data: {
                status: status,
                section_id: section_id,
            },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#section-" + section_id).html(
                        "<i style='font-size: x-large' class='mdi mdi-bookmark-outline' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#section-" + section_id).html(
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

});
