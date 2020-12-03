@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Parameters <i class="material-icons">arrow_forward_ios</i></span> Payment Terms</h4>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m12 l12">
      <div class="card">
        <div class="card-content">
          <table class="highlight" id="term-dt">
            <thead>
              <tr>
                  <th>ID</th> 
                  <th>Name</th>
                  <th>Number of Days</th>
                  <th>From End of Month</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <a href="#addModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button" data-position="left" data-tooltip="Add Payment Term"><i class="material-icons">add</i></a>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('payment_term.store')}}">
    @csrf
      <div class="modal-content">
        <h4>Add Payment Term</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m6">
            <input placeholder="e.g 30 Days, Dated Check" name="term_name" type="text" class="validate" required>
            <label for="terms_name">Name <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="e.g 30, 7" name="term_days" type="number" class="validate" required>
            <label for="terms_days">No. of Day(s) <sup class="red-text">*</sup></label>
          </div>
          <div class="col s12 m3">
            <label>
                <br>
                <input placeholder="e.g $" name="is_endofmonth" class="filled-in" type="checkbox" />
                <span>From End of Month</span>
            </label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Save</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
  </div>

  <div id="editModal" class="modal">
    <form method="POST" action="{{route('payment_term.patch')}}">
    @csrf
      <div class="modal-content">
        <h4>Edit Payment Term</h4><br><br>
        <div class="row">
            <div class="input-field col s12 m6">
              <input type="hidden" name="id" id="edit_id">
              <input placeholder="e.g 30 Days, Dated Check" name="term_name" id="edit_term_name" type="text" class="validate" required>
              <label for="terms_name">Name <sup class="red-text">*</sup></label>
            </div>
            <div class="input-field col s12 m3">
                <input placeholder="e.g 30, 7" name="term_days" id="edit_term_days" type="number" class="validate" required>
                <label for="terms_days">No. of Day(s) <sup class="red-text">*</sup></label>
            </div>
            <div class="col s12 m3">
              <label>
                  <br>
                  <input placeholder="e.g $" name="is_endofmonth" id="edit_is_endofmonth" class="filled-in" type="checkbox" />
                  <span>From End of Month</span>
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
    <form method="POST" action="{{route('payment_term.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Payment Term</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Payment Term</strong>?</p>
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
    function editItem(id){
      $.get('payment_term/'+id, function(response){
        var data = response.data;
        $('#edit_id').val(data.id);
        $('#edit_term_name').val(data.term_name);
        $('#edit_term_days').val(data.term_days);
        $('#edit_is_endofmonth').prop( "checked", data.is_endofmonth );
        $('#editModal').modal('open');
      });
    }

    function deleteItem(id){
      $('#del_id').val(id);
      $('#deleteModal').modal('open');
    }

    var term_dt = $('#term-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        //"aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/rgc_entsys/payment_term/all",
        "columns": [
            {  "data": "id" },
            {  "data": "term_name" },
            {  "data": "term_days" },
            {
                "data": "is_endofmonth",
                "render": function ( data, type, row, meta ) {
                    if(data){ return '<strong class="green-text">Yes</strong>'; }else{return '<span class="red-text">No</span>';}
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
