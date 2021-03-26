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
              <h6 style="padding: 10px; padding-top: 20px; padding-left: 10px; padding-right: 10px;   margin-top: 20px; background-color:#0d47a1" class="white-text"><b>Procedure Details</b></h6>  
              </div>
              <div class="row">
                <br>
                <div style="width:96%; 
                            height:60%; 
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
                    src="{{ action('ProceduresController@getDocument', ['id'=> $idx]) }}#toolbar=1"
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
                            {{-- <th>Action</th> --}}
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

        // $('#formDocument').on('submit',(e) => {
        //   e.preventDefault();
        //   console.log(response);
        // });

        // $.ajax({
        //   'url': '/reiss/procedure/getPostDocument',
        //   type: 'post',
        //   'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        //   'data': { 'id': {{$idx}}},
        //   'success': (response) => {
        //     // $('#pdf_file').html(response);
        //     // var ifrm = document.getElementById("pdf_file");
        //     // ifrm.innerHTML = response;
        //     // $('#iframe').append('<object type="application/pdf">'+response+'</object>');
        //     // console.log(response);
        //     // var newWindow = window.open("data:application/pdf," + response, "new window", "width=200, height=100");
        //     //write the data to the document of the newWindow
        //     //  newWindow.document.write();
        //     prepareFrame(response);    
        //   }
        // });
          
        // prepareFrame();

        // test code on up

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
        "ajax": "/api/reiss/procedure/all_revision/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}",
        "columns": [
          {  "data": "id" },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.dpr_code;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return '<a href="procedure/view_revision/'+row.id+'">'+ row.document_title +'</a>';
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return '<a href="procedure/view_revision/'+row.id+'">'+ row.document_no +'</a>';
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
                    case 'For Review':
                      return  '<span class="new badge green white-text" data-badge-caption="">For Review</span>';
                    break;
                    case 'Pending':
                      return  '<span class="new badge blue white-text" data-badge-caption="">Pending</span>';
                    break;
                    case 'Approved':
                      return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                    break;
                  }
                   
                }
            },
            // {   "data": "id",
            //     "render": function ( data, type, row, meta ) {
            //       return  '<a href="procedure/revise/'+row.id+'" class="btn-small amber darken3 waves-effect waves-dark"><i class="material-icons">create</i></a>';
            //     }
            //   }
            ]
        });

  </script>

  <!-- End of SCRIPTS -->

@endsection
