@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Parameters <i class="material-icons">arrow_forward_ios</i></span> Currencies</h4>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m12 l12">
      <div class="card">
        <div class="card-content">
          <table class="highlight" id="currency-dt">
            <thead>
              <tr>
                  <th>ID</th> 
                  <th>Name</th>
                  <th>Code</th>
                  <th>Representation in Words</th>
                  <th>Symbol</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <a href="#addModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button" data-position="left" data-tooltip="Add Currency"><i class="material-icons">add</i></a>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('currency.store')}}">
    @csrf
      <div class="modal-content">
        <h4>Add Currency</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m6">
            <input placeholder="e.g US Dollar" name="currency_name" type="text" class="validate" required>
            <label for="currency_name">Currency Name <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <input placeholder="e.g USD" name="currency_code" type="text" class="validate" required>
            <label for="currency_code">Currency Code <sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m8">
            <input placeholder="e.g Pesos" name="currency_words" type="text" class="validate" required>
            <label for="currency_words">Representation in Words <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m4">
            <input placeholder="e.g $" name="symbol" type="text" class="validate" required>
            <label for="symbol">Symbol <sup class="red-text">*</sup></label>
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
    <form method="POST" action="{{route('currency.patch')}}">
    @csrf
      <div class="modal-content">
        <h4>Edit Currency</h4><br><br>
        <div class="row">
            <div class="input-field col s12 m6">
              <input type="hidden" name="id" id="edit_id">
              <input placeholder="e.g US Dollar" name="currency_name" id="edit_currency_name" type="text" class="validate" required>
              <label for="currency_name">Currency Name <sup class="red-text">*</sup></label>
            </div>
            <div class="input-field col s12 m6">
              <input placeholder="e.g USD" name="currency_code" id="edit_currency_code" type="text" class="validate" required>
              <label for="currency_code">Currency Code <sup class="red-text">*</sup></label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12 m8">
              <input placeholder="e.g Pesos" name="currency_words" id="edit_currency_words" type="text" class="validate" required>
              <label for="currency_words">Representation in Words <sup class="red-text">*</sup></label>
            </div>
            <div class="input-field col s12 m4">
              <input placeholder="e.g $" name="symbol" id="edit_symbol" type="text" class="validate" required>
              <label for="symbol">Symbol <sup class="red-text">*</sup></label>
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
    <form method="POST" action="{{route('currency.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Currency</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Currency</strong>?</p>
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
      $.get('currency/'+id, function(response){
        var data = response.data;
        $('#edit_id').val(data.id);
        $('#edit_currency_name').val(data.currency_name);
        $('#edit_currency_code').val(data.currency_code);
        $('#edit_currency_words').val(data.currency_words);
        $('#edit_symbol').val(data.symbol);
        $('#editModal').modal('open');
      });
    }

    function deleteItem(id){
      $('#del_id').val(id);
      $('#deleteModal').modal('open');
    }

    var currency_dt = $('#currency-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        //"aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/currency/all",
        "columns": [
            {  "data": "id" },
            {  "data": "currency_name" },
            {  "data": "currency_code" },
            {  "data": "currency_words" },
            {  "data": "symbol" },
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
