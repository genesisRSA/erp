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
        <h4 class="title"><span class="grey-text darken-4">Document Control Centre<i class="material-icons">arrow_forward_ios</i></span><span class="grey-text darken-4">Procedures<i class="material-icons">arrow_forward_ios</i></span>Revise Procedure</h4>
    </div>
  </div>
  <div class="d-flex flex-row">
    <div class="m-3 main-content">  
      <div class="row">
        <div class="card mb-3 col s12 m12 l12">
          <div class="card-body" style="height: 100%">
            <form method="POST" action="{{route('procedure.revision')}}" enctype="multipart/form-data">
              @csrf
              <div class="col s12 m12 l12">
              <h6 style="padding: 10px; padding-top: 20px; padding-left: 10px; padding-right: 10px; margin-bottom: 10px; margin-top: 20px; background-color:#0d47a1" class="white-text"><b>Procedure Details</b></h6>  
              </div>
              <div class="row">
                <br>
                <input type="hidden" name="reviewed_by" value="{{$procedures->reviewed_by}}">
                <input type="hidden" name="approved_by" value="{{$procedures->approved_by}}">
                <input type="hidden" name="status_h"      value="{{$procedures->status}}">
 
                <div class="col s12 m12 l12">
                    <div class="col s12 m12 l12">
                        <div class="input-field col s12 m3 l3">
                            <input type="text" id="rev_dpr_code" name="dpr_code"  class="grey lighten-5" value="{{$lastDoc}}" readonly/>
                            <input type="hidden" id="rev_dpr_code_h" name="dpr_code_h"  class="grey lighten-5" value="{{$procedures->dpr_code}}" readonly/>
                            <label for="dpr_code">DPR No.<sup class="red-text"></sup></label>
                        </div>
                        <div class="input-field col s12 m3 l3">
                            <input type="text" id="rev_requested_date" name="requested_date" class="grey lighten-5" value="{{date('Y-m-d')}}" readonly/>
                            <input type="hidden" id="rev_requested_date_h" name="requested_date_h" value="{{$procedures->requested_date}}" readonly/>
                            <label for="requested_date">Date Requested<sup class="red-text"></sup></label>
                        </div> 
                    </div>
                    
                    <div class="col s12 m12 l12">
                        <div class="input-field col s12 m6 l6">
                            <input type="text" id="rev_document_title" name="document_title" value="{{$procedures->document_title}}"  placeholder=" " readonly/>
                            <label for="document_title">Document Title<sup class="red-text">*</sup></label>
                        </div>
                        <div class="input-field col s12 m3 l3">
                            <input type="text" id="rev_document_no" name="document_no"  value="{{$docNo}}"  placeholder=" " readonly/>
                            <input type="hidden" id="rev_document_no_h" name="document_no_h"  value="{{$procedures->document_no}}"  placeholder=" " readonly/>
                            <label for="document_no">Document No.<sup class="red-text"></sup></label>
                        </div>
                        <div class="input-field col s12 m3 l3">
                            <input type="text" id="rev_revision_no" name="revision_no" value="{{$procedures->revision_no+1}}" placeholder=" " readonly/>
                            <input type="hidden" id="rev_revision_no_h" name="revision_no_h" value="{{$procedures->revision_no}}" placeholder=" " readonly/>
                            <label for="revision_no">Revision No.<sup class="red-text"></sup></label>
                        </div>
                    </div>

                    <div class="col s12 m12 l12">
                        <div class="input-field col s12 m12 l12">
                            <textarea id="rev_change_description" name="change_description" class="materialize-textarea" placeholder="Some text here.." style="padding-bottom: 0px; border-bottom-width: 2px; margin-bottom: 20px;" required ></textarea>

                            <input id="rev_change_description_h" name="change_description_h" type="hidden" value="{{$procedures->change_description}}" />

                            <label for="change_description">Description of Change(s)<sup class="red-text">*</sup></label>
                        </div>

                        <div class="input-field col s12 m12 l12">
                            <textarea id="rev_change_reason" name="change_reason" class="materialize-textarea"  placeholder="Some text here.." style="padding-bottom: 0px; border-bottom-width: 2px; margin-bottom: 30px;" required></textarea>

                            <input id="rev_change_reason_h" name="change_reason_h" type="hidden" value="{{$procedures->change_reason}}" />

                            <label for="change_reason">Reason for Preparation / Revision<sup class="red-text">*</sup></label>
                        </div>
                    </div>
                    
                    <div class="col s12 m12 l12">
                        <div class="col s12 m6 l6"></div>
                        <div class="file-field input-field col s12 m6 l6">
                            <div class="btn blue">
                                <span>File</span>
                                <input id="rev_file" name="file" type="file">
                                <input id="rev_file_h" name="file_h" type="hidden" value="{{$procedures->file_name}}">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Click to add attachment">
                            </div>
                        </div>
                    </div>
                </div>
              </div>
 
              <div class="row col s12 m12 l12" style="padding-right: 0px">
                <div class="col s12 m3 l3"></div>
                <div class="col s12 m9 l9 right-align" style="padding-right: 0px">
                <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Save&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                <a href="{{route('procedure.index')}}" class="red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
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

    var searchInput = 'rev_complete_address';

    $(document).ready(function () {
        $('#rev_description').trigger('autoresize');
    });

     

 

  </script>

  <!-- End of SCRIPTS -->

@endsection
