var error = false;
var errorCompany = false;
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
            $('#image-error').text('Ehoose jpeg, jpg and png file format');
            $('.bootstrap-filestyle').find('input').attr('placeholder', "Choose File")
        }
    }
}

$("#filePhoto").change(function () {
    readURL(this);
});

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

$("#filePhoto").change(function () {
    readURL(this);
});
//End Image Choose and Crop Section

var clearVendorErrors = function(){
    $('#error-first-name').text('');
    $('#error-first-name').text('');
    $('#error-email').text('');
    $('#error-phone').text('');
    $('#image-error').text('');
    error = false;
}

var validateVendor = function(){
    clearVendorErrors();
    var data = new FormData(); 
    var first_name = $('#first_name').val();
    if(first_name.length == 0){
        $('#error-first-name').text('Enter a first name');
        error = true;
    }
    data.append('first_name', first_name);

    var last_name = $('#last_name').val();
    if(last_name.length == 0){
        $('#error-last-name').text('Enter a last name');
        error = true;
    }
    data.append('last_name', last_name);

    var email = $('#email').val();
    if(email.length == 0){
        $('#error-email').text('Enter a email');
        error = true;
    }else if(!validateEmail(email)){
        $('#error-email').text('Enter a valid email');
        error = true;
    }
    data.append('email', email);

    var phone = $('#phone').val();
    if(phone.length == 0){
        $('#error-phone').text('Enter a phone');
        error = true;
    }
    data.append('phone', phone);

    if(id != 0){ 
        if($('input[name=vendorimage]').prop('files')[0]){
            var img = $('input[name=vendorimage]').prop('files')[0].name;
            var file = urltoFile(base64data,img);
            data.append('image', file);
        }
    }else {
        if (!$('input[name=vendorimage]').prop('files')[0]) {
            $('#image-error').text('Choose a profile image');
            error = true;
        }else {
            var img = $('input[name=vendorimage]').prop('files')[0].name;
            var file = urltoFile(base64data,img);
            data.append('image', file);
        }
    }
    return data;
}

var addAndUpdateVendor = function(){
    var data = validateVendor();
    if(id == 0){
        !error && api.vendor.post(data, function(success){
            if(success && success.success){
                swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 1000 });
                setTimeout(function() {
                    window.location.href = "/v1/vendor/"+success.id;       
                }, 1000);
            }
        })
    }else {
        data.append('id', id);
        !error && api.vendor.patch(data, function(success){
            if(success && success.success)
                swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
        })
    }
}

var clearVendorFields  = function(){
    $('#first_name').val('');
    $('#last_name').val('');
    $('#email').val('');
    $('#phone').val('');
    $('#output').attr('src', '');
    $('#company_name').val('');
    $('#legal_company_name').val('');
    $('#company_website').val('');
    $('#contact_number').val('');
    $('textarea#registered_address').val('');
    $('textarea#registered_address_2').val('');
    $('#postal_code').val('');
    $('#bank_name').val('');
    $('#acc_no').val('');
    $('#acc_holder_name').val('');
    $('#ifsc').val('');
    $('#hear_about_us').val('');
    $('#terms_condition').val('');
    $('.bootstrap-filestyle').find('input').attr('placeholder', "Choose File")
    $('#h2-add-magazine').removeClass('img_show_upload');
    $('#add-button').text('Add'); 
    $('#add-button-company').text('Add');
    $('#company_information').hide();
    $('#verifiedOrNot').hide().removeClass('btn-success').addClass('btn-warning').text('Unverified').attr('data-id', 0);
}

var load = function(){
    api.vendor.show({id:id}, function(success){
        if(success && success.success){
            clearVendorFields();
            $('#first_name').val(success.data.first_name);
            $('#last_name').val(success.data.last_name);
            $('#email').val(success.data.email);
            $('#phone').val(success.data.phone);
            $('#output').attr('src', '/images/vendor/profile/'+success.data.profile_image);
            $('.bootstrap-filestyle').find('input').attr('placeholder', success.data.original_image_name)
            $('#h2-add-magazine').addClass('img_show_upload');
            $('#add-button').text('Update');
            $('#verifiedOrNot').show();
            if(success.data.is_verify)
                $('#verifiedOrNot').addClass('btn-success').removeClass('btn-warning').text('Verified').attr('data-id', 1);
            $('#company_information').show();
            
            if(success.data.company_information != null){
                $('#company_id').val(success.data.company_information.id);
                $('#company_name').val(success.data.company_information.company_name);
                $('#legal_company_name').val(success.data.company_information.legal_company_name);
                $('#company_website').val(success.data.company_information.company_website);
                $('#contact_number').val(success.data.company_information.contact_number);
                $('textarea#registered_address').val(success.data.company_information.registered_address);
                $('textarea#registered_address_2').val(success.data.company_information.registered_address_2);
                $('#postal_code').val(success.data.company_information.postal_code);
                $('#bank_name').val(success.data.company_information.bank_name);
                $('#acc_no').val(success.data.company_information.acc_no);
                $('#acc_holder_name').val(success.data.company_information.acc_holder_name);
                $('#ifsc').val(success.data.company_information.ifsc);
                $('#hear_about_us').val(success.data.company_information.hear_about_us);
                $('#terms_condition').val(success.data.company_information.terms_condition);
                countries(success.data.company_information.country_id);
                states(success.data.company_information.country_id, success.data.company_information.state_id);
                city(success.data.company_information.state_id, success.data.company_information.city);
                $('#add-button-company').text('Update');
            }else {
                countries();
            }
        }
    })
}

