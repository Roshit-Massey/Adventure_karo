var error = false;

var clearExclusiveErrors = function(){
    $('#error-title').text('');
    error = false;
}

var clearExclusiveFields  = function(){
    $('#title').val('');
    $('#add-button').text('Add').attr('onclick', 'addExclusive();');
    $('#add-edit-text').text('Add Exclusive');
    $('#cancel-button').hide();
}

var validateExclusive = function(id){
    clearExclusiveErrors();
    var data = new Object(); 
    if(id != undefined) data.id = id;
    data.title = $('#title').val();
    if(data.title.length == 0){
        $('#error-title').text('Please enter a title');
        error = true;
    }
    return data;
}

var addExclusive = function(){
    var data = validateExclusive();
    !error && api.exclusive.post(data, function(success){
        if(success && success.success){
            swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
            clearExclusiveFields();
            load();
        }
    },function(error){
        if(error && error.responseJSON)
            swal({ title: "", type: "warning", text: error.responseJSON.msg ,showConfirmButton: false });
    })
}

var editExclusive = function(id){
    clearExclusiveErrors();
    api.exclusive.show({ id:id }, function(success){
        if(success && success.success){
            $('#title').val(success.data.title);
            $('#add-button').text('Update').attr('onclick', 'updateExclusive(\''+id+'\');');
            $('#add-edit-text').text('Edit Exclusive');
            $('#cancel-button').show();
        }
    })
}

var updateExclusive = function(id){
    var data = validateExclusive(id);
    !error && api.exclusive.patch(data, function(success){
        if(success && success.success){
            swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
            clearExclusiveFields();
            load();
        }
    }, function(error){
        if(error && error.responseJSON)
            swal({ title: "", type: "warning", text: error.responseJSON.msg ,showConfirmButton: false });
    })
}

var deleteExclusive = function(id){
    swal({ title: "Are you sure?", text: "Once deleted, you will not be able to recover this exclusive!", icon: "warning", buttons: true, dangerMode: true })
    .then((willDelete) => {
        if(willDelete) {
            api.exclusive.delete({id:id}, function(success){
                if(success && success.success){
                    swal("Poof! Exclusive has been deleted!", { icon: "success" });
                    load();
                }
            })
        }
    });
}

var load = function(){
    $("#datatable").DataTable({
        "pageLength": 25,
        "processing": true,
        "serverSide": true,
        "stateDuration": 0,
        "destroy": true,
        "autoWidth": true,
        "columnDefs": [ { "orderable": false, "targets": 0 }, { "orderable": false, "targets": 4 } ],
        "order": [[1, "desc"], [2, "desc"], [3, "desc"]],
        "colReorder": true,
        "ajax": {
            url: "/api/all-exclusives",
            dataType: "json",
            type: "get",
            data: undefined,
        },
    });
}

$(document).ready(function(){
    load();
});