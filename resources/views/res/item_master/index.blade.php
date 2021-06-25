@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    {{-- id,cat_code,subcat_code,item_code,item_desc,oem_partno (Optional) ,uom_code,safety_stock,maximum_stock, length (Optional) , width, (Optional)  thickness (Optional) , radius (Optional) --}}
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Master Data<i class="material-icons">arrow_forward_ios</i></span> Item Master</h4>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m12 l12">
      <div class="card">
        <div class="card-content">
          <table class="highlight" id="itemmaster-dt">
            <thead>
              <tr>
                  <th>ID</th> 
                  <th>Item Category</th>
                  <th>Item Sub-Category</th>
                  <th>Item Code</th>
                  <th>Item Description</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <a href="#addModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button" data-position="left" data-tooltip="Add Item"><i class="material-icons">add</i></a>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('item_master.store')}}">
    @csrf
      <div class="modal-content">
        <h4>Add Item Master Details</h4><br><br>

        <div class="row">
          <div class="input-field col s12 m6">
            <select id="add_item_cat_code" name="item_cat_code" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($itemcat as $ic)
                <option value="{{$ic->cat_code}}">{{$ic->cat_desc}}</option>
              @endforeach
            </select>
            <label for="item_cat_code">Category<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <select id="add_item_subcat_code" name="item_subcat_code" required></select>
            <label for="item_subcat_code">Sub-Category<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m4">
            <input placeholder="" name="item_code" type="text" class="validate" required>
            <label for="item_code">Item Code<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m8">
            <textarea placeholder="" name="item_desc" class="materialize-textarea" required></textarea>
            <label for="item_desc">Item Description<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m5">
            <input placeholder="" name="oem_partno" id="add_item_oem" type="text" class="validate">
            <label for="oem_partno">OEM Part Number<sup class="red-text">(optional)</sup></label>
 
            <div class="col s12 m6 left-align">
              <label>
                  <input style="" placeholder="e.g $" type="checkbox" onclick="distext('add_item_oem')"/>
                  <span style="font-size: 12px">Click to set N/A</span>
              </label>
            </div>
          </div>

          <div class="input-field col s12 m5">
            <select id="add_item_uom" name="item_uom" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($uom as $i)
                <option value="{{$i->uom_code}}">{{$i->uom_name}}</option>
              @endforeach
            </select>
            <label for="item_uom">Unit Of Measure<sup class="red-text">*</sup></label>
          </div>
          
          <div class="input-field col s12 m2">
            <label>
              <input type="hidden" id="add_serialized" name="serialized" value="0">
              <input style="" placeholder="e.g $" type="checkbox" onclick="serialText('add_serialized')"/>
              <span>Serialized</span>
            </label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m4">
            <input placeholder="" name="item_safety" type="number" class="number validate" required>
            <label for="item_safety">Safety Stock <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m4">
            <input placeholder="" name="item_warning" type="number" class="number validate" required>
            <label for="item_warning">Warning Level<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m4">
            <input placeholder="" name="item_max" type="number" class="number validate" required>
            <label for="item_max">Maximum Stock <sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row" style="display:none" id="adtlinfo">
          <div class="input-field col s12 m6">
            <input placeholder="" name="item_length" id="add_item_length" type="number" step="0.0001" class="number validate">
            <label for="item_length">Length<sup class="red-text"></sup></label>
            <div class="col s12 m6 left-align">
              <label>
                  <input placeholder="e.g $"  type="checkbox" onclick="distext('add_item_length')"/>
                    <span style="font-size: 12px">Click to set N/A</span>
              </label>
            </div>
          </div>

          <div class="input-field col s12 m6">
            <input placeholder="" name="item_width" id="add_item_width" type="number" step="0.0001" class="number validate">
            <label for="item_width">Width<sup class="red-text"></sup></label>
            <div class="col s12 m6 left-align">
              <label>
                  <input placeholder="e.g $"  type="checkbox" onclick="distext('add_item_width')"/>
                    <span style="font-size: 12px">Click to set N/A</span>
              </label>
            </div>
          </div>
 
          <div class="input-field col s12 m6">
            <input placeholder="" name="item_thickness" id="add_item_thickness" type="number" step="0.0001" class="number validate">
            <label for="item_thickness">Thickness<sup class="red-text"></sup></label>
            <div class="col s12 m6 left-align">
              <label>
                  <input placeholder="e.g $"  type="checkbox" onclick="distext('add_item_thickness')"/>
                    <span style="font-size: 12px">Click to set N/A</span>
              </label>
            </div>
          </div>

          <div class="input-field col s12 m6">
            <input placeholder="" name="item_radius" id="add_item_radius" type="number" step="0.0001" class="number validate">
            <label for="item_radius">Radius<sup class="red-text">*</sup></label>
            <div class="col s12 m6 left-align">
              <label>
                  <input placeholder="e.g $"  type="checkbox" onclick="distext('add_item_radius')"/>
                    <span style="font-size: 12px">Click to set N/A</span>
              </label>
            </div>
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
    <form method="POST" action="{{route('item_master.patch')}}">
    @csrf
      <div class="modal-content">
        <h4>Edit Item Master Details</h4><br><br>

        <div class="row">
          <div class="input-field col s12 m6">
            <input type="hidden" name="id" id="edit_id">
            <select id="edit_item_cat_code" name="item_cat_code" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($itemcat as $ic)
                <option value="{{$ic->cat_code}}">{{$ic->cat_desc}}</option>
              @endforeach
            </select>
            <label for="item_cat_code">Category<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <select id="edit_item_subcat_code" name="item_subcat_code" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($itemsubcat as $isc)
                <option value="{{$isc->subcat_code}}">{{$isc->subcat_desc}}</option>
              @endforeach
            </select>
            <label for="item_subcat_code">Sub-Category<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m4">
            <input placeholder="" id="edit_item_code" name="item_code" type="text" class="validate" required>
            <label for="item_code">Item Code<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m8">
            <textarea id="edit_item_desc" name="item_desc" class="materialize-textarea" required></textarea>
            <label for="item_desc">Item Description<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m5">
            <input placeholder="" id="edit_item_oem" name="oem_partno" type="text" class="validate">
            <label for="oem_partno">OEM Part Number<sup class="red-text">(optional)</sup></label>
            <div class="col s12 m6 left-align">
              <label>
                  <input placeholder="e.g $" name="is_na_oem" type="checkbox" onclick="distext('edit_item_oem')"/>
                  <span style="font-size: 12px">Click to set N/A</span>
              </label>
            </div>
          </div>
       
          <div class="input-field col s12 m5">
            <select id="edit_item_uom" name="item_uom" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($uom as $i)
                <option value="{{$i->uom_code}}">{{$i->uom_name}}</option>
              @endforeach
            </select>
            <label for="item_uom">Unit Of Measure<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m2">
            <label>
              <input type="hidden" id="edit_serialized" name="serialized">
              <input id="serialx" style="" placeholder="e.g $" type="checkbox" onclick="serialEdit('edit_serialized')"/>
              <span>Serialized</span>
            </label>
          </div>
        </div>
        
        <div class="row">
          <div class="input-field col s12 m4">
            <input placeholder="" id="edit_item_safety" name="item_safety" type="number" class="number validate" required>
            <label for="item_safety">Safety Stock<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m4">
            <input placeholder="" id="edit_item_warning" name="item_warning" type="number" class="number validate" required>
            <label for="item_warning">Warning Level<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m4">
            <input placeholder="" id="edit_item_max" name="item_max" type="number" class="number validate" required>
            <label for="item_max">Maximum Stock<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row" style="display:block" id="adtlinfoedit">
          <div class="input-field col s12 m6">
            <input placeholder="" id="edit_item_length" name="item_length" type="number" step="0.0001" class="number validate">
            <label for="item_length">Length<sup class="red-text">*</sup></label>
            <div class="col s12 m6 left-align">
              <label>
                  <input placeholder="e.g $" name="is_na_len" type="checkbox" onclick="distext('edit_item_length')"/>
                  <span style="font-size: 12px">Click to set N/A</span>
              </label>
            </div>
          </div>
        
          <div class="input-field col s12 m6">
            <input placeholder="" id="edit_item_width" name="item_width" type="number" step="0.0001" class="number validate">
            <label for="item_width">Width<sup class="red-text">*</sup></label>
            <div class="col s12 m6 left-align">
              <label>
                  <input placeholder="e.g $" name="is_na_wid" type="checkbox" onclick="distext('edit_item_width')"/>
                  <span style="font-size: 12px">Click to set N/A</span>
              </label>
            </div>
          </div>

          <div class="input-field col s12 m6">
            <input placeholder="" id="edit_item_thickness" name="item_thickness" type="number" step="0.0001" class="number validate">
            <label for="item_thickness">Thickness<sup class="red-text">*</sup></label>
            <div class="col s12 m6 left-align">
              <label>
                  <input placeholder="e.g $" name="is_na_thic" type="checkbox" onclick="distext('edit_item_thickness')"/>
                  <span style="font-size: 12px">Click to set N/A</span>
              </label>
            </div>
          </div>

          <div class="input-field col s12 m6">
            <input placeholder="" id="edit_item_radius" name="item_radius" type="number" step="0.0001" class="number validate">
            <label for="item_radius">Radius<sup class="red-text">*</sup></label>
            <div class="col s12 m6 left-align">
              <label>
                  <input placeholder="e.g $" name="is_na_rad" type="checkbox" onclick="distext('edit_item_radius')"/>
                  <span style="font-size: 12px">Click to set N/A</span>
              </label>
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
    <form method="POST" action="{{route('item_master.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Item</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Item</strong>?</p>
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
   {{-- <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script> --}}
  <script type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.js"></script>
 
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>

  <script type="text/javascript">
  
    $('.number').on('keypress', function(evt){
      var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;

        return true;
    })

    $(document).ready(function () {
 
        $('#add_item_cat_code').change(function () {
             var id = $(this).val();

          $('#add_item_subcat_code').find('option').remove();

            $.ajax({
              url:'/reiss/item_master/getSubCategory/'+id,
              type:'get',
              dataType:'json',
              success:function (response) {
                  var dropdown = $("#add_item_subcat_code");
                  var len = 0;
                  if (response.data != null) {
                      len = response.data.length;
                  }

                  if (len>0) {
                      for (var i = 0; i<len; i++) {
                            var id = response.data[i].subcat_code;
                            var name = response.data[i].subcat_desc;

                            var option = "<option value='"+id+"'>"+name+"</option>"; 
                            dropdown.append(option);
                      }
                  }
                  dropdown.formSelect();
              }
            });
        });

        $('#edit_item_cat_code').change(function () {
             var id = $(this).val();

          $('#edit_item_subcat_code').find('option').remove();

            $.ajax({
              url:'/reiss/item_master/getSubCategory/'+id,
              type:'get',
              dataType:'json',
              success:function (response) {
                  var dropdown = $("#edit_item_subcat_code");
                  var len = 0;
                  if (response.data != null) {
                      len = response.data.length;
                  }

                  if (len>0) {
                      for (var i = 0; i<len; i++) {
                            var id = response.data[i].subcat_code;
                            var name = response.data[i].subcat_desc;

                            var option = "<option value='"+id+"'>"+name+"</option>"; 
                            dropdown.append(option);
                      }
                  }
                  dropdown.formSelect();
              }
            });
        });
    });


    $("select[name='item_cat_code']").on('change', function()
    {
        var catx = $(this).val();
        var x = document.getElementById("adtlinfo");
        if(catx == 'FAB')
        {
          x.style.display = "block";
        }
        else 
        {
          x.style.display = "none";
        }
    })

    
    $('#edit_item_cat_code').on('change', function()
    {
        var catx = $(this).val();
        var x = document.getElementById("adtlinfoedit");
        var id = $('#edit_id').val();

        if(catx == 'FAB')
        {
          x.style.display = "block";

          $.get('item_master/'+id, function(response){
            var data = response.data;
            $('#edit_item_length').val(data.length);
            $('#edit_item_width').val(data.width);
            $('#edit_item_thickness').val(data.thickness);
            $('#edit_item_radius').val(data.radius);
          });
        }
        else 
        {
          x.style.display = "none";
          $('#edit_item_length').val('');
          $('#edit_item_width').val('');
          $('#edit_item_thickness').val('');
          $('#edit_item_radius').val('');
        }
    })

    function serialText(id)
    {
      if (document.getElementById(id).readonly == true ){
        document.getElementById(id).readonly = false
        $('#'+id).val('0');
      } else {
        document.getElementById(id).readonly = true
        $('#'+id).val('1');
      }
    }

    function serialEdit(id)
    {
      if ($('#'+id).val() == 1 ){
        $('#'+id).val('0');
      } else {
        // document.getElementById(id).readonly = true
        $('#'+id).val('1');
      }
    }

    function editItem(id){
        $.get('item_master/'+id, function(response){
            var data = response.data;
            $('#edit_id').val(data.id);
            $('#edit_item_cat_code option[value="'+data.cat_code+'"]').prop('selected', true);
            $('#edit_item_cat_code').formSelect();
            $('#edit_item_subcat_code option[value="'+data.subcat_code+'"]').prop('selected', true);
            $('#edit_item_subcat_code').formSelect();
            $('#edit_item_code').val(data.item_code);
            $('#edit_item_desc').val(data.item_desc);
            $('#edit_item_oem').val(data.oem_partno);

            $('#edit_serialized').val(data.is_serialized);
            (data.is_serialized == 1 ? $('#serialx').prop("checked", true) : $('#serialx').prop("checked", false));
            // (data.is_serialized == 1 ? $('#edit_serialized').prop("readonly", true) : $('#edit_serialized').prop("readonly", false));
  
            $('#edit_item_uom option[value="'+data.uom_code+'"]').prop('selected', true);
            $('#edit_item_uom').formSelect();
 
            $('#edit_item_safety').val(data.safety_stock);
            $('#edit_item_warning').val(data.warning_level);
            $('#edit_item_max').val(data.maximum_stock);

            if((data.length=='')){
              $('#edit_item_length').val('N/A');
            } else {
              $('#edit_item_length').val(data.length);
            }

            if((data.width=='')){
              $('#edit_item_width').val('N/A');
            } else {
              $('#edit_item_width').val(data.width);
            }

            if((data.thickness=='')){
              $('#edit_item_thickness').val('N/A');
            } else {
              $('#edit_item_thickness').val(data.thickness);
            }

            if((data.radius=='')){
              $('#edit_item_radius').val('N/A');
            } else {
              $('#edit_item_radius').val(data.radius);
            }

            $('#editModal').modal('open');
            M.updateTextFields();
            $('.materialize-textarea').each(function (index) {
                M.textareaAutoResize(this);
            });
        });
    }

    function distext(id){

      if (document.getElementById(id).disabled == true ){
        document.getElementById(id).disabled = false
        if(id=='edit_item_oem' || id=='edit_item_length' || id=='edit_item_width' || id=='edit_item_thickness' || id=='edit_item_radius'){
          var idx = $('#edit_id').val();
          $.get('item_master/'+idx, function(response){
          var data = response.data;
            if(data!='') {
              switch(id){
                case 'edit_item_oem':
                $('#'+id).val(data.oem_partno);
                break;

                case 'edit_item_length':
                $('#'+id).val(data.length);
                break;

                case 'edit_item_width':
                $('#'+id).val(data.width);
                break;

                case 'edit_item_thickness':
                $('#'+id).val(data.thickness);
                break;

                case 'edit_item_radius':
                $('#'+id).val(data.radius);
                break;
              };
            } else {
              $('#'+id).val('');
            }
          })
        } 
        $('#'+id).val('');
      } else {
        document.getElementById(id).disabled = true
        $('#'+id).val('N/A');
      }

    }

    function deleteItem(id){
        $('#del_id').val(id);
        $('#deleteModal').modal('open');
    }

    var itemaster_dt = $('#itemmaster-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        //"aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/item_master/all",
        "columns": [
            {  "data": "id" },
            {  "data": "item_cat.cat_desc" },
            {  "data": "item_subcat.subcat_desc" },
            {  "data": "item_code" },
            {  "data": "item_desc" },
            {
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editItem('+row.id+')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+row.id+')"><i class="material-icons">delete</i></a>';
                }
            }
        ] 
    });
  </script>

  <!-- End of SCRIPTS -->

@endsection
