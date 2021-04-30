@extends('layouts.resmain')
<style>
   textarea.materialize-textarea
        {
            height: 20% !important; 
        }
</style>
 
@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Projects<i class="material-icons">arrow_forward_ios</i></span><span class="grey-text darken-4">Project List<i class="material-icons">arrow_forward_ios</i></span>New Project</h4>
    </div>
  </div>
 
    <div class="m-3 main-content">  
        <ul id="project_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
          <li class="tab col s12 m4 l4"><a class="active" href="#details">Project Details</a></li>
        </ul>

        <div class="card" style="margin-top: 0px">
          <div class="card-body">
            <form method="POST" action="{{route('projects.store')}}" enctype="multipart/form-data">
              @csrf

              <div id="details" name="details">
                <div class="row">
                  <br>
                    <div class="col s12 m12 l12">
                      <div class="col s12 m12 l12">
                        <div class="input-field col s12 m4 l4">
                            <select id="add_site_code" name="site_code" required>
                                 <option value="" disabled selected>Choose Site</option>
                             @foreach ($sites as $s)
                                 <option value="{{$s->site_code}}">{{$s->site_desc}}</option>
                             @endforeach
                            </select>
                           <label for="site_code">Site<sup class="red-text">*</sup></label>
                           {{-- <input type="hidden" id="add_site_code" name="add_site_code"> --}}
                        </div>

                        <div class="input-field col s12 m4 l4">
                            <select id="add_customer" name="customer" required>
                                    <option value="" disabled selected>Choose Customer</option>
                                @foreach ($customers as $cust)
                                    <option value="{{$cust->cust_code}}">{{$cust->cust_name}}</option>
                                @endforeach
                            </select>
                            <label for="customer">Customer<sup class="red-text">*</sup></label>
                            {{-- <input type="hidden" id="add_customer" name="add_customer"> --}}
                        </div>
                      </div>
                      
                      <div class="col s12 m12 l12">
                        <div class="input-field col s12 m4 l4">
                            <select id="add_project_type" name="project_type" required>
                                    <option value="" disabled selected>Choose Type</option>
                                    <option value="A">Automation</option>
                                    <option value="T">Tooling</option>
                            </select>
                            <label for="project_type">Project Type<sup class="red-text">*</sup></label>
                            {{-- <input type="hidden" id="add_customer" name="add_customer"> --}}
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <input type="text" id="add_project_name" name="project_name" placeholder=" " required/>
                            <label for="project_name">Project Name<sup class="red-text">*</sup></label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <input type="text" id="add_project_code" name="project_code" placeholder=" " readonly required/>
                            <label for="project_code">Project Code<sup class="red-text"></sup></label>
                        </div>
                      </div>

                      <div class="col s12 m12 l12">
                        <div class="input-field col s12 m4 l4">
                            <select id="add_sales_order" name="sales_order" required>
                                    <option value="" disabled selected>Choose Sales Order</option>
                            </select>
                            <label for="sales_order">Sales Order<sup class="red-text">*</sup></label>
                            {{-- <input type="hidden" id="add_customer" name="add_customer"> --}}
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <select id="add_product" name="product" required>
                                 <option value="" disabled selected>Choose Product</option>
                            </select>
                           <label for="product">Product<sup class="red-text">*</sup></label>
                           {{-- <input type="hidden" id="add_customer" name="add_customer"> --}}
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <input type="text" id="add_quantity" name="quantity" placeholder=" " readonly required/>
                            <label for="quantity">Quantity<sup class="red-text">*</sup></label>
                        </div>
                      </div>
  
                      <div class="row">
                        <div class="col s12 m6 l6"></div>
                        <div class="col s12 m3 l3 right-align" style="padding-right: 10px;padding-left: 12px;">
                          <a id="set" href="#!" onclick="setTable();" class="blue waves-effect waves-dark btn" style="width: 100%"><i class="material-icons left">check_circle</i>Set</a>
                        </div>
                        <div class="col s12 m3 l3 right-align" style="padding-right: 30px;padding-left: 0px;">
                          <a id="reset" href="#!" onclick="resetTable();" class="orange waves-effect waves-dark btn" style="width: 100%" disabled><i class="material-icons left">loop</i>Reset</a>
                        </div>
                      </div>
   
                      <div class="col s12 m12 l12 row" style="margin-bottom: 0px;">
                        <div id="assy" class="col s12 m12 l12 row" style="margin-bottom: 0px;">
                            
                        </div>
                      </div>                      
                  </div>
                </div>
              </div> 
              
              <div id="details_footer" class="row" style="display: none">
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
        <div class="modal-content">
          <h4 id="header"></h4>

          <div class="row">
            <input type="hidden" id="add_assy_code" name="item_code"/>
            <input type="hidden" id="loc" name="loc"/>
    
            <div class="input-field col s12 m6 l6" id="fab_code" style="display: none">
              <input type="text" id="add_fab_code" name="fab_code" placeholder=""/>
              <label for="fab_code">Fabrication Code<sup class="red-text">*</sup></label>
            </div>
          
            <div class="input-field col s12 m6 l6" id="item_code">
              <input type="text" id="add_item_code" name="item_code" placeholder=""/>
              <label for="item_code">Item Code<sup class="red-text">*</sup></label>
            </div>
            
            <div class="input-field col s12 m6 l6">
              <input type="text" id="add_description" name="description" placeholder=""/>
              <label for="description">Description<sup class="red-text">*</sup></label>
            </div>

            <div id="showUOM" class="input-field col s12 m6 l6" style="display: none">
              <select id="add_uom_code" name="uom_code" required>
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
              <input placeholder="" name="item_length" id="add_item_length" type="number" step="0.0001" class="number validate">
              <label for="item_length">Length<sup class="red-text"></sup></label>
              <div class="col s12 m6 left-align">
                <label>
                    <input placeholder="e.g $"  type="checkbox" onclick="distext('add_item_length')"/>
                      <span style="font-size: 12px">Click to set N/A</span>
                </label>
              </div>
            </div>

            <div class="input-field col s12 m6 l6">
              <input placeholder="" name="item_width" id="add_item_width" type="number" step="0.0001" class="number validate">
              <label for="item_width">Width<sup class="red-text"></sup></label>
              <div class="col s12 m6 left-align">
                <label>
                    <input placeholder="e.g $"  type="checkbox" onclick="distext('add_item_width')"/>
                      <span style="font-size: 12px">Click to set N/A</span>
                </label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12 m6 l6">
              <input placeholder="" name="item_thickness" id="add_item_thickness" type="number" step="0.0001" class="number validate">
              <label for="item_thickness">Thickness<sup class="red-text"></sup></label>
              <div class="col s12 m6 left-align">
                <label>
                    <input placeholder="e.g $"  type="checkbox" onclick="distext('add_item_thickness')"/>
                      <span style="font-size: 12px">Click to set N/A</span>
                </label>
              </div>
            </div>
            <div class="input-field col s12 m6 l6">
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
    });

    $('#add_site_code').on('change', function(){
        var site = $(this).val();
        var cust = $("#add_customer").val() == null ? '' : $("#add_customer").val();
        var type = $("#add_project_type").val() == null ? '' : $("#add_project_type").val();
        projectCode(site, cust, type, cpcount);
        console.log(site);
        $.get(site+'/orders', (response) => {
          var data = response.data;
          var select = '<option value="" disabled selected>Choose Sales Order</option>';
          $.each(data, function(index, row){
            select += '<option value="'+row.order_code+'">'+row.order_code+'</option>';
            console.log(data);
          });
         
          $('#add_sales_order').html(select);
          $('#add_sales_order').formSelect();
        });
    });

    $('#add_sales_order').on('change', function(){
        $.get($(this).val()+'/allproducts', (response) => {
          var data = response.data;
          var select = '<option value="" disabled selected>Choose Product</option>';
          $.each(JSON.parse(data.products), function(index, row){             
            select += '<option value="'+row.prod_code+'">'+row.prod_name+'</option>';
            prod_quantity.push({"prod_code":row.prod_code,"quantity":row.quantity});
          });
          $('#add_product').html(select);
          $('#add_product').formSelect();
        });
    });

    $('#add_product').on('change', function(){
        $('#add_quantity').val(prod_quantity.filter(prod => prod.prod_code == $(this).val())[0].quantity);
    });

    $('#add_customer').on('change', function(){
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

    $('#add_project_type').on('change', function(){
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

    const projectCode = (site, cust, type, cpcount) => {
        $('#add_project_code').val(site + '-' + cust + '-' + 'JO' + '-' + type  + '000' + cpcount);
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

    const showModal = (loc, assy_code) => {
       if(loc!='Add Mechanical Fabrication')
       {
        var x = document.getElementById("showUOM"); 
        x.style.display = "block";

        var y = document.getElementById("item_code");
        y.style.display = "block";

        var c = document.getElementById("fab_code");
        c.style.display = "none";
       } else {
        var x = document.getElementById("showUOM"); 
        x.style.display = "none";

        var y = document.getElementById("item_code");
        y.style.display = "none";

        var c = document.getElementById("fab_code");
        c.style.display = "block";
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

    const addItems = () => {
      var loc = $('#loc').val();
      switch (loc) {
        case "mfab":
          var assy_code = $('#add_assy_code').val();
          n_mfab.push({"assy_code":     $('#add_assy_code').val(),
                        "fab_code":     $('#add_fab_code').val(),
                        "fab_desc":     $('#add_description').val(),
                        "length":       $('#add_item_length').val(),
                        "width":        $('#add_item_width').val(),
                        "thickness":    $('#add_item_thickness').val(),
                        "radius":       $('#add_item_radius').val(),
                        "loc":          'mfab',
                      });                    
          renderTable(n_mfab,$('#tbl'+assy_code+'mfab tbody'),loc,assy_code);
            break;
        case "mstand":
          var assy_code = $('#add_assy_code').val();
          n_mstand.push({"assy_code":   $('#add_assy_code').val(),
                        "item_code":    $('#add_item_code').val(),
                        "description":  $('#add_description').val(),
                        "uom_code":     $('#add_uom_code').val(),
                        "length":       $('#add_item_length').val(),
                        "width":        $('#add_item_width').val(),
                        "thickness":    $('#add_item_thickness').val(),
                        "radius":       $('#add_item_radius').val(),
                        "loc":          'mstand',
                      });                 
          renderTable(n_mstand,$('#tbl'+assy_code+'mstand tbody'),loc,assy_code);
            break;
        case "fast":
          var assy_code = $('#add_assy_code').val();
          n_fast.push({"assy_code":      $('#add_assy_code').val(),
                        "item_code":    $('#add_item_code').val(),
                        "description":  $('#add_description').val(),
                        "uom_code":     $('#add_uom_code').val(),
                        "length":       $('#add_item_length').val(),
                        "width":        $('#add_item_width').val(),
                        "thickness":    $('#add_item_thickness').val(),
                        "radius":       $('#add_item_radius').val(),
                        "loc":          'fast',
                      });                     
          renderTable(n_fast,$('#tbl'+assy_code+'fast tbody'),loc,assy_code);  
            break;
        case "pneu":
          var assy_code = $('#add_assy_code').val();
          n_pneu.push({"assy_code":     $('#add_assy_code').val(),
                        "item_code":    $('#add_item_code').val(),
                        "description":  $('#add_description').val(),
                        "uom_code":     $('#add_uom_code').val(),
                        "length":       $('#add_item_length').val(),
                        "width":        $('#add_item_width').val(),
                        "thickness":    $('#add_item_thickness').val(),
                        "radius":       $('#add_item_radius').val(),
                        "loc":          'pneu',
                      });        
          renderTable(n_pneu,$('#tbl'+assy_code+'pneu tbody'),loc,assy_code);
            break;
        case "elec":
          var assy_code = $('#add_assy_code').val();
          n_elec.push({"assy_code":     $('#add_assy_code').val(),
                        "item_code":    $('#add_item_code').val(),
                        "description":  $('#add_description').val(),
                        "uom_code":     $('#add_uom_code').val(),
                        "length":       $('#add_item_length').val(),
                        "width":        $('#add_item_width').val(),
                        "thickness":    $('#add_item_thickness').val(),
                        "radius":       $('#add_item_radius').val(),
                        "loc":          'elec',
                      });
          renderTable(n_elec,$('#tbl'+assy_code+'elec tbody'),loc,assy_code);
            break;
      };
    };

    const addAssy = () => {
      var assy_code = $('#new_assy_code').val();
      var assy_desc = $('#new_assy_desc').val();
      renderList(assy_code, assy_desc);
    };

    const setTable = () => {
      if($('#add_site_code').val() && $('#add_customer').val() && $('#add_project_type').val() && $('#add_project_name').val() && $('#add_project_code').val() && $('#add_sales_order').val() && $('#add_product').val() && $('#add_quantity').val()){
          renderProductTable($('#add_product').val());
          // $('#add_site_code').prop('disabled', true);
          // $('#add_site_code').formSelect();

          // $('#add_customer').prop('disabled', true);
          // $('#add_customer').formSelect();

          // $('#add_project_type').prop('disabled', true);
          // $('#add_project_type').formSelect();

          // $('#add_sales_order').prop('disabled', true);
          // $('#add_sales_order').formSelect();

          // $('#add_product').prop('disabled', true);
          // $('#add_product').formSelect();

          // $('#add_project_name').prop('disabled', true);
          // $('#add_project_code').prop('disabled', true);
          // $('#add_quantity').prop('disabled', true);
          $("#set").attr('disabled','disabled');
          $("#reset").removeAttr('disabled');
          var footer = document.getElementById("details_footer");
              footer.style.display = "block";
      } else {
        alert("Please fill up all project details!");
      }
    };

    const resetTable = () => {
      $('#add_site_code').prop('disabled', false);
      $('#add_site_code').val("");
      $('#add_site_code').formSelect();
      
      $('#add_customer').prop('disabled', false);
      $('#add_customer').val("");
      $('#add_customer').formSelect();

      $('#add_project_type').prop('disabled', false);
      $('#add_project_type').val("");
      $('#add_project_type').formSelect();

      $('#add_sales_order').prop('disabled', false);
      $('#add_sales_order').val("");
      $('#add_sales_order').formSelect();

      $('#add_product').prop('disabled', false);
      $('#add_product').val("");
      $('#add_product').formSelect();

      $('#add_project_name').prop('disabled', false);
      $('#add_project_name').val(""); 

      $('#add_project_code').prop('disabled', false);
      $('#add_project_code').val(""); 

      $('#add_quantity').prop('disabled', false);
      $('#add_quantity').val("");

      $("#reset").attr('disabled','disabled');
      $("#set").removeAttr('disabled');
      $('#assy').html("");
      var footer = document.getElementById("details_footer");
          footer.style.display = "none";
    };

    const renderProductTable = (prod_code) => {
      $.get(prod_code+'/assy', (response) => {
            var data = response.data;  
 
                        // collapsible list header
            var coll =  '<div class="col s12 l10 m10"></div>'+
                        '<div class="col s12 l2 m2 right-align">'+
                            '<i onclick="assyModal();" class="white-text material-icons" style="z-index:=10;position:absolute;right:55;top: 337.5px;">add_to_photos</i>'+
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
                // assy_list.push({
                //                 "assy_code":    value['assy_code'],
                //                 "assy_desc":    value['assy_desc'],
                //                 });
                coll += '<li id="'+value['assy_code']+'">'+
                        '<input type="hidden" name="assy_code[]" value="'+value['assy_code']+'"/>'+
                        '<input type="hidden" name="assy_desc[]" value="'+value['assy_desc']+'"/>';
                    coll += '<div class="collapsible-header">'+value['assy_code']+' - '+value['assy_desc']+'<i onclick="removeListItem(\''+value['assy_code']+'\');" class="red-text material-icons" style="z-index:=10; position:absolute;right:38;">cancel</i></div>';
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
                $.get(value['assy_code']+'/fab', (response) => {
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
                        div +=  '<tr>'+
                                    '<td class="left-align">'+value['fab_code']+'</td>'+
                                    '<td class="left-align">'+value['fab_desc']+'</td>'+
                                    '<td class="left-align">'+value['length']+'</td>'+
                                    '<td class="left-align">'+value['width']+'</td>'+
                                    '<td class="left-align">'+value['thickness']+'</td>'+
                                    '<td class="left-align">'+value['radius']+'</td>'+
                                    '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="removeProduct(\''+index+'\',\''+$('#tbl'+value['assy_code']+'mfab tbody')+'\',\'mfab\',\''+value['assy_code']+'\',)"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                                    '<input type="hidden" name="fab_assy_code[]" value="'+value['assy_code']+'"/>'+
                                    '<input type="hidden" name="fab_code[]" value="'+value['fab_code']+'"/>'+
                                    '<input type="hidden" name="fab_desc[]" value="'+value['fab_desc']+'"/>'+
                                    '<input type="hidden" name="fab_length[]" value="'+value['length']+'"/>'+
                                    '<input type="hidden" name="fab_width[]" value="'+value['width']+'"/>'+
                                    '<input type="hidden" name="fab_thickness[]" value="'+value['thickness']+'"/>'+
                                    '<input type="hidden" name="fab_radius[]" value="'+value['radius']+'"/>'+
                                '</tr>';
                      n_mfab.push({
                                    "assy_code":    value['assy_code'],
                                    "fab_code":     value['fab_code'],
                                    "fab_desc":     value['fab_desc'],
                                    "length":       value['length'],
                                    "width":        value['width'],
                                    "thickness":    value['thickness'],
                                    "radius":       value['radius'],
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
            $('.collapsible').collapsible();
        });  
    };

    const renderTable = (items, table, loc, assy_code) => {
      table.html("");
      if(loc=='mfab'){
        $.each(items, (index,row) => {
        if(row.loc==loc && row.assy_code==assy_code){
          table.append('<tr>'+
                      '<td class="left-align">'+row.fab_code+'</td>'+
                      '<td class="left-align">'+row.fab_desc+'</td>'+
                      '<td class="left-align">'+row.length+'</td>'+
                      '<td class="left-align">'+row.width+'</td>'+
                      '<td class="left-align">'+row.thickness+'</td>'+
                      '<td class="left-align">'+row.radius+'</td>'+
                      '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="removeProduct(\''+index+'\',\''+table+'\',\''+loc+'\',\''+assy_code+'\',)"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                      '<input type="hidden" name="fab_assy_code[]" value="'+assy_code+'"/>'+
                      '<input type="hidden" name="fab_code[]" value="'+row.fab_code+'"/>'+
                      '<input type="hidden" name="fab_desc[]" value="'+row.fab_desc+'"/>'+
                      '<input type="hidden" name="fab_length[]" value="'+row.length+'"/>'+
                      '<input type="hidden" name="fab_width[]" value="'+row.width+'"/>'+
                      '<input type="hidden" name="fab_thickness[]" value="'+row.thickness+'"/>'+
                      '<input type="hidden" name="fab_radius[]" value="'+row.radius+'"/>'+
                    '</tr>'
                    );
          }
        });
      } else {
         
        $.each(items, (index,row) => {
        if(row.loc==loc && row.assy_code==assy_code){
          table.append('<tr>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.description+'</td>'+
                      '<td class="left-align">'+row.uom_code+'</td>'+
                      '<td class="left-align">'+row.length+'</td>'+
                      '<td class="left-align">'+row.width+'</td>'+
                      '<td class="left-align">'+row.thickness+'</td>'+
                      '<td class="left-align">'+row.radius+'</td>'+
                      '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="removeProduct(\''+index+'\',\''+table+'\',\''+loc+'\',\''+assy_code+'\',)"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                      '<input type="hidden" name="item_assy_code[]" value="'+assy_code+'"/>'+
                      '<input type="hidden" name="item_code[]" value="'+row.item_code+'"/>'+
                      '<input type="hidden" name="item_desc[]" value="'+row.description+'"/>'+
                      '<input type="hidden" name="item_uom[]" value="'+row.uom_code+'"/>'+
                      '<input type="hidden" name="item_length[]" value="'+row.length+'"/>'+
                      '<input type="hidden" name="item_width[]" value="'+row.width+'"/>'+
                      '<input type="hidden" name="item_thickness[]" value="'+row.thickness+'"/>'+
                      '<input type="hidden" name="item_radius[]" value="'+row.radius+'"/>'+
                      '<input type="hidden" name="item_loc[]" value="'+loc+'"/>'+
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
                    coll += '<div class="collapsible-header">'+assy_code+' - '+assy_desc+'<i onclick="removeListItem(\''+assy_code+'\');" class="red-text material-icons" style="z-index:=10; position:absolute;right:38;">cancel</i></div>';
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
      // $('#assy_collapse').html('');                                     
      $('#assy_collapse').append(coll);
      $('#assy_tab'+assy_code).tabs();
      $('.collapsible').collapsible();
    };

    const removeProduct = (index, table, loc, assy_code) => {   
        var item_arr = (loc=='mfab' ? n_mfab : (loc=='mstand' ? n_mstand : (loc=='fast' ? n_fast : (loc=='pneu' ? n_pneu : (loc=='elec' ? n_elec : '')))));
        item_arr.splice(index,1);
        renderTable(item_arr,$('#tbl'+assy_code+'mfab tbody'),loc,assy_code);
    };

    const removeListItem = (assy_code) => {
        var listItem = document.getElementById(assy_code);
        listItem.remove();
    };



 

  </script>

  <!-- End of SCRIPTS -->

@endsection
