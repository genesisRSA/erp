@extends('layouts.resmain')
<style>
   textarea.materialize-textarea
        {
            height: 30% !important; 
        }
</style>
 
@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Projects<i class="material-icons">arrow_forward_ios</i></span><span class="grey-text darken-4">Project List<i class="material-icons">arrow_forward_ios</i></span>Project View</h4>
    </div>
  </div>
 
    <div class="m-3 main-content">  
        <ul id="project_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
          <li class="tab col s12 m4 l4"><a class="active" href="#details">Project Details</a></li>
        </ul>

        <div class="card" style="margin-top: 0px">
          <div class="card-body">
            <form method="POST" action="{{route('projects.revision')}}" enctype="multipart/form-data">
              @csrf

              <div id="details" name="details">
                <input type="hidden" id="id" name="id" value="{{$projects->id}}">
                <div class="row">
                  <br>
                    <div class="col s12 m12 l12">
                      <div class="col s12 m12 l12">
                        <div class="input-field col s12 m4 l4">
                            <select id="site_code" name="site_code" required>
                             @foreach ($sites as $s)
                                @if($projects->site_code==$s->site_code)
                                  <option value="{{$s->site_code}}" selected disabled>{{$s->site_desc}}</option>
                                @endif
                             @endforeach
                            </select>
                           <label for="site_code">Site<sup class="red-text">*</sup></label>
                           <input type="hidden" id="add_site_code" name="add_site_code">
                        </div>

                        <div class="input-field col s12 m4 l4">
                            <select id="customer" name="customer" required>
                                @foreach ($customers as $cust)
                                  @if($projects->cust_code==$cust->cust_code)
                                    <option value="{{$cust->cust_code}}" selected>{{$cust->cust_name}}</option>
                                  @endif
                                @endforeach
                            </select>
                            <label for="customer">Customer<sup class="red-text">*</sup></label>
                            <input type="hidden" id="add_customer" name="add_customer">
                        </div>
                      </div>
                      
                      <div class="col s12 m12 l12">
                        <div class="input-field col s12 m4 l4">
                            <select id="project_type" name="project_type" required>
                                @if($projects->project_type=="A")
                                  <option value="A" selected>Automation</option>
                                @else
                                  <option value="T" selected>Tooling</option>
                                @endif
                            </select>
                            <label for="project_type">Project Type<sup class="red-text">*</sup></label>
                            <input type="hidden" id="add_project_type" name="add_project_type">
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <input type="text" id="project_name" name="project_name" placeholder=" " value="{{$projects->project_name}}" readonly required/>
                            <label for="project_name">Project Name<sup class="red-text">*</sup></label>
                            <input type="hidden" id="add_project_name" name="add_project_name">
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <input type="text" id="project_code" name="project_code" placeholder=" " value="{{$projects->project_code}}" readonly required/>
                            <label for="project_code">Project Code<sup class="red-text"></sup></label>
                            <input type="hidden" id="add_project_code" name="add_project_code" value="{{$projects->project_code}}" >
                        </div>
                      </div>

                      <div class="col s12 m12 l12">
                        <div class="input-field col s12 m4 l4">
                            <select id="sales_order" name="sales_order" required>
                                    <option value="{{$projects->order_code}}" selected>{{$projects->order_code}}</option>
                            </select>
                            <label for="sales_order">Sales Order<sup class="red-text">*</sup></label>
                            <input type="hidden" id="add_sales_order" name="add_sales_order">
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <select id="product" name="product" required>
                                 <option value="{{$projects->order_code}}" disabled selected>{{$projects->prod_code}}</option>
                            </select>
                           <label for="product">Product<sup class="red-text">*</sup></label>
                           <input type="hidden" id="add_product" name="add_product">
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <input type="text" id="quantity" name="quantity" placeholder=" " value="{{$projects->quantity}}" readonly required/>
                            <label for="quantity">Quantity<sup class="red-text">*</sup></label>
                            <input type="hidden" id="add_quantity" name="add_quantity">
                        </div>
                      </div>

   
                      <div class="col s12 m12 l12 row" style="margin-bottom: 0px;">
                        <div id="assy" class="col s12 m12 l12 row" style="margin-bottom: 0px;">
                            
                        </div>
                      </div>                      
                  </div>
                </div>
              </div> 
              
              {{-- <div id="details_footer" class="row" style="display: none"> --}}
              <div id="details_footer" class="row">
                <div class="col s12 m6 l6"></div>
                <div class="col s12 m3 l3 right-align" style="padding-bottom: 30px;padding-right: 10px;padding-left: 12px;">
                  <button class="green waves-effect waves-light btn" style="width: 100%"><i class="material-icons left">check_circle</i>Save&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                </div>
                <div class="col s12 m3 l3 right-align" style="padding-bottom: 30px;padding-right: 30px;padding-left: 0px;">
                  <a href="{{route('projects.index')}}" class="red waves-effect waves-dark btn" style="width: 100%"><i class="material-icons left">cancel</i>Cancel</a>
                </div>
              </div>

            </form>
          </div>
        </div>
    
    </div>
  <!-- Modals -->
    <div id="addModal" class="modal">
      <form action="">
        <div class="modal-content" style="padding-bottom: 0px;">
          <h4 id="header"></h4>

          <div class="row">
            <input type="hidden" id="add_assy_code" name="item_code"/>
            <input type="hidden" id="loc" name="loc"/>

            <div class="input-field col s12 m3 l3" id="btn_search" style="display: none">
              <button id="add_search" type="button" onclick="searchItem();" class="blue waves-effect waves-light btn" id="btnAddSave" style="padding-right: 30px;left: 0px;"><i class="material-icons left">search</i>Search</button>
            </div>
    
            <div class="input-field col s12 m12 l12" id="fab_code" style="display: none">
              <input type="text" id="add_fab_code" name="fab_code" placeholder=""/>
              <label for="fab_code">Fabrication Code<sup class="red-text">*</sup></label>
            </div>
          
            <div class="input-field col s12 m9 l9" id="item_code">
              <input type="text" id="add_item_code" name="item_code" placeholder=""/>
              <label for="item_code">Item Code<sup class="red-text">*</sup></label>
            </div>
            
            <div class="input-field col s12 m12 l12">
              <textarea class="materialize-textarea" type="text" id="add_description" name="description" placeholder=" " style="height: 150px; border-left: 10px;  padding-left:20px;" required readonly></textarea>
              <label for="icon_prefix2">Description</label>
            </div>

            <div id="showUOM" class="input-field col s12 m6 l6" style="display: none">
              <select id="add_uom_code" name="uom_code" required disabled>
                <option value="0" disabled selected>Choose your option</option>
                @foreach ($uoms as $uom)
                  <option value="{{$uom->uom_code}}">{{$uom->uom_name}}</option>
                @endforeach
              </select>
              <label for="uom_code">Unit of Measure<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12 m6 l6">
              <input placeholder="" name="item_length" id="add_item_length" type="number" step="0.0001" class="number validate" required>
              <label for="item_length">Length<sup class="red-text"></sup></label>
              {{-- <div class="col s12 m6 left-align">
                <label>
                    <input placeholder="e.g $"  type="checkbox" onclick="distext('add_item_length')"/>
                      <span style="font-size: 12px">Click to set N/A</span>
                </label>
              </div> --}}
            </div>

            <div class="input-field col s12 m6 l6">
              <input placeholder="" name="item_width" id="add_item_width" type="number" step="0.0001" class="number validate" required>
              <label for="item_width">Width<sup class="red-text"></sup></label>
              {{-- <div class="col s12 m6 left-align">
                <label>
                    <input placeholder="e.g $"  type="checkbox" onclick="distext('add_item_width')"/>
                      <span style="font-size: 12px">Click to set N/A</span>
                </label>
              </div> --}}
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12 m6 l6">
              <input placeholder="" name="item_thickness" id="add_item_thickness" type="number" step="0.0001" class="number validate" required>
              <label for="item_thickness">Thickness<sup class="red-text"></sup></label>
              {{-- <div class="col s12 m6 left-align">
                <label>
                    <input placeholder="e.g $"  type="checkbox" onclick="distext('add_item_thickness')"/>
                      <span style="font-size: 12px">Click to set N/A</span>
                </label>
              </div> --}}
            </div>
            <div class="input-field col s12 m6 l6">
              <input placeholder="" name="item_radius" id="add_item_radius" type="number" step="0.0001" class="number validate" required>
              <label for="item_radius">Radius<sup class="red-text">*</sup></label>
              {{-- <div class="col s12 m6 left-align">
                <label>
                    <input placeholder="e.g $"  type="checkbox" onclick="distext('add_item_radius')"/>
                      <span style="font-size: 12px">Click to set N/A</span>
                </label>
              </div> --}}
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" onclick="addItems();" class="green waves-effect waves-light btn" id="btnAddSave"><i class="material-icons left">check_circle</i>Save</button>
          <button type="button" class="modal-close red waves-effect waves-dark btn" id="closeAddModal"><i class="material-icons left">cancel</i>Cancel</button>
        </div>
      </form>
    </div>

    <div id="assyModal" class="modal">
      <div class="modal-content">
        <h4>Add Assembly Details</h4><br><br>

        <div class="row">
          <div class="input-field col s12 m6">
            <input placeholder="" id="new_assy_code" name="assy_code" type="text" class="validate" required>
            <label for="assy_code">Assembly Code<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <input placeholder="" id="new_assy_desc" name="assy_desc" type="text" class="validate" required>
            <label for="assy_desc">Assembly Description<sup class="red-text">*</sup></label>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" onclick="addAssy();" class="green waves-effect waves-light btn" id="btnAddSave"><i class="material-icons left">add_circle</i>Add</button>
        <button type="button" class="modal-close red waves-effect waves-dark btn" id="closeAddModal"><i class="material-icons left">cancel</i>Cancel</button>
      </div>
    </div>

    <div id="delAssyModal" class="modal">
      <div class="modal-content">
        <h4>Delete Assembly</h4>
        <div class="row">
            <div class="col s12 m12 l12">
                <input type="hidden" name="id" id="del_id">
                <p>Are you sure you want to delete this <strong>Assembly</strong>?</p>
            </div>
        </div>
      </div>
      <div class="modal-footer">
          <a onclick="removeListItem();" class="green waves-effect waves-dark btn"><i class="material-icons left">check_circle</i>Yes</a>
          <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
      </div>
    </div>

    <div id="delAssyItemModal" class="modal">
      <div class="modal-content">
        <h4>Delete Assembly Item</h4>
        <div class="row">
            <div class="col s12 m12 l12">
                <input type="hidden" name="id" id="del_index">
                <input type="hidden" name="id" id="del_loc">
                <input type="hidden" name="id" id="del_assy">
                <p>Are you sure you want to delete this <strong>Assembly Item</strong>?</p>
            </div>
        </div>
      </div>
      <div class="modal-footer">
          <a onclick="removeProduct();" class="green waves-effect waves-dark btn"><i class="material-icons left">check_circle</i>Yes</a>
          <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
      </div>
    </div>

    <div id="resetAssyModal" class="modal">
      <div class="modal-content">
        <h4>Reset Assembly List</h4>
        <div class="row">
            <div class="col s12 m12 l12">
                <p>Are you sure you want to reset the <strong>Assembly List</strong>?</p>
            </div>
        </div>
      </div>
      <div class="modal-footer">
          <a onclick="setTable();" class="green waves-effect waves-dark btn"><i class="material-icons left">check_circle</i>Yes</a>
          <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
      </div>
    </div>
  <!-- End of Modals -->
  <!-- SCRIPTS -->
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">

    var prod_quantity = [];
    var assy_list = [];
    var n_mfab = [];
    var n_mstand = [];   
    var n_fast = [];     
    var n_pneu = [];     
    var n_elec = [];     
    var cpcount = 0;
    
    
    $(document).ready(function () {
        $('#add_change_description').trigger('autoresize');
        $('#add_change_reason').trigger('autoresize');

        renderProductTable('{{$projects->project_code}}');
        
    });

    $('#site_code').on('change', function(){
        var site = $(this).val();
        var cust = $("#add_customer").val() == null ? '' : $("#add_customer").val();
        var type = $("#add_project_type").val() == null ? '' : $("#add_project_type").val();
        $('#add_site_code').val($(this).val());
        projectCode(site, cust, type, cpcount);
        $.get(site+'/orders', (response) => {
          var data = response.data;
          var select = '<option value="" disabled selected>Choose Sales Order</option>';
          $.each(data, function(index, row){
            select += '<option value="'+row.order_code+'">'+row.order_code+'</option>';
          });
         
          $('#sales_order').html(select);
          $('#sales_order').formSelect();
        });
    });

    $('#customer').on('change', function(){
        $('#add_customer').val($(this).val());
        $.get($(this).val()+'/count', (response) => {
            var data = response.data;
            var a_count = data.a_count;
            var t_count = data.t_count;
            var site = $('#add_site_code').val() == null ? '' : $("#add_site_code").val();
            var cust = $(this).val() == null ? '' : $("#add_customer").val();
            var type = $("#add_project_type").val() == null ? '' : $("#add_project_type").val();
            cpcount = (type == 'A' ? a_count : t_count);
            projectCode(site, cust, type, cpcount);
        });
    });

    $('#project_type').on('change', function(){
        $('#add_project_type').val($(this).val());
        var cust = $("#add_customer").val();
        $.get(cust+'/count', (response) => {
            var data = response.data;
            var a_count = data.a_count;
            var t_count = data.t_count;
            var site = $('#add_site_code').val() == null ? '' : $("#add_site_code").val();
            var cust = $(this).val() == null ? '' : $("#add_customer").val();
            var type = $("#add_project_type").val() == null ? '' : $("#add_project_type").val();
            cpcount = (type == 'A' ? a_count : t_count);
            projectCode(site, cust, type, cpcount);
        });
    });

    $('#sales_order').on('change', function(){
        $('#add_sales_order').val($(this).val());
        $.get($(this).val()+'/allproducts', (response) => {
          var data = response.data;
          var select = '<option value="" disabled selected>Choose Product</option>';
          $.each(JSON.parse(data.products), function(index, row){             
            select += '<option value="'+row.prod_code+'">'+row.prod_name+'</option>';
            prod_quantity.push({"prod_code":row.prod_code,"quantity":row.quantity});
          });
          $('#product').html(select);
          $('#product').formSelect();
        });
    });

    $('#product').on('change', function(){
        $('#add_product').val($(this).val());
        $('#quantity').val(prod_quantity.filter(prod => prod.prod_code == $(this).val())[0].quantity);
    });

    $("#add_item_code").keyup(function(event) {
      if (event.keyCode === 13) {
          $("#add_search").click();
      }
    });

    // function start

    const projectCode = (site, cust, type, cpcount) => {
        $('#project_code').val(site + '-' + cust + '-' + 'JO' + '-' + type  + '000' + cpcount);
    };

    const distext = (id) => {
      if (document.getElementById(id).disabled == true ){
          document.getElementById(id).disabled = false
          if(id=='edit_item_length' || id=='edit_item_width' || id=='edit_item_thickness' || id=='edit_item_radius'){
            var idx = $('#edit_id').val();
            $.get('item_master/'+idx, function(response){
            var data = response.data;
              if(data!='') {
                switch(id){
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
          $("#"+id).val('');
        } else {
          $("#"+id).val('N/A');
          document.getElementById(id).disabled = true
        }
    };

    const searchItem = () => {
      var id = '';
      var loc = $('#loc').val();
      if(loc=='mfab'){
        id = $('#add_fab_code').val();
      } else {
        id = $('#add_item_code').val();
      }
      $.get(id+'/item_details', (response) => {
        var data = response.data;
        if(data){
          M.updateTextFields();
          $('.materialize-textarea').each(function (index) {
              M.textareaAutoResize(this);
          });

          $('#add_description').val(data.item_desc);

          if(loc!='mfab'){             
            $('#add_uom_code option[value="'+data.uom_code+'"]').prop('selected', true);
            $('#add_uom_code').prop('disabled', true);
            $('#add_uom_code').formSelect();
          }
  
          if((data.length=='')){
            $('#add_item_length').val('N/A');
          } else {
            $('#add_item_length').val(data.length);
          }

          if((data.width=='')){
            $('#add_item_width').val('N/A');
          } else {
            $('#add_item_width').val(data.width);
          }

          if((data.thickness=='')){
            $('#add_item_thickness').val('N/A');
          } else {
            $('#add_item_thickness').val(data.thickness);
          }

          if((data.radius=='')){
            $('#add_item_radius').val('N/A');
          } else {
            $('#add_item_radius').val(data.radius);
          }

        } else {
          $('#add_description').val("");
          $('#add_item_length').val("");
          $('#add_item_width').val("");
          $('#add_item_thickness').val("");
          $('#add_item_radius').val("");
          $('#add_uom_code option[value=""]').prop('selected', true);
          $('#add_uom_code').formSelect();
          alert("Item does not exist!");
        }
      });
    };

    const showModal = (loc, assy_code) => {
       if(loc!='Add Mechanical Fabrication')
       {
        var x = document.getElementById("showUOM"); 
        x.style.display = "block";

        var y = document.getElementById("item_code");
        y.style.display = "block";

        var z = document.getElementById("btn_search");
        z.style.display = "block";

        var c = document.getElementById("fab_code");
        c.style.display = "none";

        $('#add_item_code').val('');
       
        $('#add_description').prop('disabled', true);
        $('#add_description').val('');

        $('#add_item_length').prop('disabled', true);z
        $('#add_item_length').val('');
        
        $('#add_item_width').prop('disabled', true);
        $('#add_item_width').val('');
        
        $('#add_item_thickness').prop('disabled', true);
        $('#add_item_thickness').val('');
        
        $('#add_item_radius').prop('disabled', true);
        $('#add_item_radius').val('');

       } else {
        var x = document.getElementById("showUOM"); 
        x.style.display = "none";

        var y = document.getElementById("item_code");
        y.style.display = "none";

        var z = document.getElementById("btn_search");
        z.style.display = "none";

        var c = document.getElementById("fab_code");
        c.style.display = "block";

        $('#add_fab_code').val('');

        $('#add_description').prop('disabled', false);
        $('#add_description').val('');
 
        $('#add_item_length').prop('disabled', false);
        $('#add_item_length').val('');

        $('#add_item_width').prop('disabled', false);
        $('#add_item_width').val('');

        $('#add_item_thickness').prop('disabled', false);
        $('#add_item_thickness').val('');
        
        $('#add_item_radius').prop('disabled', false);
        $('#add_item_radius').val('');


       }   

        $('#header').html(loc);
        if(loc=='Add Mechanical Fabrication'){
          $('#loc').val('mfab');
        }else if(loc=='Add Mechanical Standard'){
          $('#loc').val('mstand');
        }else if(loc=='Add Fasteners'){
          $('#loc').val('fast');
        }else if(loc=='Add Pneumatics'){
          $('#loc').val('pneu');
        }else if(loc=='Add Electrical'){
          $('#loc').val('elec');
        }
        
        $('#add_assy_code').val(assy_code);
        $('#addModal').modal('open');
    };

    const assyModal = () => {
      $('#assyModal').modal('open');
    };

    const assyListModal = () => {
      $('#resetAssyModal').modal('open');
    }

    const delAssyModal = (assy_code) => {
      $('#del_id').val(assy_code);
      $('#delAssyModal').modal('open');
    };

    const delItemModal = (index, loc, assy_code) => {
      $('#del_index').val(index);
      $('#del_loc').val(loc);
      $('#del_assy').val(assy_code);
      $('#delAssyItemModal').modal('open');
    };

    const checkItem = (arr, assy, code, loc,) => {
      var valid = false;
      if(loc=="mfab")
      {
        $(arr).each(function(){
          if(this.fab_code==code && this.assy_code==assy)
          {
            return valid = true;
          } 
        });
      } else {
        $(arr).each(function(){
          if(this.item_code==code && this.assy_code==assy)
          {
            return valid = true;
          } 
        });
      }
      return valid;
    };

    const addItems = () => {
      var loc = $('#loc').val();
      var fab_code =  $('#add_fab_code').val();
      var assy_code = $('#add_assy_code').val();
      var item_code = $('#add_item_code').val();
      $('#addModal').modal('close');
      switch (loc) {
        case "mfab":
          if(checkItem(n_mfab, assy_code, fab_code, loc) == false){
            n_mfab.push({"assy_code":     $('#add_assy_code').val(),
                          "fab_code":     $('#add_fab_code').val(),
                          "fab_desc":     $('#add_description').val(),
                          "length":       $('#add_item_length').val(),
                          "width":        $('#add_item_width').val(),
                          "thickness":    $('#add_item_thickness').val(),
                          "radius":       $('#add_item_radius').val(),
                          "po_status":    '',
                          "rcv_status":   '',
                          "loc":          'mfab',
                        });
            renderTable(n_mfab,$('#tbl'+assy_code+'mfab tbody'),loc,assy_code);
          } else {
            alert("Fabrication code already exist!");
          };
          break;
        case "mstand":
          if(checkItem(n_mstand, assy_code, item_code, loc) == false ){
            n_mstand.push({"assy_code":   $('#add_assy_code').val(),
                          "item_code":    $('#add_item_code').val(),
                          "description":  $('#add_description').val(),
                          "uom_code":     $('#add_uom_code').val(),
                          "length":       $('#add_item_length').val(),
                          "width":        $('#add_item_width').val(),
                          "thickness":    $('#add_item_thickness').val(),
                          "radius":       $('#add_item_radius').val(),
                          "po_status":    '',
                          "rcv_status":   '',
                          "loc":          'mstand',
                        });                 
            renderTable(n_mstand,$('#tbl'+assy_code+'mstand tbody'),loc,assy_code);
          } else {
            alert("Item code already exist!");
          };
          break;
        case "fast":
          if(checkItem(n_fast, assy_code, item_code, loc) == false ){
            n_fast.push({"assy_code":      $('#add_assy_code').val(),
                          "item_code":    $('#add_item_code').val(),
                          "description":  $('#add_description').val(),
                          "uom_code":     $('#add_uom_code').val(),
                          "length":       $('#add_item_length').val(),
                          "width":        $('#add_item_width').val(),
                          "thickness":    $('#add_item_thickness').val(),
                          "radius":       $('#add_item_radius').val(),
                          "po_status":    '',
                          "rcv_status":   '',
                          "loc":          'fast',
                        });               
            renderTable(n_fast,$('#tbl'+assy_code+'fast tbody'),loc,assy_code);  
          } else {
            alert("Item code already exist!");
          };
          break;
        case "pneu":
          if(checkItem(n_pneu, assy_code, item_code, loc) == false ){
            n_pneu.push({"assy_code":     $('#add_assy_code').val(),
                          "item_code":    $('#add_item_code').val(),
                          "description":  $('#add_description').val(),
                          "uom_code":     $('#add_uom_code').val(),
                          "length":       $('#add_item_length').val(),
                          "width":        $('#add_item_width').val(),
                          "thickness":    $('#add_item_thickness').val(),
                          "radius":       $('#add_item_radius').val(),
                          "po_status":    '',
                          "rcv_status":   '',
                          "loc":          'pneu',
                        });             
            renderTable(n_pneu,$('#tbl'+assy_code+'pneu tbody'),loc,assy_code);
          } else {
            alert("Item code already exist!");
          };
            break;
        case "elec":
          if(checkItem(n_elec, assy_code, item_code, loc) == false ){
            n_elec.push({"assy_code":     $('#add_assy_code').val(),
                          "item_code":    $('#add_item_code').val(),
                          "description":  $('#add_description').val(),
                          "uom_code":     $('#add_uom_code').val(),
                          "length":       $('#add_item_length').val(),
                          "width":        $('#add_item_width').val(),
                          "thickness":    $('#add_item_thickness').val(),
                          "radius":       $('#add_item_radius').val(),
                          "po_status":    '',
                          "rcv_status":   '',  
                          "loc":          'elec',
                        });         
            renderTable(n_elec,$('#tbl'+assy_code+'elec tbody'),loc,assy_code);
          } else {
            alert("Item code already exist!");
          };         
          break;
      };
    };

    const addAssy = () => {
      if($('#new_assy_code').val() && $('#new_assy_desc').val()){
        renderList($('#new_assy_code').val(), $('#new_assy_desc').val());
        $('#assyModal').modal('close');
      } else {
        alert("Please fill up all assembly details!");
      }
    };

    const setTable = () => {
      if($('#site_code').val() && $('#customer').val() && $('#project_type').val() && $('#project_name').val() && $('#project_code').val() && $('#sales_order').val() && $('#product').val() && $('#quantity').val()){
          renderProductTable($('#product').val());
          $('#site_code').prop('disabled', true);
          $('#site_code').formSelect();

          $('#customer').prop('disabled', true);
          $('#customer').formSelect();

          $('#project_type').prop('disabled', true);
          $('#project_type').formSelect();

          $('#sales_order').prop('disabled', true);
          $('#sales_order').formSelect();

          $('#product').prop('disabled', true);
          $('#product').formSelect();

          $('#project_name').prop('disabled', true);
          $('#project_code').prop('disabled', true);
          $('#quantity').prop('disabled', true);

          $('#add_project_name').val($('#project_name').val());
          $('#add_project_code').val($('#project_code').val());
          $('#add_quantity').val($('#quantity').val());

          $("#set").attr('disabled','disabled');
          $("#reset").removeAttr('disabled');
          var footer = document.getElementById("details_footer");
              footer.style.display = "block";
              $('#resetAssyModal').modal('close');
      } else {
        alert("Please fill up all project details!");
      }
    };

    const resetTable = () => {
      $('#site_code').prop('disabled', false);
      $('#site_code').val("");
      $('#site_code').formSelect();
      
      $('#customer').prop('disabled', false);
      $('#customer').val("");
      $('#customer').formSelect();

      $('#project_type').prop('disabled', false);
      $('#project_type').val("");
      $('#project_type').formSelect();

      $('#sales_order').prop('disabled', false);
      $('#sales_order').val("");
      $('#sales_order').formSelect();

      $('#product').prop('disabled', false);
      $('#product').val("");
      $('#product').formSelect();

      $('#project_name').prop('disabled', false);
      $('#project_name').val(""); 

      $('#project_code').prop('disabled', false);
      $('#project_code').val(""); 

      $('#quantity').prop('disabled', false);
      $('#quantity').val("");

      $("#reset").attr('disabled','disabled');
      $("#set").removeAttr('disabled');
      $('#assy').html("");
      var footer = document.getElementById("details_footer");
          footer.style.display = "none";
    };

    const renderProductTable = (project_code) => {
      $.get(project_code+'/edit_assy', (response) => {
            var data = response.data;  
 
                        // collapsible list header
            var coll =  '<div class="col s12 l8 m8"></div>'+
                          '<div class="col s12 l2 m2 right-align">'+
                            '<i onclick="assyModal();" class="green-text material-icons" style="z-index:=10;position:absolute;right:55;top: 280.5px;">add_circle</i>'+
                          '</div>'+
                          '<div class="col s12 l2 m2 right-align">'+
                          '</div>'+
                        '<h6 style="padding: 10px;padding-top: 10px;margin-bottom: 0em;background-color:#0d47a1;margin-top: 0px;" class="white-text"><b>Assembly List</b></h6>'+
                        // end collapsible list header

                        // collapsible list 
                        '<ul class="collapsible expandable" id="assy_collapse"> ';
            $.each(data, function(index, value){   
                $('#mfab'+value['assy_code']).html('');
                $('#mstand'+value['assy_code']).html('');
                $('#fast'+value['assy_code']).html('');
                $('#pneu'+value['assy_code']).html('');
                $('#elec'+value['assy_code']).html('');

                coll += '<li id="'+value['assy_code']+'">'+
                        '<input type="hidden" name="assy_code[]" value="'+value['assy_code']+'"/>'+
                        '<input type="hidden" name="assy_desc[]" value="'+value['assy_desc']+'"/>';
                    coll += '<div class="collapsible-header">'+value['assy_code']+' - '+value['assy_desc']+'<i onclick="delAssyModal(\''+value['assy_code']+'\');" class="red-text material-icons" style="z-index:=10; position:absolute;right:38;">cancel</i></div>';
                    // coll += '<div class="collapsible-header">'+value['assy_code']+' - '+value['assy_desc']+'</div>';
                    coll += '<div class="collapsible-body">'+
                                '<span>'+
                                    // tabs header
                                    '<ul id="assy_tab'+value['assy_code']+'" class="tabs tabs-fixed-width tab-demo z-depth-1">'+
                                        '<li class="tab col s12 m4 l4"><a class="active" href="#mfab'+value['assy_code']+'">Mechnical Fabrication</a></li>'+
                                        '<li class="tab col s12 m4 l4"><a href="#mstand'+value['assy_code']+'">Mechnical Standard</a></li>'+
                                        '<li class="tab col s12 m4 l4"><a href="#fast'+value['assy_code']+'">Fasteners</a></li>'+
                                        '<li class="tab col s12 m4 l4"><a href="#pneu'+value['assy_code']+'">Pneumatics</a></li>'+
                                        '<li class="tab col s12 m4 l4"><a href="#elec'+value['assy_code']+'">Electrical</a></li>'+
                                    '</ul>'+
                                    // end tabs header

                                    // tabs table
                                    '<div id="mfab'+value['assy_code']+'"></div>'+

                                    '<div id="mstand'+value['assy_code']+'">'+
                                      '<div class="col s12 m3 l3 right-align" style="padding-right: 10px;padding-left: 10px; margin-top: 10px; margin-bottom: 20px">'+
                                        '<a onclick="showModal(\'Add Mechanical Standard\',\''+value['assy_code']+'\');" class="teal waves-effect waves-dark btn modal-trigger" style="width: 100%"><i class="material-icons left">add_circle</i>Add Item(s)</a>'+
                                      '</div>'+
                                      '<div class="card" style="margin-top: 0px">'+
                                        '<div class="card-content">'+
                                          '<table class="responsive-table highlight" id="tbl'+value['assy_code']+'mstand" style="width: 100%">'+
                                            '<thead>'+
                                                '<tr>'+
                                                    '<th>Item Code</th>'+
                                                    '<th>Description</th>'+
                                                    '<th>Unit Of Measure</th>'+
                                                    '<th>Length</th>'+
                                                    '<th>Width</th>'+
                                                    '<th>Thickness</th>'+
                                                    '<th>Radius</th>'+
                                                    '<th>Action</th>'+
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody></tbody>'+
                                          '</table>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+

                                    '<div id="fast'+value['assy_code']+'">'+
                                      '<div class="col s12 m3 l3 right-align" style="padding-right: 10px;padding-left: 10px; margin-top: 10px; margin-bottom: 20px">'+
                                        '<a onclick="showModal(\'Add Fasteners\',\''+value['assy_code']+'\');" class="teal waves-effect waves-dark btn modal-trigger" style="width: 100%"><i class="material-icons left">add_circle</i>Add Item(s)</a>'+
                                      '</div>'+
                                      '<div class="card" style="margin-top: 0px">'+
                                        '<div class="card-content">'+
                                          '<table class="responsive-table highlight" id="tbl'+value['assy_code']+'fast" style="width: 100%">'+
                                            '<thead>'+
                                                '<tr>'+
                                                    '<th>Item Code</th>'+
                                                    '<th>Description</th>'+
                                                    '<th>Unit Of Measure</th>'+
                                                    '<th>Length</th>'+
                                                    '<th>Width</th>'+
                                                    '<th>Thickness</th>'+
                                                    '<th>Radius</th>'+
                                                    '<th>Action</th>'+
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody></tbody>'+
                                          '</table>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+

                                    '<div id="pneu'+value['assy_code']+'">'+
                                      '<div class="col s12 m3 l3 right-align" style="padding-right: 10px;padding-left: 10px; margin-top: 10px; margin-bottom: 20px">'+
                                        '<a onclick="showModal(\'Add Pneumatics\',\''+value['assy_code']+'\');" class="teal waves-effect waves-dark btn modal-trigger" style="width: 100%"><i class="material-icons left">add_circle</i>Add Item(s)</a>'+
                                      '</div>'+
                                      '<div class="card" style="margin-top: 0px">'+
                                        '<div class="card-content">'+
                                          '<table class="responsive-table highlight" id="tbl'+value['assy_code']+'pneu" style="width: 100%">'+
                                            '<thead>'+
                                                '<tr>'+
                                                    '<th>Item Code</th>'+
                                                    '<th>Description</th>'+
                                                    '<th>Unit Of Measure</th>'+
                                                    '<th>Length</th>'+
                                                    '<th>Width</th>'+
                                                    '<th>Thickness</th>'+
                                                    '<th>Radius</th>'+
                                                    '<th>Action</th>'+
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody></tbody>'+
                                          '</table>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+

                                    '<div id="elec'+value['assy_code']+'">'+
                                      '<div class="col s12 m3 l3 right-align" style="padding-right: 10px;padding-left: 10px; margin-top: 10px; margin-bottom: 20px">'+
                                        '<a onclick="showModal(\'Add Electrical\',\''+value['assy_code']+'\');" class="teal waves-effect waves-dark btn modal-trigger" style="width: 100%"><i class="material-icons left">add_circle</i>Add Item(s)</a>'+
                                      '</div>'+
                                      '<div class="card" style="margin-top: 0px">'+
                                        '<div class="card-content">'+
                                          '<table class="responsive-table highlight" id="tbl'+value['assy_code']+'elec" style="width: 100%">'+
                                            '<thead>'+
                                                '<tr>'+
                                                    '<th>Item Code</th>'+
                                                    '<th>Description</th>'+
                                                    '<th>Unit Of Measure</th>'+
                                                    '<th>Length</th>'+
                                                    '<th>Width</th>'+
                                                    '<th>Thickness</th>'+
                                                    '<th>Radius</th>'+
                                                    '<th>Action</th>'+
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody></tbody>'+
                                          '</table>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+ 
                                    // end tabs table
                                '</span>'+
                            '</div>';
                coll += '</li>';
                // end collapsible list

                // mech-fab table
                $.get(value['project_code']+'/'+value['assy_code']+'/fab', (response) => {
                    var fab = response.data;
                    var div = '<div class="col s12 m3 l3 right-align" style="padding-right: 10px;padding-left: 10px; margin-top: 10px; margin-bottom: 20px">'+
                                '<a onclick="showModal(\'Add Mechanical Fabrication\',\''+value['assy_code']+'\');" class="teal waves-effect waves-dark btn modal-trigger" style="width: 100%"><i class="material-icons left">add_circle</i>Add Item(s)</a>'+
                              '</div>'+
                                '<div class="card" style="margin-top: 0px">'+
                                '<div class="card-content">'+
                                    '<table class="responsive-table highlight" id="tbl'+value['assy_code']+'mfab" style="width: 100%">'+
                                      '<thead>'+
                                          '<tr>'+
                                              '<th>Fabrication Code</th>'+
                                              '<th>Description</th>'+
                                              '<th>Length</th>'+
                                              '<th>Width</th>'+
                                              '<th>Thickness</th>'+
                                              '<th>Radius</th>'+
                                              '<th>Action</th>'+
                                          '</tr>'+
                                      '</thead>'+
                                    '<tbody>';
                    $.each(fab, function(index, value){
                        if( value['po_status']=='' || value['po_status']==null || value['po_status']=='null' || value['rcv_status']=='' || value['rcv_status']==null || value['rcv_status']=='null' )
                        {
                          div +=  '<tr>'+
                                      '<td class="left-align">'+value['fab_code']+'</td>'+
                                      '<td class="left-align">'+value['fab_desc']+'</td>'+
                                      '<td class="left-align">'+value['length']+'</td>'+
                                      '<td class="left-align">'+value['width']+'</td>'+
                                      '<td class="left-align">'+value['thickness']+'</td>'+
                                      '<td class="left-align">'+value['radius']+'</td>'+
                                      '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="delItemModal(\''+index+'\',\'mfab\',\''+value['assy_code']+'\',)"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                                      '<input type="hidden" name="fab_assy_code[]" value="'+value['assy_code']+'"/>'+
                                      '<input type="hidden" name="fab_code[]" value="'+value['fab_code']+'"/>'+
                                      '<input type="hidden" name="fab_desc[]" value="'+value['fab_desc']+'"/>'+
                                      '<input type="hidden" name="fab_length[]" value="'+value['length']+'"/>'+
                                      '<input type="hidden" name="fab_width[]" value="'+value['width']+'"/>'+
                                      '<input type="hidden" name="fab_thickness[]" value="'+value['thickness']+'"/>'+
                                      '<input type="hidden" name="fab_radius[]" value="'+value['radius']+'"/>'+
                                  '</tr>';
                        }
                        else
                        {
                          div +=  '<tr>'+
                                    '<td class="left-align">'+value['fab_code']+'</td>'+
                                    '<td class="left-align">'+value['fab_desc']+'</td>'+
                                    '<td class="left-align">'+value['length']+'</td>'+
                                    '<td class="left-align">'+value['width']+'</td>'+
                                    '<td class="left-align">'+value['thickness']+'</td>'+
                                    '<td class="left-align">'+value['radius']+'</td>'+
                                    '<td><button type="button" class="btn-small red waves-effect waves-light" disabled><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                                    '<input type="hidden" name="fab_assy_code[]" value="'+value['assy_code']+'"/>'+
                                    '<input type="hidden" name="fab_code[]" value="'+value['fab_code']+'"/>'+
                                    '<input type="hidden" name="fab_desc[]" value="'+value['fab_desc']+'"/>'+
                                    '<input type="hidden" name="fab_length[]" value="'+value['length']+'"/>'+
                                    '<input type="hidden" name="fab_width[]" value="'+value['width']+'"/>'+
                                    '<input type="hidden" name="fab_thickness[]" value="'+value['thickness']+'"/>'+
                                    '<input type="hidden" name="fab_radius[]" value="'+value['radius']+'"/>'+
                                '</tr>';
                        }
                        
                        n_mfab.push({
                                      "assy_code":    value['assy_code'],
                                      "fab_code":     value['fab_code'],
                                      "fab_desc":     value['fab_desc'],
                                      "length":       value['length'],
                                      "width":        value['width'],
                                      "thickness":    value['thickness'],
                                      "radius":       value['radius'],
                                      "po_status":    value['po_status'],
                                      "rcv_status":   value['rcv_status'],
                                      "loc":          'mfab',
                                      });
                    });
                        div +=  '</tbody>'+
                                '</table>'+
                                '</div>'+ 
                                '</div>';
                    $('#mfab'+value['assy_code']).append(div);
                    $('#assy_tab'+value['assy_code']).tabs();
                });
                // end mech-fab table

      
            });

            coll += '</ul>';
            $('#assy').html("");
            $('#assy').append(coll);
            
            // adtl table
            $.get(project_code+'/adtl', (response) => {
              var data = response.data;
              $.each(data, function(index, value){   
              renderItems(value['location'],
                          value['assy_code'],
                          value['item_code'],
                          value['item_desc'],
                          value['uom_code'],
                          value['length'],
                          value['width'],
                          value['thickness'],
                          value['radius'],
                          null,
                          null);
              });
            });
            // end adtl table

            $('.collapsible').collapsible();
        });  
    };

    const renderItems = (loc, assy_code, item_code, item_desc, item_uom, item_length, item_width, item_thickness, item_radius, po_status, rcv_status) => {       
      switch (loc) {
        case "mstand":
            n_mstand.push({"assy_code":   assy_code,
                          "item_code":    item_code,
                          "description":  item_desc,
                          "uom_code":     item_uom,
                          "length":       item_length,
                          "width":        item_width,
                          "thickness":    item_thickness,
                          "radius":       item_radius,
                          "po_status":    po_status,
                          "rcv_status":   rcv_status,
                          "loc":          'mstand',
                        });                 
            renderTable(n_mstand,$('#tbl'+assy_code+'mstand tbody'),loc,assy_code);
          
          break;
        case "fast":
            n_fast.push({"assy_code":   assy_code,
                          "item_code":    item_code,
                          "description":  item_desc,
                          "uom_code":     item_uom,
                          "length":       item_length,
                          "width":        item_width,
                          "thickness":    item_thickness,
                          "radius":       item_radius,
                          "po_status":    po_status,
                          "rcv_status":   rcv_status,
                          "loc":          'fast',
                        });               
            renderTable(n_fast,$('#tbl'+assy_code+'fast tbody'),loc,assy_code);  
          break;
        case "pneu":
            n_pneu.push({"assy_code":   assy_code,
                          "item_code":    item_code,
                          "description":  item_desc,
                          "uom_code":     item_uom,
                          "length":       item_length,
                          "width":        item_width,
                          "thickness":    item_thickness,
                          "radius":       item_radius,
                          "po_status":    po_status,
                          "rcv_status":   rcv_status,
                          "loc":          'pneu',
                        });             
            renderTable(n_pneu,$('#tbl'+assy_code+'pneu tbody'),loc,assy_code);
            break;
        case "elec":
            n_elec.push({"assy_code":   assy_code,
                          "item_code":    item_code,
                          "description":  item_desc,
                          "uom_code":     item_uom,
                          "length":       item_length,
                          "width":        item_width,
                          "thickness":    item_thickness,
                          "radius":       item_radius,
                          "po_status":    po_status,
                          "rcv_status":   rcv_status,
                          "loc":          'elec',
                        });         
            renderTable(n_elec,$('#tbl'+assy_code+'elec tbody'),loc,assy_code);      
          break;
      };
    };

    const renderTable = (items, table, loc, assy_code) => {
      table.html("");
      if(loc=='mfab'){
        $.each(items, (index,row) => {
            if( row.po_status=='' || row.po_status==null || row.po_status=='null' || row.rcv_status=='' || row.rcv_status==null || row.rcv_status=='null' )
            {
              table.append('<tr>'+
                            '<td class="left-align">'+row.fab_code+'</td>'+
                            '<td class="left-align">'+row.fab_desc+'</td>'+
                            '<td class="left-align">'+row.length+'</td>'+
                            '<td class="left-align">'+row.width+'</td>'+
                            '<td class="left-align">'+row.thickness+'</td>'+
                            '<td class="left-align">'+row.radius+'</td>'+
                            '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="delItemModal(\''+index+'\',\''+loc+'\',\''+assy_code+'\',)"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                            '<input type="hidden" name="fab_assy_code[]" value="'+assy_code+'"/>'+
                            '<input type="hidden" name="fab_code[]" value="'+row.fab_code+'"/>'+
                            '<input type="hidden" name="fab_desc[]" value="'+row.fab_desc+'"/>'+
                            '<input type="hidden" name="fab_length[]" value="'+row.length+'"/>'+
                            '<input type="hidden" name="fab_width[]" value="'+row.width+'"/>'+
                            '<input type="hidden" name="fab_thickness[]" value="'+row.thickness+'"/>'+
                            '<input type="hidden" name="fab_radius[]" value="'+row.radius+'"/>'+
                            '<input type="hidden" name="fab_po_status[]" value="'+row.po_status+'"/>'+
                            '<input type="hidden" name="fab_rcv_status[]" value="'+row.rcv_status+'"/>'+
                          '</tr>'
                          );
            } else {
  
              table.append('<tr>'+
                            '<td class="left-align">'+row.fab_code+'</td>'+
                            '<td class="left-align">'+row.fab_desc+'</td>'+
                            '<td class="left-align">'+row.length+'</td>'+
                            '<td class="left-align">'+row.width+'</td>'+
                            '<td class="left-align">'+row.thickness+'</td>'+
                            '<td class="left-align">'+row.radius+'</td>'+
                            '<td><button type="button" class="btn-small red waves-effect waves-light" disabled><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                            '<input type="hidden" name="fab_assy_code[]" value="'+assy_code+'"/>'+
                            '<input type="hidden" name="fab_code[]" value="'+row.fab_code+'"/>'+
                            '<input type="hidden" name="fab_desc[]" value="'+row.fab_desc+'"/>'+
                            '<input type="hidden" name="fab_length[]" value="'+row.length+'"/>'+
                            '<input type="hidden" name="fab_width[]" value="'+row.width+'"/>'+
                            '<input type="hidden" name="fab_thickness[]" value="'+row.thickness+'"/>'+
                            '<input type="hidden" name="fab_radius[]" value="'+row.radius+'"/>'+
                            '<input type="hidden" name="fab_po_status[]" value="'+row.po_status+'"/>'+
                            '<input type="hidden" name="fab_rcv_status[]" value="'+row.rcv_status+'"/>'+
                          '</tr>'
                          );
            }
        });
      } else {
         
        $.each(items, (index,row) => {
            if( row.po_status=='' || row.po_status==null || row.po_status=='null' || row.rcv_status=='' || row.rcv_status==null || row.rcv_status=='null' )
            {
              table.append('<tr>'+
                            '<td class="left-align">'+row.item_code+'</td>'+
                            '<td class="left-align">'+row.description+'</td>'+
                            '<td class="left-align">'+row.uom_code+'</td>'+
                            '<td class="left-align">'+row.length+'</td>'+
                            '<td class="left-align">'+row.width+'</td>'+
                            '<td class="left-align">'+row.thickness+'</td>'+
                            '<td class="left-align">'+row.radius+'</td>'+
                            '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="delItemModal(\''+index+'\',\''+loc+'\',\''+assy_code+'\',)"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                            '<input type="hidden" name="item_assy_code[]" value="'+assy_code+'"/>'+
                            '<input type="hidden" name="item_code[]" value="'+row.item_code+'"/>'+
                            '<input type="hidden" name="item_desc[]" value="'+row.description+'"/>'+
                            '<input type="hidden" name="item_uom[]" value="'+row.uom_code+'"/>'+
                            '<input type="hidden" name="item_length[]" value="'+row.length+'"/>'+
                            '<input type="hidden" name="item_width[]" value="'+row.width+'"/>'+
                            '<input type="hidden" name="item_thickness[]" value="'+row.thickness+'"/>'+
                            '<input type="hidden" name="item_radius[]" value="'+row.radius+'"/>'+
                            '<input type="hidden" name="item_loc[]" value="'+loc+'"/>'+
                            '<input type="hidden" name="item_po_status[]" value="'+row.po_status+'"/>'+
                            '<input type="hidden" name="item_rcv_status[]" value="'+row.rcv_status+'"/>'+
                          '</tr>'
                          );
            } else {
              table.append('<tr>'+
                            '<td class="left-align">'+row.item_code+'</td>'+
                            '<td class="left-align">'+row.description+'</td>'+
                            '<td class="left-align">'+row.uom_code+'</td>'+
                            '<td class="left-align">'+row.length+'</td>'+
                            '<td class="left-align">'+row.width+'</td>'+
                            '<td class="left-align">'+row.thickness+'</td>'+
                            '<td class="left-align">'+row.radius+'</td>'+
                            '<td><button type="button" class="btn-small red waves-effect waves-light" disabled><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                            '<input type="hidden" name="item_assy_code[]" value="'+assy_code+'"/>'+
                            '<input type="hidden" name="item_code[]" value="'+row.item_code+'"/>'+
                            '<input type="hidden" name="item_desc[]" value="'+row.description+'"/>'+
                            '<input type="hidden" name="item_uom[]" value="'+row.uom_code+'"/>'+
                            '<input type="hidden" name="item_length[]" value="'+row.length+'"/>'+
                            '<input type="hidden" name="item_width[]" value="'+row.width+'"/>'+
                            '<input type="hidden" name="item_thickness[]" value="'+row.thickness+'"/>'+
                            '<input type="hidden" name="item_radius[]" value="'+row.radius+'"/>'+
                            '<input type="hidden" name="item_loc[]" value="'+loc+'"/>'+
                            '<input type="hidden" name="item_po_status[]" value="'+row.po_status+'"/>'+
                            '<input type="hidden" name="item_rcv_status[]" value="'+row.rcv_status+'"/>'+
                          '</tr>'
                          );
            }
        });
      }
    };

    const renderList = (assy_code, assy_desc) => {
      
      var coll  = '<li id="'+assy_code+'">'+
                  '<input type="hidden" name="assy_code[]" value="'+assy_code+'"/>'+
                  '<input type="hidden" name="assy_desc[]" value="'+assy_desc+'"/>';
                    coll += '<div class="collapsible-header">'+assy_code+' - '+assy_desc+'<i onclick="delAssyModal(\''+assy_code+'\');" class="red-text material-icons" style="z-index:=10; position:absolute;right:38;">cancel</i></div>';
                    coll += '<div class="collapsible-body">'+
                                '<span>'+
                                    // tabs header
                                    '<ul id="assy_tab'+assy_code+'" class="tabs tabs-fixed-width tab-demo z-depth-1">'+
                                        '<li class="tab col s12 m4 l4"><a class="active" href="#mfab'+assy_code+'">Mechnical Fabrication</a></li>'+
                                        '<li class="tab col s12 m4 l4"><a href="#mstand'+assy_code+'">Mechnical Standard</a></li>'+
                                        '<li class="tab col s12 m4 l4"><a href="#fast'+assy_code+'">Fasteners</a></li>'+
                                        '<li class="tab col s12 m4 l4"><a href="#pneu'+assy_code+'">Pneumatics</a></li>'+
                                        '<li class="tab col s12 m4 l4"><a href="#elec'+assy_code+'">Electrical</a></li>'+
                                    '</ul>'+
                                    // end tabs header

                                    // tabs table
                                    '<div id="mfab'+assy_code+'">'+
                                      '<div class="col s12 m3 l3 right-align" style="padding-right: 10px;padding-left: 10px; margin-top: 10px; margin-bottom: 20px">'+
                                        '<a onclick="showModal(\'Add Mechanical Fabrication\',\''+assy_code+'\');" class="teal waves-effect waves-dark btn modal-trigger" style="width: 100%"><i class="material-icons left">add_circle</i>Add Item(s)</a>'+
                                      '</div>'+
                                      '<div class="card" style="margin-top: 0px">'+
                                        '<div class="card-content">'+
                                          '<table class="responsive-table highlight" id="tbl'+assy_code+'mfab" style="width: 100%">'+
                                            '<thead>'+
                                                '<tr>'+
                                                    '<th>Fabrication Code</th>'+
                                                    '<th>Description</th>'+
                                                    '<th>Length</th>'+
                                                    '<th>Width</th>'+
                                                    '<th>Thickness</th>'+
                                                    '<th>Radius</th>'+
                                                    '<th>Action</th>'+
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody></tbody>'+
                                          '</table>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+

                                    '<div id="mstand'+assy_code+'">'+
                                      '<div class="col s12 m3 l3 right-align" style="padding-right: 10px;padding-left: 10px; margin-top: 10px; margin-bottom: 20px">'+
                                        '<a onclick="showModal(\'Add Mechanical Standard\',\''+assy_code+'\');" class="teal waves-effect waves-dark btn modal-trigger" style="width: 100%"><i class="material-icons left">add_circle</i>Add Item(s)</a>'+
                                      '</div>'+
                                      '<div class="card" style="margin-top: 0px">'+
                                        '<div class="card-content">'+
                                          '<table class="responsive-table highlight" id="tbl'+assy_code+'mstand" style="width: 100%">'+
                                            '<thead>'+
                                                '<tr>'+
                                                    '<th>Item Code</th>'+
                                                    '<th>Description</th>'+
                                                    '<th>Unit Of Measure</th>'+
                                                    '<th>Length</th>'+
                                                    '<th>Width</th>'+
                                                    '<th>Thickness</th>'+
                                                    '<th>Radius</th>'+
                                                    '<th>Action</th>'+
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody></tbody>'+
                                          '</table>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+

                                    '<div id="fast'+assy_code+'">'+
                                      '<div class="col s12 m3 l3 right-align" style="padding-right: 10px;padding-left: 10px; margin-top: 10px; margin-bottom: 20px">'+
                                        '<a onclick="showModal(\'Add Fasteners\',\''+assy_code+'\');" class="teal waves-effect waves-dark btn modal-trigger" style="width: 100%"><i class="material-icons left">add_circle</i>Add Item(s)</a>'+
                                      '</div>'+
                                      '<div class="card" style="margin-top: 0px">'+
                                        '<div class="card-content">'+
                                          '<table class="responsive-table highlight" id="tbl'+assy_code+'fast" style="width: 100%">'+
                                            '<thead>'+
                                                '<tr>'+
                                                    '<th>Item Code</th>'+
                                                    '<th>Description</th>'+
                                                    '<th>Unit Of Measure</th>'+
                                                    '<th>Length</th>'+
                                                    '<th>Width</th>'+
                                                    '<th>Thickness</th>'+
                                                    '<th>Radius</th>'+
                                                    '<th>Action</th>'+
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody></tbody>'+
                                          '</table>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+

                                    '<div id="pneu'+assy_code+'">'+
                                      '<div class="col s12 m3 l3 right-align" style="padding-right: 10px;padding-left: 10px; margin-top: 10px; margin-bottom: 20px">'+
                                        '<a onclick="showModal(\'Add Pneumatics\',\''+assy_code+'\');" class="teal waves-effect waves-dark btn modal-trigger" style="width: 100%"><i class="material-icons left">add_circle</i>Add Item(s)</a>'+
                                      '</div>'+
                                      '<div class="card" style="margin-top: 0px">'+
                                        '<div class="card-content">'+
                                          '<table class="responsive-table highlight" id="tbl'+assy_code+'pneu" style="width: 100%">'+
                                            '<thead>'+
                                                '<tr>'+
                                                    '<th>Item Code</th>'+
                                                    '<th>Description</th>'+
                                                    '<th>Unit Of Measure</th>'+
                                                    '<th>Length</th>'+
                                                    '<th>Width</th>'+
                                                    '<th>Thickness</th>'+
                                                    '<th>Radius</th>'+
                                                    '<th>Action</th>'+
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody></tbody>'+
                                          '</table>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+

                                    '<div id="elec'+assy_code+'">'+
                                      '<div class="col s12 m3 l3 right-align" style="padding-right: 10px;padding-left: 10px; margin-top: 10px; margin-bottom: 20px">'+
                                        '<a onclick="showModal(\'Add Electrical\',\''+assy_code+'\');" class="teal waves-effect waves-dark btn modal-trigger" style="width: 100%"><i class="material-icons left">add_circle</i>Add Item(s)</a>'+
                                      '</div>'+
                                      '<div class="card" style="margin-top: 0px">'+
                                        '<div class="card-content">'+
                                          '<table class="responsive-table highlight" id="tbl'+assy_code+'elec" style="width: 100%">'+
                                            '<thead>'+
                                                '<tr>'+
                                                    '<th>Item Code</th>'+
                                                    '<th>Description</th>'+
                                                    '<th>Unit Of Measure</th>'+
                                                    '<th>Length</th>'+
                                                    '<th>Width</th>'+
                                                    '<th>Thickness</th>'+
                                                    '<th>Radius</th>'+
                                                    '<th>Action</th>'+
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody></tbody>'+
                                          '</table>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+ 
                                    // end tabs table
                                '</span>'+
                            '</div>';
      coll += '</li>';                                 
      $('#assy_collapse').append(coll);
      $('#assy_tab'+assy_code).tabs();
      $('.collapsible').collapsible();
    };

    const removeProduct = () => {
        var index =     $('#del_index').val();
        var loc =       $('#del_loc').val();
        var assy_code = $('#del_assy').val();
        var item_arr = (loc=='mfab' ? n_mfab : (loc=='mstand' ? n_mstand : (loc=='fast' ? n_fast : (loc=='pneu' ? n_pneu : (loc=='elec' ? n_elec : '')))));
        item_arr.splice(index,1);
          $('#delAssyItemModal').modal('close');
        switch (loc) {
          case "mfab":
            renderTable(item_arr,$('#tbl'+assy_code+'mfab tbody'),loc,assy_code);
            break;
          case "mstand":
            renderTable(item_arr,$('#tbl'+assy_code+'mstand tbody'),loc,assy_code);
            break;
          case "fast":
            renderTable(item_arr,$('#tbl'+assy_code+'fast tbody'),loc,assy_code);
            break;
          case "pneu":
            renderTable(item_arr,$('#tbl'+assy_code+'pneu tbody'),loc,assy_code);
            break;
          case "elec":
            renderTable(item_arr,$('#tbl'+assy_code+'elec tbody'),loc,assy_code);
            break;
        };
      
    };

    const removeListItem = () => {
        var listItem = document.getElementById($('#del_id').val());
        listItem.remove();
        $('#delAssyModal').modal('close');
    };

    // function end

 

  </script>

  <!-- End of SCRIPTS -->

@endsection
