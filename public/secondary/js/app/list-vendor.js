var deleteVendor = function(id){
    swal({ title: "Are you sure?", text: "Once deleted, you will not be able to recover this vendor!", icon: "warning", buttons: true, dangerMode: true })
    .then((willDelete) => {
        if(willDelete) {
            api.vendor.delete({id:id}, function(success){
                if(success && success.success){
                    swal("Poof! Vendor has been deleted!", { icon: "success" });
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
        "columnDefs": [ { "orderable": false, "targets": 0 }, { "orderable": false, "targets": 1 },{ "orderable": false, "targets": 6 }, { "orderable": false, "targets": 9 } ],
        "order": [[2, "desc"], [3, "desc"], [4, "desc"], [5, "desc"], [7, "desc"], [8, "desc"]],
        "colReorder": true,
        "ajax": {
            url: "/api/all-vendors",
            dataType: "json",
            type: "get",
            data: undefined,
        },
    });
}

$(document).ready(function(){
    load();
});