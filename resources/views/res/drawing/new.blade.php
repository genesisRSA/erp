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
        <h4 class="title"><span class="grey-text darken-4">Document Control Centre<i class="material-icons">arrow_forward_ios</i></span><span class="grey-text darken-4">Drawings<i class="material-icons">arrow_forward_ios</i></span>New Drawing</h4>
    </div>
  </div>
 
    <div class="m-3 main-content">  
       
        <ul id="drawing_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
          <li class="tab col s12 m4 l4"><a class="active" href="#details">Drawing Details</a></li>
          <li class="tab col s12 m4 l4"><a href="#signatories">signatories</a></li>
        </ul>

        <div class="card" style="margin-top: 0px">
          <div class="card-body">
            <form method="POST" action="{{route('drawing.store')}}" enctype="multipart/form-data">
              @csrf

              <div id="details" name="details">
                <div class="row"><br>
                  <div class="col s12 m12 l12">

                    <div class="col s12 m12 l12">
                      <div class="input-field col s12 m3 l3">
                        <input type="text" id="add_ecn_code" name="ecn_code" class="grey lighten-5" value="{{$lastDoc}}" readonly/>
                        <label for="ecn_code">ECN No.<sup class="red-text"></sup></label>
                      </div>

                      <div class="input-field col s12 m3 l3"></div>

                      <div class="input-field col s12 m3 l3">
                        <input type="text" id="add_revision_no" name="revision_no" class="grey lighten-5" value="0" placeholder=" " readonly/>
                        <label for="revision_no">Revision No.<sup class="red-text"></sup></label>
                      </div>

                      <div class="input-field col s12 m3 l3">
                        <input type="text" id="add_revision_date" name="revision_date" class="grey lighten-5" value="{{date('Y-m-d')}}" readonly/>
                        <label for="revision_date">Revision Date<sup class="red-text"></sup></label>
                      </div> 
                    </div>

                    <div class="col s12 m12 l12">                  
                      <div class="input-field col s12 m6 l6">
                        <select searchable="test" id="add_cust_code" name="cust_code" required>
                          <option value="" disabled selected>Choose Customer</option>
                          @foreach ($customer as $cust)
                            <option value="{{$cust->cust_code}}">{{$cust->cust_name}}</option>
                          @endforeach
                        </select>
                        <label for="cust_code">Customer<sup class="red-text">*</sup></label>
                      </div>

                      <div class="input-field col s12 m6 l6">
                          <select id="add_project_code" name="project_code" required>
                            <option value="" disabled selected>Choose Project</option>
                            <option value="DISSYS">DISASSY SYSTEM WITH CONVEYOR</option>
                             
                          </select>
                          <label for="project_code">Project Name<sup class="red-text">*</sup></label>
                      </div>
                    </div>

                    <div class="col s12 m12 l12">
                      <div class="input-field col s12 m4 l4">
                        <select id="add_assy_code" name="assy_code" required>
                          <option value="" disabled selected>Choose Assembly</option>
                          @foreach ($assembly as $assem)
                            <option value="{{$assem->assy_code}}">{{$assem->assy_desc}}</option>
                          @endforeach
                        </select>
                        <label for="assy_code">Assembly Description<sup class="red-text">*</sup></label>
                      </div>
                      
                      <div class="input-field col s12 m4 l4">
                        <select id="add_fab_code" name="fab_code" required>
                          <option value="" disabled selected>Choose Fabrication</option>
                          @foreach ($fabrication as $fab)
                            <option value="{{$fab->fab_code}}">{{$fab->fab_desc}}</option>
                          @endforeach
                        </select>
                        <label for="fab_code">Fabrication Description<sup class="red-text">*</sup></label>
                      </div>

                      <div class="input-field col s12 m4 l4">
                        <input type="text" id="add_drawing_no" name="drawing_no"   value="{{$docNo}}"  placeholder=" " readonly/>
                        {{-- <input type="text" id="add_drawing_no" name="drawing_no"   value="RSA-001-A0001-1-F"  placeholder=" " readonly/> --}}
                        <label for="drawing_no">Drawing No. / Assembly Name<sup class="red-text"></sup></label>
                      </div>
                    </div>

                    <div class="col s12 m12 l12">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="add_part_name" name="part_name" placeholder=" " required/>
                        <label for="v">Part Name / BOM / Module Name<sup class="red-text">*</sup></label>
                      </div>

                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="add_process_specs" name="process_specs" placeholder=" " required/>
                        <label for="process_specs">Existing Process Specification(s)<sup class="red-text">*</sup></label>
                      </div>
                    </div>

                    <div class="col s12 m12 l12">
                      <div class="input-field col s12 m6 l6">
                          <textarea id="add_change_description" name="change_description" class="materialize-textarea" placeholder="Some text here.." style="padding-bottom: 0px; margin-bottom: 20px;" required ></textarea>
                          <label for="change_description">Description of Change(s)<sup class="red-text">*</sup></label>
                      </div>

                      <div class="input-field col s12 m6 l6">
                          <textarea id="add_change_reason" name="change_reason" class="materialize-textarea"  placeholder="Some text here.." style="padding-bottom: 0px; margin-bottom: 30px;" required></textarea>
                          <label for="change_reason">Reason for Change / Revision<sup class="red-text">*</sup></label>
                      </div>
                    </div>
                  
                    <div class="col s12 m12 l12">
                        <div class="col s12 m6 l6"></div>
                        <div class="file-field input-field col s12 m6 l6">
                            <div class="btn blue">
                                <span>File</span>
                                <input id="add_file" name="file" type="file" accept=".pdf" required>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Click to add attachment">
                            </div>
                        </div>
                    </div>

                  </div>
                </div>
              </div>

              <div id="signatories" name="signatories">
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="card">
                      <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
                      <div class="card-content" style="padding: 10px; padding-top: 0px">
                        <table class="highlight" id="approver-dt">
                          <thead>
                            <tr>
                                <th>Sequence</th> 
                                <th>Approver ID</th> 
                                <th>Approver Name</th> 
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
 
              <div class="row">
                <div class="col s12 m6 l6"></div>
                <div class="col s12 m3 l3 right-align" style="padding-bottom: 100px;padding-right: 10px;padding-left: 12px;">
                <button class="green waves-effect waves-light btn" style="width: 100%"><i class="material-icons left">check_circle</i>Save&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                </div>
                <div class="col s12 m3 l3 right-align" style="padding-bottom: 100px;padding-right: 30px;padding-left: 0px;">
                <a href="{{route('drawing.index')}}" class="red waves-effect waves-dark btn" style="width: 100%"><i class="material-icons left">cancel</i>Cancel</a>
                </div>
              </div>

            </form>
          </div>
        </div>
    
    </div>
 
  <!-- SCRIPTS -->
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">

    var searchInput = 'add_complete_address';

    $(document).ready(function () {
        $('#add_change_description').trigger('autoresize');
        $('#add_change_reason').trigger('autoresize');
        // $('#drawing_tab').tabs('select','details');  

        $('#add_cust_code').on('change', function(){
          var cust = $(this).val();
          var assy = $('#add_assy_code').val();
          var fab = $('#add_fab_code').val();
          drawingNo(cust,assy,fab);
        });
        $('#add_assy_code').on('change', function(){
          var assy = $(this).val();
          var cust = $('#add_cust_code').val();
          var fab = $('#add_fab_code').val();
          drawingNo(cust,assy,fab);
        });
        $('#add_fab_code').on('change', function(){
          var fab = $(this).val();
          var cust = $('#add_cust_code').val();
          var assy = $('#add_assy_code').val();
          drawingNo(cust,assy,fab);
        });

        function drawingNo(cust, assy, fab){
          var drawing_no = '{{$docNo}}';
          var site = drawing_no.slice(0,3);
          var count = drawing_no.slice(4,7);
          
          console.log (drawing_no + ' ' + site + ' ' + count + ' ' + cust + ' ' + assy + ' ' + fab);

          // $('#add_drawing_no').val(site+'-'+cust+'-'+);
        };
        
        $.get('getApprover/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}', function(response){
 
          var AppendString = "";
          var i, j = "";
          var data = response.data;
          var dataMatrix = data.matrix;
          var matrix = JSON.parse(dataMatrix);
          var myTable = document.getElementById("approver-dt");
          
          var rowCount = myTable.rows.length;
          for (var x=rowCount-1; x>0; x--) 
            {
              myTable.deleteRow(x); 
            }

          for(i in matrix)
            {
              for(j in matrix[i].sequence)
              {
                AppendString += 
                "<tr><td>" + matrix[i].sequence + 
                "</td><td>" + matrix[i].approver_emp_no + 
                "</td><td>" + matrix[i].approver_name + 
                      '<input type="hidden" name="app_seq[]" value="'+matrix[i].sequence+'"/>' + 
                      '<input type="hidden" name="app_id[]" value="'+matrix[i].approver_emp_no+'"/>'+
                      '<input type="hidden" name="app_fname[]" value="'+matrix[i].approver_name+'"/>'+
                      '<input type="hidden" name="app_nstatus[]" value="'+matrix[i].next_status+'"/>'+
                      '<input type="hidden" name="app_gate[]" value="'+matrix[i].is_gate+'"/>'+
                "</td></tr>";
              }
            }

          
          $('#approver-dt').find('tbody').append(AppendString);
    
        });

    });

     

 

  </script>

  <!-- End of SCRIPTS -->

@endsection
