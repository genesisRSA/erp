@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Master Data <i class="material-icons">arrow_forward_ios</i></span> Vendor</h4>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m12 l12">
      <div class="card">
        <div class="card-content">
          <table class="highlight" id="vendor-dt">
            <thead>
              <tr>
                  <th>ID</th> 
                  <th>Name</th>
                  <th>Code</th>
                  <th>Reference No.</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <a href="#addModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button" data-position="left" data-tooltip="Add Vendor"><i class="material-icons">add</i></a>
 
  <!-- MODALS -->

  <div id="addModal" class="modal modal-fixed-footer">
    <form method="POST" action="{{route('vendor.store')}}">
    @csrf
      <div class="modal-content">
        <h4>Add Vendor</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m6">
            <input placeholder="RTI System Automation Inc." name="ven_name" type="text" class="validate" required>
            <label for="ven_name">Name <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="e.g RSA" name="ven_code" type="text" class="validate" required>
            <label for="ven_code">Code <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="e.g 002" name="ven_num_code" type="text" class="validate" required>
            <label for="ven_num_code">Reference No. <sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m3">
            <select name="ven_type" required>
              <option value="" disabled selected>Choose your option</option>
              <option value="Local">Local</option>
              <option value="Government">Government</option>
              <option value="Foreign">Foreign</option>
            </select>
            <label>Type <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <select name="currency_id" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($currency as $c)
                <option value="{{$c->id}}">{{$c->currency_name.' ('.$c->symbol.')'}}</option>
              @endforeach
            </select>
            <label>Currency <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <select name="term_id" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($terms as $t)
                <option value="{{$t->id}}">{{$t->term_name}}</option>
              @endforeach
            </select>
            <label>Payment Term <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <select name="vat_type" required>
              <option value="" disabled selected>Choose your option</option>
              <option value="VAT-inclusive">VAT-inclusive</option>
              <option value="VAT-exclusive">VAT-exclusive</option>
              <option value="Zero-rated">Zero-rated</option>
              <option value="VAT-exempt">VAT-exempt</option>
            </select>
            <label>Vat Type <sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m3">
            <input placeholder="e.g 123-456-789-000" name="ven_tin" type="text" class="validate" required>
            <label for="ven_tin">TIN <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="e.g http://www.rsa.com.ph/" name="ven_website" type="text" class="validate">
            <label for="ven_website">Website</label>
          </div>
          <div class="input-field col s12 m6">
            <textarea id="ven_address" name="ven_address" class="materialize-textarea" required></textarea>
            <label for="ven_address">Address <sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m3">
            <input placeholder="e.g info@rsa.com.ph" name="ven_email" type="text" class="validate" required>
            <label for="ven_email">Email <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="e.g (046) 123-4567" name="ven_no" type="text" class="validate" required>
            <label for="ven_no">Phone No. <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="e.g John Doe" name="ven_person" type="text" class="validate" required>
            <label for="ven_person">Contact Person <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="e.g Buyer" name="ven_person_pos" type="text" class="validate" required>
            <label for="ven_person_pos">Contact Person Position <sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m12">
            <textarea id="remarks" name="remarks" class="materialize-textarea"></textarea>
            <label for="remarks">Remarks</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Save</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
  </div>

  <div id="editModal" class="modal modal-fixed-footer">
    <form method="POST" action="{{route('vendor.patch')}}">

    @csrf
      <div class="modal-content">
        <h4>Edit Vendor</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m6">
            <input type="hidden" name="id" id="edit_id">
            <input placeholder="RTI System Automation Inc." id="edit_ven_name" name="ven_name" type="text" class="validate" required>
            <label for="ven_name">Name <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="e.g RSA" id="edit_ven_code" name="ven_code" type="text" class="validate" required>
            <label for="ven_code">Code <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="e.g 002" id="edit_ven_num_code" name="ven_num_code" type="text" readonly>
            <label for="ven_num_code">Reference No.</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m3">
            <select id="edit_ven_type" name="ven_type" required>
              <option value="" disabled selected>Choose your option</option>
              <option value="Local">Local</option>
              <option value="Government">Government</option>
              <option value="Foreign">Foreign</option>
            </select>
            <label>Type <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <select id="edit_currency_id" name="currency_id" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($currency as $c)
                <option value="{{$c->id}}">{{$c->currency_name.' ('.$c->symbol.')'}}</option>
              @endforeach
            </select>
            <label>Currency <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <select id="edit_term_id" name="term_id" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($terms as $t)
                <option value="{{$t->id}}">{{$t->term_name}}</option>
              @endforeach
            </select>
            <label>Payment Term <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <select id="edit_vat_type" name="vat_type" required>
              <option value="" disabled selected>Choose your option</option>
              <option value="VAT-inclusive">VAT-inclusive</option>
              <option value="VAT-exclusive">VAT-exclusive</option>
              <option value="Zero-rated">Zero-rated</option>
              <option value="VAT-exempt">VAT-exempt</option>
            </select>
            <label>Vat Type <sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m3">
            <input placeholder="e.g 123-456-789-000" id="edit_ven_tin" name="ven_tin" type="text" class="validate" required>
            <label for="ven_tin">TIN <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="e.g http://www.rsa.com.ph/" id="edit_ven_website" name="ven_website" type="text" class="validate">
            <label for="ven_website">Website</label>
          </div>
          <div class="input-field col s12 m6">
            <textarea id="edit_ven_address" name="ven_address" class="materialize-textarea" required></textarea>
            <label for="ven_address">Address <sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m3">
            <input placeholder="e.g info@rsa.com.ph" id="edit_ven_email" name="ven_email" type="text" class="validate" required>
            <label for="ven_email">Email <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="e.g (046) 123-4567" id="edit_ven_no" name="ven_no" type="text" class="validate" required>
            <label for="ven_no">Phone No. <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="e.g John Doe" id="edit_ven_person" name="ven_person" type="text" class="validate" required>
            <label for="ven_person">Contact Person <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="e.g Buyer" id="edit_ven_person_pos" name="ven_person_pos" type="text" class="validate" required>
            <label for="ven_person_pos">Contact Person Position <sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m12">
            <textarea id="edit_remarks" name="remarks" class="materialize-textarea"></textarea>
            <label for="remarks">Remarks</label>
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
    <form method="POST" action="{{route('vendor.delete')}}">
      
        @csrf
        <div class="modal-content">
            <h4>Delete Vendor</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Vendor</strong>?</p>
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
      $.get('vendor/'+id, function(response){
        var data = response.data;
        $('#edit_id').val(data.id);
        $('#edit_ven_name').val(data.ven_name);
        $('#edit_ven_code').val(data.ven_code);
        $('#edit_ven_num_code').val(data.ven_num_code);
        $('#edit_ven_type option[value="'+data.ven_type+'"]').prop('selected', true);
        $('#edit_ven_type').formSelect();
        $('#edit_currency_id option[value="'+data.currency_id+'"]').prop('selected', true);
        $('#edit_currency_id').formSelect();
        $('#edit_term_id option[value="'+data.term_id+'"]').prop('selected', true);
        $('#edit_term_id').formSelect();
        $('#edit_vat_type option[value="'+data.vat_type+'"]').prop('selected', true);
        $('#edit_vat_type').formSelect();
        $('#edit_ven_tin').val(data.ven_tin);
        $('#edit_ven_website').val(data.ven_website);
        $('#edit_ven_address').val(data.ven_address);
        $('#edit_ven_email').val(data.ven_email);
        $('#edit_ven_no').val(data.ven_no);
        $('#edit_ven_person').val(data.ven_person);
        $('#edit_ven_person_pos').val(data.ven_person_pos);
        $('#edit_remarks').val(data.remarks);
        $('#editModal').modal('open');
        M.updateTextFields();
        $('.materialize-textarea').each(function (index) {
            M.textareaAutoResize(this);
        });
      });
    }

    function deleteItem(id){
      $('#del_id').val(id);
      $('#deleteModal').modal('open');
    }

    var vendor_dt = $('#vendor-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        //"aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/rgc_entsys/vendor/all",
        "columns": [
            {  "data": "id" },
            {  "data": "ven_name" },
            {  "data": "ven_code" },
            {  "data": "ven_num_code" },
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
