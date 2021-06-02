@extends('layouts.resmain')
     <style>
        .e-signature-pad {
            position: relative;
            display: -ms-flexbox;
            -ms-flex-direction: column;
            width: 100%;
            height: 100%;
            max-width: 1000px;
            max-height: 315px;
            border: 1px solid #e8e8e8;
            background-color: #fff;
            box-shadow: 0 3px 20px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08) inset;
            border-radius: 15px;
            padding: 20px;
        }
        .txt-center {
            text-align: -webkit-center;
        }
    </style>
@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title">
          <span class="grey-text darken-4">Parts Preparation<i class="material-icons">arrow_forward_ios</i></span>
          <span class="grey-text darken-4">Returned Items<i class="material-icons">arrow_forward_ios</i></span>
          Receiving</h4>
    </div>
  </div>
  <div class="row main-content">
 

    

<body>
 
    <div id="signature-pad" class="e-signature-pad">
        <div class="jay-signature-pad--body">
            <canvas id="jay-signature-pad" width=500 height=250></canvas>
        </div>
        <div class="signature-pad--footer txt-center">
            <div class="description"><strong> SIGN ABOVE </strong></div>
            <div class="signature-pad--actions txt-center">
                <div>
                    <button type="button" class="button clear" data-action="clear">Clear</button>
                    <button type="button" class="button" data-action="change-color">Change color</button>
                </div><br/>
                {{-- <div>
                    <button type="button" class="button save" data-action="save-png">Save as PNG</button>
                    <button type="button" class="button save" data-action="save-jpg">Save as JPG</button>
                    <button type="button" class="button save" data-action="save-svg">Save as SVG</button>
                </div> --}}
            </div>
        </div>
    </div>
    

</body>

  </div>
 
  <!-- MODALS -->

  <!-- End of MODALS -->

  <!-- SCRIPTS -->
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>

  <script>
    var wrapper = document.getElementById("signature-pad");
    var clearButton = wrapper.querySelector("[data-action=clear]");
    var changeColorButton = wrapper.querySelector("[data-action=change-color]");
    // var savePNGButton = wrapper.querySelector("[data-action=save-png]");
    // var saveJPGButton = wrapper.querySelector("[data-action=save-jpg]");
    // var saveSVGButton = wrapper.querySelector("[data-action=save-svg]");
    var canvas = wrapper.querySelector("canvas");
    var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)'
    });
    // Adjust canvas coordinate space taking into account pixel ratio,
    // to make it look crisp on mobile devices.
    // This also causes canvas to be cleared.
    function resizeCanvas() {
        // When zoomed out to less than 100%, for some very strange reason,
        // some browsers report devicePixelRatio as less than 1
        // and only part of the canvas is cleared then.
        var ratio =  Math.max(window.devicePixelRatio || 1, 1);
        // This part causes the canvas to be cleared
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        // This library does not listen for canvas changes, so after the canvas is automatically
        // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
        // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
        // that the state of this library is consistent with visual state of the canvas, you
        // have to clear it manually.
        signaturePad.clear();
    }
    // On mobile devices it might make more sense to listen to orientation change,
    // rather than window resize events.
    window.onresize = resizeCanvas;
    resizeCanvas();
    function download(dataURL, filename) {
        var blob = dataURLToBlob(dataURL);
        var url = window.URL.createObjectURL(blob);
        var a = document.createElement("a");
        a.style = "display: none";
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
    }
    // One could simply use Canvas#toBlob method instead, but it's just to show
    // that it can be done using result of SignaturePad#toDataURL.
    function dataURLToBlob(dataURL) {
        var parts = dataURL.split(';base64,');
        var contentType = parts[0].split(":")[1];
        var raw = window.atob(parts[1]);
        var rawLength = raw.length;
        var uInt8Array = new Uint8Array(rawLength);
        for (var i = 0; i < rawLength; ++i) {
            uInt8Array[i] = raw.charCodeAt(i);
        }
        return new Blob([uInt8Array], { type: contentType });
    }
    clearButton.addEventListener("click", function (event) {
        signaturePad.clear();
    });
    changeColorButton.addEventListener("click", function (event) {
        var r = Math.round(Math.random() * 255);
        var g = Math.round(Math.random() * 255);
        var b = Math.round(Math.random() * 255);
        var color = "rgb(" + r + "," + g + "," + b +")";
        signaturePad.penColor = color;
    });
    savePNGButton.addEventListener("click", function (event) {
        if (signaturePad.isEmpty()) {
        alert("Please provide a signature first.");
        } else {
        var dataURL = signaturePad.toDataURL();
        download(dataURL, "signature.png");
        }
    });
    saveJPGButton.addEventListener("click", function (event) {
        if (signaturePad.isEmpty()) {
        alert("Please provide a signature first.");
        } else {
        var dataURL = signaturePad.toDataURL("image/jpeg");
        download(dataURL, "signature.jpg");
        }
    });
    saveSVGButton.addEventListener("click", function (event) {
        if (signaturePad.isEmpty()) {
        alert("Please provide a signature first.");
        } else {
        var dataURL = signaturePad.toDataURL('image/svg+xml');
        download(dataURL, "signature.svg");
        }
    });
