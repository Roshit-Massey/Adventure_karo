var error = false;

var clearLoginErrors = function(){
    $('#error-email').text('');
    $('#error-password').text('');
    $('#error-login').text('');
    error = false;
}

var validateLogin = function(){
    clearLoginErrors();
    var data = new Object();
    data.email = $('#email').val();
    if(data.email.length == 0){
        error = true;
        $('#error-email').text('Please enter email');
    }else if(!validateEmail(data.email)){
        error = true;
        $('#error-email').text('Please enter a valid email');
    }
    data.password = $('#password').val();
    if(data.password.length == 0){
        error = true;
        $('#error-password').text('Please enter password');
    }
    return data;
}

var signIn = function(){
    var data = validateLogin();
    if(!error){
        $.ajax({
            url: "/api/login",
            async: true,
            method: "post",
            data: data != undefined ? JSON.stringify(data) : '',
            dataType: "json",
            contentType: "application/json",
            success: function (success) {
                window.location.href = '/v1';
            },
            error: function (jqXHR) {
                if(jqXHR && jqXHR.responseJSON){
                    $('#error-login').text(jqXHR.responseJSON.msg);
                }
            }
        })
    }
}