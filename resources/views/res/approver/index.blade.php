@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Admin Panel<i class="material-icons">arrow_forward_ios</i></span>Approver Matrix</h4>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m12 l12">
      <div class="card">
        <div class="card-content">
          <table class="highlight" id="approver-dt">
            <thead>
              <tr>
                  <th>ID</th> 
                  <th>Module</th> 
                  <th>Requestor</th> 
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <a href="#addModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button" data-position="left" data-tooltip="Add Approver Details"><i class="material-icons">add</i></a>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('approver.store')}}">
    {{-- <form> --}}
    @csrf
      <div class="modal-content">
        <h4>Add Approver Matrix Details</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m6">
            <select id="app_module" name="app_module" required>
              <option value="0" disabled selected>Choose your option</option>
              <option value="Sales Forecast">Sales Forecast</option>
              <option value="Sales Order">Sales Order</option>
              <option value="Sales Quotation">Sales Quotation</option>
              <option value="Sales Visit">Sales Visit</option>
              <option value="Procedures">Procedures</option>
              <option value="Drawings">Drawings</option>
              <option value="Issuance">Inventory Issuance</option>
              <option value="RTV">Inventory RTV</option>
            </select>
            <label for="app_module">Module<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <select name="app_req" id="app_req" required>
              <option value="0" disabled selected>Choose your option</option>
              @foreach ($employee as $emp)
                <option value="{{$emp->emp_no}}">{{$emp->full_name}}</option>                 
              @endforeach
            </select>
            <label for="app_req">Requestor<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m4">
            <select name="app_approver" id="app_approver" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($employee as $emp)
               <option value="{{$emp->emp_no}}">{{$emp->full_name}}</option>                 
              @endforeach
            </select>
            <label for="app_approver">Approver<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m4">
            <select name="app_nstatus" id="app_nstatus" required>
              <option value="0" disabled selected>Choose your option</option>
             
              <option value="For Review">For Review</option>
              <option value="For Approval">For Approval</option>
              <option value="Approved">Approved</option>
          
            </select>
            <label for="app_nstatus">Status<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m4">
            <label>
              <input type="checkbox" name="app_gate" id="app_gate"/>
              <span>Is Gate?</span>
            </label>
          </div>
        </div>

        <div class="row">
          <div class="col s12 m12 l12">
            <button type="button" name="btnAdd" id="btnAdd" class="blue waves-effect waves-light btn"><i class="material-icons left">add_box</i>Add Approver</button>
            <button type="button" name="btnDel" id="btnDel" class="red waves-effect waves-light btn"><i class="material-icons left">delete_sweep</i>Clear All</button>
          </div> 
        </div>

        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card">
              <div class="card-content">
                <table class="highlight" id="matrix-dt">
                  <thead>
                    <tr>
                        <th>Sequence</th> 
                        <th>Approver</th> 
                        <th>Status</th> 
                        <th>Gate</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Save</button>
        <a href="#!" onclick="NStatus=[]" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
  </div>

  <div id="editModal" class="modal">
    <form method="POST" action="{{route('approver.patch')}}">
    @csrf
      <div class="modal-content">
        <h4>Edit Approver Matrix Details</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m6">
            <input type="hidden" id="edit_id" name="edit_id"/>
            <select id="edit_app_module" name="edit_app_module" required>
              <option value="0" disabled selected>Choose your option</option>
              <option value="Sales Forecast">Sales Forecast</option>
              <option value="Sales Order">Sales Order</option>
              <option value="Sales Quotation">Sales Quotation</option>
              <option value="Sales Visit">Sales Visit</option>
              <option value="Procedures">Procedures</option>
              <option value="Drawings">Drawings</option>
              <option value="Issuance">Inventory Issuance</option>
              <option value="RTV">Inventory RTV</option>
            </select>
            <label for="edit_app_module">Module<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <select name="edit_app_req" id="edit_app_req" required>
              <option value="0" disabled selected>Choose your option</option>
              @foreach ($employee as $emp)
                <option value="{{$emp->emp_no}}">{{$emp->full_name}}</option>                 
              @endforeach
            </select>
            <label for="edit_app_req">Requestor<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m4">
            <select name="edit_app_approver" id="edit_app_approver">
              <option value="" disabled selected>Choose your option</option>
              @foreach ($employee as $emp)
               <option value="{{$emp->emp_no}}">{{$emp->full_name}}</option>                 
              @endforeach
            </select>
            <label for="edit_app_approver">Approver<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m4">
            <select name="edit_app_nstatus" id="edit_app_nstatus">
              <option value="0" disabled selected>Choose your option</option>
             
              <option value="For Review">For Review</option>
              <option value="For Approval">For Approval</option>
              <option value="Approved">Approved</option>
          
            </select>
            <label for="edit_app_nstatus">Status<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m4">
            <label>
              <input type="checkbox" name="edit_app_gate" id="edit_app_gate"/>
              <span>Is Gate?</span>
            </label>
          </div>
        </div>

        <div class="row">
          <div class="col s12 m12 l12">
            <button type="button" name="btnAddEdit" id="btnAddEdit" class="blue waves-effect waves-light btn"><i class="material-icons left">add_box</i>Add Approver</button>
            <button type="button" name="btnDelEdit" id="btnDelEdit" class="red waves-effect waves-light btn"><i class="material-icons left">delete_sweep</i>Clear All</button>
          </div>
        </div>

        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card">
              <div class="card-content">
                <table class="highlight" id="matrix-dt-edit">
                  <thead>
                    <tr>
                        <th>Sequence</th> 
                        <th>Approver</th> 
                        <th>Status</th> 
                        <th>Gate</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Update</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
  </div>

  <div id="deleteModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('approver.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Approver Matrix</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Approver Matrix</strong>?</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Yes</button>
            <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
        </div>
    </form>
  </div>

  <!-- End of MODALS -->

  <!-- SCRIPTS -->
  
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">
    var NStatus = [];
    var NEStaus = [];
    $(document).ready(function(){
      // var SeqAdd = 0;
      // var SeqEdit = 0;
     
      $('#btnAdd').on('click', function(){
        addRow('#btnAdd');
      });

      $('#btnDel').on('click', function(){
        deleteAllRow('#btnDel');
      });

      $('#btnAddEdit').on('click', function(){
        addRow('#btnAddEdit');
      });

      $('#btnDelEdit').on('click', function(){
        deleteAllRow('#btnDelEdit');
      });
    });


    function showTableData() {

        var myTab = document.getElementById('matrix-dt');

        for (i = 1; i < myTab.rows.length; i++) {
            var objCells = myTab.rows.item(i).cells;
            for (var j = 0; j < objCells.length; j++) {
                var objcel = objCells.item(2).innerHTML;
            }

        }
       
    }

    function deleteRow(r) {
      var i = r.parentNode.parentNode.rowIndex;
      document.getElementById("matrix-dt").deleteRow(i);
    }

    function addRow(btn){
      if(btn == '#btnAdd'){

        var ApproverID = $('#app_approver').val();
        var Approverx = document.getElementById("app_approver");
        var ApproverText = Approverx.options[Approverx.selectedIndex].text;
        var Gatex = document.getElementById("app_gate").checked;
        var Status = $('#app_nstatus').val();
        var found = false;

        if($.inArray(Status,NStatus) > -1){
          found = true;
        } else {
          found = false;
        }

        if(!found)
        {
          if(ApproverText!='Choose your option' && Status != null)
            {
              NStatus.push(Status);

              var myTab = document.getElementById('matrix-dt');
              var SeqAdd = myTab.rows.length - 1;
              
              $('#matrix-dt').find('tbody').append("<tr>"+
              "<td>" + SeqAdd + "</td>" + 
              "<td>" + ApproverText + "</td>" + 
              "<td>" + Status + "</td>" +
              "<td>" + Gatex + "</td>" +
              '<input type="hidden" name="app_seq[]" value="'+SeqAdd+'"/>' + 
              '<input type="hidden" name="app_id[]" value="'+ApproverID+'"/>'+
              '<input type="hidden" name="app_fname[]" value="'+ApproverText+'"/>'+
              '<input type="hidden" name="app_nstatus[]" value="'+Status+'"/>'+
              '<input type="hidden" name="app_gate[]" value="'+Gatex+'"/>'+
              "</tr>");

        
            }
        }
      } 
      else 
      {
        var ApproverID = $('#edit_app_approver').val();
        var Approverx = document.getElementById("edit_app_approver");
        var ApproverText = Approverx.options[Approverx.selectedIndex].text;

        var Gatex = document.getElementById("edit_app_gate").checked;
        var Status = $('#edit_app_nstatus').val();
        var found = false;

        if($.inArray(Status,NEStatus) > -1){
          found = true;
        } else {
          found = false;
        }

        if(!found)
        {
            if(ApproverText!='Choose your option' && Status != null)
            {
              NEStatus.push(Status);
              var myTab = document.getElementById('matrix-dt-edit');
              var SeqEdit = myTab.rows.length - 1;
              
              $('#matrix-dt-edit').find('tbody').append("<tr>"+
              "<td>" + SeqEdit + "</td>" + 
              "<td>" + ApproverText + "</td>" + 
              "<td>" + Status + "</td>" +
              "<td>" + Gatex + "</td>" +
              '<input type="hidden" name="edit_app_seq[]" value="'+SeqEdit+'"/>' + 
              '<input type="hidden" name="edit_app_id[]" value="'+ApproverID+'"/>'+
              '<input type="hidden" name="edit_app_fname[]" value="'+ApproverText+'"/>'+
              '<input type="hidden" name="edit_app_nstatus[]" value="'+Status+'"/>'+
              '<input type="hidden" name="edit_app_gate[]" value="'+Gatex+'"/>'+
              "</tr>");
            }
        }
      }
      

    }

    function deleteAllRow(btn) {
      if(btn == '#btnDel'){
        var myTable = document.getElementById("matrix-dt");
        var rowCount = myTable.rows.length;
        for (var x=rowCount-1; x>0; x--) 
        {
          myTable.deleteRow(x); 
        }
        NStatus = [];
        NEStatus = [];
      } else {
        var myTable = document.getElementById("matrix-dt-edit");
        var rowCount = myTable.rows.length;
        for (var x=rowCount-1; x>0; x--) 
        {
          myTable.deleteRow(x); 
        }
        NStatus = [];
        NEStatus = [];
      }
    }

    function editItem(id){
        $.get('approver/'+id, function(response){
            NStatus = [];
            deleteAllRow('#btnDelEdit');
            var data = response.data;
            var dataEmp = data.employee_details;
            var dataMatrix = data.matrix;


            $('#edit_id').val(data.id);
            $('#edit_app_module option[value="'+data.module+'"]').prop('selected', true);
            $('#edit_app_module').formSelect();
            $('#edit_app_req option[value="'+dataEmp.emp_no+'"]').prop('selected', true);
            $('#edit_app_req').formSelect();
          
            var matrix = JSON.parse(dataMatrix);

            //console.log(matrix);
            var AppendString = "";
            var i, j = "";

            for(i in matrix)
              {
                for(j in matrix[i].sequence)
                {
                  AppendString += "<tr><td>" + matrix[i].sequence + 
                    "</td><td>" + matrix[i].approver_name + 
                      "</td><td>" + matrix[i].next_status + 
                        "</td><td>" + matrix[i].is_gate + 
                          '</td><input type="hidden" name="edit_app_seq[]" value="'+matrix[i].sequence+'"/>' +
                               '<input type="hidden" name="edit_app_id[]" value="'+matrix[i].approver_emp_np+'"/>' +
                               '<input type="hidden" name="edit_app_fname[]" value="'+matrix[i].approver_name+'"/>' +
                               '<input type="hidden" name="edit_app_nstatus[]" value="'+matrix[i].next_status+'"/>' +
                               '<input type="hidden" name="edit_app_gate[]" value="'+matrix[i].is_gate+'"/></tr>';
                  NEStatus.push(matrix[i].next_status);
                }
              }

            $('#matrix-dt-edit').find('tbody').append(AppendString);
            
            $('#editModal').modal('open');
        });
    }

    function deleteItem(id){
        $('#del_id').val(id);
        $('#deleteModal').modal('open');
    }

    var category_dt = $('#approver-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/approver/all",
        "columns": [
            {  "data": "id" },
            {  "data": "module" },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.employee_details.full_name;
                }
            },
            {
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editItem('+data+')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+data+')"><i class="material-icons">delete</i></a>';
                }
            }
        ] 
    });
  </script>

  <!-- End of SCRIPTS -->

@endsection
