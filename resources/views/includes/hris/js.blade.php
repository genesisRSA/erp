<script type="text/javascript">
    var existing_rel = [];
    
    $(function () {
        var attendance_dt = $('#attendance-dt').DataTable({
            "responsive": true,
            "ajax": "/api/hris/attendances/all",
            "columns": [
                { "data": "employee_name" },
                { "data": "att_date" },
                { "data": "punch_time" },
                { "data": "att_status",
                  "targets": 0,
                  "render": function( data, type, row, meta ){
                      if(data=="IN"){
                        return '<span class="badge badge-success">IN</span>';
                      }else{
                        return '<span class="badge badge-danger">OUT</span>';
                      }
                  } }
            ]
        });

        var employee_dt = $('#employee-dt').DataTable({
            "responsive": true,
            "aaSorting": [],
            "ajax": "/api/hris/employees/all",
            "columns": [
                { "data": "site.site_desc" },
                { "data": "department.dept_desc" },
                { "data": "section.sect_desc" },
                { "data": "emp_no" },
                {
                    "targets": 0,
                    "data": "emp_photo",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+data+'" target="_blank"><img src="/'+data+'" class="img-fluid rounded-circle bg-white" style="height:48px;"/></a>';
                    }
                },
                { "data": "full_name" },
                {
                    "targets": 0,
                    "data": "id_no",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="employees/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a> '+
                                '<a href="employees/'+data+'/edit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a> '
                                @if(Auth::user()->is_admin)
                                +'<a href="employees/'+data+'" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</a> '
                                +'<a href="employees/'+data+'/account" class="btn btn-success btn-sm"><i class="fas fa-user"></i> Manage Account</a>'
                                @endif
                                ;
                    }
                } 
            ]
        });

        var leave_dt = $('#leave-dt').DataTable({
            "responsive": true,
            "ajax": "/api/hris/leaves/all",
            "columns": [
                { "data": "ref_no" },
                { "data": "type" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-white" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'</span>';
                    }
                },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved"){
                            return '<span class="badge badge-success">'+data+'</span>';
                        }else if(data == "Disapproved"){
                            return '<span class="badge badge-danger">'+data+'</span>';
                        }else{
                            return '<span class="badge badge-warning">'+data+'</span>';
                        }
                        
                    }
                },
                {  
                    "targets": 0,
                    "data": "last_approved_by",
                    "render": function ( data, type, row, meta ) {
                        if(row.approved_employee){
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-white" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                { "data": "last_approved" },
                {  
                    "targets": 0,
                    "data": "next_approver",
                    "render": function ( data, type, row, meta ) {
                        if(row.approver_employee){
                            return  '<a href="/'+row.approver_employee.emp_photo+'" target="_blank"><img src="/'+row.approver_employee.emp_photo+'" class="img-fluid rounded-circle bg-white" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approver_employee.full_name+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                }
            ]
        });

        var myleave_dt = $('#myleave-dt').DataTable({
            "responsive": true,
            "ajax": "/hris/leaves/my",
            "columns": [
                { "data": "ref_no" },
                { "data": "type" },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved"){
                            return '<span class="badge badge-success">'+data+'</span>';
                        }else if(data == "Declined"){
                            return '<span class="badge badge-danger">'+data+'</span>';
                        }else{
                            return '<span class="badge badge-warning">'+data+'</span>';
                        }
                        
                    }
                },
                {  
                    "targets": 0,
                    "data": "last_approved_by",
                    "render": function ( data, type, row, meta ) {
                        if(row.approved_employee){
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-white" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                { "data": "last_approved" },
                {  
                    "targets": 0,
                    "data": "next_approver",
                    "render": function ( data, type, row, meta ) {
                        if(row.approver_employee){
                            return  '<a href="/'+row.approver_employee.emp_photo+'" target="_blank"><img src="/'+row.approver_employee.emp_photo+'" class="img-fluid rounded-circle bg-white" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approver_employee.full_name+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                {
                    "targets": 0,
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="leave/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                } 
            ]
        });

        

        var leaveapproval_dt = $('#leaveapproval-dt').DataTable({
            "responsive": true,
            "ajax": "/hris/leaves/approval",
            "columns": [
                { "data": "ref_no" },
                { "data": "type" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-white" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'</span>';
                    }
                },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved"){
                            return '<span class="badge badge-success">'+data+'</span>';
                        }else if(data == "Disapproved"){
                            return '<span class="badge badge-danger">'+data+'</span>';
                        }else{
                            return '<span class="badge badge-warning">'+data+'</span>';
                        }
                        
                    }
                },
                {
                    "targets": 0,
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="leaves/'+data+'/approval" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                } 
            ]
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#emp_img_preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#emp_img").change(function () {
            readURL(this);
        });

        $("#access_id").change(function () {
            $.get("/api/hris/attendances/access_details/"+$(this).val(), function(res){
                var response = res.data[0];
                $('#emp_name').val(response.emp_name);
            });
        });

        $("#site_code").change(function () {
                $.get("/api/hris/sites/"+$(this).val()+"/domain/", function(res){
                    var response = "@"+res.data;
                    $("#email-addon").text(response);
                    $("#email_suffix").val(response);
                });

               $.get("/api/hris/sites/"+$(this).val()+"/departments/", function(res){
                    var response = res.data;
                    $('#dept_code').empty();
                    $('#sect_code').empty();
                    $('#position').empty();
                    $('#sect_code').append($('<option>', { 
                        value: "",
                        text : "Choose Section...",
                        disabled: true
                    }));
                    $('#position').append($('<option>', { 
                        value: "",
                        text : "Choose Position...",
                        disabled: true
                    }));
                    $('#dept_code').append($('<option>', { 
                        value: "",
                        text : "Choose Department...",
                        disabled: true
                    }));
                    $.each(response, function (i, item) {
                        $('#dept_code').append($('<option>', { 
                            value: item.dept_code,
                            text : item.dept_desc 
                        }));
                    });
                    $('#dept_code').val("");
                    $('#sect_code').val("");
                    $('#position').val("");
                });
        });

        $("#dept_code").change(function () {

               $.get("/api/hris/departments/"+$(this).val()+"/sections/", function(res){
                    var response = res.data;
                    $('#sect_code').empty();
                    $('#position').empty();
                    $('#sect_code').append($('<option>', { 
                        value: "",
                        text : "Choose Section...",
                        disabled: true
                    }));
                    $('#position').append($('<option>', { 
                        value: "",
                        text : "Choose Position...",
                        disabled: true
                    }));
                    $.each(response, function (i, item) {
                        $('#sect_code').append($('<option>', { 
                            value: item.sect_code,
                            text : item.sect_desc 
                        }));
                    });
                    $('#sect_code').val("");
                    $('#position').val("");
                });
        });

        $("#sect_code").change(function () {

            $.get("/api/hris/sections/"+$(this).val()+"/positions/", function(res){
                    var response = res.data;
                    $('#position').empty();
                    $('#position').append($('<option>', { 
                        value: "",
                        text : "Choose Position...",
                        disabled: true
                    }));
                    $.each(response, function (i, item) {
                        $('#position').append($('<option>', { 
                            value: item.position,
                            text : item.position 
                        }));
                    });
                    $('#position').val("");
                });
        });

        $('#is_hmo').change(function (){
            if($(this).is(':checked')){
                $('#hmo_cardno').prop('readonly', false);
                $('#hmo_cardno').prop('required', true);
            }else{
                $('#hmo_cardno').prop('readonly', true);
                $('#hmo_cardno').prop('required', false);
            }
        });

        $('#emp_cat').change(function (){
            if($(this).val()=="Regular"){
                $('#date_regularized').prop('readonly', false);
            }else{
                $('#date_regularized').prop('readonly', true);
            }
        });

        $('#add_dep').click(function (){
            var name = $('#dep_name').val();
            var dob = $('#dep_dob').val();
            var rel = $('#dep_rel').val();
            var found = false;
            if(rel != "Brother" && rel != "Sister" && rel != "Son" && rel != "Daugther"){
                if($.inArray(rel,existing_rel) > -1){
                    found = true;
                }
            }

            if(name != "" && !found){
                var button = '<button type="button" class="btn btn-sm btn-danger" id="del_dep"><i class="fas fa-trash-alt"></i> Delete</button>';
                var markup = "<tr><td>"+name+"</td>"+
                         "<td>"+dob+"</td>"+
                         "<td>"+rel+"</td>"+
                         '<td class="text-center">'+button+"</td>"+
                         '<input type="hidden" name="dep_name[]" value="'+name+'" />'+
                         '<input type="hidden" name="dep_dob[]" value="'+dob+'" />'+
                         '<input type="hidden" name="dep_rel[]" value="'+rel+'" />'+
                         "</tr>";

                $('#dep_table tbody').append(markup);
                existing_rel.push(rel);
                $('#dep_name').val("");
                $('#dep_name').removeClass('is-invalid');
            }else if(found){
                alert(rel+" already exist!");
            }else{
                $('#dep_name').addClass('is-invalid');
            }
        });

        $("body").on("click", "#del_dep", function (){
            if(confirm("Are you sure you want to delete this record?")){
                $(this).parents("tr").remove();
                existing_rel.splice($(this).parents("tr").index(),1);
            }
        });

        $("body").on("click", "#signout", function (){
            $('#logoutModal').modal('show');
        });

        $("#is_one_day").change(function (){
            if($(this).prop('checked')){
                $('#leave_to').prop('readonly', true);
            }else{
                $('#leave_to').prop('readonly', false);
            }
        });

        @if($page=="my attendance")
            $.get("/api/hris/attendances/my_today/{{Auth::user()->employee->access_id}}/{{date('Y-m-d')}}/", function(res){
                var response = res.data;
                $('#time-in').html(response.time_in);

                if(response.time_in != response.time_out)
                $('#time-out').html(response.time_out);
            });
                
            var my_attendance_dt = $('#my-attendance-td').DataTable({
                "responsive": true,
                "aaSorting": [],
                "ajax": "/api/hris/attendances/my_attendance/{{Auth::user()->employee->access_id}}",
                "columns": [
                    { "data": "att_date" },
                    { "data": "time_in" },
                    { "data": "time_out" },
                    { "data": "hours_work" },
                    {
                        "targets": 0,
                        "data": "late",
                        "render": function ( data, type, row, meta ) {
                            if((data+"").indexOf('-') != '-1'){
                                return "N/A";
                            }else{
                                return data;
                            }
                        }
                    } 
                ]
            });

        @endif

    });
</script>