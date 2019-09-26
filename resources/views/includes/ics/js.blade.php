<script type="text/javascript">
    $(function () {
        var area_dt = $('#area-dt').DataTable({
            "responsive": true,
            "ajax": "/api/areas/all",
            "columns": [
                { "data": "area_type" },
                { "data": "area_code" },
                { "data": "area_name" },
                {
                    "targets": 0,
                    "data": "id",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="'+data+'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a> '+
                                '<a href="'+data+'" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</a>';
                    }
                } 
            ]
        });
        

        $("body").on("click", "#signout", function (){
            $('#logoutModal').modal('show');
        });
    });
</script>