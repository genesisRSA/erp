@extends('layouts.resmain')
<style>
   textarea.materialize-textarea
        {
            height: 20% !important; 
        }
</style>

@section('content')<body oncontextmenu="return false;">
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Document Control Centre<i class="material-icons">arrow_forward_ios</i></span><span class="grey-text darken-4">Drawings<i class="material-icons">arrow_forward_ios</i></span>Controlled Copy</h4>
    </div>
  </div>
  <div class="d-flex flex-row">
    <div class="m-3 main-content">  
      <div class="row">

        <div class="card mb-3 col s12 m12 l12">
          <div class="card-body" style="height: 100%">
            <form method="POST" enctype="multipart/form-data">
              <div class="row">
                <input type="hidden" name="process_owner" id="process_owner" value="{{$drawings->created_by}}">
                @csrf
                <div class="col s12 m12 l12">
                  <h6 style="padding: 10px; padding-top: 20px; padding-left: 10px; padding-right: 10px; background-color:#0d47a1" class="white-text"><b>Drawing Details</b></h6>  
                </div>
                        
                <div class="col s12 m12 l12">
                  <div class="input-field col s12 m3 l3">
                    <input type="text" id="app_ecn_code" name="ecn_code" value="{{$drawings->ecn_code}}" readonly/>
                    <label for="ecn_code">ECN No.<sup class="red-text"></sup></label>
                  </div>

                  <div class="input-field col s12 m3 l3">
                    <input type="text" id="app_designer" name="designer" value="{{$employee->full_name}}" readonly/>
                    <label for="ecn_code">Designer<sup class="red-text"></sup></label>
                  </div> 
                   
                  <div class="input-field col s12 m3 l3">
                    <input type="text" id="app_revision_no" name="revision_no" value="{{$drawings->revision_no}}" placeholder=" " readonly/>
                    <label for="revision_no">Revision No.<sup class="red-text"></sup></label>
                  </div>

                  <div class="input-field col s12 m3 l3">
                    <input type="text" id="app_revision_date" name="revision_date" value="{{$drawings->revision_date}}" readonly/>
                    <label for="revision_date">Revision Date<sup class="red-text"></sup></label>
                  </div> 
                </div>

                <div class="col s12 m12 l12">                  
                  <div class="input-field col s12 m6 l6">
                    <input type="text" id="app_cust_code" name="cust_code" value="{{$customer->cust_name}}" readonly/>
                    <label for="cust_code">Customer<sup class="red-text"> </sup></label>
                  </div>

                  <div class="input-field col s12 m6 l6">
                    <input type="text" id="app_project_code" name="project_code" value="{{$drawings->project_code}}" readonly/>
                    <label for="project_code">Project Name<sup class="red-text"> </sup></label>
                  </div>
                </div>

                <div class="col s12 m12 l12">
                  <div class="input-field col s12 m4 l4">
                    <input type="text" id="app_assy_code" name="assy_code" value="{{$assy->assy_desc}}" readonly/>
                    <label for="assy_code">Assembly Description<sup class="red-text"> </sup></label>
                  </div>
                  
                  <div class="input-field col s12 m4 l4">
                    <input type="text" id="app_fab_code" name="fab_code" value="{{$fab->fab_desc}}" readonly/>
                    <label for="fab_code">Fabrication Description<sup class="red-text"> </sup></label>
                  </div>

                  <div class="input-field col s12 m4 l4">
                    <input type="text" id="app_drawing_no" name="drawing_no" value="{{$drawings->drawing_no}}" readonly/>
                    <label for="drawing_no">Drawing No. / Assembly Name<sup class="red-text"></sup></label>
                  </div>
                </div>

                <div class="col s12 m12 l12">
                  <div class="input-field col s12 m6 l6">
                    <input type="text" id="app_part_name" name="part_name" value="{{$drawings->part_name}}" readonly/>
                    <label for="v">Part Name / BOM / Module Name<sup class="red-text"> </sup></label>
                  </div>

                  <div class="input-field col s12 m6 l6">
                    <input type="text" id="app_process_specs" name="process_specs" value="{{$drawings->process_specs}}" readonly/>
                    <label for="process_specs">Existing Process Specification(s)<sup class="red-text"> </sup></label>
                  </div>
                </div>

                <div class="col s12 m12 l12">
                  <div class="input-field col s12 m6 l6">
                      <textarea id="app_change_description" name="change_description" class="materialize-textarea" placeholder="Some text here.." style="padding-bottom: 0px; margin-bottom: 10px;" required readonly>{{$drawings->change_description}}</textarea>
                      <label for="change_description">Description of Change(s)<sup class="red-text"> </sup></label>
                  </div>

                  <div class="input-field col s12 m6 l6">
                      <textarea id="app_change_reason" name="change_reason" class="materialize-textarea"  placeholder="Some text here.." style="padding-bottom: 0px; margin-bottom: 10px;" required readonly>{{$drawings->change_reason}}</textarea>
                      <label for="change_reason">Reason for Change / Revision<sup class="red-text"> </sup></label>
                  </div>
                </div>

                <div class="col s12 m12 l12">
                  <h6 style="padding: 10px; padding-top: 20px; padding-left: 10px; padding-right: 10px;   margin-top: 20px; background-color:#0d47a1" class="white-text"><b>Drawing Attachment(s)</b></h6>  
                </div>

                <div class="row">
                  <br>
                  <div style="width:96%; 
                              height:40%; 
                              z-index: 10; 
                              opacity:0.15;
                              position:absolute; 
                              text-align:center;
                              line-height:300px;
                              font-size:130px; 
                              color:blue;">
                    &nbspRSA PROPERTY
                    &nbspRSA PROPERTY
                    </div>
                    <embed
                      src="/reiss/drawing/pdf/{{$drawings->id}}/copy#toolbar=0"
                      style="width:95%; 
                            height:130%; 
                            margin-left:2.5%;" type="application/pdf"
                      id="pdf_file" name="pdf_file"
                      frameborder="1"
                      > 
                </div>

                <div class="col s12 m12 l12">
                  <h6 style="padding: 10px; padding-top: 20px; padding-left: 10px; padding-right: 10px;   margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Revision History</b></h6>  
                </div>

                <div class="col s12 m12 l12">
                  <div class="card" style="margin-top: 0px">
                    <div class="card-content">
                      <table class="responsive-table highlight" id="revisions-dt" style="width: 100%">
                        <thead>
                          <tr>
                            <th>ID</th> 
                            <th>Drawing No.</th>
                            <th>Part Name</th>
                            <th>ECN No.</th>
                            <th>Revision No.</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="input-field col s12 m6 l6">
                    <select id="copy_department" name="department" required>
                        <option value="" disabled selected>Choose your option</option>
                          @if($copyCount==0)
                              <option value="{{$deptx->department}}" selected>{{$deptx->dept_details->dept_desc}}</option>
                          @else
                            @foreach ($department as $dept)
                              <option value="{{$dept->dept_code}}">{{$dept->dept_desc}}</option>
                            @endforeach
                          @endif
                        
                    </select>
                      <label for="prod_code">Department<sup class="red-text">*</sup></label>
                </div>
                <div class="col s12 m3 l3 right-align">
                    <a href="#!" onclick="CreateCopy({{$drawings->id}});" class="green waves-effect waves-dark btn" style="width: 100%"><i class="material-icons left">add_box</i>Create Copy</a>
                </div>
                <div class="col s12 m3 l3 right-align">
                    <a href="{{route('drawing.index', ['#'.$locx = ($loc=='cc'?'controlled': ($loc=='controlled'?'controlled':($loc=='master'?'master':($loc=='app'?'approval':($loc=='master'?'master': ($loc=='drawings'?'ongoing':''))))))])}}" class="red waves-effect waves-dark btn" style="width: 100%; margin-bottom: 30px"><i class="material-icons left">keyboard_return</i>Return</a>
                </div>    
              </div>

           
            </form>
          </div>
        </div>

        <div id="copyModal" class="modal bottom-sheet">
          <form method="POST" action="{{route('drawing.makecopy')}}">
              @csrf
              <div class="modal-content">
                  <h4>Controlled Copy</h4><br><br>
                  <div class="row">
                      <div class="col s12 m6">
                          <input type="hidden" name="id" id="copy_id">
                          @if($copyCount==0)
                          <input type="hidden" name="dept" id="copy_dept" value="{{$deptx->department}}">
                          @else
                          <input type="hidden" name="dept" id="copy_dept">
                          @endif
                          <input type="hidden" name="ecn_code" id="rev_ecn_code" value="{{$drawings->ecn_code}}">
                          <input type="hidden" name="part_name" id="c_part_name" value="{{$drawings->part_name}}">
                          <input type="hidden" name="cust_code" id="c_cust_code" value="{{$drawings->cust_code}}">
                          <input type="hidden" name="project_code" id="c_project_code" value="{{$drawings->project_code}}">
                          <input type="hidden" name="revision_no" id="c_revision_no" value="{{$drawings->revision_no}}">
                          <input type="hidden" name="drawing_no" id="c_drawing_no" value="{{$drawings->drawing_no}}">

                          <input type="hidden" name="designer" id="c_designer" value="{{$drawings->created_by}}">

                          <p>Are you sure you want to create a controlled copy for this <strong>drawing</strong>?</p>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Yes</button>
                  <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
              </div>
          </form>
        </div>
      
    
      </div>  
    </div>
  </div>

  <!-- SCRIPTS -->
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">

    var searchInput = 'add_complete_address';


    $(document).ready(function () {

            // document.onkeydown = function(e) {
            //   if(event.keyCode == 123) {
            //     return false;
            //   }
            //   if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
            //     return false;
            //   }
            //   if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
            //     return false;
            //   }
            //   if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
            //     return false;
            //   }
            //   if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
            //     return false;
            //   }
            // }
        $('#copy_department').change(function () {
            var id = $(this).val();
            $('#copy_dept').val(id);
        });

        $('#add_description').trigger('autoresize');

        document.onmousedown = disableRightclick;
        var message = "Right click is not allowed in this page";
        function disableRightclick(evt){
          if(evt.button == 2){
              alert(message);
              return false;    
          }
        }
       
    });

    function CreateCopy(id)
    {
      $('#copy_id').val(id);
      $('#copyModal').modal('open');
    }

 

    var drawings = $('#revisions-dt').DataTable({
          "lengthChange": false,
          "pageLength": 15,
          "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
          "pagingType": "full",
          "ajax": "/api/reiss/drawing/all_revision/{{Illuminate\Support\Facades\Crypt::encrypt($drawings->drawing_no)}}",
          "columns": [
              {  "data": "id" 
              
              },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                  // if(row.status=='Approved' || row.status=='Created'){
                  //   return '<a href="../../view/'+row.drawings.id+'/{{$loc}}">'+ row.drawing_no +'</a>';
                  // }else{
                  //   return row.drawing_no;
                  // }  
                  return row.drawing_no;
                }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.part_name;
                }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                  // if(row.status=='Approved' || row.status=='Created'){
                  //   return '<a href="../../view/'+row.drawings.id+'/{{$loc}}">'+ row.ecn_code +'</a>';
                  // }else{
                  //   return row.ecn_code;
                  // }
                  return row.ecn_code;
                }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.revision_no;
                  }
              },
              {   "data": "status",
                  "render": function ( data, type, row, meta ) {
                    switch(data){
                      case 'Approved':
                        return  '<span class="new badge green white-text" data-badge-caption="">Approved</span>';
                      break;
                      case 'Pending':
                        return  '<span class="new badge blue white-text" data-badge-caption="">Pending</span>';
                      break;
                      case 'Created':
                        return  '<span class="new badge green white-text" data-badge-caption="">Created</span>';
                      break;
                      case 'Received':
                      return  '<span class="new badge deep-orange lighten-1 white-text" data-badge-caption="">Received</  span>';
                      break;
                      case 'Obsolete':
                        return  '<span class="new badge black white-text" data-badge-caption="">Obsolete</span>';
                      break;
                      case 'Rejected':
                        return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                      break;
                    }
                    
                  }
              } 
              ]
    });

  </script>

  <!-- End of SCRIPTS -->

@endsection
