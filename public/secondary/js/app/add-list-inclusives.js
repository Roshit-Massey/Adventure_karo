var error = false;

var clearInclusiveErrors = function(){
    $('#error-title').text('');
    error = false;
}

var clearInclusiveFields  = function(){
    $('#title').val('');
    $('#add-button').text('Add').attr('onclick', 'addInclusive();');
    $('#add-edit-text').text('Add Inclusive');
    $('#cancel-button').hide();
}

var validateInclusive = function(id){
    clearInclusiveErrors();
    var data = new Object(); 
    if(id != undefined) data.id = id;
    data.title = $('#title').val();
    if(data.title.length == 0){
        $('#error-title').text('Please enter a title');
        error = true;
    }
    return data;
}

var addInclusive = function(){
    var data = validateInclusive();
    !error && api.inclusive.post(data, function(success){
        if(success && success.success){
            swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
            clearInclusiveFields();
            load();
        }
    }, function(error){
        if(error && error.responseJSON)
            swal({ title: "", type: "warning", text: error.responseJSON.msg ,showConfirmButton: false });
    })
}

var editInclusive = function(id){
    clearInclusiveErrors();
    api.inclusive.show({ id:id }, function(success){
        if(success && success.success){
            $('#title').val(success.data.title);
            $('#add-button').text('Update').attr('onclick', 'updateInclusive(\''+id+'\');');
            $('#add-edit-text').text('Edit Inclusive');
            $('#cancel-button').show();
        }
    })
}

var updateInclusive = function(id){
    var data = validateInclusive(id);
    !error && api.inclusive.patch(data, function(success){
        if(success && success.success){
            swal({ title: "", type: "success", text: success.msg ,showConfirmButton: false,timer: 2000 });
            clearInclusiveFields();
            load();
        }
    }, function(error){
        if(error && error.responseJSON)
            swal({ title: "", type: "warning", text: error.responseJSON.msg ,showConfirmButton: false });
    })
}

var deleteInclusive = function(id){
    swal({ title: "Are you sure?", text: "Once deleted, you will not be able to recover this inclusive!", icon: "warning", buttons: true, dangerMode: true })
    .then((willDelete) => {
        if(willDelete) {
            api.inclusive.delete({id:id}, function(success){
                if(success && success.success){
                    swal("Poof! Inclusive has been deleted!", { icon: "success" });
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
            url: "/api/all-inclusives",
            dataType: "json",
            type: "get",
            data: undefined,
        },
    });
}

$(document).ready(function(){
    load();
});