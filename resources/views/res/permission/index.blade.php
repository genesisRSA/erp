@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Admin Panel<i class="material-icons">arrow_forward_ios</i></span>Site Permission</h4>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m12 l12">
      <div class="card">
        <div class="card-content">
          <table class="highlight" id="permission-dt">
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

  <a href="#addModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button" data-position="left" data-tooltip="Add Site Permission"><i class="material-icons">add</i></a>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('permission.store')}}">
    <form>
    @csrf
      <div class="modal-content">
        <h4>Add Site Permission</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m6">
            <select id="add_module" name="add_module" required>
              <option value="0" disabled selected>Choose your option</option>
              <option value="Sales Forecast">Sales Forecast</option>
              <option value="Sales Quotation">Sales Quotation</option>
              <option value="Sales Visit">Sales Visit</option>
              <option value="Procedures">Procedures</option>
            </select>
            <label for="add_module">Module<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m6">
            <select id="add_requestor" name="add_requestor" required>
              <option value="0" disabled selected>Choose your option</option>
              @foreach ($employee as $emp)
                <option value="{{$emp->emp_no}}">{{$emp->full_name}}</option>                 
              @endforeach
            </select>
            <label for="add_requestor">Requestor<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="add" id="add_ad"/>
              <span>Add</span>
            </label>
          </div>
          
          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="edit" id="add_ed"/>
              <span>Edit</span>
            </label>
          </div>
          
          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="view" id="add_vw"/>
              <span>View</span>
            </label>
          </div>
          
          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="delete" id="add_dl"/>
              <span>Delete</span>
            </label>
          </div>
          
          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="void" id="add_vd"/>
              <span>Void</span>
            </label>
          </div>
          
          <div class="input-field col s12 m4">
            <label>
              <input type="checkbox" class="filled-in" name="app" id="add_ap"/>
              <span>Approval</span>
            </label>
          </div>
          
        {{-- </div>

        <div class="row"> --}}
          <div class="col s12 m4 l4"></div>
          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="mas" id="add_mas"/>
              <span>Master List</span>
            </label>
          </div>
          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="all" id="add_all"/>
              <span>All</span>
            </label>
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
    <form method="POST" action="{{route('permission.patch')}}">
    @csrf
      <div class="modal-content">
        <h4>Add Site Permission</h4><br><br>
        <div class="row">
          <input type="hidden" name="id" id="edit_id">
          <div class="input-field col s12 m6">
            <select id="edit_module" name="module" required>
              <option value="0" disabled selected>Choose your option</option>
              <option value="Sales Forecast">Sales Forecast</option>
              <option value="Sales Quotation">Sales Quotation</option>
              <option value="Sales Visit">Sales Visit</option>
              <option value="Procedures">Procedures</option>
            </select>
            <label for="module">Module<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m6">
            <select id="edit_requestor" name="requestor" required>
              <option value="0" disabled selected>Choose your option</option>
              @foreach ($employee as $emp)
                <option value="{{$emp->emp_no}}">{{$emp->full_name}}</option>                 
              @endforeach
            </select>
            <label for="requestor">Requestor<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="add" id="edit_ad"/>
              <span>Add</span>
            </label>
          </div>
          
          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="edit" id="edit_ed"/>
              <span>Edit</span>
            </label>
          </div>
          
          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="view" id="edit_vw"/>
              <span>View</span>
            </label>
          </div>
          
          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="delete" id="edit_dl"/>
              <span>Delete</span>
            </label>
          </div>
          
          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="void" id="edit_vd"/>
              <span>Void</span>
            </label>
          </div>
          
          <div class="input-field col s12 m4">
            <label>
              <input type="checkbox" class="filled-in" name="app" id="edit_ap"/>
              <span>Approval</span>
            </label>
          </div>
          
          <div class="col s12 m4 l4"></div>
          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="mas" id="edit_mas"/>
              <span>Master List</span>
            </label>
          </div>
          <div class="input-field col s12 m4 l4">
            <label>
              <input type="checkbox" class="filled-in" name="all" id="edit_all"/>
              <span>All</span>
            </label>
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
    <form method="POST" action="{{route('permission.delete')}}">
      <form>
        @csrf
        <div class="modal-content">
            <h4>Delete Site Permission</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Site Permission</strong>?</p>
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

    $(document).ready(function(){
     
      $('#add_all').on('click', function(){
        var all = document.getElementById('add_all').checked;
          if(all==true)
          {
            $('#add_ad').prop('checked', true);
            $('#add_ed').prop('checked', true);
            $('#add_vw').prop('checked', true);
            $('#add_dl').prop('checked', true);
            $('#add_vd').prop('checked', true);
            $('#add_ap').prop('checked', true);
            $('#add_mas').prop('checked', true);
          }
          else
          {
            $('#add_ad').prop('checked', false);
            $('#add_ed').prop('checked', false);
            $('#add_vw').prop('checked', false);
            $('#add_dl').prop('checked', false);
            $('#add_vd').prop('checked', false);
            $('#add_ap').prop('checked', false);
            $('#add_mas').prop('checked', false);
          }
      });
      
      $('#edit_all').on('click', function(){
        var all = document.getElementById('edit_all').checked;
          if(all==true)
          {
            $('#edit_ad').prop('checked', true);
            $('#edit_ed').prop('checked', true);
            $('#edit_vw').prop('checked', true);
            $('#edit_dl').prop('checked', true);
            $('#edit_vd').prop('checked', true);
            $('#edit_ap').prop('checked', true);
            $('#edit_mas').prop('checked', true);
          }
          else
          {
            $('#edit_ad').prop('checked', false);
            $('#edit_ed').prop('checked', false);
            $('#edit_vw').prop('checked', false);
            $('#edit_dl').prop('checked', false);
            $('#edit_vd').prop('checked', false);
            $('#edit_ap').prop('checked', false);
            $('#edit_mas').prop('checked', false);
          }
      });
      
    });


    function editItem(id){
        $.get('permission/'+id, function(response){
 
            var data = response.data;
            var dataEmp = data.employee_details;
            var permission = data.permission;
            var permissionMatrix = JSON.parse(permission);

            $('#edit_id').val(data.id);
            $('#edit_module option[value="'+data.module+'"]').prop('selected', true);
            $('#edit_module').formSelect();
            $('#edit_requestor option[value="'+dataEmp.emp_no+'"]').prop('selected', true);
            $('#edit_requestor').formSelect();

            $('#edit_ad').prop('checked', permissionMatrix[0].add);
            $('#edit_ed').prop('checked', permissionMatrix[0].edit);
            $('#edit_vw').prop('checked', permissionMatrix[0].view);
            $('#edit_dl').prop('checked', permissionMatrix[0].delete);
            $('#edit_vd').prop('checked', permissionMatrix[0].void);
            $('#edit_ap').prop('checked', permissionMatrix[0].approval);
            $('#edit_mas').prop('checked', permissionMatrix[0].masterlist);
          
 
            $('#editModal').modal('open');
        });
    }

    function deleteItem(id){
        $('#del_id').val(id);
        $('#deleteModal').modal('open');
    }

    var permission_dt = $('#permission-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/permission/all",
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
