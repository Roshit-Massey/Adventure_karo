var deleteActivity = function(id){
    swal({ title: "Are you sure?", text: "Once deleted, you will not be able to recover this activity!", icon: "warning", buttons: true, dangerMode: true })
    .then((willDelete) => {
        if(willDelete) {
            api.activity.delete({id:id}, function(success){
                if(success && success.success){
                    swal("Poof! Activity has been deleted!", { icon: "success" });
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
        "columnDefs": [ { "orderable": false, "targets": 0 }, { "orderable": false, "targets": 1 }, { "orderable": false, "targets": 3 }, { "orderable": false, "targets": 6 } ],
        "order": [[2, "desc"], [4, "desc"], [5, "desc"]],
        "colReorder": true,
        "ajax": {
            url: "/api/all-activities",
            dataType: "json",
            type: "get",
            data: undefined,
        },
    });
}

$(document).ready(function(){
    load();
});