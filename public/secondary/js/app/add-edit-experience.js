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

var clearExperienceErrors = function(){
    $('#error-title').text('');
    $('#error-info').text('');
    $('#error-details').text('');
    $('#image-error').text('');
    $('#error-country').text('');
    $('#error-state').text('');
    $('#error-city').text('');
    error = false;
}

var validateExperience = function(){
    clearExperienceErrors();
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

    var country_id = $('#countries').val();
    if(country_id.length == 0){
        $('#error-country').text('Please enter a country');
        error = true;
    }
    data.append('country_id', country_id);

    var state_id = $('#states').val();
    if(state_id.length == 0){
        $('#error-state').text('Please enter a state');
        error = true;
    }
    data.append('state_id', state_id);

    var city_id = $('#cities').val();
    if(city_id.length == 0){
        $('#error-city').text('Please enter a city');
        error = true;
    }
    data.append('city_id', city_id);

    if(id != 0){ 
        if($('input[name=experienceimage]').prop('files').length > 0){
            // var img = $('input[name=experienceimage]').prop('files')[0].name;
            // var file = urltoFile(base64data,img);
            // data.append('image', file);
            var fileArr = $('input[name=experienceimage]').prop('files');
            for(var i=0;i<fileArr.length;i++){
                data.append("image[]", fileArr[i], fileArr[i]['name']);
            }
        }
    }else {
        if ($('input[name=experienceimage]').prop('files').length == 0) {
            $('#image-error').text('Please choose a experience image');
            error = true;
        }else {
            // var img = $('input[name=experienceimage]').prop('files')[0].name;
            // var file = urltoFile(base64data,img);
            // data.append('image', file);
            var fileArr = $('input[name=experienceimage]').prop('files');
            for(var i=0;i<fileArr.length;i++){
                data.append("image[]", fileArr[i], fileArr[i]['name']);
            }
        }
    }
    return data;
}

var addAndUpdateExperience = function(){
    var data = validateExperience();
    if(id == 0){
        !error && api.experience.post(data, function(success){
            if(success && success.success){
                swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
                setTimeout(function() {
                    window.location.href = "/v1/experiences";       
                }, 2000);
            }
        })
    }else {
        data.append('id', id);
        !error && api.experience.patch(data, function(success){
            if(success && success.success){
                swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
                load();
            }
        })
    }
}

var clearExperienceFields  = function(){
    $('#title').val('');
    $('#elm1').val('');
    $('#elm2').val('');
    $('#experience_images').html('');
    // $('#output').attr('src', '');
    $('.bootstrap-filestyle').find('input').attr('placeholder', "Choose Files")
    // $('#h2-add-magazine').removeClass('img_show_upload');
    $('#add-button').text('Add');
}

var setExperienceImage = function(data){
    $('#experience_images').append('<div class="col-md-3"> <div class="mb-3"> <img src="/images/experience/logo/'+data.image+'" style="width:100px;"/> </div> <label class="mb-1">'+data.original_image_name+'  <a href="javascript:void(0);" onclick="deleteExperienceImage('+data.id+');" title="Delete" style="color: #dc3545;"><i class="fas fa-trash-alt"></i></a></label> </div>');
}

var deleteExperienceImage = function(id){
    swal({ title: "Are you sure?", text: "Once deleted, you will not be able to recover this experience image!", icon: "warning", buttons: true, dangerMode: true })
    .then((willDelete) => {
        if(willDelete) {
            api.experience.image({id:id}, function(success){
                if(success && success.success){
                    swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
                    load();
                }
            })
        }
    });
}

var load = function(){
    api.experience.show({id:id}, function(success){
        if(success && success.success){
            clearExperienceFields();
            $('#title').val(success.data.title);
            $('#elm1').val(success.data.info);
            $('#elm2').val(success.data.details);
            countries(success.data.country_id);
            states(success.data.country_id, success.data.state_id);
            city(success.data.state_id, success.data.city_id);
            $('#add-button').text('Update');
            if(success.data.experience_images && success.data.experience_images.length > 0){
                success.data.experience_images.forEach(experience => {
                    setExperienceImage(experience);
                });
            }
            // $('#output').attr('src', '/images/experience/logo/'+success.data.image);
            // $('.bootstrap-filestyle').find('input').attr('placeholder', success.data.original_image_name)
            // $('#h2-add-magazine').addClass('img_show_upload');

        }
    })
}

var countries = function(countryId){
    api.CSC.countries(undefined, function(success){
        if(success && success.success){
            $('#countries').html('<option value="">Select Country</option>');
            success.data.forEach(function(country) {
                $('#countries').append('<option value="'+country.id+'" '+(countryId != undefined && countryId == country.id ? "selected": "")+'>'+country.name+'</option>');
            });
        }
    })
}

var states = function(id, stateId){
    api.CSC.states({country_id: id}, function(success){
        if(success && success.success){
            $('#states').html('<option value="">Select State</option>');
            success.data.forEach(function(state) {
                $('#states').append('<option value="'+state.id+'" '+(stateId != undefined && stateId == state.id ? "selected": "")+'>'+state.name+'</option>');
            });
        }
    })
}

var city = function(id, cityId){
    api.CSC.cities({state_id: id}, function(success){
        if(success && success.success){
            $('#cities').html('<option value="">Select City</option>');
            success.data.forEach(function(city) {
                $('#cities').append('<option value="'+city.id+'" '+(cityId != undefined && cityId == city.id ? "selected": "")+'>'+city.name+'</option>');
            });
        }
    })
}

$(document).ready(function(){
    if(id != 0) load();
    else{
        countries();
        $('.bootstrap-filestyle').find('input').attr('placeholder', "Choose Files")
    } 
    
})

