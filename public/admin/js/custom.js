$(document).ready(function(){
    //check Admin Password is correct or not
    $('#current_password').keyup(function(){
        var current_password = $('#current_password').val();
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url : 'check-admin-password',
            data : {current_password: current_password},
            success: function(resp){
                if(resp == "false"){
                    $('#check_password').html("<font color='red'>Current Password is Incorrent!</font>");
                }else if(resp == "true"){
                    $('#check_password').html("<font color='green'>Current Password is Corrent! </font>")
                }
            },error :function(){
                alert('Error');
            }
        });
    })

    //update Admin status
    $(document).on("click", ".updateAdminStatus", function () {
        var status = $(this).children("i").attr("status");
        var admin_id = $(this).attr("admin_id");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: 'POST',
            url: '/admin/update-admin-status',
            data: {
                status: status,
                admin_id: admin_id,
            },
            success: function (resp) {
                if(resp['status'] == 0){
                    $("#admin-"+admin_id).html("<i style='font-size: x-large' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status'] == 1){
                    $("#admin-"+admin_id).html("<i style='font-size: x-large' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });
})