</script>
  {{-- <script type="text/javascript">
    var issueCount = {{$count}};
    const str = new Date().toISOString().slice(0, 10);
    var newtoday = str.replace(/[^a-zA-Z0-9]/g,"");
    var add_items = [];
    var edit_items = [];
    var view_items = [];
    var app_items = [];
    var proc_items = [];

    
    $(document).ready(function () {
      
        $.get('/api/reiss/item_master/all', (response) => {
          var data = response.data;
          var autodata = {};
          for(var i = 0; i < data.length; i++)
          {
            autodata[data[i].item_code] = 'https://icons.iconarchive.com/icons/icojam/blueberry-basic/32/check-icon.png';
          }

          $('input#add_item_code').autocomplete({
            data : autodata,
          });

          $('input#edit_item_code').autocomplete({
            data : autodata,
          });

          $('input#add_item_code').keypress(function(event) {
              if (event.keyCode == 13) {
                  event.preventDefault();
              }
          });

          $('input#edit_item_code').keypress(function(event) {
              if (event.keyCode == 13) {
                  event.preventDefault();
              }
          });
        });

        $('#add_site_code').on('change', function(){
          issuanceCode($(this).val(), 'add');
          // projectCode($(this).val(), 'add');
          $('#site_code').val($(this).val());
        });
        
        $('#add_unit_price').on('keyup', function(){
          computeTotalPrice(($('#add_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#add_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#add_unit_price').val()),parseFloat($('#add_quantity').val()),$('#add_total_price'));
        });

        $('#add_quantity').on('keyup', function(){
          computeTotalPrice(($('#add_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#add_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#add_unit_price').val()),parseFloat($('#add_quantity').val()),$('#add_total_price'));
        });

        $('#add_currency_code').on('change', function(){
          computeTotalPrice(($('#add_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#add_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#add_unit_price').val()),parseFloat($('#add_quantity').val()),$('#add_total_price'));
        });

        $('#btnAdd').on('click', function(){
          if($('#add_item_code').val() && $('#add_quantity').val())
          {
            if($('#add_quantity').val() % 1 != 0)
            {
              console.log('not allowed');
              alert("Decimal point is not allowed! Please input whole number on quantity.");
            } else {
              $.get('../item_master/getItemDetails/'+$('#add_item_code').val(), (response) => {
                var item = response.data;
                console.log(item);
                if(item!=null){
                  var item_qty = parseInt($('#add_quantity').val());
                  var safety_stock = parseInt(item.safety_stock);
                  $('#add_item_desc').val(item.item_desc);
                  addItem('add',item_qty, safety_stock);
                } else {
                  alert('Item code does not exist! Please the check the item code before adding item..');
                }
              });
            }
          }else{
            alert("Please fill up product details!");
          }
        });



        $('#edit_site_code').on('change', function(){
          issuanceCode($(this).val(), 'edit');
          $('#site_code_edit').val($(this).val());
        });

        $('#edit_unit_price').on('keyup', function(){
          computeTotalPrice(($('#edit_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#edit_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#edit_unit_price').val()),parseFloat($('#edit_quantity').val()),$('#edit_total_price'));
        });

        $('#edit_quantity').on('keyup', function(){
          computeTotalPrice(($('#edit_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#edit_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#edit_unit_price').val()),parseFloat($('#edit_quantity').val()),$('#edit_total_price'));
        });

        $('#edit_currency_code').on('change', function(){
          computeTotalPrice(($('#edit_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#edit_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#edit_unit_price').val()),parseFloat($('#edit_quantity').val()),$('#edit_total_price'));
        });

        $('#edit_btnAdd').on('click', function(){
          if($('#edit_item_code').val() &&
              $('#edit_quantity').val()  
          ){
            $.get('../item_master/getItemDetails/'+$('#edit_item_code').val(), (response) => {
              var item = response.data;
              if(item!=null){
                $.get('receiving/'+item.item_code+'/'+$('#edit_inventory_location').val()+'/getCurrentStock', (response) => {
                  var item_qty = parseInt($('#edit_quantity').val());
                  var safety_stock = parseInt(item.safety_stock);
                  $('#edit_item_desc').val(item.item_desc);
                  addItem('edit',item_qty, safety_stock);
                });
              } else {
                alert('Item code does not exist! Please the check item code before adding item details..');
              }
            });
          }else{
            alert("Please fill up product details!");
          }
        });

        $('#item_location_code').on('keyup', function(e){
          if(e.which == 13){      
            $.get('../inventory/location/getlocation/'+$('#item_location_code').val(), (response) => {
              var data = response.data;
              console.log(data);
              if(data!=null)
                { 
                  $('#btnCollect').prop('disabled', false);
                }else{
                  alert("Inventory location doesn't exist! Please re-scan inventory location.")
                  $('#btnCollect').prop('disabled', true);
                };
            }); 
          }
        });

    });
    
    const FormatNumber = (number) => {
          var n = number.toString().split(".");
          n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          n[1] = n[1] ? n[1] : '00';
          return n.join(".");
    };

    const trim = (str) => {
        return str.replace(/^\s+|\s+$/gm,'');
    };
    
    const computeTotalPrice = (symbol = '$', unit_price = 0, quantity = 0, input_total) => {
      const total = unit_price * quantity;
      input_total.val(symbol+" "+FormatNumber(total ? parseFloat(total) : 0));
    };

    const calculateGrandTotal = (symbol, products, field_grand_total) => {
        var grand_total = 0.0;
        $.each(products,(index,row) => {
            grand_total = parseFloat(grand_total) + parseFloat(row.total_price);
        });

        field_grand_total.val(symbol+" "+FormatNumber(grand_total));
    };

    const setDetails = (loc) => {
      if(loc=="add"){

        if(trim($('#add_rtv_code').val()) &&
        trim($('#add_reason').val()) &&  
        trim($('#add_site_code').val()))
        {
            $('#btnAdd').prop('disabled', false);
            $('#add_item_code').prop('disabled', false);
            $('#add_quantity').prop('disabled', false);

            $('#add_rtv_code').prop('readonly', true);
            $('#add_reason').prop('readonly', true);
            $('#add_site_code').prop('disabled', true);
            $('#add_site_code').formSelect();

            var set = document.getElementById('add_set');
                set.style.display = "none";
            var reset = document.getElementById('add_reset');
                reset.style.display = "block";
        } else {
          alert('Please fill up all issuance details before setting-up items!');
        }

      } else {

        if(trim($('#edit_rtv_code').val()) &&
        trim($('#edit_reason').val()) &&  
        trim($('#edit_site_code').val()))
        {
            $('#edit_btnAdd').prop('disabled', false);
            $('#edit_item_code').prop('disabled', false);
            $('#edit_quantity').prop('disabled', false);

            $('#edit_rtv_code').prop('readonly', true);
            $('#edit_reason').prop('readonly', true);
            $('#edit_site_code').prop('disabled', true);
            $('#edit_site_code').formSelect();

            var set = document.getElementById('edit_set');
                set.style.display = "none";
            var reset = document.getElementById('edit_reset');
                reset.style.display = "block";
        } else {
          alert('Please fill up all issuance details before setting-up items!');
        }

      }
    };

    const resetDetails = () => {
      var loc = $('#reset_loc').val();
      if(loc=="add"){
          $('#btnAdd').prop('disabled', true);
          $('#add_item_code').val("");
          $('#add_item_code').prop('disabled', true);
          $('#add_quantity').val("");
          $('#add_quantity').prop('disabled', true);

          $('#add_reason').prop('readonly', false);
          $('#add_reason').html("");

          $('#add_site_code option[value=""]').prop('selected', true);
          $('#add_site_code').prop('disabled', false);
          $('#add_site_code').formSelect();

          var set = document.getElementById('add_set');
              set.style.display = "block";
          var reset = document.getElementById('add_reset');
              reset.style.display = "none";
   
          add_items = [];
          renderItems(add_items,$('#items-dt tbody'),'add');
          $('#btnAddSave').prop('disabled', true);
          $('#resetModal').modal('close');
      } else {
          $('#edit_btnAdd').prop('disabled', true);
          $('#edit_item_code').val("");
          $('#edit_item_code').prop('disabled', true);
          $('#edit_quantity').val("");
          $('#edit_quantity').prop('disabled', true);

          $('#edit_reason').prop('readonly', false);
          $('#edit_reason').html("");

          $('#edit_site_code option[value=""]').prop('selected', true);
          $('#edit_site_code').prop('disabled', false);
          $('#edit_site_code').formSelect();
           
          $('#btnEditSave').prop('disabled', true);

          var set = document.getElementById('edit_set');
              set.style.display = "block";
          var reset = document.getElementById('edit_reset');
              reset.style.display = "none";

          $('#resetModal').modal('close');
      }
    };

    const resetItemDetails = (loc) => {
      if(loc=="add"){
        $('#add_item_code').val("");
        $('#add_quantity').val("");
      } else {
        $('#edit_item_code').val("");
        $('#edit_quantity').val("");
      }
    };

    const issuanceCode = (site, loc) => {
        if(loc=='add'){
          $('#add_rtv_code').val( site + '-RTV' + newtoday + '-00' + issueCount );
        } else {
          var str = $('#edit_rtv_code').val();
          var count = str.substr(-3, 3);
          $('#edit_rtv_code').val( site + '-RTV' + newtoday + '-' + count);
        }
    };

    const projectCode = (site, loc) => {
      $.get('../projects/'+site+'/project',(response) => {
        var data = response.data;
        var select = '<option value="" selected disabled>Choose your option</option>';
        $.each(data, (index, row) => {
          select += '<option value="'+row.project_code+'">'+row.project_name+'</option>';
        }); 
        if(loc=='add')
        {
          $('#add_project_code').html(select);
          $('#add_project_code').formSelect();
        } else {
          $('#edit_project_code').html(select);
          $('#edit_project_code').formSelect();
        }
      });
    };
    
    const openModal = () => {
      $('#add_site_code option[value=""]').prop('selected', true);
      $('#add_site_code').formSelect();
      $('#add_requestor option[value=""]').prop('selected', true);
      $('#add_requestor').formSelect();
      $('#add_purpose option[value=""]').prop('selected', true);
      $('#add_purpose').formSelect();
      $('#addModal').modal('open');
      loadApprover();
    };

    const resetModal = (loc) => {
      $('#reset_loc').val(loc);
      $('#resetModal').modal('open');
    }

    const editRTV = (id) => {
      edit_items = [];
      $('#editModal').modal('open');
      $('.tabs.edit').tabs('select','edit_issuance');
      $.get('rtv/'+id, (response) => {
        var data = response.data[0];
        var matrix = JSON.parse(data.matrix);
        if(matrix != null) renderSignatoriesTable(matrix,$('#edit-matrix-dt tbody'));
        $('#edit_id').val(id);
        $('#edit_rtv_code').val(data.rtv_code);

        $('#edit_site_code option[value="'+data.site_code+'"]').prop('selected', true);
        $('#edit_site_code').prop('disabled', false);
        $('#edit_site_code').formSelect();
        $('#edit_reason').html(data.reason);
        $('#edit_reason').prop('disabled', false);
 
        $('#edit_item_code').prop('disabled', true);
        $('#edit_quantity').prop('disabled', true);
        $('#btnEditSave').prop('disabled', true);
        $('#edit_btnAdd').prop('disabled', true);
 
        $('#site_code_edit').val(data.site_code);
      
        $.get('list/'+data.rtv_code+'/items', (response) => {
          var data = response.data;
          $.each(data, (index, row) => {
            edit_items.push({"item_code": row.item_code,
                            "item_desc": row.item_details.item_desc,
                            "quantity": row.quantity,
                            });
          });
          renderItems(edit_items,$('#edit-items-dt tbody'),'edit');
        });

      });
    };

    const viewRTV = (id) => {
      view_items = [];
      $('#viewModal').modal('open');
      $('.tabs.view').tabs('select','view_issuance');
      $.get('rtv/'+id, (response) => {
        var data = response.data[0];
        var matrix = JSON.parse(data.matrix);
        var matrix_h = JSON.parse(data.matrix_h);
        if(matrix != null) renderSignatoriesTable(matrix,$('#view-matrix-dt tbody'));
        if(matrix_h != null) renderSignatoriesTable(matrix_h,$('#view-matrix-dt-h tbody'),true);

        $('#view_rtv_code').val(data.rtv_code);
        $('#view_site_code').val(data.sites.site_desc);
        $('#view_reason').val(data.reason);
        
        if(data.status=="RTV"){
          $.get('list/'+data.rtv_code+'/items', (response) => {
            var data = response.data;
            $.each(data, (index, row) => {
              if(row.status=='Return to Vendor'){
                view_items.push({"item_code": row.item_code,
                                "item_desc": row.item_details.item_desc,
                                "quantity": row.quantity,
                                "status": row.status,
                                });
              }
            });
            renderItems(view_items,$('#view-items-dt tbody'),'view');
          });
        } else {
          $.get('list/'+data.rtv_code+'/items', (response) => {
            var data = response.data;
            $.each(data, (index, row) => {
                view_items.push({"item_code": row.item_code,
                                "item_desc": row.item_details.item_desc,
                                "quantity": row.quantity,
                                "status": row.status,
                                });
            });
            renderItems(view_items,$('#view-items-dt tbody'),'view');
          });
        }
      });
    };

    const appRTV = (id) => {
      app_items = [];
      $('#appModal').modal('open');
      $('.tabs.app').tabs('select','app_issuance');
      $.get('rtv/'+id, (response) => {
        var data = response.data[0];
        var matrix = JSON.parse(data.matrix);
        var matrix_h = JSON.parse(data.matrix_h);
        if(matrix != null) renderSignatoriesTable(matrix,$('#app-matrix-dt tbody'));
        if(matrix_h != null) renderSignatoriesTable(matrix_h,$('#app-matrix-dt-h tbody'),true);

        $('#app_id').val(id);
        $('#app_rtv_code').val(data.rtv_code);
        $('#app_site_code').val(data.sites.site_desc);
        $('#app_reason').val(data.reason);

        $.get('list/'+data.rtv_code+'/items', (response) => {
          var data = response.data;
          $.each(data, (index, row) => {
            app_items.push({"item_code": row.item_code,
                            "item_desc": row.item_details.item_desc,
                            "quantity": row.quantity,
                            "status": row.status,
                            });
            
          });
          renderItems(app_items,$('#app-items-dt tbody'),'app');
        });

      });
    };

    const processRTV = (id) => {
      proc_items = [];
      $('#processModal').modal('open');
      $('.tabs.issue').tabs('select','process');
      $.get('rtv/'+id, (response) => {
        var data = response.data[0];
        var matrix = JSON.parse(data.matrix);
        var matrix_h = JSON.parse(data.matrix_h);
        if(matrix != null) renderSignatoriesTable(matrix,$('#issue-matrix-dt tbody'));
        if(matrix_h != null) renderSignatoriesTable(matrix_h,$('#issue-matrix-dt-h tbody'),true);

        $('#process_rtv_code').val(data.rtv_code);
        $('#process_requestor').val(data.employee_details.full_name);
        $('#process_site_code').val(data.sites.site_desc);
        $('#process_reason').val(data.reason);
 
        $.get('list/'+data.rtv_code+'/items', (response) => {
          var datax = response.data;
          $.each(datax, (index, row) => {
            proc_items.push({"trans_code": row.trans_code,
                            "item_code": row.item_code,
                            "item_desc": row.item_details.item_desc,
                            "quantity": row.quantity,
                            "status": row.status,
                            "is_check": false,
                            "inventory_location": row.inventory_location_code,
                            });
          });
          renderItems(proc_items,$('#process-items-dt tbody'),'issue');
        });

      });
    };

    const prepareItems = (trans_code, item_code, id) => {
      $('#prepareModal').modal('open');
      $.get('rtv/'+trans_code+'/'+item_code+'/item_details', (response) => {
        var data = response.data;
          $('#item_id').val(id);
          $('#item_item_code').val(data.item_code);
          $('#item_item_desc').val(data.item_details.item_desc);
          $('#item_uom').val(data.item_details.uom_code);
          $('#item_quantity').val(data.quantity);
          $('#item_location_code').val("");
          $('#btnCollect').prop('disabled', true);
      });
    };

    const issItemsCan = () => {
      var id = $('#item_id').val();
      $('#'+id).prop('checked', false);

      id = id - 1;
      proc_items[id].inventory_location = "";
      proc_items[id].is_check = false;
      renderItems(proc_items,$('#process-items-dt tbody'),'issue');

      $('#prepareModal').modal('close');
    };

    const collectItem = () => {
      var index = $('#item_id').val();
          index = index - 1;

      proc_items[index].inventory_location = $('#item_location_code').val();
      proc_items[index].is_check = true;
      renderItems(proc_items,$('#process-items-dt tbody'),'issue');
      $('#prepareModal').modal('close');
    };

    const receiveRTV = (id) => {
      $('#receiveModal').modal('open');
    }

    const renderItems = (items, table, loc) => {
      table.html("");
      $.each(items, (index, row) => {
        if(loc=='add'){
          var id = parseInt(index) + 1;
          table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="deleteItem(\''+index+'\',\'add\')"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                      '<input type="hidden" name="itm_item_code[]" value="'+row.item_code+'"/>'+
                      '<input type="hidden" name="itm_quantity[]" value="'+row.quantity+'"/>'+
                      '<input type="hidden" name="itm_inventory_location[]" value=" "/>'+
                      '<input type="hidden" name="itm_currency[]" value=" "/>'+
                      '<input type="hidden" name="itm_currency_code[]" value=" "/>'+
                      '<input type="hidden" name="itm_unit_price[]" value=" "/>'+
                      '<input type="hidden" name="itm_total_price[]" value=" "/>'+
                      '</tr>'
                    );
          if(items.length > 0){
            $('#btnAddSave').prop('disabled', false);
          };
        } else if(loc=='edit'){
          var id = parseInt(index) + 1;
          table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td><button type="button" class="btn-small red waves-effect waves-light" disabled><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                      '<input type="hidden" name="e_itm_item_code[]" value="'+row.item_code+'"/>'+
                      '<input type="hidden" name="e_itm_quantity[]" value="'+row.quantity+'"/>'+
                      '<input type="hidden" name="e_itm_inventory_location[]" value=" "/>'+
                      '<input type="hidden" name="e_itm_currency[]" value=" "/>'+
                      '<input type="hidden" name="e_itm_currency_code[]" value=" "/>'+
                      '<input type="hidden" name="e_itm_unit_price[]" value=" "/>'+
                      '<input type="hidden" name="e_itm_total_price[]" value=" "/>'+
                      '</tr>'
                    );
        } else if(loc=='issue'){
          var id = parseInt(index) + 1;
          if( row.status=="Issued"){
            table.append('<tr>'+
                                '<td class="left-align">'+id+'</td>'+
                                '<td class="left-align">'+row.item_code+'</td>'+
                                '<td class="left-align">'+row.item_desc+'</td>'+
                                '<td class="left-align">'+row.quantity+'</td>'+
                                '<td class="left-align"><span class="new badge black white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
                                '<td class="left-align"><p><label><input id="'+id+'" class="filled-in" checked="checked" type="checkbox" value="'+id+'" disabled/><span></span></label></p></td>'+
                                '<input type="hidden" name="i_itm_item_code[]" value="'+row.item_code+'"/>'+
                                '<input type="hidden" name="i_itm_quantity[]" value="'+row.quantity+'"/>'+
                                '<input type="hidden" name="i_itm_inventory_location[]" value="'+row.inventory_location+'"/>'+
                                '<input type="hidden" name="i_itm_currency[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_currency_code[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_unit_price[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_total_price[]" value=" "/>'+
                                '</tr>'
                              );
              // $('#btnIssue').prop('disabled', false);
          } else if (row.is_check==true) {
            table.append('<tr>'+
                                '<td class="left-align">'+id+'</td>'+
                                '<td class="left-align">'+row.item_code+'</td>'+
                                '<td class="left-align">'+row.item_desc+'</td>'+
                                '<td class="left-align">'+row.quantity+'</td>'+
                                '<td class="left-align"><span class="new badge blue white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
                                '<td class="left-align"><p><label><input id="'+id+'" class="filled-in" checked="checked" type="checkbox" value="'+id+'"  onclick="prepareItems(\''+row.trans_code+'\',\''+row.item_code+'\','+id+')"/><span></span></label></p></td>'+
                                '<input type="hidden" name="i_itm_item_code[]" value="'+row.item_code+'"/>'+
                                '<input type="hidden" name="i_itm_quantity[]" value="'+row.quantity+'"/>'+
                                '<input type="hidden" name="i_itm_inventory_location[]" value="'+row.inventory_location+'"/>'+
                                '<input type="hidden" name="i_itm_currency[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_currency_code[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_unit_price[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_total_price[]" value=" "/>'+
                                '</tr>'
                              );
              $('#btnIssue').prop('disabled', false);
          } else {
            table.append('<tr>'+
                                '<td class="left-align">'+id+'</td>'+
                                '<td class="left-align">'+row.item_code+'</td>'+
                                '<td class="left-align">'+row.item_desc+'</td>'+
                                '<td class="left-align">'+row.quantity+'</td>'+
                                '<td class="left-align"><span class="new badge blue white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
                                '<td class="left-align"><p><label><input id="'+id+'" class="with-gap" type="checkbox" value="'+id+'" onclick="prepareItems(\''+row.trans_code+'\',\''+row.item_code+'\','+id+')"/><span></span></label></p></td>'+
                                '<input type="hidden" name="i_itm_item_code[]" value="'+row.item_code+'"/>'+
                                '<input type="hidden" name="i_itm_quantity[]" value="'+row.quantity+'"/>'+
                                '<input type="hidden" name="i_itm_inventory_location[]" value="'+row.inventory_location+'"/>'+
                                '<input type="hidden" name="i_itm_currency[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_currency_code[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_unit_price[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_total_price[]" value=" "/>'+
                                '</tr>'
                              );
          }
        } else {
          var id = parseInt(index) + 1;
          if(row.status=='Issued'){
            table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td class="left-align"><span class="new badge black white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
                      '</tr>'
                    );
          } else if(row.status=='Rejected'){
            table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td class="left-align"><span class="new badge red white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
                      '</tr>'
                    );
          } else {
            table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td class="left-align"><span class="new badge blue white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
                      '</tr>'
                    );
          }
        }
      });

  
    };

    const removeItem = () => {
        var index = $('#del_index').val();
        add_items.splice(index,1);
        $('#removeItemModal').modal('close');
        renderItems(add_items,$('#items-dt tbody'),'add');
        if(add_items.length  == 0 ){ $('#btnAddSave').prop('disabled', true); }
    };

    const deleteItem = (index,loc) => {
      $('#del_index').val(index);
      $('#removeItemModal').modal('open');
    };

    const addItem = (loc, item_qty = 0, safety_stock = 0) => {
      var found = false;
      var cindex = 0;
      if(loc=='add')
      {
        if($('#add_unit_price').val() <= 0){
          alert('Unit Price must be greater than 0!');
        }else if($('#add_quantity').val() <= 0){
          alert('Quantity must be greater than 0!');
        }else{
          $.each(add_items,(index,row) => {
            if(row.item_code == $('#add_item_code').val()){
              cindex = index;
              found = true;
              return false;
            }
          });

          if(found){
              var itm_qtys = parseInt(item_qty) + parseInt(add_items[cindex].quantity);
            if(safety_stock <= itm_qtys)
            {
              add_items[cindex].quantity = parseFloat(add_items[cindex].quantity) + parseFloat(item_qty);
              renderItems(add_items,$('#items-dt tbody'),'add');
              resetItemDetails("add");
            } else {
              add_items[cindex].quantity = parseFloat(add_items[cindex].quantity) + parseFloat($('#add_quantity').val());
              renderItems(add_items,$('#items-dt tbody'),'add');
              resetItemDetails("add");
            }
          
          }else{
              var itm_qtys = parseInt(item_qty);
            if(safety_stock <= itm_qtys)
            {
              add_items.push({ "item_code": $('#add_item_code').val(),
                              "item_desc": $('#add_item_desc').val(),
                              "quantity": parseFloat($('#add_quantity').val()),
                            });
              renderItems(add_items,$('#items-dt tbody'),'add');
              resetItemDetails("add");
            } else {
              add_items.push({ "item_code": $('#add_item_code').val(),
                              "item_desc": $('#add_item_desc').val(),
                              "quantity": parseFloat($('#add_quantity').val()),
                              });
              renderItems(add_items,$('#items-dt tbody'),'add');
              resetItemDetails("add");
            }
          }
        }
      } else if(loc=='edit') {
        if($('#edit_unit_price').val() <= 0){
          alert('Unit Price must be greater than 0!');
        }else if($('#edit_quantity').val() <= 0){
          alert('Quantity must be greater than 0!');
        }else{
          $.each(edit_items,(index,row) => {
            if(row.item_code == $('#edit_item_code').val()){
              cindex = index;
              found = true;
              return false;
            }
          });

          if(found){
              var itm_qtys = parseInt(item_qty) + parseInt(edit_items[cindex].quantity);
            if(safety_stock <= itm_qtys)
            {
              edit_items[cindex].quantity = parseFloat(edit_items[cindex].quantity) + parseFloat($('#edit_quantity').val());
              $('#btnEditSave').prop('disabled', false);
              renderItems(edit_items,$('#edit-items-dt tbody'),'edit');
              resetItemDetails("edit");
            } else {
              edit_items[cindex].quantity = parseFloat(edit_items[cindex].quantity) + parseFloat($('#edit_quantity').val());
              $('#btnEditSave').prop('disabled', false);
              renderItems(edit_items,$('#edit-items-dt tbody'),'edit');
              resetItemDetails("edit");
            }
          }else{
              var itm_qtys = parseInt(item_qty) + parseInt(edit_items[cindex].quantity);
              if(safety_stock <= itm_qtys)
            {
              edit_items.push({ "item_code": $('#edit_item_code').val(),
                                "item_desc": $('#edit_item_desc').val(),
                                "quantity": parseFloat($('#edit_quantity').val()),
                              });
              $('#btnEditSave').prop('disabled', false);
              renderItems(edit_items,$('#edit-items-dt tbody'),'edit');
              resetItemDetails("edit");
            } else {
              edit_items.push({ "item_code": $('#edit_item_code').val(),
                                "item_desc": $('#edit_item_desc').val(),
                                "quantity": parseFloat($('#edit_quantity').val()),
                                });
              $('#btnEditSave').prop('disabled', false);
              renderItems(edit_items,$('#edit-items-dt tbody'),'edit');
              resetItemDetails("edit");
            }
          }

        }
      }
    };

    const loadApprover = () => {
      $.get('../approver/{{Auth::user()->emp_no}}/RTV/my_matrix', (response) => {
        var data = response.data;
        var tabledata = '';
        if(data){
          var matrix = data.matrix;
          $.each(JSON.parse(matrix),(index, row) => {
              tabledata +=  '<tr>'+
                              '<td>'+row.sequence+'</td>'+
                              '<td>'+row.approver_emp_no+'</td>'+
                              '<td>'+row.approver_name+'</td>'+
                              '<input type="hidden" name="app_seq[]" value="'+row.sequence+'"/>'+
                              '<input type="hidden" name="app_id[]" value="'+row.approver_emp_no+'"/>'+
                              '<input type="hidden" name="app_fname[]" value="'+row.approver_name+'"/>'+
                              '<input type="hidden" name="app_nstatus[]" value="'+row.next_status+'"/>'+
                              '<input type="hidden" name="app_gate[]" value="'+row.is_gate+'"/>'+
                            '</tr>'
          });
          $('#matrix-dt tbody').html(tabledata);
        } else {
          
        }
      });
    };

    const renderSignatoriesTable = (matrix,table,is_history = false) => {
      table.html("");
      if(!is_history){
        $.each(matrix, (index,row) => {
          table.append('<tr>'+
                        '<td>'+row.sequence+'</td>'+
                        '<td>'+row.approver_emp_no+'</td>'+
                        '<td>'+row.approver_name+'</td>'+
                      '</tr>'
                      );
        });
      }else{
        $.each(matrix, (index,row) => {
          table.append('<tr>'+
                        '<td>'+row.sequence+'</td>'+
                        '<td>'+row.approver_name+'</td>'+
                        '<td>'+row.status+'</td>'+
                        '<td>'+row.remarks+'</td>'+
                        '<td>'+row.action_date+'</td>'+
                      '</tr>'
                      );
        });
      }
    };

    var request = $('#return-dt').DataTable({
            "lengthChange": false,
            "pageLength": 15,
            "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
            "pagingType": "full",
            "ajax": "/api/reiss/inventory/rtv/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}",
            "columns": [
                {  "data": "id" },
                {   "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return '<a href="#!" onclick="viewRTV('+data+')">'+ row.rtv_code; +'</a>';
                    }
                },

                {  "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return row.reason;
                    }
                },
                {   "data": "id",
                    "render": function ( data, type, row, meta ) {
                    switch (row.status) {
                        case "Pending":
                        return  '<span class="new badge blue white-text" data-badge-caption="">Pending</span>';
                        break;
                        case "Approved":
                        return  '<span class="new badge green white-text" data-badge-caption="">Approved</span>';
                        break;
                        case "Rejected":
                        return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                        break;
                        case "RTV":
                        return  '<span class="new badge purple white-text" data-badge-caption="">Returned to Vendor</span>';
                        break;
                        case "Issued":
                        return  '<span class="new badge purple white-text" data-badge-caption="">Issued</span>';
                        break;
                        case "Issued with Pending":
                        return  '<span class="new badge grey darken-1 white-text" data-badge-caption="">Issued with Pending</span>';
                        break;
                        case "Returned":
                        return  '<span class="new badge amber white-text" data-badge-caption="">Returned</span>';
                        break;
                        case "Voided":
                        return  '<span class="new badge black white-text" data-badge-caption="">Voided</span>';
                        break;
                    }
                    }
                },
                {   "data": "id",
                    "render": function ( data, type, row, meta ) {

                    if(row.status=="Pending")
                    {
                        return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editRTV('+data+')"><i class="material-icons">create</i></a>';
                    } else {
                        return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" disabled><i class="material-icons">create</i></a>';
                    }
            
                    }
                },   
            ]
    });

    var approval = $('#approval-dt').DataTable({
            "lengthChange": false,
            "pageLength": 15,
            "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
            "pagingType": "full",
            "ajax": "/api/reiss/inventory/rtv/all_approval/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}",
            "columns": [
                {  "data": "id" },
                {  "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return row.sites.site_desc;
                    }
                },
                {   "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return '<a href="#!" onclick="viewRTV('+data+')">'+ row.rtv_code; +'</a>';
                    }
                },
                {  "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return row.employee_details.full_name;;
                    }
                },
                {  "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return row.reason;
                    }
                },
                {   "data": "id",
                    "render": function ( data, type, row, meta ) {
                    switch (row.status) {
                        case "Pending":
                        return  '<span class="new badge blue white-text" data-badge-caption="">Pending</span>';
                        break;
                        case "Approved":
                        return  '<span class="new badge green white-text" data-badge-caption="">Approved</span>';
                        break;
                        case "Issued":
                        return  '<span class="new badge purple white-text" data-badge-caption="">Issued</span>';
                        break;
                        case "Returned":
                        return  '<span class="new badge amber white-text" data-badge-caption="">Returned</span>';
                        break;
                        case "Voided":
                        return  '<span class="new badge black white-text" data-badge-caption="">Voided</span>';
                        break;
                    }
                    }
                },
                {   "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return  '<a href="#" class="btn-small blue darken3 waves-effect waves-dark" onclick="appRTV('+data+')"><i class="material-icons">rate_review</i></a>';
                    }
                },   
            ]
    });

    var process = $('#process-dt').DataTable({
            "lengthChange": false,
            "pageLength": 15,
            "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
            "pagingType": "full",
            "ajax": "/api/reiss/inventory/rtv/all_process",
            "columns": [
                {  "data": "id" },
                {  "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return row.sites.site_desc;
                    }
                },
                {   "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return '<a href="#!" onclick="viewRTV('+data+')">'+ row.rtv_code; +'</a>';
                    }
                },
                {  "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return row.employee_details.full_name;;
                    }
                },
                {  "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return row.reason;
                    }
                },
                {   "data": "id",
                    "render": function ( data, type, row, meta ) {
                    switch (row.status) {
                        case "Pending":
                        return  '<span class="new badge blue white-text" data-badge-caption="">Pending</span>';
                        break;
                        case "Approved":
                        return  '<span class="new badge green white-text" data-badge-caption="">Approved</span>';
                        break;
                        case "RTV":
                        return  '<span class="new badge purple white-text" data-badge-caption="">Returned to Vendor</span>';
                        break;
                        case "Issued":
                        return  '<span class="new badge purple white-text" data-badge-caption="">Issued</span>';
                        break;
                        case "Issued with Pending":
                        return  '<span class="new badge grey darken-1 white-text" data-badge-caption="">Issued with Pending</span>';
                        break;
                        case "Returned":
                        return  '<span class="new badge amber white-text" data-badge-caption="">Returned</span>';
                        break;
                        case "Voided":
                        return  '<span class="new badge black white-text" data-badge-caption="">Voided</span>';
                        break;
                    }
                    }
                },
                {   "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return  '<a href="#" class="btn-small teal darken-1 waves-effect waves-dark" onclick="processRTV('+data+')"><i class="material-icons">shopping_cart</i></a>';
                    }
                },   
            ]
    });

    var receiving = $('#receiving-dt').DataTable({
            "lengthChange": false,
            "pageLength": 15,
            "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
            "pagingType": "full",
            "ajax": "/api/reiss/inventory/rtv/all_receiving",
            "columns": [
                {  "data": "id" },
                {  "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return row.vendors.ven_name;
                    }
                },
                {   "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return '<a href="#!" onclick="viewRTV('+data+')">'+ row.rtv_code; +'</a>';
                    }
                },
                {  "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return row.employee_details.full_name;;
                    }
                },
                {  "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return row.reason;
                    }
                },
                {   "data": "id",
                    "render": function ( data, type, row, meta ) {
                    switch (row.status) {
                        case "RTV":
                        return  '<span class="new badge green white-text" data-badge-caption="">For Receiving</span>';
                        break;
                        case "Returned":
                        return  '<span class="new badge amber white-text" data-badge-caption="">Returned</span>';
                        break;
                    }
                    }
                },
                {   "data": "id",
                    "render": function ( data, type, row, meta ) {
                    return  '<a href="#" class="btn-small teal darken-1 waves-effect waves-dark" onclick="receiveRTV('+data+')"><i class="material-icons">shopping_cart</i></a>';
                    }
                },   
            ]
    });
  </script> --}}
    <!-- End of SCRIPTS -->
@endsection