var deleteExperience = function(id){
    swal({ title: "Are you sure?", text: "Once deleted, you will not be able to recover this experience!", icon: "warning", buttons: true, dangerMode: true })
    .then((willDelete) => {
        if(willDelete) {
            api.experience.delete({id:id}, function(success){
                if(success && success.success){
                    swal("Poof! Experience has been deleted!", { icon: "success" });
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
        "columnDefs": [ { "orderable": false, "targets": 0 }, { "orderable": false, "targets": 2 },{ "orderable": false, "targets": 3 }, { "orderable": false, "targets": 4 }, { "orderable": false, "targets": 5 }, { "orderable": false, "targets": 8 } ],
        "order": [[1, "desc"], [6, "desc"], [7, "desc"]],
        "colReorder": true,
        "ajax": {
            url: "/api/all-experiences",
            dataType: "json",
            type: "get",
            data: undefined,
        },
    });
}

$(document).ready(function(){
    load();
});