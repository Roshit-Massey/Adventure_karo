var error = false;

var clearAvtivityErrors = function(){
    $('#error-title').text('');
    $('#error-info').text('');
    $('#error-details').text('');
    error = false;
}

var validateActivity = function(){
    clearAvtivityErrors();
    var data = new Object(); 
    data.title = $('#title').val();
    if(data.title.length == 0){
        $('#error-title').text('Please enter a title');
        error = true;
    }

    data.info = tinyMCE.get('elm1').getContent();
    if(data.info.length == 0){
        $('#error-info').text('Please enter a infomation');
        error = true;
    }

    data.details = tinyMCE.get('elm2').getContent();
    if(data.details.length == 0){
        $('#error-details').text('Please enter a details');
        error = true;
    }
    return data;
}

var addAndUpdateActivity = function(type){
    var data = validateActivity();
    if(id == 0){
        !error && api.activity.post(data, function(success){
            if(success && success.success){
                swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
                setTimeout(function() {
                    window.location.href = "/v1/activities";       
                }, 2000);
            }
        })
    }else {
        data.id = id;
        !error && api.activity.patch(data, function(success){
            if(success && success.success)
                swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
        })
    }
}

var clearActivityFields  = function(){
    $('#title').val('');
    $('#elm1').val('');
    $('#elm2').val('');
    $('#add-button').text('Add');
}

var load = function(){
    api.activity.show({id:id}, function(success){
        if(success && success.success){
            clearActivityFields();
            $('#title').val(success.data.title);
            $('#elm1').val(success.data.info);
            $('#elm2').val(success.data.details);
            $('#add-button').text('Update');
        }
    })
}

$(document).ready(function(){
    if(id != 0) load();
})

