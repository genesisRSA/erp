<script type="text/javascript">
    var existing_rel = [];
    var existing_ot_date = [];
    var existing_leave_date = [];
    var existing_leave_edate = [];
    var existing_ot_emp = [];
    var existing_ob_date = [];
    var existing_ob_from = [];
    var existing_ob_to = [];
    
    $(function () {
        function buildSelect( table ) {
            table.columns().every( function () {
                var column = table.column( this, {search: 'applied'} );
                var select = $('<select class="form-control"><option value=""></option></select>')
                .appendTo( $(column.footer()).empty() )
                .on( 'change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                column
                .search( val ? '^'+val+'$' : '', true, false )
                .draw();
                } );

                column.data().unique().sort().each( function ( d, j ) {
                select.append( '<option value="'+d+'">'+d+'</option>' );
                } );
                
                // The rebuild will clear the exisiting select, so it needs to be repopulated
                var currSearch = column.search();
                if ( currSearch ) {
                select.val( currSearch.substring(1, currSearch.length-1) );
                }
            } );
            }

        $('form').submit(function(){

            $("button:submit", this).html("Please Wait...");

            return true;

        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                                        .columns.adjust()
                                        .responsive.recalc();
        });  
        
        var hash = window.location.hash;
        $('#myTab a[href="'+hash+'"]').tab('show');

        @if($page == "attendance")
        $('body').on('click','#run_attendance',function(){
                $("#attendance-dt").dataTable().fnDestroy()

                var attendance_dt = $('#attendance-dt').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'pageLength',
                    { extend: 'excel',
                    title: 'HRIS - Raw Attendance'
                    },
                    { extend: 'print',
                    title: 'HRIS - Raw Attendance'
                    }
                ],
                "responsive": true,
                "pagingType": "full",
                "ajax": "/api/hris/attendances/av_attendance/"+$('#date_from').val()+"/"+$('#date_to').val(),
                "columns": [
                    { "data": "emp_code" },
                    { "data": "emp_name" },
                    { "data": "date_log" },
                    { "data": "time_in" },
                    { "data": "temp_time_in" },
                    { "data": "lunch_in",
                        "render": function( data, type, row, meta ){
                            if(data){
                                return data;
                            }else{
                                return '<span class="bg-danger text-white p-2">NO LUNCH IN</span>';
                            }
                        }
                    },
                    { "data": "temp_lunch_in",
                        "render": function( data, type, row, meta ){
                            if(data){
                                return data;
                            }else{
                                return '<span class="bg-danger text-white p-2">NO TEMP</span>';
                            }
                        }
                    },
                    { "data": "lunch_out",
                        "render": function( data, type, row, meta ){
                            if(data){
                                return data;
                            }else{
                                return '<span class="bg-danger text-white p-2">NO LUNCH OUT</span>';
                            }
                        }
                    },
                    { "data": "temp_lunch_out",
                        "render": function( data, type, row, meta ){
                            if(data){
                                return data;
                            }else{
                                return '<span class="bg-danger text-white p-2">NO TEMP</span>';
                            }
                        }
                    },
                    { "data": "time_out",
                        "render": function( data, type, row, meta ){
                            if(data){
                                return data;
                            }else{
                                return '<span class="bg-danger text-white p-2">NO TIME OUT</span>';
                            }
                        }
                    },
                    { "data": "temp_time_out",
                        "render": function( data, type, row, meta ){
                            if(data){
                                return data;
                            }else{
                                return '<span class="bg-danger text-white p-2">NO TEMP</span>';
                            }
                        }
                    },
                ]
            });
            
            buildSelect( attendance_dt );
            attendance_dt.on( 'draw', function () {
                buildSelect( attendance_dt );
            } );
        });
        


        /*var attendance_dt = $('#attendance-dt').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'pageLength',
                { extend: 'excel',
                  title: 'HRIS - Raw Attendance'
                },
                { extend: 'print',
                  title: 'HRIS - Raw Attendance'
                }
            ],
            "responsive": true,
            "pagingType": "full",
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

        buildSelect( attendance_dt );
        attendance_dt.on( 'draw', function () {
            buildSelect( attendance_dt );
        } );

        var calcattendance_dt = $('#calcattendance-dt').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'pageLength', 
                { extend: 'excel',
                  title: 'HRIS - Calculated Attendance'
                },
                { extend: 'print',
                  title: 'HRIS - Calculated Attendance'
                }
            ],
            "responsive": true,
            "pagingType": "full",
            "ajax": "/api/hris/attendances/calc_all",
            "columns": [
                { "data": "employee_name" },
                { "data": "att_date" },
                { "data": "time_in" },
                { "data": "time_out" },
                { "data": "hours_work" },
                { "data": "late" }
            ]
        });

        buildSelect( calcattendance_dt );
        calcattendance_dt.on( 'draw', function () {
            buildSelect( calcattendance_dt );
        } );*/
        
        @endif

        @if($page=="my attendance")
            $.get("/api/hris/attendances/my_today/{{Auth::user()->employee->emp_no}}/{{date('Y-m-d')}}/", function(res){
                var response = res.data;
                $('#time-in').html(response.time_in);
                $('#time-in-mini').html(response.time_in);

                if(response.time_in != response.time_out)
                {
                    $('#time-out').html(response.time_out);
                    $('#time-out-mini').html(response.time_out);
                }
            });
                
            var my_attendance_dt = $('#my-attendance-td').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'pageLength',
                    { extend: 'print',
                    title: 'ERIS - My Attendance'
                    }
                ],
                "responsive": true,
                "pagingType": "full",
                "aaSorting": [],
                "ajax": "/api/hris/attendances/my_attendance/{{Auth::user()->employee->emp_no}}",
                "columns": [
                    { "data": "date_log" },
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

            var my_shift_dt = $('#my-shift-td').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'pageLength',
                    { extend: 'print',
                    title: 'ERIS - My Shift'
                    }
                ],
                "responsive": true,
                "pagingType": "full",
                "aaSorting": [],
                "ajax": "/api/hris/employeeshifts/my_shift/{{Auth::user()->employee->emp_no}}",
                "columns": [
                    { "data": "shift_date" },
                    { "data": "shift_code" },
                    { "data": "time_in" },
                    { "data": "time_out" }, 
                ]
            });
        @endif

        @if($page=="team attendance")
            $.get("/api/hris/attendances/my_today/{{$access_id}}/{{date('Y-m-d')}}/", function(res){
                var response = res.data;
                $('#time-in').html(response.time_in);
                $('#time-in-mini').html(response.time_in);

                if(response.time_in != response.time_out)
                {
                    $('#time-out').html(response.time_out);
                    $('#time-out-mini').html(response.time_out);
                }
            });
                
            var my_attendance_dt = $('#my-attendance-td').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'pageLength',
                    { extend: 'print',
                    title: 'HRIS - My Attendance'
                    }
                ],
                "responsive": true,
                "pagingType": "full",
                "aaSorting": [],
                "ajax": "/api/hris/attendances/my_attendance/{{$access_id}}",
                "columns": [
                    { "data": "date_log" },
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


        @if($page == "employees")
        var employee_dt = $('#employee-dt').DataTable({
            "responsive": true,
            "pagingType": "full",
		    "columnDefs": [
		            { responsivePriority: 1, targets: 1 },
		            { responsivePriority: 2, targets: 3 },
		    ],
            "aaSorting": [],
            "ajax": "/api/hris/employees/all",
            "columns": [
                { "data": "site.site_code" },
                { "data": "section.sect_desc" },
                { "data": "position" },
                {
                    "targets": 3,
                    "data": "emp_photo",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+data+'" target="_blank"><img src="/'+data+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/> <span class="badge badge-secondary">'+row.full_name+'<br>'+row.emp_no+'</span></a>';
                    }
                },
                {
                    "targets": 4,
                    "data": "id_no",
                    "render": function ( data, type, row, meta ) {
                        return  '<div class="btn-group btn-group-sm"><a href="employees/'+data+'" class="btn btn-primary"><i class="fas fa-eye"></i> View</a> '+
                                '<a href="employees/'+data+'/edit" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a> '
                                +'<a href="#" class="btn btn-danger"><i class="fas fa-window-close"></i> Resign</a>'
                                +'<a href="employees/'+data+'/movement" class="btn btn-secondary"><i class="fas fa-file-invoice"></i> Movement</a>' 
                                @if(Auth::user()->is_admin)
                                +'<a href="employees/'+data+'" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a> '
                                +'<a href="employees/'+data+'/account" class="btn btn-success"><i class="fas fa-user"></i> Account</a>'
                                @endif
                               // +'<a href="employees/'+data+'/201file" class="btn btn-secondary"><i class="fas fa-file-invoice"></i> 201</a>' 
                                +'</div>';
                    }
                } 
            ]
        });

        var remployee_dt = $('#resemployee-dt').DataTable({
            "responsive": true,
            "pagingType": "full",
		    "columnDefs": [
		            { responsivePriority: 1, targets: 1 },
		            { responsivePriority: 2, targets: 3 },
		    ],
            "aaSorting": [],
            "ajax": "/api/hris/employees/all_resign",
            "columns": [
                { "data": "site.site_code" },
                { "data": "section.sect_desc" },
                { "data": "position" },
                {
                    "targets": 3,
                    "data": "emp_photo",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+data+'" target="_blank"><img src="/'+data+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/> <span class="badge badge-secondary">'+row.full_name+'<br>'+row.emp_no+'</span></a>';
                    }
                },
                {
                    "targets": 4,
                    "data": "id_no",
                    "render": function ( data, type, row, meta ) {
                        return  '<div class="btn-group btn-group-sm"><a href="employees/'+data+'" class="btn btn-primary"><i class="fas fa-eye"></i> View</a> '+
                                '<a href="employees/'+data+'" class="btn btn-success"><i class="fas fa-check-square"></i> Re-activate</a>'
                                +'<a href="employees/'+data+'/movement" class="btn btn-secondary"><i class="fas fa-file-invoice"></i> Movement</a>' 
                                +'</div>';
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
            if(rel == "Father" || rel == "Mother"){
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

        $("body").on("change", "#gender", function (){
            if($(this).val() == "Male"){
                $('#paternity_leave').attr('readonly',false);
                $('#maternity_leave').attr('readonly',true);
            }
            else{
                $('#paternity_leave').attr('readonly',true);
                $('#maternity_leave').attr('readonly',false);
            }
        });

        if($('#gender').val() == "Male"){
            $('#paternity_leave').attr('readonly',false);
            $('#maternity_leave').attr('readonly',true);
        }
        else{
            $('#paternity_leave').attr('readonly',true);
            $('#maternity_leave').attr('readonly',false);
        }

        @endif

        @if($page == "timekeeping")

        var leave_dt = $('#leave-dt').DataTable({
            "responsive": true,
            "aaSorting": [],
            "pagingType": "full",
            "ajax": "/api/hris/leaves/all",
            "columns": [
                { "data": "ref_no" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'<br>'+row.filer_employee.emp_no+'</span>';
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
                        }else if(data == "Posted"){
                            return '<span class="badge badge-secondary">'+data+'</span>';
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
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'<br>'+row.approved_employee.emp_no+'</span>';
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
                            return  '<a href="/'+row.approver_employee.emp_photo+'" target="_blank"><img src="/'+row.approver_employee.emp_photo+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/></a> <span class="badge badge-secondary">'+row.approver_employee.full_name+'<br>'+row.approver_employee.emp_no+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                {
                    "targets": 0,
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        if(row.status == "Approved"){
                            return  '<a href="leave/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>'+
                                    '<a href="leave/'+data+'/posting" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Post</a>';
                        }else
                        return  '<a href="leave/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                }
            ]
        });

        var leaveposted_dt = $('#leaveposted-dt').DataTable({
            "responsive": true,
            "aaSorting": [],
            "pagingType": "full",
            "ajax": "/api/hris/leaves/all_posted",
            "columns": [
                { "data": "ref_no" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'<br>'+row.filer_employee.emp_no+'</span>';
                    }
                },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
                            return '<span class="badge badge-success">'+data+'</span>';
                        }else if(data == "Disapproved" || data == "Voided"){
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
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'<br>'+row.approved_employee.emp_no+'</span>';
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
                            return  '<a href="/'+row.approver_employee.emp_photo+'" target="_blank"><img src="/'+row.approver_employee.emp_photo+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/></a> <span class="badge badge-secondary">'+row.approver_employee.full_name+'<br>'+row.approver_employee.emp_no+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                {
                    "targets": 0,
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="leave/'+data+'/posted" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                } 
            ]
        });

        var shift_dt = $('#shift-dt').DataTable({
            "responsive": true,
            "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
            "pagingType": "full",
            "ajax": "/api/hris/employeeshifts/all",
            "columns": [
                {  
                    "targets": 0,
                    "data": "employee",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.employee.emp_photo+'" target="_blank"><img src="/'+row.employee.emp_photo+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/></a> <span class="badge badge-secondary">'+row.employee.full_name+'<br>'+row.employee.emp_no+'</span>';
                    }
                },
                {  
                    "targets": 0,
                    "data": "shift",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  row.shift_code;
                    }
                },
                { "data": "shift_date" },
                { "data": "shift_day" },
                { "data": "time_in" },
                { "data": "time_out" },
                {
                    "targets": 0,
                    "data": "id",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="employeeshift/delete/'+row.id+'" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>';
                    }
                }
            ] 
        });

        var ob_dt = $('#ob-dt').DataTable({
            "responsive": true,
            "ajax": "/api/hris/obs/all",
            "columns": [
                { "data": "ref_no" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'<br>'+row.filer_employee.emp_no+'</span>';
                    }
                },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
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
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'<br>'+row.approved_employee.emp_no+'</span>';
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
                            return  '<a href="/'+row.approver_employee.emp_photo+'" target="_blank"><img src="/'+row.approver_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approver_employee.full_name+'<br>'+row.approver_employee.emp_no+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                {
                    "targets": 0,
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        if(row.status == "Approved"){
                            return  '<a href="ob/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>'+
                                    '<a href="obs/'+data+'/posting" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Post</a>';
                        }else
                        return  '<a href="ob/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                },
            ]
        });

        var obposted_dt = $('#obposted-dt').DataTable({
            "responsive": true,
            "ajax": "/api/hris/obs/all_posted",
            "columns": [
                { "data": "ref_no" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'<br>'+row.filer_employee.emp_no+'</span>';
                    }
                },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
                            return '<span class="badge badge-success">'+data+'</span>';
                        }else if(data == "Declined" || data == "Voided"){
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
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'<br>'+row.approved_employee.emp_no+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                { "data": "last_approved" },
                {
                    "targets": 0,
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="ob/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                },
            ]
        });

        var cs_dt = $('#cs-dt').DataTable({
            "responsive": true,
            "ajax": "/api/hris/css/all",
            "columns": [
                { "data": "ref_no" },
                { "data": "type" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'<br>'+row.filer_employee.emp_no+'</span>';
                    }
                },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
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
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'<br>'+row.approved_employee.emp_no+'</span>';
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
                            return  '<a href="/'+row.approver_employee.emp_photo+'" target="_blank"><img src="/'+row.approver_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approver_employee.full_name+'<br>'+row.approver_employee.emp_no+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                {
                    "targets": 0,
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        if(row.status == "Approved"){
                            return  '<a href="cs/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>'+
                                    '<a href="css/'+data+'/posting" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Post</a>';
                        }else
                        return  '<a href="cs/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                } 
            ]
        });

        var csposted_dt = $('#csposted-dt').DataTable({
            "responsive": true,
            "ajax": "/api/hris/css/all_posted",
            "columns": [
                { "data": "ref_no" },
                { "data": "type" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'<br>'+row.filer_employee.emp_no+'</span>';
                    }
                },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
                            return '<span class="badge badge-success">'+data+'</span>';
                        }else if(data == "Disapproved" || data == "Voided"){
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
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'<br>'+row.approved_employee.emp_no+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                { "data": "last_approved" },
                {
                    "targets": 0,
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="cs/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                } 
            ]
        });

        var ot_dt = $('#ot-dt').DataTable({
            "responsive": true,
            "ajax": "/api/hris/ots/all",
            "columns": [
                { "data": "ref_no" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'<br>'+row.filer_employee.emp_no+'</span>';
                    }
                },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
                            return '<span class="badge badge-success">'+data+'</span>';
                        }else if(data == "Disapproved" || data == "Declined"){
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
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'<br>'+row.approved_employee.emp_no+'</span>';
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
                            return  '<a href="/'+row.approver_employee.emp_photo+'" target="_blank"><img src="/'+row.approver_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approver_employee.full_name+'<br>'+row.approver_employee.emp_no+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                {
                    "targets": 0,
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        if(row.status == "Approved"){
                            return  '<a href="ot/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>'+
                                    '<a href="ots/'+data+'/posting" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Post</a>';
                        }else
                        return  '<a href="ot/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                } 
            ]
        });

        var otposted_dt = $('#otposted-dt').DataTable({
            "responsive": true,
            "ajax": "/api/hris/ots/all_posted",
            "columns": [
                { "data": "ref_no" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'<br>'+row.filer_employee.emp_no+'</span>';
                    }
                },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
                            return '<span class="badge badge-success">'+data+'</span>';
                        }else if(data == "Disapproved" || data == "Voided"){
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
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'<br>'+row.approved_employee.emp_no+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                { "data": "last_approved" },
                {
                    "targets": 0,
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="ot/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                } 
            ]
        });

        @endif

        @if($page == "my timekeeping")
        
        var myleave_dt = $('#myleave-dt').DataTable({
            "responsive": true,
            "aaSorting": [],
            "pagingType": "full",
            "ajax": "/hris/leaves/my",
            "columns": [
                { "data": "ref_no" },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved"){
                            return '<span class="badge badge-success">'+data+'</span>';
                        }else if(data == "Declined"){
                            return '<span class="badge badge-danger">'+data+'</span>';
                        }else if(data == "Posted"){
                            return '<span class="badge badge-secondary">'+data+'</span>';
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
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'<br>'+row.approved_employee.emp_no+'</span>';
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
                            return  '<a href="/'+row.approver_employee.emp_photo+'" target="_blank"><img src="/'+row.approver_employee.emp_photo+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/></a> <span class="badge badge-secondary">'+row.approver_employee.full_name+'<br>'+row.approver_employee.emp_no+'</span>';
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

        var myleaveposted_dt = $('#myleaveposted-dt').DataTable({
            "responsive": true,
            "aaSorting": [],
            "pagingType": "full",
            "ajax": "/hris/leaves/my_posted",
            "columns": [
                { "data": "ref_no" },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
                            return '<span class="badge badge-success">'+data+'</span>';
                        }else if(data == "Declined" || data == "Voided"){
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
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'<br>'+row.approved_employee.emp_no+'</span>';
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
                            return  '<a href="/'+row.approver_employee.emp_photo+'" target="_blank"><img src="/'+row.approver_employee.emp_photo+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/></a> <span class="badge badge-secondary">'+row.approver_employee.full_name+'<br>'+row.approver_employee.emp_no+'</span>';
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
            "aaSorting": [],
            "pagingType": "full",
            "ajax": "/hris/leaves/approval",
            "columns": [
                { "data": "ref_no" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-white border" style="height:32px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'<br>'+row.filer_employee.emp_no+'</span>';
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
                        }else if(data == "Posted"){
                            return '<span class="badge badge-secondary">'+data+'</span>';
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

        var myob_dt = $('#myob-dt').DataTable({
            "responsive": true,
            "ajax": "/hris/obs/my",
            "columns": [
                { "data": "ref_no" },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
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
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'<br>'+row.approved_employee.emp_no+'</span>';
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
                            return  '<a href="/'+row.approver_employee.emp_photo+'" target="_blank"><img src="/'+row.approver_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approver_employee.full_name+'<br>'+row.approver_employee.emp_no+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                {
                    "targets": 0,
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="ob/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                } 
            ]
        });

        var obapproval_dt = $('#obapproval-dt').DataTable({
            "responsive": true,
            "ajax": "/hris/obs/approval",
            "columns": [
                { "data": "ref_no" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'<br>'+row.filer_employee.emp_no+'</span>';
                    }
                },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
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
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="obs/'+data+'/approval" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                } 
            ]
        });

        var mycs_dt = $('#mycs-dt').DataTable({
            "responsive": true,
            "ajax": "/hris/css/my",
            "columns": [
                { "data": "ref_no" },
                { "data": "type" },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
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
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'<br>'+row.approved_employee.emp_no+'</span>';
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
                            return  '<a href="/'+row.approver_employee.emp_photo+'" target="_blank"><img src="/'+row.approver_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approver_employee.full_name+'<br>'+row.approver_employee.emp_no+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                {
                    "targets": 0,
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="cs/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                } 
            ]
        });

        var csapproval_dt = $('#csapproval-dt').DataTable({
            "responsive": true,
            "ajax": "/hris/css/approval",
            "columns": [
                { "data": "ref_no" },
                { "data": "type" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'<br>'+row.filer_employee.emp_no+'</span>';
                    }
                },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
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
                        return  '<a href="css/'+data+'/approval" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                } 
            ]
        });

        var myot_dt = $('#myot-dt').DataTable({
            "responsive": true,
            "ajax": "/hris/ots/my",
            "columns": [
                { "data": "ref_no" },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
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
                            return  '<a href="/'+row.approved_employee.emp_photo+'" target="_blank"><img src="/'+row.approved_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approved_employee.full_name+'<br>'+row.approved_employee.emp_no+'</span>';
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
                            return  '<a href="/'+row.approver_employee.emp_photo+'" target="_blank"><img src="/'+row.approver_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.approver_employee.full_name+'<br>'+row.approver_employee.emp_no+'</span>';
                        }else{
                            return 'N/A';
                        }
                    }
                },
                {
                    "targets": 0,
                    "data": "ref_no",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="ot/'+data+'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                } 
            ]
        });

        var otapproval_dt = $('#otapproval-dt').DataTable({
            "responsive": true,
            "ajax": "/hris/ots/approval",
            "columns": [
                { "data": "ref_no" },
                {  
                    "targets": 0,
                    "data": "filer",
                    'className': 'dt-center',
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="/'+row.filer_employee.emp_photo+'" target="_blank"><img src="/'+row.filer_employee.emp_photo+'" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">'+row.filer_employee.full_name+'<br>'+row.filer_employee.emp_no+'</span>';
                    }
                },
                { "data": "date_filed" },
                { 
                    "targets": 0,
                    "data": "status" ,
                    "render": function ( data, type, row, meta){
                        if(data == "Approved" || data == "Posted"){
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
                        return  '<a href="ots/'+data+'/approval" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
                    }
                } 
            ]
        });


        @endif

        $("#is_one_day").change(function (){
            if($(this).prop('checked')){
                $('#leave_to').prop('readonly', true);
                $('#is_half_day').prop('checked', false);
            }else{
                $('#leave_to').prop('readonly', false);
            }
        });

        $("#is_half_day").change(function (){
            if($(this).prop('checked')){
                $('#leave_to').prop('readonly', true);
                $('#is_one_day').prop('checked', false);
            }else{
                $('#leave_to').prop('readonly', false);
            }
        });

        $("body").on("click", "#signout", function (){
            $('#logoutModal').modal('show');
        });

        $("body").on("click", "#settings", function (){
            $('#settingsModal').modal('show');
        });

        $("body").on("click", "#alteration", function (){
            $('#alterationModal').modal('show');
        });

        $("body").on("keyup", "#new_password", function(){
            if($('#cnew_password').val()!=$(this).val()){
                $('#new_password').addClass("is-invalid");
            }else{
                $('#new_password').removeClass("is-invalid");
                $('#cnew_password').removeClass("is-invalid");
            }
        });

        $("body").on("keyup", "#cnew_password", function(){
            if($('#new_password').val()!=$(this).val()){
                $('#cnew_password').addClass("is-invalid");
            }else{
                $('#new_password').removeClass("is-invalid");
                $('#cnew_password').removeClass("is-invalid");
            }
        });

        @if($page=="shift")
            $('.datepicker').datepicker({
                autoClose: true,
                format: "yyyy-mm-dd"
            });

            $('.datepicker').on('change', function(e){
                value = $(".datepicker").val();
                $('#date_to').val(moment(value).day(6).format("YYYY-MM-DD"));
                $("#date_from").val(moment(value).day(1).format("YYYY-MM-DD"));
            });

            $('.datepicker').on('blur', function(e){
                value = $(".datepicker").val();
                $('#date_to').val(moment(value).day(6).format("YYYY-MM-DD"));
                $("#date_from").val(moment(value).day(1).format("YYYY-MM-DD"));
            });

            $('#shiftimport-dt').DataTable();

            $('body').on('change', '#shift' ,function(){
                $.get("/api/hris/shifts/"+$(this).val()+"/days/", function(res){
                    var response = res.data;
                    $.each(response, function (i, item) {
                       if(item.shift_start == "00:00:00"){
                        $('#'+item.shift_day.toLowerCase()).text("Rest Day");
                           $('#'+item.shift_day.toLowerCase()).removeClass('badge-success').addClass('badge-danger');
                       }else{
                        $('#'+item.shift_day.toLowerCase()).text(moment("01-01-1990 "+item.shift_start).format('LT') +" - "+ moment("01-01-1990 "+item.shift_end).format('LT'));
                        $('#'+item.shift_day.toLowerCase()).removeClass('badge-danger').addClass('badge-success');
                       }
                    });
                });
            });
        @endif
        
        @if($page == "official business")

        $("#purpose").change(function (){
            if($(this).val()=="Others"){
                $('#others').prop('readonly', false);
            }else{
                $('#others').prop('readonly', true);
            }
        });

        $('#add_ob').click(function (){
            var ob_date = $('#ob_date').val();
            var ob_from = $('#ob_from').val();
            var ob_to = $('#ob_to').val();
            var purpose = $('#purpose').val() =="Others" ? $('#others').val() : $('#purpose').val() ;
            var destination = $('#destination').val();
            var others = $('#others').val();
            $('#ob_date').removeClass('is-invalid');
            $('#ob_from').removeClass('is-invalid');
            $('#ob_to').removeClass('is-invalid');
            $('#purpose').removeClass('is-invalid');
            $('#destination').removeClass('is-invalid');
            $('#others').removeClass('is-invalid');
            var found = false;
            var conflict = false;

            if($.inArray(ob_date,existing_ob_date) > -1){
                $.each(existing_ob_from, function (index, value){
                    if(existing_ob_date[index]==ob_date){
                        if((ob_from > existing_ob_from[index]) && (ob_from < existing_ob_to[index])){
                            conflict = true
                        }
                    }
                }); 
            }

            if(ob_date && ob_from && ob_to && purpose && !conflict && (ob_from < ob_to)){
                var button = '<button type="button" class="btn btn-sm btn-danger" id="del_ob"><i class="fas fa-trash-alt"></i> Delete</button>';
                var markup = "<tr><td>"+ob_date+"</td>"+
                         "<td>"+ob_from+"</td>"+
                         "<td>"+ob_to+"</td>"+
                         "<td>"+destination+"</td>"+
                         "<td>"+purpose+"</td>"+
                         '<td class="text-center">'+button+"</td>"+
                         '<input type="hidden" name="ob_date[]" value="'+ob_date+'" />'+
                         '<input type="hidden" name="ob_from[]" value="'+ob_from+'" />'+
                         '<input type="hidden" name="ob_to[]" value="'+ob_to+'" />'+
                         '<input type="hidden" name="destination[]" value="'+destination+'" />'+
                         '<input type="hidden" name="purpose[]" value="'+purpose+'" />'+
                         "</tr>";

                $('#ob_table tbody').append(markup);
                existing_ob_date.push(ob_date);
                existing_ob_from.push(ob_from);
                existing_ob_to.push(ob_to);
                $('#ob_from').val("");
                $('#ob_to').val("");
                $('#others').val("");
                $('#destination').val("");
            }else if(conflict){
                alert("OB DateTime: "+ob_date+" "+ob_from+" - "+ob_to+"  has conflict with other schedule.");
                $('#ob_date').addClass('is-invalid');
                $('#ob_from').addClass('is-invalid');
                $('#ob_to').addClass('is-invalid');
            }else if(ob_from == ob_to){
                $('#ob_from').addClass('is-invalid');
                $('#ob_to').addClass('is-invalid');
            }else{
                if(!ob_from){
                    $('#ob_from').addClass('is-invalid');
                }
                if(!ob_to){
                    $('#ob_to').addClass('is-invalid');
                }
                if(!purpose){
                    $('#purpose').addClass('is-invalid');
                }
                if(!destination){
                    $('#destination').addClass('is-invalid');
                }
                if(purpose == "Others" && !others){
                    $('#others').addClass('is-invalid');
                }
                if(ob_from > ob_to){
                    $('#ob_from').addClass('is-invalid');
                    $('#ob_to').addClass('is-invalid');
                }
            }
        });

        $("body").on("click", "#del_ob", function (){
            if(confirm("Are you sure you want to delete this record?")){
                existing_ob_date.splice($(this).parents("tr").index(),1);
                $(this).parents("tr").remove();
            }
        });

        @endif

        @if($page == "change shift")

        $("#date_from").blur(function (){
            if($('#type').val() != "Change of Date"){
                $('#date_to').val($(this).val());
            }
        });

        $("#type").change(function (){
            if($('#type').val() == "Change of Shift"){
                $('#date_to').val($('#date_from').val());
                $('#new_sched').attr('readonly', false);
                $('#date_to').attr('readonly', true);
            }else if($('#type').val() == "Change of Date"){
                $('#new_sched').attr('readonly', true);
                $('#date_to').attr('readonly', false);
                $('#new_sched').val("");
            }else{
                $('#new_sched').attr('readonly', false);
                $('#date_to').attr('readonly', false);
                $('#new_sched').val("");
            }
        });

        @endif

        @if($page == "overtime")

        $('#add_ot').click(function (){
            var emp_no = $('#person').val();
            var emp_name = $('#person option:selected').text();
            var ot_date = $('#ot_date').val();
            var ot_from = $('#ot_from').val();
            var ot_to = $('#ot_to').val();
            var reason = $('#reason').val();
            $('#person').removeClass('is-invalid');
            $('#ot_date').removeClass('is-invalid');
            $('#ot_from').removeClass('is-invalid');
            $('#ot_to').removeClass('is-invalid');
            $('#reason').removeClass('is-invalid');
            var found = false;
            $.each(existing_ot_date, function(index, value){
                if(existing_ot_date[index] == ot_date && existing_ot_emp[index] == emp_no){
                    found = true;
                    return false;
                }
            });

            if(ot_from && ot_to && reason && !found){
                var button = '<button type="button" class="btn btn-sm btn-danger" id="del_ot"><i class="fas fa-trash-alt"></i> Delete</button>';
                var markup = "<tr><td>"+emp_name+"</td>"+
                         "<td>"+ot_date+"</td>"+
                         "<td>"+ot_from+"</td>"+
                         "<td>"+ot_to+"</td>"+
                         "<td>"+reason+"</td>"+
                         '<td class="text-center">'+button+"</td>"+
                         '<input type="hidden" name="emp_name[]" value="'+emp_name+'" />'+
                         '<input type="hidden" name="emp_no[]" value="'+emp_no+'" />'+
                         '<input type="hidden" name="ot_date[]" value="'+ot_date+'" />'+
                         '<input type="hidden" name="ot_from[]" value="'+ot_from+'" />'+
                         '<input type="hidden" name="ot_to[]" value="'+ot_to+'" />'+
                         '<input type="hidden" name="reason[]" value="'+reason+'" />'+
                         "</tr>";

                $('#ot_table tbody').append(markup);
                existing_ot_emp.push(emp_no);
                existing_ot_date.push(ot_date);
                $('#ot_from').val("");
                $('#ot_to').val("");
                $('#reason').val("");
            }else if(found){
                alert("Employee: "+emp_name+"\nOT Date : "+ot_date+"\n Already exist!");
                $('#person').addClass('is-invalid');
                $('#ot_date').addClass('is-invalid');
            }else{
                if(!ot_from){
                    $('#ot_from').addClass('is-invalid');
                }
                if(!ot_to){
                    $('#ot_to').addClass('is-invalid');
                }
                if(!reason){
                    $('#reason').addClass('is-invalid');
                }
                if(!emp_no){
                    $('#person').addClass('is-invalid');
                }
            }
        });

        $("body").on("click", "#del_ot", function (){
            if(confirm("Are you sure you want to delete this record?")){
                existing_ot_emp.splice($(this).parents("tr").index(),1);
                existing_ot_date.splice($(this).parents("tr").index(),1);
                $(this).parents("tr").remove();
            }
        });

        @endif

        @if($page == "leave")

        $('#add_leave').click(function (){
            var leave_type = $('#type option:selected').text();
            var credit = 0;
            var date_from = $('#leave_from').val();
            var date_to = $('#leave_to').val();
            var reason = $('#details').val();
            var is_one_day = $('#is_one_day').is(":checked");
            var is_half_day = $('#is_half_day').is(":checked");
            $('#type').removeClass('is-invalid');
            $('#leave_from').removeClass('is-invalid');
            $('#leave_to').removeClass('is-invalid');
            $('#details').removeClass('is-invalid');
            var found = false;
            var invalid = false;
            if(!is_one_day && !is_half_day){
                if(new Date($('#leave_to').val()) < new Date($('#leave_from').val())){
                    invalid = true;
                }
            }

            if(leave_type != "Unpaid Leave"){credit = leave_type.split(" : ")[1]; leave_type = leave_type.split(" : ")[0]; }

            $.each(existing_leave_date, function(index, value){
                if(existing_leave_date[index] == date_from){
                    found = true;
                    return false;
                }
                
                if(date_from >= existing_leave_date[index] && date_from <= existing_leave_edate[index]){
                    found = true;
                    return false;
                }
                
                if(!is_one_day && !is_half_day){
                    if(date_to >= existing_leave_date[index] && date_to <= existing_leave_edate[index]){
                        found = true;
                        return false;
                    }
                }
            });

            if(reason && !found && !invalid){
                if(is_one_day == 1){ date_to = date_from; duration = 1;}
                else if(is_half_day == 1){ date_to = date_from; duration = 0.5;}
                else { const diffInMs = new Date(date_to) - new Date(date_from); duration = diffInMs / (1000 * 60 * 60 * 24); }
                if(leave_type != "Unpaid Leave" && (duration > credit)){ alert("Insufficient leave credit!"); return false; }
                    
                var button = '<button type="button" class="btn btn-sm btn-danger" id="del_leave"><i class="fas fa-trash-alt"></i> Delete</button>';
                var markup = "<tr><td>"+leave_type+"</td>"+
                         "<td>"+date_from+"</td>"+
                         "<td>"+date_to+"</td>"+
                         "<td>"+duration+"</td>"+
                         "<td>"+reason+"</td>"+
                         '<td class="text-center">'+button+"</td>"+
                         '<input type="hidden" name="leave_type[]" value="'+leave_type+'" />'+
                         '<input type="hidden" name="date_from[]" value="'+date_from+'" />'+
                         '<input type="hidden" name="date_to[]" value="'+date_to+'" />'+
                         '<input type="hidden" name="duration[]" value="'+duration+'" />'+
                         '<input type="hidden" name="reason[]" value="'+reason+'" />'+
                         "</tr>";
                $('#leave_table tbody').append(markup);
                existing_leave_date.push(date_from);
                existing_leave_edate.push(date_to);
                $('#is_one_day').prop("checked",false);
                $('#is_half_day').prop("checked",false);
                $('#leave_to').prop("readonly", false);
                $('#details').val("");
            }else if(invalid){
                alert("Leave end date is earlier than start date!");
                $('#leave_from').addClass('is-invalid');
                $('#leave_to').addClass('is-invalid');
            }else if(found){
                alert("Leave Date From : "+date_from+"\n Already exist or between date range!");
                $('#leave_from').addClass('is-invalid');
            }else{
                if(!date_from){
                    $('#leave_from').addClass('is-invalid');
                }
                if(!date_to){
                    $('#leave_to').addClass('is-invalid');
                }
                if(!reason){
                    $('#details').addClass('is-invalid');
                }
            }
        });

        $("body").on("click", "#del_leave", function (){
            if(confirm("Are you sure you want to delete this record?")){
                existing_leave_edate.splice($(this).parents("tr").index(),1);
                existing_leave_date.splice($(this).parents("tr").index(),1);
                $(this).parents("tr").remove();
            }
        });

        @endif
    });
</script>