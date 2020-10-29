<script type="text/javascript">
    $(function () {

        @if($page == "digital signage")

        var signage_dt = $('#signage-dt').DataTable({
            "responsive": true,
            "pagingType": "full",
            "ajax": "/api/signages/all/{{Auth::user()->emp_no}}",
            "columns": [
                { "data": "id" },
                {
                    "targets": 2,
                    "data": "is_video",
                    "render": function ( data, type, row, meta ) {
                        if(data==0){
                            return "Image";                                
                        }else{
                            return "Video";
                        }
                    }
                },
                {
                    "targets": 3,
                    "data": "is_enabled",
                    "render": function ( data, type, row, meta ) {
                        if(data==0){
                            return '<span class="badge badge-warning">For HR Approval</span>';                                
                        }else if(data==2){
                            return '<span class="badge badge-warning">For Approval</span>';
                        }else if(data==3){
                            return '<span class="badge badge-danger">Rejected</span>';
                        }else{
                            return '<span class="badge badge-success">Approved</span>';
                        }
                    }
                },
                {
                    "targets": 4,
                    "data": "source_url",
                    "render": function ( data, type, row, meta ) {
                        if(row.is_video == 0){
                            return '<img src="/'+data+'" class="img-thumbnail text-center" style="width:384px;height:216px;" />';                             
                        }else{
                            return '<video src="/'+data+'" class="text-center" loop muted controls style="width:384px;height:216px;" ></video>';
                        }
                    }
                },
                {
                    "targets": 5,
                    "data": "source_url_vertical",
                    "render": function ( data, type, row, meta ) {
                        if(row.is_video == 0){
                            return '<img src="/'+data+'" class="img-thumbnail text-center" style="height:384px;width:216px;" />';                             
                        }else{
                            return '<video src="/'+data+'" class="text-center" loop muted controls style="height:384px;width:216px;"></video>';
                        }
                    }
                },
                {
                    "targets": 6,
                    "data": "id",
                    "render": function ( data, type, row, meta ) {
                        if(row.is_enabled == 0){
                            return  '<div class="btn-group btn-group-sm"> '+
                            //'<a href="signages/'+data+'/enable" class="btn btn-success"><i class="fas fa-edit"></i> Enable</a> '+
                            '<a href="signages/'+data+'/delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a> '+
                            '</div>';

                        }else{
                            return  '<div class="btn-group btn-group-sm">'+
                            //'<a href="signages/'+data+'/disable" class="btn btn-warning"><i class="fas fa-edit"></i> Disable</a> '+
                            '<a href="signages/'+data+'/delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a> '+
                            '</div>';
                        }
                    }
                },
            ]
        });

        var forapproval_dt = $('#forapproval-dt').DataTable({
            "responsive": true,
            "pagingType": "full",
            "ajax": "/api/signages/forapproval/{{Auth::user()->emp_no}}",
            "columns": [
                { "data": "id" },
                {
                    "targets": 2,
                    "data": "is_video",
                    "render": function ( data, type, row, meta ) {
                        if(data==0){
                            return "Image";                                
                        }else{
                            return "Video";
                        }
                    }
                },
                {
                    "data": "status",
                },
                {
                    "targets": 3,
                    "data": "created_by",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.requestor.emp_photo+'" target="_blank"><img src="/'+row.requestor.emp_photo+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/> <span class="badge badge-secondary">'+row.requestor.emp_lname+', '+row.requestor.emp_fname+'<br>'+row.requestor.emp_no+'</span></a>';
                    }
                },
                {
                    "targets": 4,
                    "data": "source_url",
                    "render": function ( data, type, row, meta ) {
                        if(row.is_video == 0){
                            return '<img src="/'+data+'" class="img-thumbnail text-center" style="width:384px;height:216px;" />';                             
                        }else{
                            return '<video src="/'+data+'" class="text-center" loop muted controls style="width:384px;height:216px;" ></video>';
                        }
                    }
                },
                {
                    "targets": 5,
                    "data": "source_url_vertical",
                    "render": function ( data, type, row, meta ) {
                        if(row.is_video == 0){
                            return '<img src="/'+data+'" class="img-thumbnail text-center" style="height:384px;width:216px;" />';                             
                        }else{
                            return '<video src="/'+data+'" class="text-center" loop muted controls style="height:384px;width:216px;"></video>';
                        }
                    }
                },
                {
                    "targets": 6,
                    "data": "id",
                    "render": function ( data, type, row, meta ) {
                            return  '<div class="btn-group btn-group-sm"> '+
                            '<a href="/ics/signages/'+data+'/approve" class="btn btn-success"><i class="fas fa-check"></i> Approve</a> '+
                            '<a href="/ics/signages/'+data+'/reject" class="btn btn-danger"><i class="fas fa-times"></i> Reject</a> '+
                            '</div>';
                    }
                },
            ]
        });

        $(function () {
            $('#is_video').change(function(){
                if($(this).val()==0){
                    $('#label_source_url').html('Image <sup class="text-danger">*</sup>');
                    $('#label_source_url_vertical').html('Image Vertical<sup class="text-danger">*</sup>');
                    $('#img_preview').fadeIn(); 
                    $('#img_preview_vertical').fadeIn();
                    $('#vid_preview').fadeOut();
                    $('#vid_preview_vertical').fadeOut();
                    $('#source_url').attr('accept',".jpg,.png");
                    $('#source_url_vertical').attr('accept',".jpg,.png");
                }else{
                    $('#label_source_url').html('Video <sup class="text-danger">*</sup>');
                    $('#label_source_url_vertical').html('Video Vertical<sup class="text-danger">*</sup>');
                    $('#img_preview').fadeOut();
                    $('#img_preview_vertical').fadeOut();
                    $('#vid_preview').fadeIn();
                    $('#vid_preview_vertical').fadeIn();
                    $('#source_url').attr('accept',".mp4");
                    $('#source_url_vertical').attr('accept',".mp4");
                }
            });

            $('#is_video').val(0);

            function readURL(input,id) {
                var p_id = id;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $(p_id).attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#source_url_vertical").change(function () {
                if($('#is_video').val()==0){
                    readURL(this,'#img_preview_vertical');
                }else{
                    readURL(this,'#vid_preview_vertical');
                }
            });

            $("#source_url").change(function () {
                if($('#is_video').val()==0){
                    readURL(this,'#img_preview');
                }else{
                    readURL(this,'#vid_preview');
                }
            });
        });

        @endif
        

        $("body").on("click", "#settings", function (){
            $('#settingsModal').modal('show');
        });

        $("body").on("click", "#signout", function (){
            $('#logoutModal').modal('show');
        });
    });
</script>