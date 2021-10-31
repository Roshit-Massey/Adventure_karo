var error = false;

var clearAvtivityErrors = function(){
    $('#error-activity').text('');
    $('#error-inclusives').text('');
    $('#error-exclusives').text('');
    $('#error-info').text('');
    $('#error-days').text('');
    $('#error-start-time').text('');
    $('#error-end-time').text('');
    $('#image-error').text('');
    error = false;
}

var validateActivity = function(){
    clearAvtivityErrors();
    var data = new FormData(); 
    var activity = $('#activity').val();
    if(activity.length == 0){
        $('#error-activity').text('Please select a activity');
        error = true;
    }
    data.append('activity_id', activity);

    var info = tinyMCE.get('elm1').getContent();
    if(info.length == 0){
        $('#error-info').text('Please enter a infomation');
        error = true;
    }
    data.append('info', info);
    var inclusives = $('#inclusives').val();
    if(inclusives.length == 0){
        $('#error-inclusives').text('Please select a inclusives');
        error = true;
    }
    data.append('inclusives', JSON.stringify(inclusives));

    var exclusives = $('#exclusives').val();
    if(exclusives.length == 0){
        $('#error-exclusives').text('Please select a exclusives');
        error = true;
    }
    data.append('exclusives', JSON.stringify(exclusives));

    var days = $('.weekday:checkbox:checked').map(function() {
        return this.value;
    }).get();
    if(days.length == 0){
        $('#error-days').text('Please select a days');
        error = true;
    }
    days = days.join(",")
    data.append('days', JSON.stringify(days));

    var startTime = $('#start-time').val();
    if(startTime.length == 0){
        $('#error-start-time').text('Please enter a start time');
        error = true;
    }
    data.append('start_time', startTime);

    var endTime = $('#end-time').val();
    if(endTime.length == 0){
        $('#error-end-time').text('Please enter a end time');
        error = true;
    }
    data.append('end_time', endTime);

    if(id != 0){ 
        if($('input[name=activityimage]').prop('files').length > 0){
            var fileArr = $('input[name=activityimage]').prop('files');
            for(var i=0;i<fileArr.length;i++){
                data.append("image[]", fileArr[i], fileArr[i]['name']);
            }
        }
    }else {
        if ($('input[name=activityimage]').prop('files').length == 0) {
            $('#image-error').text('Please choose a activity image');
            error = true;
        }else {
            var fileArr = $('input[name=activityimage]').prop('files');
            for(var i=0;i<fileArr.length;i++){
                data.append("image[]", fileArr[i], fileArr[i]['name']);
            }
        }
    }
    return data;
}

var addAndUpdateActivity = function(){
    var data = validateActivity();
    if(id == 0){
        !error && api.v_activity.post(data, function(success){
            if(success && success.success){
                swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
                setTimeout(function() {
                    window.location.href = "/v2/activities";       
                }, 2000);
            }
        })
    }else {
        data.append('id', id);
        !error && api.v_activity.patch(data, function(success){
            if(success && success.success){
                swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
                load();
            }
        })
    }
}

var clearActivityFields  = function(){
    $('#activity').val('');
    $('#inclusives').val('');
    $('#exclusives').val('');
    $('#elm1').val('');
    $('#start-time').val('');
    $('#end-time').val('');
    $('#activity_images').html('');
    $('.bootstrap-filestyle').find('input').attr('placeholder', "Choose Files")
    $('#add-button').text('Add');
}

var setActivityImage = function(data){
    $('#activity_images').append('<div class="col-md-3"> <div class="mb-3"> <img src="/images/activity/logo/'+data.image+'" style="width:100px;"/> </div> <label class="mb-1">'+data.original_image_name+'  <a href="javascript:void(0);" onclick="deleteActivityImage('+data.id+');" title="Delete" style="color: #dc3545;"><i class="fas fa-trash-alt"></i></a></label> </div>');
}

var deleteActivityImage = function(id){
    swal({ title: "Are you sure?", text: "Once deleted, you will not be able to recover this activity image!", icon: "warning", buttons: true, dangerMode: true })
    .then((willDelete) => {
        if(willDelete) {
            api.v_activity.image({id:id}, function(success){
                if(success && success.success){
                    swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
                    load();
                }
            })
        }
    });
}

var load = function(){
    api.v_activity.show({id:id}, function(success){
        if(success && success.success){
            clearActivityFields();
            $('#activity').val(success.data.activity_id);
            if(success.data.days){
                var days = JSON.parse(success.data.days).split(",");
                for(let i = 0; i < days.length; i++) $('#weekday-'+days[i].toLowerCase()).prop('checked', true);
            }
            if(success.data.inclusives){
                var inclusives = JSON.parse(success.data.inclusives);
                $.each(inclusives, function(i,e){
                    $("#inclusives option[value='" + e + "']").prop("selected", true);
                });
            }
            if(success.data.exclusives){
                var exclusives = JSON.parse(success.data.exclusives);
                $.each(exclusives, function(i,e){
                    $("#exclusives option[value='" + e + "']").prop("selected", true);
                });
            }
            $('.selectpicker').selectpicker('refresh');
            $('#start-time').val(success.data.start_time);
            $('#end-time').val(success.data.end_time);
            $('#elm1').val(success.data.info);
            $('#add-button').text('Update');
            if(success.data.vendor_activity_images && success.data.vendor_activity_images.length > 0){
                success.data.vendor_activity_images.forEach(activity => {
                    setActivityImage(activity);
                });
            }
        }
    })
}

$(document).ready(function(){
    if(id != 0) load();
    $('.bootstrap-filestyle').find('input').attr('placeholder', "Choose Files");
    $("#inclusives").selectpicker({ noneSelectedText : 'Select Inclusives' });
    $("#exclusives").selectpicker({ noneSelectedText : 'Select Exclusives' });
})

