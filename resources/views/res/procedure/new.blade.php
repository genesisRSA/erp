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
        <h4 class="title"><span class="grey-text darken-4">Document Control Centre<i class="material-icons">arrow_forward_ios</i></span><span class="grey-text darken-4">Procedures<i class="material-icons">arrow_forward_ios</i></span>New Procedure</h4>
    </div>
  </div>
 
    <div class="m-3 main-content">  
       
        <ul id="procedure_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
          <li class="tab col s12 m4 l4"><a class="active" href="#details">Procedure Details</a></li>
          <li class="tab col s12 m4 l4"><a href="#signatories">signatories</a></li>
        </ul>

        <div class="card" style="margin-top: 0px">
          <div class="card-body">
            <form method="POST" action="{{route('procedure.store')}}" enctype="multipart/form-data">
              @csrf

              {{-- <div class="col s12 m12 l12">  
              <h6 style="padding: 10px; padding-top: 20px; padding-left: 10px; padding-right: 10px; margin-bottom: 10px; margin-top: 20px; background-color:#0d47a1" class="white-text"><b>Procedure Details</b></h6>  
               </div> --}}

              <div id="details" name="details">
                <div class="row">
                  <br>
                  <div class="col s12 m12 l12">
                      <div class="col s12 m12 l12">
                          <div class="input-field col s12 m3 l3">
                              <input type="text" id="add_dpr_code" name="dpr_code"  class="grey lighten-5" value="{{$lastDoc}}" readonly/>
                              <label for="dpr_code">DPR No.<sup class="red-text"></sup></label>
                          </div>
                          <div class="input-field col s12 m3 l3">
                              <input type="text" id="add_requested_date" name="requested_date" class="grey lighten-5" value="{{date('Y-m-d')}}" readonly/>
                              <label for="requested_date">Date Requested<sup class="red-text"></sup></label>
                          </div> 
                      </div>
                      
                      <div class="col s12 m12 l12">
                          <div class="input-field col s12 m6 l6">
                              <input type="text" id="add_document_title" name="document_title" placeholder=" " />
                              <label for="document_title">Document Title<sup class="red-text">*</sup></label>
                          </div>
                          <div class="input-field col s12 m3 l3">
                              <input type="text" id="add_document_no" name="document_no"  value="{{$docNo}}"  placeholder=" "/>
                              <label for="document_no">Document No.<sup class="red-text"></sup></label>
                          </div>
                          <div class="input-field col s12 m3 l3">
                              <input type="text" id="add_revision_no" name="revision_no" value="0" placeholder=" " />
                              <label for="revision_no">Revision No.<sup class="red-text"></sup></label>
                          </div>
                      </div>

                      <div class="col s12 m12 l12">
                          <div class="input-field col s12 m6 l6">
                              <textarea id="add_change_description" name="change_description" class="materialize-textarea" placeholder="Some text here.." style="padding-bottom: 0px; border-bottom-width: 2px; margin-bottom: 20px;" required ></textarea>
                              <label for="change_description">Description of Change(s)<sup class="red-text">*</sup></label>
                          </div>

                          <div class="input-field col s12 m6 l6">
                              <textarea id="add_change_reason" name="change_reason" class="materialize-textarea"  placeholder="Some text here.." style="padding-bottom: 0px; border-bottom-width: 2px; margin-bottom: 30px;" required></textarea>
                              <label for="change_reason">Reason for Preparation / Revision<sup class="red-text">*</sup></label>
                          </div>
                      </div>
                      
                      <div class="col s12 m12 l12">
                          <div class="col s12 m6 l6"></div>
                          <div class="file-field input-field col s12 m6 l6">
                              <div class="btn blue">
                                  <span>File</span>
                                  <input id="add_file" name="file" type="file" accept=".pdf">
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
                <div class="col s12 m3 l3"></div>
                <div class="col s12 m9 l9 right-align" style="padding-right: 35px; padding-bottom: 100px">
                <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Save&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                <a href="{{route('procedure.index')}}" class="red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
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
        // $('#procedure_tab').tabs('select','details');

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
