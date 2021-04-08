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
        <h4 class="title"><span class="grey-text darken-4">Document Control Centre<i class="material-icons">arrow_forward_ios</i></span><span class="grey-text darken-4">Procedures<i class="material-icons">arrow_forward_ios</i></span>View Procedure</h4>
    </div>
  </div>
  <div class="d-flex flex-row">
    <div class="m-3 main-content">  
      <div class="row">
        <div class="card mb-3 col s12 m12 l12">
          <div class="card-body" style="height: 100%">
            <form method="POST" enctype="multipart/form-data">
              @csrf
              <div class="col s12 m12 l12">
                <h6 style="padding: 10px; padding-top: 20px; padding-left: 10px; padding-right: 10px; background-color:#0d47a1" class="white-text"><b>Procedure Details</b></h6>  
              </div>

              <div class="col s12 m12 l12">
                <div class="input-field col s12 m3 l3">
                    <input type="text" id="rev_dpr_code" name="dpr_code"  class="grey lighten-5" value="{{$procedures->dpr_code}}" readonly/>
                    <label for="dpr_code">DPR No.<sup class="red-text"></sup></label>
                </div>
                <div class="input-field col s12 m3 l3">
                    <input type="text" id="rev_requested_date" name="requested_date" class="grey lighten-5" value="{{$procedures->requested_date}}" readonly/>
                    <label for="requested_date">Date Requested<sup class="red-text"></sup></label>
                </div> 
            </div>
            
            <div class="col s12 m12 l12">
                <div class="input-field col s12 m6 l6">
                    <input type="text" id="rev_document_title" name="document_title" value="{{$procedures->document_title}}"  placeholder=" " readonly/>
                    <label for="document_title">Document Title<sup class="red-text">*</sup></label>
                </div>
                <div class="input-field col s12 m3 l3">
                    <input type="text" id="rev_document_no" name="document_no"  value="{{$procedures->document_no}}"  placeholder=" " readonly/>
                    <label for="document_no">Document No.<sup class="red-text"></sup></label>
                </div>
                <div class="input-field col s12 m3 l3">
                    <input type="text" id="rev_revision_no" name="revision_no" value="{{$procedures->revision_no}}" placeholder=" " readonly/>
                    <label for="revision_no">Revision No.<sup class="red-text"></sup></label>
                </div>
            </div>

            <div class="col s12 m12 l12">
                <div class="input-field col s12 m6 l6">
                    <textarea id="rev_change_description" name="change_description" class="materialize-textarea" placeholder="Some text here.." style="padding-bottom: 0px; border-bottom-width: 2px; margin-bottom: 0px;" readonly>{{$procedures->change_description}}</textarea>
                    <label for="change_description">Description of Change(s)<sup class="red-text">*</sup></label>
                </div>

                <div class="input-field col s12 m6 l6">
                    <textarea id="rev_change_reason" name="change_reason" class="materialize-textarea"  placeholder="Some text here.." style="padding-bottom: 0px; border-bottom-width: 2px; margin-bottom: 0px;" readonly>{{$procedures->change_reason}}</textarea>
                    <label for="change_reason">Reason for Preparation / Revision<sup class="red-text">*</sup></label>
                </div>
            </div>

              <div class="col s12 m12 l12">
                <h6 style="padding: 10px; padding-top: 20px; padding-left: 10px; padding-right: 10px;   margin-top: 20px; background-color:#0d47a1" class="white-text"><b>Procedure Attachment(s)</b></h6>  
              </div>

              <div class="row">
                <br>
                <div style="width:96%; 
                            height:50%; 
                            z-index: 10; 
                            opacity:0.15;
                            position:absolute; 
                            text-align:center;
                            line-height:400px;
                            font-size:130px; 
                            color:blue;">
                   &nbspRSA PROPERTY
                   &nbspRSA PROPERTY
                  </div>

                <embed
                    src="{{ action('ProceduresController@getDocument', ['id'=> $procedures->id, 'loc' => $procedures->status]) }}#toolbar=0"
                    style="width:95%; 
                          height:130%; 
                          margin-left:2.5%;" type="application/pdf"
                    id = "pdf_file"
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
                            <th>DPR No.</th>
                            <th>Document Title</th>
                            <th>Document No.</th>
                            <th>Revision No.</th>
                            <th>Status</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>

              <div class="row col s12 m12 l12" style="padding-right: 0px">
                <div class="col s12 m3 l3"></div>
                <div class="col s12 m9 l9 right-align" style="padding-right: 10px">
                <a href="{{route('procedure.index')}}" class="red waves-effect waves-dark btn"><i class="material-icons left">keyboard_return</i>Return</a>
                </div>
              </div>

            </form>
          </div>
        </div>

    
      </div>  
    </div>
  </div>

  <!-- SCRIPTS -->
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">

    var searchInput = 'add_complete_address';

    
    function prepareFrame(test) {
                var ifrm = document.createElement("iframe");
                ifrm.setAttribute("src", test);
                ifrm.style.width = "640px";
                ifrm.style.height = "480px";
                document.body.appendChild(ifrm);
            }

    $(document).ready(function () {

            document.onkeydown = function(e) {
              if(event.keyCode == 123) {
                return false;
              }
              if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
                return false;
              }
              if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
                return false;
              }
              if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
                return false;
              }
              if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
                return false;
              }
            }

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

     
    var procedures = $('#revisions-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/procedure/all_revision/{{$procedures->document_no}}",
        "columns": [
            {  "data": "id" 
             
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.dpr_code;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.document_title;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return '<a href="../view/'+row.procedures.id+'">'+ row.document_no +'</a>';
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
                    case 'Rejected':
                      return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                    break;
                    case 'For Approval':
                      return  '<span class="new badge yellow white-text" data-badge-caption="">For Approval</span>';
                    break;
                    case 'For Review':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Review</span>';
                    break;
                    case 'Voided':
                      return  '<span class="new badge black white-text" data-badge-caption="">Voided</span>';
                    break;
                    case 'Quoted':
                      return  '<span class="new badge blue darken-4 white-text" data-badge-caption="">Quoted</span>';
                    break;
                    case 'Ordered':
                      return  '<span class="new badge blue darken-4 white-text" data-badge-caption="">Ordered</span>';
                    break;
                  }
                   
                }
            } 
            ]
        });

  </script>

  <!-- End of SCRIPTS -->

@endsection