var verifiedOrUnverified = function(){
    var goingToUpdateStatus = $('#verifiedOrNot').attr('data-id');
    api.vendor.verify({id: id, status:goingToUpdateStatus}, function(success){
        if(success && success.success){
            swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
            if(goingToUpdateStatus == 0)
                $('#verifiedOrNot').addClass('btn-success').removeClass('btn-warning').text('Verified').attr('data-id', 1);
            else $('#verifiedOrNot').removeClass('btn-success').addClass('btn-warning').text('Unverified').attr('data-id', 0);
        }
    })
}


var clearVendorCompanyErrors = function(){
    $('#error-company-name').text('');
    $('#error-legal-company-name').text('');
    $('#error-company-website').text('');
    $('#error-contact-number').text('');
    $('#error-registered-address').text('');
    $('#error-country-id').text('');
    $('#error-state-id').text('');
    $('#error-city').text('');
    $('#error-postal-code').text('');
    $('#error-bank-name').text('');
    $('#error-acc-no').text('');
    $('#error-acc-holder-name').text('');
    $('#error-ifsc').text('');
    errorCompany = false;
}

var validateCompanyVendor = function(){
    clearVendorCompanyErrors();
    var data = new Object(); 
    data.vendor_id = id;
    data.company_name = $('#company_name').val();
    if(data.company_name.length == 0){
        $('#error-company-name').text('Enter a company name');
        errorCompany = true;
    }

    data.legal_company_name = $('#legal_company_name').val();
    if(data.legal_company_name.length == 0){
        $('#error-legal-company-name').text('Enter a legal company name');
        errorCompany = true;
    }

    data.company_website = $('#company_website').val();
    if(data.company_website.length == 0){
        $('#error-company-website').text('Enter a company website');
        errorCompany = true;
    }

    data.contact_number = $('#contact_number').val();
    if(data.contact_number.length == 0){
        $('#error-contact-number').text('Enter a contact number');
        errorCompany = true;
    }

    data.registered_address = $('textarea#registered_address').val();
    if(data.registered_address.length == 0){
        $('#error-registered-address').text('Enter a registered address');
        errorCompany = true;
    }

    data.registered_address_2 = $('#registered_address_2').val();

    data.country_id = $('#country_id').val();
    if(data.country_id.length == 0){
        $('#error-country-id').text('Enter a country');
        errorCompany = true;
    }

    data.state_id = $('#state_id').val();
    if(data.state_id.length == 0){
        $('#error-state-id').text('Enter a state');
        errorCompany = true;
    }

    data.city = $('#city').val();
    if(data.company_name.length == 0){
        $('#error-city').text('Enter a city');
        errorCompany = true;
    }

    data.postal_code = $('#postal_code').val();
    if(data.postal_code.length == 0){
        $('#error-postal-code').text('Enter a postal code');
        errorCompany = true;
    }

    data.bank_name = $('#bank_name').val();
    if(data.bank_name.length == 0){
        $('#error-bank-name').text('Enter a bank name');
        errorCompany = true;
    }

    data.acc_no = $('#acc_no').val();
    if(data.acc_no.length == 0){
        $('#error-acc-no').text('Enter a account no');
        errorCompany = true;
    }

    data.acc_holder_name = $('#acc_holder_name').val();
    if(data.acc_holder_name.length == 0){
        $('#error-acc-holder-name').text('Enter a A/c holder name');
        errorCompany = true;
    }
    
    data.ifsc = $('#ifsc').val();
    if(data.ifsc.length == 0){
        $('#error-ifsc').text('Enter a IFSC code');
        errorCompany = true;
    }

    data.hear_about_us = $('#hear_about_us').val();
    data.terms_condition = $('#terms_condition').val();

    return data;
}

var addAndUpdateVendorCompany = function(){
    var data = validateCompanyVendor();
    data.id = $('#company_id').val();
    if(data.id == ""){
        !errorCompany && api.vendor.add(data, function(success){
            if(success && success.success){
                swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 1000 });
            }
        })
    }else {
        !errorCompany && api.vendor.update(data, function(success){
            if(success && success.success)
                swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
        })
    }
}

var countries = function(countryId){
    api.CSC.countries(undefined, function(success){
        if(success && success.success){
            $('#country_id').html('<option value="">Select Country</option>');
            success.data.forEach(function(country) {
                $('#country_id').append('<option value="'+country.id+'" '+(countryId != undefined && countryId == country.id ? "selected": "")+'>'+country.name+'</option>');
            });
        }
    })
}

var states = function(id, stateId){
    api.CSC.states({country_id: id}, function(success){
        if(success && success.success){
            $('#state_id').html('<option value="">Select State</option>');
            success.data.forEach(function(state) {
                $('#state_id').append('<option value="'+state.id+'" '+(stateId != undefined && stateId == state.id ? "selected": "")+'>'+state.name+'</option>');
            });
        }
    })
}

var city = function(id, cityId){
    api.CSC.cities({state_id: id}, function(success){
        if(success && success.success){
            $('#city').html('<option value="">Select City</option>');
            success.data.forEach(function(city) {
                $('#city').append('<option value="'+city.name+'" '+(cityId != undefined && cityId == city.name ? "selected": "")+'>'+city.name+'</option>');
            });
        }
    })
}

$(document).ready(function(){
    if(id != 0) load();
    $('.bootstrap-filestyle').find('input').attr('placeholder', "Choose File")
})

