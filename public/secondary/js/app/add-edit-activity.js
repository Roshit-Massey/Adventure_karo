var error = false;
var reader;
var bs_modal = $('.bs-example-modal-lg');
var image = document.getElementById('image');
var cropper,reader,file;
var base64data;

//Start Image Choose and Crop Section
var done = function(url) {
    image.src = url;
    bs_modal.modal('show');
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var filename = input.files[0].name;
        ext = filename.split('.').pop().toLowerCase();
        if (ext == 'png' || ext == 'jpeg' || ext == 'jpg' || ext == 'gif') {
            $('.bootstrap-filestyle').find('input').attr('placeholder', filename)
            // $(input).next('label').text(filename);
            let filesize = (input.files[0].size / 1024 / 1024);
            if (filesize > 2) {
                $('#filePhoto').val('');
                $(input).next('label').text('Choose file');
                $('#image-error').text('Maximum file upto 2MB size.');
            }else {
                var files = input.files[0];
                if (URL) {
                    done(URL.createObjectURL(files));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files);
                }
            }
        } else {
            $('#filePhoto').val('');
            $('#image-error').text('Please choose jpeg, jpg and png file format');
            $('.bootstrap-filestyle').find('input').attr('placeholder', "Choose File")
        }
    }
}


bs_modal.on('shown.bs.modal', function() {
    cropper = new Cropper(image, {
        aspectRatio: 70/45,
        minContainerHeight:300,
        // viewMode: 3,
        preview: '.crop_preview'
    });
}).on('hidden.bs.modal', function() {
    cropper.destroy();
    cropper = null;
});

$("#crop").click(function() {
    canvas = cropper.getCroppedCanvas({
        width: 700,
        height: 450,
        imageSmoothingQuality: 'high'
    });

    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
            base64data = reader.result;
            bs_modal.modal('hide');
            swal({ title: "", type: "success", text: "Your file has been successfully cropped",showConfirmButton: false,timer: 1500 })
            $('#output').attr('src', base64data);
            $('#h2-add-magazine').addClass('img_show_upload');
        };
    });
});
    
function urltoFile(dataurl, filename) {
    var arr = dataurl.split(','),
    mime = arr[0].match(/:(.*?);/)[1],
    bstr = atob(arr[1]), 
    n = bstr.length, 
    u8arr = new Uint8Array(n);   
    while(n--){
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new File([u8arr], filename, {type:mime});
}

function cancelPopup(){
    $('#filePhoto').val('');
    $('.bootstrap-filestyle').find('input').attr('placeholder', "Choose File")
}

// $("#filePhoto").change(function () {
//     readURL(this);
// });
//End Image Choose and Crop Section

var clearAvtivityErrors = function(){
    $('#error-title').text('');
    $('#error-info').text('');
    $('#error-details').text('');
    $('#image-error').text('');
    error = false;
}

var validateActivity = function(){
    clearAvtivityErrors();
    var data = new FormData(); 
    var title = $('#title').val();
    if(title.length == 0){
        $('#error-title').text('Please enter a title');
        error = true;
    }
    data.append('title', title);

    var info = tinyMCE.get('elm1').getContent();
    if(info.length == 0){
        $('#error-info').text('Please enter a infomation');
        error = true;
    }
    data.append('info', info);

    var details = tinyMCE.get('elm2').getContent();
    if(details.length == 0){
        $('#error-details').text('Please enter a details');
        error = true;
    }
    data.append('details', details);

    if(id != 0){ 
        if($('input[name=activityimage]').prop('files').length > 0){
            // var img = $('input[name=activityimage]').prop('files')[0].name;
            // var file = urltoFile(base64data,img);
            // data.append('image', file);
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
            // var img = $('input[name=activityimage]').prop('files')[0].name;
            // var file = urltoFile(base64data,img);
            // data.append('image', file);
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
        !error && api.activity.post(data, function(success){
            if(success && success.success){
                swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
                setTimeout(function() {
                    window.location.href = "/v1/activities";       
                }, 2000);
            }
        })
    }else {
        data.append('id', id);
        !error && api.activity.patch(data, function(success){
            if(success && success.success){
                swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
                load();
            }
        })
    }
}

var clearActivityFields  = function(){
    $('#title').val('');
    $('#elm1').val('');
    $('#elm2').val('');
    $('#activity_images').html('');
    // $('#output').attr('src', '');
    $('.bootstrap-filestyle').find('input').attr('placeholder', "Choose Files")
    // $('#h2-add-magazine').removeClass('img_show_upload');
    $('#add-button').text('Add');
}

var setActivityImage = function(data){
    $('#activity_images').append('<div class="col-md-3"> <div class="mb-3"> <img src="/images/activity/logo/'+data.image+'" style="width:100px;"/> </div> <label class="mb-1">'+data.original_image_name+'  <a href="javascript:void(0);" onclick="deleteActivityImage('+data.id+');" title="Delete" style="color: #dc3545;"><i class="fas fa-trash-alt"></i></a></label> </div>');
}

var deleteActivityImage = function(id){
    swal({ title: "Are you sure?", text: "Once deleted, you will not be able to recover this activity image!", icon: "warning", buttons: true, dangerMode: true })
    .then((willDelete) => {
        if(willDelete) {
            api.activity.image({id:id}, function(success){
                if(success && success.success){
                    swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
                    load();
                }
            })
        }
    });
}

var load = function(){
    api.activity.show({id:id}, function(success){
        if(success && success.success){
            clearActivityFields();
            $('#title').val(success.data.title);
            $('#elm1').val(success.data.info);
            $('#elm2').val(success.data.details);
            $('#add-button').text('Update');
            if(success.data.activity_images && success.data.activity_images.length > 0){
                success.data.activity_images.forEach(activity => {
                    setActivityImage(activity);
                });
            }
            // $('#output').attr('src', '/images/activity/logo/'+success.data.image);
            // $('.bootstrap-filestyle').find('input').attr('placeholder', success.data.original_image_name)
            // $('#h2-add-magazine').addClass('img_show_upload');
        }
    })
}

$(document).ready(function(){
    if(id != 0) load();
    $('.bootstrap-filestyle').find('input').attr('placeholder', "Choose Files")
})

