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
})