@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Purchasing<i class="material-icons">arrow_forward_ios</i></span>Request for Quotation</h4>
    </div>
  </div>
  <div class="row main-content">
    <ul id="project_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
      @if($permission[0]["add"]==true || $permission[0]["masterlist"]==true)
        <li class="tab col s12 m4 l4"><a class="active" href="#Request">Request</a></li>
      @endif
      @if($permission[0]["approval"]==true || $permission[0]["masterlist"]==true)
        <li class="tab col s12 m4 l4"><a class="active" href="#Approval">Approval</a></li>
      @endif
      @if($permission[0]["masterlist"]==true)
        <li class="tab col s12 m4 l4"><a class="active" href="#ForRFQ">For Quotation</a></li>
      @endif
      @if($permission[0]["add"]==true || $permission[0]["masterlist"]==true)
        <li class="tab col s12 m4 l4"><a class="active" href="#ForReview">For Review</a></li>
      @endif
    </ul>
    @if($permission[0]["add"]==true || $permission[0]["masterlist"]==true)
      <div id="Request" name="ongoing">
          <div class="card" style="margin-top: 0px">
            <div class="card-content">
              <table class="responsive-table highlight" id="request-dt" style="width: 100%">
                <thead>
                  <tr>
                      <th>ID</th>
                      <th>RFQ Code</th>
                      <th>Purpose</th>
                      <th>Project Code</th>
                      <th>Status</th>
                      <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        
        @if($permission[0]["add"]==true || $permission[0]["masterlist"]==true)
          <a href="#!" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Request for Quotation" onclick="openModal();"><i class="material-icons">add</i></a>
        @endif
      </div>
    @endif

    @if($permission[0]["approval"]==true || $permission[0]["masterlist"]==true)
      <div id="Approval" name="Approval">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="approval-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>RFQ Code</th>
                    <th>Requestor</th>
                    <th>Purpose</th>
                    <th>Project Code</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    @endif

    @if($permission[0]["masterlist"]==true)
      <div id="ForRFQ" name="ForRFQ">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="for-rfq-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>RFQ Code</th>
                    <th>Requestor</th>
                    <th>Purpose</th>
                    <th>Project Code</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    @endif
  
    @if($permission[0]["add"]==true || $permission[0]["masterlist"]==true)
      <div id="ForReview" name="ForReview">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="for-rev-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>RFQ Code</th>
                    <th>Purpose</th>
                    <th>Project Code</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    @endif
  </div>
  
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('rfq.store')}}">
    @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4>Add Request for Quotation</h4>
        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#issuance">Request Details</a></li>
           <li class="tab col s12 m4 l4"><a href="#signatories">Signatories</a></li>
        </ul><br>

        <div id="issuance" name="issuance">
          <input type="hidden" name="site_code" id="add_site_code" value="{{$employee->site_code}}">
          <div class="row"  style="margin-bottom: 0px;">
            <div class="input-field col s12 m4 l4">
              <input id="add_rfq_code" name="rfq_code" type="text" class="validate" placeholder="" value="{{$employee->site_code}}-RFQ{{date('Ymd')}}-00{{$count}}" required readonly>
              <label for="rfq_code">Request for Quotation Code<sup class="red-text"></sup></label>
            </div>

            <div class="input-field col s12 m4 l4">
              <input type="hidden" name="purpose" id="purpose">
              <select id="add_purpose" name="add_purpose" required>
                  <option value="" disabled selected>Choose your option</option>
                  <option value="Office Use">Office Use</option>
                  <option value="Project">Project</option>
              </select>
              <label for="add_purpose">Purpose<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l4" style="display: none; margin-bottom: 0px;" id="project_details">
              <input type="hidden" name="project_code" id="project_code">
              <select id="add_project_code" name="add_project_code">
                  <option value="" disabled selected>Choose your option</option>
              </select>
              <label for="add_project_code">Project Name<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m12 l12">
              <textarea class="materialize-textarea" id="add_remarks" name="remarks" cols="30" rows="10" placeholder="Please input RFQ remarks here.."></textarea>
              <label for="remarks">Remarks<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row col s12 m12 l12">
            <div id="add_set" class="col s12 m2 l2 right-align" style="padding-right: 20px;padding-left: 10px;">
              <button id="set" type="button" onclick="setDetails('add');" class="blue waves-effect waves-light btn left-align" style="width: 100%"><i class="material-icons left">check_circle</i>Set</button>
            </div>

            <div id="add_reset" class="col s12 m2 l2 right-align" style="padding-right: 20px;padding-left: 10px; display: none;">
              <button id="reset" type="button" onclick="resetModal('add')" class="orange waves-effect waves-light btn left-align" style="width: 100%"><i class="material-icons left">loop</i>Reset</button>
            </div>
            <div class="col s10 l10 m10"></div>
          </div>

          <div class="col s12 m12 l12 row">
            <h6 style="padding: 10px;padding-top: 10px;margin-bottom: 0px;background-color:#0d47a1;border-right-width: 20px;margin-top: 0+;margin-top: 0px;margin-right: 10px;margin-left: 10px;" class="white-text"><b>Item Details</b></h6>
          </div>

          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="add_delivery_date" name="delivery_date" type="text" class="datepicker" placeholder="" disabled>
              <label for="delivery_date">Required Delivery Date<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6" style="display:none" id="assy_details">
              <select id="add_assy_code" name="assy_code">
                <option value="" disabled selected>Choose your option</option>
              </select>
              <label for="assy_code">Assembly<sup class="red-text">*</sup></label>
            </div>
          </div>
            
          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="add_item_code" name="item_code" type="text" class="validate" autocomplete="" placeholder="" disabled>
              <label for="item_code">Item Code<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="add_item_desc" name="item_desc" type="text" placeholder="" readonly>
              <label for="item_desc">Description<sup class="red-text"></sup></label>
            </div>
          </div>

          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <select id="add_uom_code" name="uom_code">
                <option value="" disabled>Choose your option</option>
              </select>
              <label for="uom_code">Unit of Measure<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="add_quantity" name="quantity" type="number" step="0.0001" class="number validate" placeholder="" disabled>
              <label for="quantity">Quantity<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row" style="margin-bottom: 10px;">
            <div class="input-field col s12 m6 l6 left-align">
              <button type="button" class="blue waves-effect waves-light btn right-align" id="btnAdd" disabled><i class="material-icons left">add_circle</i>Add Item</button>
            </div>
          </div>

          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight responsive-table" id="items-dt">
                    <thead id="items-header"></thead>
                    <tbody></tbody>
                  </table>
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
                  <table class="highlight" id="matrix-dt">
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

      </div>

      <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
        <button class="green waves-effect waves-light btn" id="btnAddSave" disabled><i class="material-icons left">check_circle</i>Save</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
  </div>

  <div id="editModal" class="modal">
    <form method="POST" action="{{route('rfq.patch')}}">
      @csrf
        <div class="modal-content" style="padding-bottom: 0px;">
          <h4>Edit Request for Quotation</h4> 
          <input type="hidden" id="edit_id" name="id">
          <ul id="tabs-swipe-demo" class="tabs edit">
            <li class="tab col s12 m4 l4"><a class="active" href="#edit_rfq">Request Details</a></li>
             <li class="tab col s12 m4 l4"><a href="#edit_signatories">Signatories</a></li>
          </ul><br>
          
          <div id="edit_rfq" name="edit_rfq">
            <input type="hidden" name="site_code" id="edit_site_code" value="{{$employee->site_code}}">
            <div class="row" style="margin-bottom: 0px;">
              <div class="input-field col s12 m4 l4">
                <input id="edit_rfq_code" name="rfq_code" type="text" class="validate" placeholder="" required readonly>
                <label for="rfq_code">Request for Quotation Code<sup class="red-text"></sup></label>
              </div>
  
              <div class="input-field col s12 m4 l4">
                <input type="hidden" name="purpose" id="purpose_edit">
                <select id="edit_purpose" name="edit_purpose" required>
                    <option value="" disabled selected>Choose your option</option>
                    <option value="Office Use">Office Use</option>
                    <option value="Project">Project</option>
                </select>
                <label for="edit_purpose">Purpose<sup class="red-text">*</sup></label>
              </div>
  
              <div class="input-field col s12 m4 l4" style="display: none; margin-bottom: 0px;" id="edit_project_details">
                <input type="hidden" name="project_code" id="project_code_edit">
                <select id="edit_project_code" name="edit_project_code">
                    <option value="" disabled selected>Choose your option</option>
                </select>
                <label for="edit_project_code">Project Name<sup class="red-text">*</sup></label>
              </div>
            </div>
  
            <div class="row" style="margin-bottom: 0px;">
              <div class="input-field col s12 m12 l12">
                <textarea class="materialize-textarea" id="edit_remarks" name="remarks" cols="30" rows="10" placeholder="Please input RFQ remarks here.."></textarea>
                <label for="remarks">Remarks<sup class="red-text">*</sup></label>
              </div>
            </div>
  
            <div class="row col s12 m12 l12">
              <div id="edit_set" class="col s12 m2 l2 left-align" style="padding-right: 20px;padding-left: 10px;">
                <button id="set" type="button" onclick="setDetails('edit');" class="blue waves-effect waves-light btn left-align" style="width: 100%"><i class="material-icons left">check_circle</i>Set</button>
              </div>
  
              <div id="edit_reset" class="col s12 m2 l2 left-align" style="padding-right: 20px;padding-left: 10px; display: none;">
                <button id="reset" type="button" onclick="resetModal('edit');" class="orange waves-effect waves-light btn left-align" style="width: 100%"><i class="material-icons left">loop</i>Reset</button>
              </div>
              <div class="col s6 l6 m6"></div>
            </div>
  
            <div class="col s12 m12 l12 row">
              <h6 style="padding: 10px;padding-top: 10px;margin-bottom: 0px;background-color:#0d47a1;border-right-width: 20px;margin-top: 0+;margin-top: 0px;margin-right: 10px;margin-left: 10px;" class="white-text"><b>Item Details</b></h6>
            </div>

            <div class="row" style="margin-bottom: 0px;">
              <div class="input-field col s12 m6 l6">
                <input id="edit_delivery_date" name="delivery_date" type="text" class="datepicker" placeholder="" disabled>
                <label for="delivery_date">Required Delivery Date<sup class="red-text">*</sup></label>
              </div>
  
              <div class="input-field col s12 m6 l6" style="display:none" id="edit_assy_details">
                <input type="hidden" name="assy_code" id="assy_code_edit">
                <select id="edit_assy_code" name="assy_code">
                  <option value="" disabled selected>Choose your option</option>
                </select>
                <label for="assy_code">Assembly<sup class="red-text">*</sup></label>
              </div>
            </div>
              
            <div class="row" style="margin-bottom: 0px;">
              <div class="input-field col s12 m6 l6">
                <input id="edit_item_code" name="item_code" type="text" class="validate" autocomplete="" placeholder="" disabled>
                <label for="item_code">Item Code<sup class="red-text">*</sup></label>
              </div>
  
              <div class="input-field col s12 m6 l6">
                <input id="edit_item_desc" name="item_desc" type="text" placeholder="" readonly>
                <label for="item_desc">Description<sup class="red-text"></sup></label>
              </div>
            </div>
  
            <div class="row" style="margin-bottom: 0px;">
              <div class="input-field col s12 m6 l6">
                <select id="edit_uom_code" name="uom_code">
                  <option value="" selected disabled>Choose your option</option>
                </select>
                <label for="uom_code">Unit of Measure<sup class="red-text">*</sup></label>
              </div>
  
              <div class="input-field col s12 m6 l6">
                <input id="edit_quantity" name="quantity" type="number" step="0.0001" class="number validate" placeholder="" disabled>
                <label for="quantity">Quantity<sup class="red-text">*</sup></label>
              </div>
            </div>
  
            <div class="row" style="margin-bottom: 0px;">
              <div class="input-field col s12 m6 l6 left-align">
                <button type="button" class="blue waves-effect waves-light btn right-align" id="edit_btnAdd" disabled><i class="material-icons left">add_circle</i>Add Item</button>
              </div>
            </div>
  
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="card">
                  <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
                  <div class="card-content" style="padding: 10px; padding-top: 0px">
                    <table class="highlight" id="edit-items-dt">
                      <thead id="edit-items-header"></thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
  
          </div>
  
          <div id="edit_signatories" name="edit_signatories">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="card">
                  <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
                  <div class="card-content" style="padding: 10px; padding-top: 0px">
                    <table class="highlight" id="edit-matrix-dt">
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
          
        </div>
  
        <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
          <button class="green waves-effect waves-light btn" id="btnEditSave" disabled><i class="material-icons left">check_circle</i>Save</button>
          <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
        </div>
    </form>
  </div>

  <div id="viewModal" class="modal">
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4>Request for Quotation Details</h4> 
      <ul id="tabs-swipe-demo" class="tabs view">
        <li class="tab col s12 m4 l4"><a class="active" href="#view_rfq_details">Request Details</a></li>
        <li class="tab col s12 m4 l4"><a href="#view_signatories">Signatories</a></li>
      </ul><br>

      <div id="view_rfq_details" name="view_rfq_details" style="margin-bottom: 0px">
        <div class="row" style="margin-bottom: 0px">
          <div class="input-field col s12 m6 l6">
            <input id="view_rfq_code" name="rfq_code" type="text" class="validate" placeholder="" readonly>
            <label class="active">Request for Quotation Code</label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="view_date_requested" name="date_requested" type="text" class="validate" placeholder="" readonly>
            <label class="active">Date Requested</label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px">
          <div class="input-field col s12 m6 l6">
            <input id="view_purpose" name="purpose" type="text" class="validate" placeholder="" readonly>
            <label class="active">Purpose</label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="view_remarks" name="remarks" type="text" class="validate" placeholder="" readonly>
            <label class="active">Remarks</label>
          </div>

          <div class="input-field col s12 m6 l6" style="display: none;" id="view_project_details">
            <input id="view_project_code" name="project_code" type="text" class="validate" placeholder="" readonly>
            <label class="active">Project</label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight" id="view-items-dt">
                  <thead id="view-items-header">
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px; display: none;" id="view_quote_list">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Quotation List</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight" id="view-quote-dt">
                  <thead id="view-quote-header">
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="view_signatories" name="view_signatories">
        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight" id="view-matrix-dt">
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

        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Approval History</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight" id="view-matrix-dt-h">
                  <thead>
                    <tr>
                      <th>Sequence</th> 
                      <th>Approver Name</th> 
                      <th>Status</th> 
                      <th>Remarks</th> 
                      <th>Action Date</th> 
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>

    <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
      <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">keyboard_return</i>Return</a>
    </div>
  </div>

  <div id="appModal" class="modal">
    <form method="post" action="{{route('rfq.approve')}}">
    @csrf
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4>Request for Quotation Details</h4> 
      <input type="hidden" id="app_id" name="id">
      <ul id="tabs-swipe-demo" class="tabs app">
        <li class="tab col s12 m4 l4"><a class="active" href="#app_rfq">Request Details</a></li>
        <li class="tab col s12 m4 l4"><a href="#app_signatories">Signatories</a></li>
      </ul><br>

      <div id="app_rfq" name="app_rfq">
        <div class="row" style="margin-bottom: 0px">
          <div class="input-field col s12 m6 l6">
            <input id="app_rfq_code" name="rfq_code" type="text" class="validate" placeholder="" readonly>
            <label class="active">Request for Quotation Code</label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="app_date_requested" name="date_requested" type="text" class="validate" placeholder="" readonly>
            <label class="active">Date Requested</label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px">
          <div class="input-field col s12 m6 l6">
            <input id="app_purpose" name="purpose" type="text" class="validate" placeholder="" readonly>
            <label class="active">Purpose</label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="app_remarks" name="remarks" type="text" class="validate" placeholder="" readonly>
            <label class="active">Remarks</label>
          </div>

          <div class="input-field col s12 m6 l6" style="display: none;" id="app_project_details">
            <input id="app_project_code" name="project_code" type="text" class="validate" placeholder="" readonly>
            <label class="active">Project</label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight" id="app-items-dt">
                  <thead id="app-items-header"></thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Quotation List</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight" id="app-quote-items-dt">
                  <thead>
                    <th>ID</th>
                    <th>Vendor</th>
                    <th>Item Code</th>
                    <th>SPQ</th>
                    <th>MOQ</th>
                    <th>Lead Time</th>
                    <th>Currency</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="app_signatories" name="app_signatories">
        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight" id="app-matrix-dt">
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

        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Approval History</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight" id="app-matrix-dt-h">
                  <thead>
                    <tr>
                      <th>Sequence</th> 
                      <th>Approver Name</th> 
                      <th>Status</th> 
                      <th>Remarks</th> 
                      <th>Action Date</th> 
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>

      <hr style="padding:1px;color:blue;background-color:blue">
    </div>

    <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
      <div class="row" style="padding-left: 20px">

        <div class="input-field col s12 m9 l9">
          <textarea class="materialize-textarea" type="text" id="app_remarks" name="remarks" placeholder="Please input remarks here.." style="height: 150px; border-left: 10px; border-color: black; padding-left:20px;" required></textarea>
          <label for="icon_prefix2">Remarks</label>
        </div>
        
        <div class="input-field col s12 m3 l3">
          <input type="hidden" id="status" name="status">

          <button id="btnApp" name="btnSubmit" value="Approved" class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Approve</button>
          
          <button id="btnRej" name="btnSubmit" value="Rejected" class="red waves-effect waves-dark btn" style="padding-right: 19px"><i class="material-icons left">cancel</i>Reject&nbsp;&nbsp;&nbsp;</button>

          <a href="#!" class="modal-close orange waves-effect waves-dark btn"><i class="material-icons left">keyboard_return</i>Cancel&nbsp;&nbsp;</a>
        </div>
        
      </div>
    </div>
    </form>
  </div>

  <div id="forQModal" class="modal">
    <form id="quote_form" method="post" action="{{route('rfq.store_quote')}}">
    @csrf
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4>Request for Quotation Details</h4> 
      <ul id="tabs-swipe-demo" class="tabs view">
        <li class="tab col s12 m4 l4"><a class="active" href="#fq_rfq_details">Request Details</a></li>
        <li class="tab col s12 m4 l4"><a href="#fq_signatories">Signatories</a></li>
      </ul><br>

      <div id="fq_rfq_details" name="fq_rfq_details" style="margin-bottom: 0px">
        <div class="row" style="margin-bottom: 0px">
          <div class="input-field col s12 m6 l6">
            <input id="fq_rfq_code" name="rfq_code" type="text" class="validate" placeholder="" readonly>
            <label class="active">Request for Quotation Code</label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="fq_date_requested" name="date_requested" type="text" class="validate" placeholder="" readonly>
            <label class="active">Date Requested</label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px">
          <div class="input-field col s12 m6 l6">
            <input id="fq_purpose" name="purpose" type="text" class="validate" placeholder="" readonly>
            <label class="active">Purpose</label>
          </div>

          <div class="input-field col s12 m6 l6" style="display: none;" id="fq_project_details">
            <input id="fq_project_code" name="project_code" type="text" class="validate" placeholder="" readonly>
            <label class="active">Project</label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="fq_remarks" name="remarks" type="text" class="validate" placeholder="" readonly>
            <label class="active">Remarks</label>
          </div>

        </div>

        <div class="row" style="margin-bottom: 0px">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight responsive-table" id="fq-items-dt">
                  <thead id="fq-items-header">
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Quotation List</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight responsive-table" id="q-details-dt">
                  <thead id="q-header">
                    <tr>
                      <th>ID</th>
                      <th>Vendor</th>
                      <th>Item Code</th>
                      <th>SPQ</th>
                      <th>MOQ</th>
                      <th>Lead Time</th>
                      <th>Currency</th>
                      <th>Unit Price</th>
                      <th>Total Price</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        {{-- <div class="row col s12 m12 l12">
          <div class="col s12 m8 l8"></div>
          <div class="col s12 m4 l4 right-align">
            <input placeholder="0" id="fq_grand_total" name="grand_total" type="text" style="text-align: right; left: 75%; font-size: 25px" class="number" required readonly>
            <label for="grand_total" style="left: 75%; font-size:20px;"><b>Grand Total Price</b><sup class="red-text"></sup></label>
          </div>
        </div> --}}
      </div>

      <div id="fq_signatories" name="fq_signatories">
        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight" id="fq-matrix-dt">
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

        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Approval History</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight" id="fq-matrix-dt-h">
                  <thead>
                    <tr>
                      <th>Sequence</th> 
                      <th>Approver Name</th> 
                      <th>Status</th> 
                      <th>Remarks</th> 
                      <th>Action Date</th> 
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>

    <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
      <div class="row col s12 m12 l12">
        <div class="row col s12 m4 l4 left-align" style="margin-left: 20px;">
          <button type="button" class="orange waves-effect waves-light btn right-align" id="btnResetQ" onclick="resetQDetails();" disabled><i class="material-icons left">loop</i>Reset Details</button>
        </div>
        <div class="row col s12 m8 l8 right-align">
          <button class="green waves-effect waves-light btn" id="btnSaveQ" onclick="saveQuote();" disabled><i class="material-icons left">check_circle</i>Save</button>
          <a href="#!" class="modal-close red waves-effect waves-dark btn" onclick="cancelQuote();"><i class="material-icons left">cancel</i>Cancel</a>
        </div>
      </div>
    </div>
    </form>
  </div>

  <div id="QdetModal" class="modal">
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4 style="margin-bottom: 0px">Quotation Details</h4><br>
        <input type="hidden" name="id" id="item_id">
        <input type="hidden" name="status" id="item_status">

        <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 1em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item Details</b></h6>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m4 l4">
            <input id="item_rfq_code" name="item_rfq_code" type="text" placeholder="" readonly>
            <label for="item_rfq_code">Request for Quotation Code<sup class="red-text"></sup></label>
          </div>

          <div class="input-field col s12 m4 l4">
            <input id="item_req_del" name="item_req_del" type="text"  placeholder="" readonly>
            <label for="item_req_del">Required Delivery Date<sup class="red-text"></sup></label>
          </div>

          <div class="input-field col s12 m4 l4" id="item_assy" style="display: none">
            <input id="item_assy_code" name="item_assy_code" type="text"  placeholder="" readonly>
            <label for="item_assy_code">Assembly Code<sup class="red-text"></sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 10px;">
          <input type="hidden" name="uom_code" id="item_uom_code">
          <input type="hidden" name="req_qty" id="item_req_qty">

          <div class="input-field col s12 m4 l4">
            <input id="item_item_code" name="item_item_code" type="text"  placeholder="" readonly>
            <label for="item_item_code">Item Code<sup class="red-text"></sup></label>
          </div>

          <div class="input-field col s12 m8 l8">
            <input id="item_item_desc" name="item_desc" type="text" placeholder="" readonly>
            <label for="item_desc" class="active">Item Description</label>
          </div> 
        </div>

        <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 1em; background-color:#0d47a1" class="white-text"><b>Quotation from Vendor</b></h6>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m4 l4">
            <select id="item_vendor" name="item_vendor" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($vendor as $vens)
                <option value="{{$vens->ven_code}}">{{$vens->ven_name}}</option>
              @endforeach
            </select>
            <label for="item_vendor">Vendor <sup class="red-text">*</sup></label>
          </div>  
              
          <div class="input-field col s12 m4 l4">
            <input id="item_ven_delivery" name="item_ven_delivery" type="text" class="validate datepicker" placeholder="YYYY/MM/DD" required>
            <label for="item_ven_delivery">Delivery Date <sup class="red-text">*</sup></label>
            <input type="hidden" name="lead_time" id="item_lead_days">
            <span id="item_lead_time" class="badge lighten-3 black-text" style="font-size: 12px">Lead Time: 0 day(s)</span>
          </div>

          <div class="input-field col s12 m4 l4">
            <select id="item_currency_code" name="item_currency_code" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($currency as $currency)
                <option value="{{$currency->currency_code}}">{{$currency->symbol}} - {{$currency->currency_name}}</option>
              @endforeach
            </select>
            <label for="item_currency_code">Currency <sup class="red-text">*</sup></label>
          </div>  
        </div>
 
        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m4 l4">
            <input id="item_spq" name="item_spq" type="number" placeholder="0" required>
            <label for="item_spq">Standard Packaging Qty. <sup class="red-text">*</sup></label>
          </div>   

          <div class="input-field col s12 m4 l4">
            <input id="item_moq" name="item_moq" type="number" placeholder="0" required>
            <label for="item_moq">Minimum Order Qty. <sup class="red-text">*</sup></label>
          </div>
  
          <div class="input-field col s12 m4 l4">
            <input id="item_unit_price" name="item_unit_price" type="number" placeholder="0" required>
            <label for="item_unit_price">Unit Price <sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m4 l4">
            <input id="item_total_price" name="item_total_price" type="text" value="0" readonly>
            <label for="item_total_price">Total Price</label>
          </div>
        </div>
    </div>

    <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
      <div class="row col s12 m12 l12">
        <div class="row col s12 m4 l4 left-align" style="margin-left: 20px;">
          <button type="button" class="orange waves-effect waves-light btn right-align" id="btnQReset" onclick="resetColDetails();" disabled><i class="material-icons left">loop</i>Reset</button>
        </div>
 
        <div class="row col s12 m8 l8 right-align">
          <button class="green waves-effect waves-light btn" id="btnQSave" onclick="quoteSave();" disabled><i class="material-icons left">assignment_turned_in</i>Save</button>
          <button class="modal-close red waves-effect waves-light btn" id="btnQCan" onclick="quoteCan();"><i class="material-icons left">cancel</i>Cancel</button>
        </div>
      </div>
    </div>
  </div>
  
  <div id="deleteModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('location.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Inventory Location</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Inventory Location</strong>?</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Yes</button>
            <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
        </div>
    </form>
  </div> 

  <div id="resetModal" class="modal bottom-sheet">
    <div class="modal-content">
        <h4>Reset Request for Quotation</h4><br><br>
        <div class="row">
            <div class="col s12 m6">
                <input type="hidden" name="reset_loc" id="reset_loc">
                <p>Are you sure you want to reset <strong>Request for Quotation Details</strong>?</p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="green waves-effect waves-light btn" id="btnReset" onclick="resetDetails();" ><i class="material-icons left">check_circle</i>Yes</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
    </div>
  </div> 

  <div id="resetColModal" class="modal bottom-sheet">
    <div class="modal-content">
        <h4>Reset Quotation Details</h4><br><br>
        <div class="row">
            <div class="col s12 m6">
                <input type="hidden" name="reset_loc" id="reset_loc">
                <p>Are you sure you want to reset <strong>Quotation Details</strong>?</p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="green waves-effect waves-light btn" id="btnReset" onclick="resetCollection();" ><i class="material-icons left">check_circle</i>Yes</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
    </div>
  </div> 

  <div id="resetQModal" class="modal bottom-sheet">
    <div class="modal-content">
        <h4>Reset Quotation Details</h4><br><br>
        <div class="row">
            <div class="col s12 m6">
                <input type="hidden" name="reset_loc" id="reset_loc">
                <p>Are you sure you want to reset <strong>Quotation(s) Details</strong>?</p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="green waves-effect waves-light btn" id="btnReset" onclick="resetQuoteDetails();" ><i class="material-icons left">check_circle</i>Yes</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
    </div>
  </div> 

  <div id="removeItemModal" class="modal">
    <div class="modal-content">
      <h4  >Remove Item</h4>
      <div class="row">
          <div class="col s12 m12 l12">
              <input type="hidden" name="id" id="del_index">
              <input type="hidden" name="item_index" id="del_item_index">
              <input type="hidden" name="loc" id="del_loc">
              <p>Are you sure you want to remove this <strong>Item</strong> on the list?</p>
          </div>
      </div>
    </div>
    <div class="modal-footer">
        <a onclick="removeItem();" class="green waves-effect waves-dark btn"><i class="material-icons left">check_circle</i>Yes</a>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
    </div>
  </div>

  <!-- End of MODALS -->

    <!-- SCRIPTS -->
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">
  
    var RFQCount = {{$count}};
    const todayx = new Date().toISOString().slice(0, 10);
    var newtoday = todayx.replace(/[^a-zA-Z0-9]/g,"");

    var convert_values = 0;
    
    var add_items = [];
    var edit_items = [];
    
    var view_items = [];
    var view_qt = [];

    var app_items = [];
    var rev_items = [];
    var rev_quote = [];

    var fq_items = [];
    var qt_items = [];

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

 
        $('#add_purpose').on('change', function(){
          if($(this).val()=='Project')
          {
            var x = document.getElementById('project_details');
                x.style.display = "block";
            var assy = document.getElementById('assy_details');
                assy.style.display = "block";
            $('#add_assy_code').prop('disabled', true);
            $('#add_assy_code').formSelect();
            $('#items-header').html("");
            $('#items-header').append('<tr>'+
                                        '<th>ID</th>'+
                                        '<th>Assembly</th>'+
                                        '<th>Item Code</th>'+
                                        '<th>Item Description</th>'+
                                        '<th>Quantity</th>'+
                                        '<th>Unit of Measure</th>'+
                                        '<th>Delivery Date</th>'+
                                        '<th>Action</th>'+
                                      '</tr>');
            projectCode('{{$employee->site_code}}', 'add');
          } else {
            var x = document.getElementById('project_details');
                x.style.display = "none";
            var assy = document.getElementById('assy_details');
                assy.style.display = "none";
            $('#items-header').html("");
            $('#items-header').append('<tr>'+
                                        '<th>ID</th>'+
                                        '<th>Item Code</th>'+
                                        '<th>Item Description</th>'+
                                        '<th>Quantity</th>'+
                                        '<th>Unit of Measure</th>'+
                                        '<th>Delivery Date</th>'+
                                        '<th>Action</th>'+
                                      '</tr>');
          }
          $('#purpose').val($(this).val());
        });

        $('#add_project_code').on('change', function(){
          $.get('../projects/view/'+$(this).val()+'/view_assy', (response) => {
            var data = response.data;
            var select = '<option value="" disabled selected>Choose your option</option>';
            $.each(data, (index,row) => {
                select += '<option value="'+row.assy_code+'">'+row.assy_desc+'</option>';
            });
            $('#add_assy_code').html(select);
            $('#add_assy_code').formSelect();
          });
          $('#project_code').val($(this).val());
        });
        
        $('#add_delivery_date').on('change', function(){
          if($(this).val() < todayx){ 
            $(this).val("")
            alert("You cannot set delivery date of the item less than today's date!");
          }
        });

        $('#add_assy_code').on('change', function(){
          $('#assy_code').val($(this).val());
        });
        
        $('#add_unit_price').on('keyup', function(){
          computeTotalPrice(($('#add_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#add_currency_code option:selected').text().split(" - ")[0]),parseInt($('#add_unit_price').val()),parseInt($('#add_quantity').val()),$('#add_total_price'));
        });

        $('#add_quantity').on('keyup', function(){
          computeTotalPrice(($('#add_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#add_currency_code option:selected').text().split(" - ")[0]),parseInt($('#add_unit_price').val()),parseInt($('#add_quantity').val()),$('#add_total_price'));
        });

        $('#add_currency_code').on('change', function(){
          computeTotalPrice(($('#add_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#add_currency_code option:selected').text().split(" - ")[0]),parseInt($('#add_unit_price').val()),parseInt($('#add_quantity').val()),$('#add_total_price'));
        });

        $('#add_item_code').on('blur', function(){
          $.get('../item_master/getItemDetails/'+trim($(this).val()), (response) => {
            var data = response.data;
            if(data)
            {
              $('#add_item_desc').val(data.item_desc);
              $.get('../uom_conversion/conversions/'+data.uom_code, (response) => {
                var datax = response.data;
                var select = '<option value="" disabled>Choose your option</option>';
                $.each(datax, (index,row) => {
                  if(data.uom_code == row.uom_to){
                    select += '<option value="'+row.uom_details.uom_code+'" selected>'+row.uom_details.uom_name+'</option>';
                  } else {
                    select += '<option value="'+row.uom_details.uom_code+'">'+row.uom_details.uom_name+'</option>';
                  }
                });
                $('#add_uom_code').html(select);
                $('#add_uom_code').formSelect();
              });
            } else {
              alert('Item code does not exist! Please the check the item code before adding item..');
            }
          });
        });
        
        $('#btnAdd').on('click', function(){
          console.log(todayx);
          console.log(newtoday);
          console.log(trim($('#add_delivery_date').val()) > todayx);

          if($('#purpose').val() == 'Project'){         
            if(trim($('#add_delivery_date').val()) && 
            $('#add_assy_code').val() != null && 
            trim($('#add_item_code').val()) && 
            trim($('#add_quantity').val()) &&
            trim($('#add_uom_code').val()))
            {
              var item_qty = parseInt($('#add_quantity').val());
              addItem('add',item_qty, $('#purpose').val());
            }else{
              alert("Please fill-up all item details!");
            }
          } else {
            if(trim($('#add_delivery_date').val()) && 
            trim($('#add_item_code').val()) && 
            trim($('#add_quantity').val()) &&
            trim($('#add_uom_code').val()))
            {
              var item_qty = parseInt($('#add_quantity').val());
              addItem('add',item_qty, $('#purpose').val());
            }else{
              alert("Please fill-up all item details!");
            }            
          }

        });


 
        $('#edit_purpose').on('change', function(){
          if($(this).val()=='Project')
          {
            var x = document.getElementById('edit_project_details');
              x.style.display = "block";
              projectCode('{{$employee->site_code}}', 'edit');
          } else {
            var x = document.getElementById('edit_project_details');
              x.style.display = "none";
              $('#edit_project_code option[value=""]').prop('selected', true);
              $('#edit_project_code').formSelect();
              $('#project_code_edit').val("");

              $('#edit_assy_code option[value=""]').prop('selected', true);
              $('#edit_assy_code').formSelect();
              $('#assy_code_edit').val("");
          }
          $('#purpose_edit').val($(this).val());
        });

        $('#edit_project_code').on('change', function(){
          $.get('../projects/view/'+$(this).val()+'/view_assy', (response) => {
            var data = response.data;
            var select = '<option value="" disabled selected>Choose your option</option>';
            $.each(data, (index,row) => {
                select += '<option value="'+row.assy_code+'">'+row.assy_desc+'</option>';
            });
            $('#edit_assy_code').html(select);
            $('#edit_assy_code').formSelect();
          });
          $('#project_code_edit').val($(this).val());
        });

        $('#edit_delivery_date').on('change', function(){
          if($(this).val() < todayx){ 
            $(this).val("")
            alert("You cannot set delivery date of the item less than today's date!");
          }
        });

        $('#edit_assy_code').on('change', function(){
          $('#assy_code_edit').val($(this).val());
        });

        $('#edit_unit_price').on('keyup', function(){
          computeTotalPrice(($('#edit_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#edit_currency_code option:selected').text().split(" - ")[0]),parseInt($('#edit_unit_price').val()),parseInt($('#edit_quantity').val()),$('#edit_total_price'));
        });

        $('#edit_quantity').on('keyup', function(){
          computeTotalPrice(($('#edit_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#edit_currency_code option:selected').text().split(" - ")[0]),parseInt($('#edit_unit_price').val()),parseInt($('#edit_quantity').val()),$('#edit_total_price'));
        });

        $('#edit_currency_code').on('change', function(){
          computeTotalPrice(($('#edit_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#edit_currency_code option:selected').text().split(" - ")[0]),parseInt($('#edit_unit_price').val()),parseInt($('#edit_quantity').val()),$('#edit_total_price'));
        });

        $('#edit_item_code').on('blur', function(){
          $.get('../item_master/getItemDetails/'+trim($(this).val()), (response) => {
            var data = response.data;
         
            if(data)
            {
              $('#edit_item_desc').val(data.item_desc);
              $.get('../uom_conversion/conversions/'+data.uom_code, (response) => {
                var datax = response.data;
                var select = '<option value="" disabled selected>Choose your option</option>';
                $.each(datax, (index,row) => {
                  if(data.uom_code == row.uom_to){
                    select += '<option value="'+row.uom_details.uom_code+'" selected>'+row.uom_details.uom_name+'</option>';
                  } else {
                    select += '<option value="'+row.uom_details.uom_code+'">'+row.uom_details.uom_name+'</option>';
                  }
                });
                $('#edit_uom_code').html(select);
                $('#edit_uom_code').formSelect();
              });
            } else {
              alert('Item code does not exist! Please the check the item code before adding item..');
            }
          });
        });

        $('#edit_btnAdd').on('click', function(){
          
          if($('#purpose_edit').val() == 'Project'){         
            if(trim($('#edit_delivery_date').val()) && 
            $('#edit_assy_code').val() != null && 
            trim($('#edit_item_code').val()) && 
            trim($('#edit_quantity').val()) &&
            trim($('#edit_uom_code').val()))
            {
              var item_qty = parseInt($('#edit_quantity').val());
              addItem('edit',item_qty, $('#purpose_edit').val());
              $('#btnEditSave').prop('disabled', false);
            }else{
              alert("Please fill-up all item details!");
            }
          } else {
            if(trim($('#edit_delivery_date').val()) && 
            trim($('#edit_item_code').val()) && 
            trim($('#edit_quantity').val()) &&
            trim($('#edit_uom_code').val()))
            {
              var item_qty = parseInt($('#edit_quantity').val());
              addItem('edit',item_qty, $('#purpose_edit').val());
              $('#btnEditSave').prop('disabled', false);
            }else{
              alert("Please fill-up all item details!");
            }            
          }
        
        });



        $('#item_ven_delivery').on('change', function(){
          if($(this).val() >= $('#item_req_del').val()){
            if($(this).val() > todayx){
            var diff,
                aDay = 86400000,
                start_date = todayx,
                end_date = $(this).val();
                diff = Math.floor( (Date.parse(end_date.replace(/-/g, '\/')) - Date.parse(start_date.replace(/-/g, '\/'))) / aDay);
  
              $('#item_lead_time').html("Lead Time: " + diff + " day(s)");
              $('#item_lead_days').val(diff);

            } else {
              alert("You cannot set delivery date of the item less than today's date!");
              $(this).val("");
            }
          } else {
            alert("You cannot set delivery date of the item less than required delivery date!");
              $(this).val("");
          }

        });

        $('#item_currency_code').on('change', function(){
          if($(this).val() != null){
            computeTotalPrice($('#item_currency_code option:selected').text().split(" - ")[0], parseFloat($('#item_spq').val()), parseFloat($('#item_moq').val()), parseFloat($('#item_unit_price').val()), $('#item_total_price'));
          }
        });

        $('#item_spq').on('keyup', function(){
          if(trim($(this).val()) != ""){
            if(parseFloat($(this).val()) >= 0){
              computeTotalPrice($('#item_currency_code option:selected').text().split(" - ")[0], parseFloat($('#item_spq').val()), parseFloat($('#item_moq').val()), parseFloat($('#item_unit_price').val()), $('#item_total_price'));
              checkQuoteDetails();
            } else {
              alert('Standard packaging quantity must be greater than zero!');
              $(this).val("");
            }
          }
        });

        $('#item_moq').on('keyup', function(){
          if(trim($(this).val()) != ""){
            if(parseFloat($(this).val()) >= 0){
              computeTotalPrice($('#item_currency_code option:selected').text().split(" - ")[0], parseFloat($('#item_spq').val()), parseFloat($('#item_moq').val()), parseFloat($('#item_unit_price').val()), $('#item_total_price'));
              checkQuoteDetails();
            } else {
              alert('Minimum order quantity must be greater than zero!');
              $(this).val("");
            }
          }
        });

        $('#item_unit_price').on('keyup', function(){
          if(trim($(this).val()) != ""){
            if(parseFloat($(this).val()) >= 0){
              computeTotalPrice($('#item_currency_code option:selected').text().split(" - ")[0], parseFloat($('#item_spq').val()), parseFloat($('#item_moq').val()), parseFloat($('#item_unit_price').val()), $('#item_total_price'));
              checkQuoteDetails();
            } else {
              alert('Unit price must be greater than zero!');
              $(this).val("");
            }
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
    
    const computeTotalPrice = (symbol = '$', spq = 0, moq = 0, unit_price = 0, input_total) => {
      const total = spq * moq * unit_price;
      input_total.val(symbol+" "+FormatNumber(total ? parseInt(total) : 0));
    };

    const computeGrandTotal = (symbol, products, field_grand_total) => {
        var grand_total = 0.0;
        $.each(products,(index,row) => {
            grand_total = parseInt(grand_total) + ( parseInt(row.spq) * parseInt(row.moq) * parseInt(row.unit_price) );
        });
        field_grand_total.val(symbol+" "+FormatNumber(grand_total));
    };

    const checkQuoteDetails = () => {
      if(($('#item_vendor').val() != "" || $('#item_vendor').val() != null) && 
        ($('#item_currency_code').val() != "" || $('#item_currency_code').val() != null) &&
        trim($('#item_ven_delivery').val()) &&
        trim($('#item_spq').val()) &&
        trim($('#item_moq').val()) &&
        trim($('#item_unit_price').val()))
        {
          $('#btnQReset').prop('disabled', false);
          $('#btnQSave').prop('disabled', false);
        }
    };

    const setDetails = (loc) => {
      if(loc=="add"){
        if(trim($('#add_rfq_code').val()) &&
        trim($('#add_purpose').val()) &&
        trim($('#add_purpose').val()))
        {
          if($('#add_purpose').val()=='Project')
          {
            if($('#add_project_code').val())
            {
              $('#btnAdd').prop('disabled', false);
              $('#add_delivery_date').prop('disabled', false);
              $('#add_item_code').prop('disabled', false);
              $('#add_quantity').prop('disabled', false);
              $('#add_uom_code').prop('disabled', false);
              $('#add_uom_code').formSelect();
              $('#add_assy_code').prop('disabled', false);
              $('#add_assy_code').formSelect();

              $('#add_purpose').prop('disabled', true);
              $('#add_purpose').formSelect();
              $('#add_project_code').prop('disabled', true);
              $('#add_project_code').formSelect();
              $('#add_remarks').prop('readonly', true);
        
              var set = document.getElementById('add_set');
                  set.style.display = "none";
              var reset = document.getElementById('add_reset');
                  reset.style.display = "block";
            } else {
              alert('Please fill up all request details before setting-up items!');
            }
          } else {
            $('#btnAdd').prop('disabled', false);
            $('#add_delivery_date').prop('disabled', false);
            $('#add_item_code').prop('disabled', false);
            $('#add_quantity').prop('disabled', false);
            $('#add_uom_code').prop('disabled', false);
            $('#add_uom_code').formSelect();

            $('#add_purpose').prop('disabled', true);
            $('#add_purpose').formSelect();
            $('#add_remarks').prop('readonly', true);
             
            var set = document.getElementById('add_set');
                set.style.display = "none";
            var reset = document.getElementById('add_reset');
                reset.style.display = "block";
          }
        } else {
          alert('Please fill up all request details before setting-up items!');
        }
      } else {
        if(trim($('#edit_rfq_code').val()) &&
        trim($('#edit_purpose').val()) &&
        trim($('#edit_purpose').val()))
        {
          if($('#edit_purpose').val()=='Project')
          {
            if($('#edit_project_code').val())
            {
              $('#edit_btnAdd').prop('disabled', false);
              $('#edit_delivery_date').prop('disabled', false);
              $('#edit_item_code').prop('disabled', false);
              $('#edit_quantity').prop('disabled', false);
              $('#edit_uom_code').prop('disabled', false);
              $('#edit_uom_code').formSelect();

              $.get('../projects/view/'+$('#edit_project_code').val()+'/view_assy', (response) => {
                var data = response.data;
                var select = '<option value="" disabled selected>Choose your option</option>';
                $.each(data, (index,row) => {
                    select += '<option value="'+row.assy_code+'">'+row.assy_desc+'</option>';
                });
                $('#edit_assy_code').html(select);
                $('#edit_assy_code').formSelect();
                $('#edit_assy_code').prop('disabled', false);
                $('#edit_assy_code').formSelect();
              });

              $('#edit_purpose').prop('disabled', true);
              $('#edit_purpose').formSelect();
              $('#edit_project_code').prop('disabled', true);
              $('#edit_project_code').formSelect();
              $('#edit_remarks').prop('readonly', true);
        
              var set = document.getElementById('edit_set');
                  set.style.display = "none";
              var reset = document.getElementById('edit_reset');
                  reset.style.display = "block";
            } else {
              alert('Please fill up all request details before setting-up items!');
            }
          } else {
              $('#edit_btnAdd').prop('disabled', false);
              $('#edit_delivery_date').prop('disabled', false);
              $('#edit_item_code').prop('disabled', false);
              $('#edit_quantity').prop('disabled', false);
              $('#edit_uom_code').prop('disabled', false);
              $('#edit_uom_code').formSelect();

              $('#edit_purpose').prop('disabled', true);
              $('#edit_purpose').formSelect();
              $('#edit_remarks').prop('readonly', true);
              
              var set = document.getElementById('edit_set');
                  set.style.display = "none";
              var reset = document.getElementById('edit_reset');
                  reset.style.display = "block";
          }
        } else {
          alert('Please fill up all request details before setting-up items!');
        }
      }
    };

    const resetQDetails = () => {
     $('#resetQModal').modal('open');
    }

    const resetQuoteDetails = () => {
      $('#btnResetQ').prop('disabled', true);
      $('#btnSaveQ').prop('disabled', true);
      qt_items = [];
      fq_items = [];

      $.get('list/'+$('#fq_rfq_code').val()+'/items_user', (response) => {
      var datax = response.data;
        
        $.each(datax, (index, row) => {
          fq_items.push({"assy_code": row.assy_code,
                          "item_code": row.item_code,
                          "item_desc": row.item_details.item_desc,
                          "uom_code": row.uoms.uom_code,
                          "uom_name": row.uoms.uom_name,
                          "quantity": row.required_qty,
                          "delivery_date": row.required_delivery_date,
                          "status": row.rfq_status ? row.rfq_status.status : 0,
                          "q_count": 0,
                          });
        });
        renderItems(fq_items,$('#fq-items-dt tbody'),'forQ',$('#fq_purpose').val());
      });
      
      renderItems(qt_items, $('#q-details-dt tbody'),'quote',$('#fq_purpose').val());
      $('#resetQModal').modal('close');
    }

    const resetDetails = () => {
      var loc = $('#reset_loc').val();
      if(loc=="add"){
        if($('#add_purpose').val()=='Project')
        {
          $('#btnAdd').prop('disabled', true);
          $('#add_item_code').prop('disabled', true);
          $('#add_item_code').val("");
          $('#add_item_desc').val("");
          $('#add_quantity').prop('disabled', true);
          $('#add_quantity').val("");
          $('#add_uom_code').prop('disabled', true);
          $('#add_uom_code').formSelect();
          $('#add_assy_code').prop('disabled', true);
          $('#add_assy_code').formSelect();

          $('#add_purpose').prop('disabled', false);
          $('#add_purpose').formSelect();
          $('#add_project_code').prop('disabled', false);
          $('#add_project_code').formSelect();
 

          var set = document.getElementById('add_set');
              set.style.display = "block";
          var reset = document.getElementById('add_reset');
              reset.style.display = "none";
          var x = document.getElementById('project_details');
              x.style.display = "block";
        } else {
          $('#btnAdd').prop('disabled', true);
          $('#add_item_code').prop('disabled', true);
          $('#add_item_code').val("");
          $('#add_item_desc').val("");
          $('#add_quantity').prop('disabled', true);
          $('#add_quantity').val("");
          $('#add_uom_type').prop('disabled', true);
          $('#add_uom_type').formSelect();
          $('#add_uom_code').prop('disabled', true);
          $('#add_uom_code').formSelect();
          $('#add_assy_code').prop('disabled', false);
          $('#add_assy_code').formSelect();

          $('#add_purpose').prop('disabled', false);
          $('#add_purpose').formSelect();
          $('#add_project_code').prop('disabled', false);
          $('#add_project_code').formSelect();


          var set = document.getElementById('add_set');
              set.style.display = "block";
          var reset = document.getElementById('add_reset');
              reset.style.display = "none";
          var x = document.getElementById('project_details');
              x.style.display = "none";
        } 
        add_items = [];
        renderItems(add_items,$('#items-dt tbody'),'add');
        $('#btnAddSave').prop('disabled', true);
        $('#resetModal').modal('close');
      } else {
        if($('#edit_purpose').val()=='Project')
        {
          $('#edit_btnAdd').prop('disabled', true);
          $('#edit_item_code').prop('disabled', true);
          $('#edit_quantity').prop('disabled', true);
          $('#edit_uom_type').prop('disabled', true);
          $('#edit_uom_type').formSelect();
          $('#edit_uom_code').prop('disabled', true);
          $('#edit_uom_code').formSelect();

          $('#edit_purpose').prop('disabled', false);
          $('#edit_purpose').formSelect();
          
          $('#edit_project_code').prop('disabled', false);
          $('#edit_project_code').formSelect();
          $('#edit_assy_code').prop('disabled', false);
          $('#edit_assy_code').formSelect();

          var set = document.getElementById('edit_set');
              set.style.display = "block";
          var reset = document.getElementById('edit_reset');
              reset.style.display = "none";
          var x = document.getElementById('edit_project_details');
              x.style.display = "block";
          $('#btnEditSave').prop('disabled', false);
          $('#resetModal').modal('close');
        } else {
          $('#edit_btnAdd').prop('disabled', true);
          $('#edit_item_code').prop('disabled', true);
          $('#edit_quantity').prop('disabled', true);
          $('#edit_uom_type').prop('disabled', true);
          $('#edit_uom_type').formSelect();
          $('#edit_uom_code').prop('disabled', true);
          $('#edit_uom_code').formSelect();

          $('#edit_purpose').prop('disabled', false);
          $('#edit_purpose').formSelect();

          $('#edit_project_code').prop('disabled', false);
          $('#edit_project_code').formSelect();
          $('#edit_assy_code').prop('disabled', false);
          $('#edit_assy_code').formSelect();

          var set = document.getElementById('edit_set');
              set.style.display = "block";
          var reset = document.getElementById('edit_reset');
              reset.style.display = "none";
          var x = document.getElementById('edit_project_details');
              x.style.display = "none";
          $('#btnEditSave').prop('disabled', false);
          $('#resetModal').modal('close');
        }
      }
    };

    const resetItemDetails = (loc) => {
      if(loc=="add"){
        $('#add_delivery_date').val("");

        if($('#purpose').val() == "Project"){
          $('#add_assy_code').val(""); 
          $('#add_assy_code').formSelect();
        } 
      
        $('#add_item_code').val("");
        $('#add_item_desc').val("");
        $('#add_quantity').val("");

        $('#add_uom_code').val("");
        $('#add_uom_code').formSelect();

      } else {
        $('#edit_delivery_date').val("");

        if($('#purpose_edit').val() == "Project"){
          $('#edit_assy_code').val(""); 
          $('#edit_assy_code').formSelect();
        } 

        $('#edit_item_code').val("");
        $('#edit_item_desc').val("");
        $('#edit_quantity').val("");
 
        $('#edit_uom_code').val("");
        $('#edit_uom_code').formSelect();
      }
    };

    const resetCollection = () => {
      $('#item_vendor').val("");
      $('#item_vendor').formSelect();
      $('#item_currency_code').val("");
      $('#item_currency_code').formSelect();
      
      $('#item_ven_delivery').val("");
      $('#item_lead_time').html("Lead Time: 0 day(s)");

      $('#item_spq').val("");
      $('#item_moq').val("");
      $('#item_unit_price').val("");
      $('#item_total_price').val(0);

      $('#btnQReset').prop('disabled', true);
      $('#btnQSave').prop('disabled', true);
      $('#resetColModal').modal('close');
    };

    const resetColDetails = () => {
      $('#resetColModal').modal('open');
    };

    const resetIss = () => {
      status = $('#issue_status').val();
      rfq_code = $('#issue_rfq_code').val();
      iss_items = [];
      iss_list = []
      all_iss_items = [];
      $.get('list/'+trim($('#issue_rfq_code').val())+'/items', (response) => {
          var datax = response.data;
          console.log(datax);
          $.each(datax, (index, row) => {
            if (row.status == 'Pending') {
              iss_items.push({"trans_code": trim($('#issue_rfq_code').val()),
                          "item_code": row.item_code,
                          "item_desc": row.item_details.item_desc,
                          "uom_code": row.uom_code,
                          "iss_uom": "",
                          "req_qty": row.quantity,
                          "rem_qty": 0, // must be requested quantity - issued quantity
                          "iss_qty": 0, // summary of issued quantity Status: Issued with Pending
                          "tbi_qty": 0,
                          "conv_id": 0,
                          "status": row.status,
                          "iss_date": row.trans_date,
                          "is_check": false,
                          "inventory_location": row.inventory_location_code,
                          });
            } else if(row.status == 'Issued') {
              iss_items.push({"trans_code": trim($('#issue_rfq_code').val()),
                          "item_code": row.item_code,
                          "item_desc": row.item_details.item_desc,
                          "uom_code": row.uom_code,
                          "req_qty": row.quantity,
                          "rem_qty": 0, 
                          "iss_qty": row.quantity,
                          "tbi_qty": 0,
                          "status": row.status,
                          "is_check": false,
                          "inventory_location": row.inventory_location_code,
                          });
            } else if(row.status == 'Issued with Pending') {
              iss_list.push({"trans_code": trim($('#issue_rfq_code').val()),
                          "item_code": row.item_code,
                          "item_desc": row.item_details.item_desc,
                          "req_qty": row.quantity,
                          "uom_code": row.uom_code,
                          "rem_qty": row.rem_qty,
                          "iss_qty": row.quantity,
                          "tbi_qty": 0,
                          "status": row.status,
                          "iss_date": row.trans_date,
                          "is_check": false,
                          "inventory_location": row.inventory_location_code,
                        });
            }
          });

          if(status=="Approved"){
            renderItems(iss_items,$('#issue-items-dt tbody'),'issue');
            renderItems(iss_list,$('#issued-items-dt tbody'),'issued_items');
          } else {
            $.get('list/'+rfq_code+'/items_issued', (response) => {
              var datax = response.data;
              $.each(datax, (index, row) => {
                all_iss_items.push({"item_code": row.item_code,
                                  "iss_qty": row.issued_qty, 
                                  "iss_uom": row.uom_code,
                                  "conv_id": row.uom_conv_id,
                });
              });
 
              iss_items.forEach(item => {
                var issued = all_iss_items.filter(item2 => item2.item_code == item.item_code);
                var issue_qty = 0;
                for (let index = 0; index < issued.length; index++) {

                  if(issued.length > 0)
                  {
                    if(issued[index].conv_id != null){
                      if(issued[index].iss_uom == item.uom_code){

                        $.get('../uom_conversion/conv_values/'+issued[index].conv_id, (response) => { 
                          var value_to = response.data.uom_to_value;
                          var converted_value = parseFloat(issued[index].iss_qty) / parseFloat(value_to);
                          
                          issue_qty = issue_qty + (value_to * converted_value);
                          item.conv_id = issued[0].conv_id;
                          item.rem_qty = parseFloat(item.req_qty) - parseFloat(issue_qty);
                          renderItems(iss_items,$('#issue-items-dt tbody'),'issue');
                        });

                      } else {

                        $.get('../uom_conversion/rev_convert/'+issued[index].iss_uom+'/'+item.uom_code, (response) => { 
                          var value_to = response.data.uom_to_value;
                          var converted_value = parseFloat(issued[index].iss_qty) * parseFloat(value_to);

                          issue_qty = issue_qty + converted_value;
                          item.conv_id = issued[0].conv_id;
                          item.rem_qty = parseFloat(item.req_qty) - parseFloat(issue_qty);
                          renderItems(iss_items,$('#issue-items-dt tbody'),'issue');
                        });

                      }

                    } else {
                      renderItems(iss_items,$('#issue-items-dt tbody'),'issue');
                    }
                  }
                }
              });
              renderItems(iss_list,$('#issued-items-dt tbody'),'issued_items');
            });
          };
 
          $('#btnIssue').prop('disabled', true);
          $('#btnResetQ').prop('disabled', true);
          $('#resetIssModal').modal('close');
        });
    };

    const resetISSDetails = () => {
      $('#resetIssModal').modal('open');
    };

    const issuanceCode = (site, loc) => {
        if(loc=='add'){
          $('#add_rfq_code').val( site + '-RFQ' + newtoday + '-00' + RFQCount );
        } else {
          var str = $('#edit_rfq_code').val();
          var count = str.substr(-3, 3);
          $('#edit_rfq_code').val( site + '-RFQ' + newtoday + '-' + count);
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
      $('#btnAdd').prop('disabled', true);

      $('#add_remarks').val("");
      $('#add_purpose option[value=""]').prop('selected', true);
      $('#add_purpose').formSelect(); 

      $('#add_delivery_date').prop('disabled', true);
      $('#add_delivery_date').val("");
      $('#add_item_code').prop('disabled', true);
      $('#add_item_code').val("");
      $('#add_quantity').prop('disabled', true);
      $('#add_quantity').val("");
      $('#add_uom_type').prop('disabled', true);
      $('#add_uom_type').formSelect();
      $('#add_uom_code').prop('disabled', true);
      $('#add_uom_code').formSelect();

      $('#add_purpose').prop('disabled', false);
      $('#add_purpose').formSelect();
      $('#add_project_code').prop('disabled', false);
      $('#add_project_code').formSelect();
      $('#add_assy_code').prop('disabled', false);
      $('#add_assy_code').formSelect();

      var set = document.getElementById('add_set');
          set.style.display = "block";
      var reset = document.getElementById('add_reset');
          reset.style.display = "none";
      var project = document.getElementById('project_details');
          project.style.display = "none";

      add_items = [];
      renderItems(add_items,$('#items-dt tbody'),'add','');
      $('#btnAddSave').prop('disabled', true);
      $('#addModal').modal('open');
      loadApprover();
    };

    const cancelIss = () => {
      iss_items = [];
      iss_list = [];
      all_iss_items = [];
      $('#issueModal').modal('close');
    }

    const resetModal = (loc) => {
      $('#reset_loc').val(loc);
      $('#resetModal').modal('open');
    };

    const editRFQ = (id) => {
      edit_items = [];
      $('#editModal').modal('open');
      $('.tabs.edit').tabs('select','edit_rfq');
      $.get('rfq/'+id, (response) => {
        var data = response.data[0];
        var matrix = JSON.parse(data.matrix);
        if(matrix != null) renderSignatoriesTable(matrix,$('#edit-matrix-dt tbody'));
        $('#edit_id').val(id);
        $('#edit_rfq_code').val(data.rfq_code);
        $('#edit_remarks').val(data.remarks);
 
        $('#edit_purpose option[value="'+data.purpose+'"]').prop('selected', true);
        $('#edit_purpose').prop('disabled', false);
        $('#edit_purpose').formSelect();

        $('#edit_item_code').prop('disabled', true);
        $('#edit_item_code').val("");

        $('#edit_item_desc').prop('readonly', true);
        $('#edit_item_desc').val("");

        $('#edit_quantity').prop('disabled', true);
        $('#edit_quantity').val("");

        $('#edit_uom_code').prop('disabled', true);
        $('#edit_uom_code').formSelect();

        $('#btnEditSave').prop('disabled', true);
        $('#edit_btnAdd').prop('disabled', true);
        
        var x = document.getElementById('edit_set');
              x.style.display = "block";

        var y = document.getElementById('edit_reset');
              y.style.display = "none";

              
        
        $('#purpose_edit').val(data.purpose);
        $('#site_code_edit').val(data.site_code);
      
        if(data.purpose=='Project')
        {
          $.get('../projects/'+'{{$employee->site_code}}'+'/project',(response) => {
            var datay = response.data;
            var select = '<option value="" selected disabled>Choose your option</option>';
            $.each(datay, (index, row) => {
              select += '<option value="'+row.project_code+'">'+row.project_name+'</option>';
            }); 
            $('#edit_project_code').html(select);
            $('#edit_project_code').formSelect();
            $('#edit_project_code option[value="'+data.project_code+'"]').prop('selected', true);
            $('#edit_project_code').prop('disabled', false);
            $('#edit_project_code').formSelect();
          });

            $('#project_code_edit').val(data.project_code);
       
            var x = document.getElementById('edit_project_details');
                x.style.display = "block";

            var assy = document.getElementById('edit_assy_details');
                assy.style.display = "block";
            $('#edit_assy_code').prop('disabled', true);
            $('#edit_assy_code').formSelect();

            $('#edit-items-header').html("");
            $('#edit-items-header').append('<tr>'+
                                        '<th>ID</th>'+
                                        '<th>Assembly</th>'+
                                        '<th>Item Code</th>'+
                                        '<th>Item Description</th>'+
                                        '<th>Quantity</th>'+
                                        '<th>Unit of Measure</th>'+
                                        '<th>Delivery Date</th>'+
                                        '<th>Action</th>'+
                                      '</tr>');

            $.get('list/'+data.rfq_code+'/items_user', (response) => {
              var datax = response.data;
              $.each(datax, (index, row) => {
                edit_items.push({"assy_code": row.assy_code,
                                "item_code": row.item_code,
                                "item_desc": row.item_details.item_desc,
                                "uom_code": row.uom_code,
                                "quantity": row.required_qty,
                                "delivery_date": row.required_delivery_date,
                                });
              });
              renderItems(edit_items,$('#edit-items-dt tbody'),'edit',data.purpose);
            });

            

        } else {
            var x = document.getElementById('edit_project_details');
                x.style.display = "none";

            var assy = document.getElementById('edit_assy_details');
                assy.style.display = "none";
            $('#edit_assy_code').prop('disabled', true);
            $('#edit_assy_code').formSelect();

            $('#edit-items-header').html("");
            $('#edit-items-header').append('<tr>'+
                                        '<th>ID</th>'+
                                        '<th>Item Code</th>'+
                                        '<th>Item Description</th>'+
                                        '<th>Quantity</th>'+
                                        '<th>Unit of Measure</th>'+
                                        '<th>Delivery Date</th>'+
                                        '<th>Action</th>'+
                                      '</tr>');

            $.get('list/'+data.rfq_code+'/items_user', (response) => {
              var datax = response.data;
              $.each(datax, (index, row) => {
                edit_items.push({"item_code": row.item_code,
                                "item_desc": row.item_details.item_desc,
                                "uom_code": row.uom_code,
                                "quantity": row.required_qty,
                                "delivery_date": row.required_delivery_date,
                                });
              });
              renderItems(edit_items,$('#edit-items-dt tbody'),'edit',data.purpose);
            });
        }


      });
    };

    const viewRFQ = (id) => {
      view_items = [];
      view_qt = [];
      $('#viewModal').modal('open');
      $('.tabs.view').tabs('select','view_rfq_details');
      $.get('rfq/'+id, (response) => {
        var data = response.data[0];
        var matrix = JSON.parse(data.matrix);
        var matrix_h = JSON.parse(data.matrix_h);
        if(matrix != null) renderSignatoriesTable(matrix,$('#view-matrix-dt tbody'));
        if(matrix_h != null) renderSignatoriesTable(matrix_h,$('#view-matrix-dt-h tbody'),true);

        $('#view_rfq_code').val(data.rfq_code);
        $('#view_date_requested').val(data.date_requested);
        $('#view_purpose').val(data.purpose);
        $('#view_remarks').val(data.remarks);

        if(data.purpose=='Project')
        {
          $('#view_project_code').val(data.projects.project_name);
          var x = document.getElementById('view_project_details');
              x.style.display = "block";

          $('#view-items-header').html("");
          $('#view-items-header').append('<tr>'+
                                        '<th>ID</th>'+
                                        '<th>Assembly</th>'+
                                        '<th>Item Code</th>'+
                                        '<th>Item Description</th>'+
                                        '<th>Quantity</th>'+
                                        '<th>Unit of Measure</th>'+
                                        '<th>Delivery Date</th>'+
                                        '</tr>');

          $.get('list/'+data.rfq_code+'/items_user', (response) => {
            var datax = response.data;
              $.each(datax, (index, row) => {
                view_items.push({"assy_code": row.assy_code,
                                "item_code": row.item_code,
                                "item_desc": row.item_details.item_desc,
                                "uom_code": row.uoms.uom_code,
                                "uom_name": row.uoms.uom_name,
                                "quantity": row.required_qty,
                                "delivery_date": row.required_delivery_date,
                                });
            });
            renderItems(view_items,$('#view-items-dt tbody'),'view',data.purpose);
          });
        } else {
          var x = document.getElementById('view_project_details');
              x.style.display = "none";
          
          $('#view-items-header').html("");
          $('#view-items-header').append('<tr>'+
                                        '<th>ID</th>'+
                                        '<th>Item Code</th>'+
                                        '<th>Item Description</th>'+
                                        '<th>Quantity</th>'+
                                        '<th>Unit of Measure</th>'+
                                        '<th>Delivery Date</th>'+
                                        '</tr>');
          
          $.get('list/'+data.rfq_code+'/items_user', (response) => {
            var datax = response.data;
              $.each(datax, (index, row) => {
                view_items.push({"item_code": row.item_code,
                                "item_desc": row.item_details.item_desc,
                                "uom_code": row.uoms.uom_code,
                                "uom_name": row.uoms.uom_name,
                                "quantity": row.required_qty,
                                "delivery_date": row.required_delivery_date,
                                });
            });
            renderItems(view_items,$('#view-items-dt tbody'),'view',data.purpose);
          });
        }

        if(data.status!='Pending'){
          var quote_list = document.getElementById('view_quote_list');
              quote_list.style.display = "block";

          $('#view-quote-header').html("");
          $('#view-quote-header').append('<tr>'+
                                        '<th>ID</th>'+
                                        '<th>Vendor</th>'+
                                        '<th>Item Code</th>'+
                                        '<th>SPQ</th>'+
                                        '<th>MOQ</th>'+
                                        '<th>Lead Time</th>'+
                                        '<th>Currency</th>'+
                                        '<th>Unit Price</th>'+
                                        '<th>Total Price</th>'+
                                        '</tr>');
          

          $.get('list/'+data.rfq_code+'/items_purch', (response) => {
            var datax = response.data;
              $.each(datax, (index, row) => {
                view_qt.push({"ven_name": row.ven_details.ven_name,
                              "item_code": row.item_code,
                              "spq": row.spq,
                              "moq": row.moq,
                              "leadtime": row.leadtime,
                              "currency_name": row.currency.currency_name,
                              "symbol": row.currency.symbol,
                              "unit_price": row.unit_price,
                              "total_price": row.total_price,
                                });
            });
            renderItems(view_qt,$('#view-quote-dt tbody'),'quote_view',data.purpose);
          });
          
        } else {
          var quote_list = document.getElementById('view_quote_list');
              quote_list.style.display = "none";
        }


      });
    };

    const appRFQ = (id) => {
      app_items = [];
      rev_quote = [];
      $('#appModal').modal('open');
      $('.tabs.app').tabs('select','app_rfq');
      $.get('rfq/'+id, (response) => {
        var data = response.data[0];
        var matrix = JSON.parse(data.matrix);
        var matrix_h = JSON.parse(data.matrix_h);
        if(matrix != null) renderSignatoriesTable(matrix,$('#app-matrix-dt tbody'));
        if(matrix_h != null) renderSignatoriesTable(matrix_h,$('#app-matrix-dt-h tbody'),true);
 
        $('#app_id').val(data.id);
        $('#app_rfq_code').val(data.rfq_code);
        $('#app_date_requested').val(data.date_requested);
        $('#app_purpose').val(data.purpose);
        $('#app_remarks').val(data.remarks);

        if(data.purpose=='Project')
        {
          $('#app_project_code').val(data.projects.project_name);
          var x = document.getElementById('app_project_details');
              x.style.display = "block";

          $('#app-items-header').html("");
          $('#app-items-header').append('<tr>'+
                                        '<th>ID</th>'+
                                        '<th>Assembly</th>'+
                                        '<th>Item Code</th>'+
                                        '<th>Item Description</th>'+
                                        '<th>Quantity</th>'+
                                        '<th>Unit of Measure</th>'+
                                        '<th>Delivery Date</th>'+
                                        '</tr>');

          $.get('list/'+data.rfq_code+'/items_user', (response) => {
            var datax = response.data;
              $.each(datax, (index, row) => {
                app_items.push({"assy_code": row.assy_code,
                                "item_code": row.item_code,
                                "item_desc": row.item_details.item_desc,
                                "uom_code": row.uoms.uom_code,
                                "uom_name": row.uoms.uom_name,
                                "quantity": row.required_qty,
                                "delivery_date": row.required_delivery_date,
                                });
            });
            renderItems(app_items,$('#app-items-dt tbody'),'view',data.purpose);
          });
        } else {
          var x = document.getElementById('app_project_details');
              x.style.display = "none";
          
          $('#app-items-header').html("");
          $('#app-items-header').append('<tr>'+
                                        '<th>ID</th>'+
                                        '<th>Item Code</th>'+
                                        '<th>Item Description</th>'+
                                        '<th>Quantity</th>'+
                                        '<th>Unit of Measure</th>'+
                                        '<th>Delivery Date</th>'+
                                        '</tr>');
          
          $.get('list/'+data.rfq_code+'/items_user', (response) => {
            var datax = response.data;
              $.each(datax, (index, row) => {
                app_items.push({"item_code": row.item_code,
                                "item_desc": row.item_details.item_desc,
                                "uom_code": row.uoms.uom_code,
                                "uom_name": row.uoms.uom_name,
                                "quantity": row.required_qty,
                                "delivery_date": row.required_delivery_date,
                                });
            });
            renderItems(app_items,$('#app-items-dt tbody'),'view',data.purpose);
          });
        }

        $.get('list/'+data.rfq_code+'/items_purch', (response) => {

            var datax = response.data;
              $.each(datax, (index, row) => {
                rev_quote.push({"ven_name": row.ven_details.ven_name,
                              "item_code": row.item_code,
                              "spq": row.spq,
                              "moq": row.moq,
                              "leadtime": row.leadtime,
                              "currency_name": row.currency.currency_name,
                              "symbol": row.currency.symbol,
                              "unit_price": row.unit_price,
                              "total_price": row.total_price,
                                });
            });
            renderItems(rev_quote,$('#app-quote-items-dt tbody'),'quote_view',data.purpose);
        });


      });
    };

    const forQuotation = (id) => {
      fq_items = [];
      qt_items = [];
      $('#forQModal').modal('open');
      $('.tabs.view').tabs('select','fq_rfq_details');
      $.get('rfq/'+id, (response) => {
        var data = response.data[0];
        var matrix = JSON.parse(data.matrix);
        var matrix_h = JSON.parse(data.matrix_h);
        if(matrix != null) renderSignatoriesTable(matrix,$('#fq-matrix-dt tbody'));
        if(matrix_h != null) renderSignatoriesTable(matrix_h,$('#fq-matrix-dt-h tbody'),true);

        $('#fq_rfq_code').val(data.rfq_code);
        $('#fq_date_requested').val(data.date_requested);
        $('#fq_purpose').val(data.purpose);
        $('#fq_remarks').val(data.remarks);
        $('#btnQReset').prop('disabled', true);
        $('#btnQSave').prop('disabled', true);

        if(data.purpose=='Project')
        {
          $('#fq_project_code').val(data.projects.project_name);
          var x = document.getElementById('fq_project_details');
              x.style.display = "block";

          $('#fq-items-header').html("");
          $('#fq-items-header').append('<tr>'+
                                        '<th>ID</th>'+
                                        '<th>Assembly</th>'+
                                        '<th>Item Code</th>'+
                                        '<th>Item Description</th>'+
                                        '<th>Quantity</th>'+
                                        '<th>Unit of Measure</th>'+
                                        '<th>Required Delivery Date</th>'+
                                        '<th>Quote Count</th>'+
                                        '<th>Action</th>'+
                                        '</tr>');

          $.get('list/'+data.rfq_code+'/items_user', (response) => {
            var datax = response.data;
              $.each(datax, (index, row) => {
                fq_items.push({"assy_code": row.assy_code,
                                "item_code": row.item_code,
                                "item_desc": row.item_details.item_desc,
                                "uom_code": row.uoms.uom_code,
                                "uom_name": row.uoms.uom_name,
                                "quantity": row.required_qty,
                                "delivery_date": row.required_delivery_date,
                                "status": row.rfq_status ? row.rfq_status.status : 0,
                                "q_count": 0,
                                });
            });
            renderItems(fq_items,$('#fq-items-dt tbody'),'forQ',data.purpose);
          });
        } else {
          var x = document.getElementById('fq_project_details');
              x.style.display = "none";
          
          $('#fq-items-header').html("");
          $('#fq-items-header').append('<tr>'+
                                        '<th>ID</th>'+
                                        '<th>Item Code</th>'+
                                        '<th>Item Description</th>'+
                                        '<th>Quantity</th>'+
                                        '<th>Unit of Measure</th>'+
                                        '<th>Required Delivery Date</th>'+
                                        '<th>Quote Count</th>'+
                                        '<th>Action</th>'+
                                        '</tr>');
          
          $.get('list/'+data.rfq_code+'/items_user', (response) => {
            var datax = response.data;
              $.each(datax, (index, row) => {
                fq_items.push({"item_code": row.item_code,
                                "item_desc": row.item_details.item_desc,
                                "uom_code": row.uoms.uom_code,
                                "uom_name": row.uoms.uom_name,
                                "quantity": row.required_qty,
                                "delivery_date": row.required_delivery_date,
                                "status": row.rfq_status ? row.rfq_status.status : 0,
                                "q_count": 0,
                                });
            });
            renderItems(fq_items,$('#fq-items-dt tbody'),'forQ',data.purpose);
          });
        }

        renderItems(qt_items, $('#q-details-dt tbody'),'quote',$('#fq_purpose').val());
        // $('#fq_grand_total').val("");

      });
    };

    const quoteDet = (rfq_code, item_code, item_desc, assy_code, uom_code, required_qty, req_del_date, id, status) => {

      $('#item_id').val(id);
      $('#item_rfq_code').val(rfq_code);

      if(assy_code != ""){
        var assy = document.getElementById('item_assy');
            assy.style.display = "block";
        $('#item_assy_code').val(assy_code);
      } else {
        var assy = document.getElementById('item_assy');
            assy.style.display = "none";
        $('#item_assy_code').val("");
      }

      $('#item_item_code').val(item_code);
      $('#item_item_desc').val(item_desc);

      $('#item_uom_code').val(uom_code);
      $('#item_req_qty').val(required_qty);
      $('#item_req_del').val(req_del_date);

      $('#item_vendor').val("");
      $('#item_vendor').formSelect();
      $('#item_currency_code').val("");
      $('#item_currency_code').formSelect();
      
      $('#item_ven_delivery').val("");
      $('#item_lead_time').html("Lead Time: 0 day(s)");

      $('#item_spq').val("");
      $('#item_moq').val("");
      $('#item_unit_price').val("");
      $('#item_total_price').val(0);

      $('#btnQReset').prop('disabled', true);
      $('#btnQSave').prop('disabled', true);
      $('#QdetModal').modal('open');
    
    };

    const quoteCan = () => {
      var id = parseInt($('#item_id').val()) - 1;
      var status = $('#item_status').val();

      fq_items[id].status = 0;
      renderItems(fq_items,$('#fq-items-dt tbody'),'forQ',$('#fq_purpose').val());
      $('#QdetModal').modal('close');
    };

    const quoteSave = () => {
      
      Array.prototype.sum = function (prop) {
          var total = 0
          for ( var i = 0, _len = this.length; i < _len; i++ ) {
              total += this[i][prop]
          }
          return total
      }
      
      if($('#item_vendor').val() && 
         $('#item_currency_code').val() &&
        trim($('#item_ven_delivery').val()) &&
        trim($('#item_spq').val()) &&
        trim($('#item_moq').val()) &&
        trim($('#item_unit_price').val()))
        {
          var id = parseInt($('#item_id').val()) - 1;
          var status = $('#item_status').val();
          var found = false;
          var cindex = 0;
          
          var foundx = false;
          var xindex = 0;

          var req_quote = fq_items.length * 3;
          var curr_quote = 0;

          fq_items[id].status = 1;
          // renderItems(fq_items,$('#fq-items-dt tbody'),'forQ',$('#fq_purpose').val());

          $.each(qt_items,(index,row) => {
            if(row.item_code == $('#item_item_code').val() && row.ven_code == $('#item_vendor').val()){
              cindex = index;
              found = true;
              return false;
            }
          });

          if(found){
            alert("You're not allowed to add multiple quotation on same item and vendor!");
          } else {
            qt_items.push({"index_id": $('#item_id').val(),
                        "rfq_code" : $('#item_rfq_code').val(),
                        "assy_code" : $('#item_assy_code').val() ? $('#item_assy_code').val() : "",
                        "item_code" : $('#item_item_code').val(),
                        "uom_code" : $('#item_uom_code').val(),
                        "required_qty" : $('#item_req_qty').val(),
                        "required_delivery_date" : $('#item_req_del').val(),
                        "status" : 1,
                        "ven_code" : $('#item_vendor').val(),
                        "ven_name" : $('#item_vendor option:selected').text(),
                        "spq" : $('#item_spq').val(),
                        "moq" : $('#item_moq').val(),
                        "ven_delivery" : $('#item_ven_delivery').val(),
                        "leadtime" : $('#item_lead_days').val(),
                        "currency_code" : $('#item_currency_code').val(),
                        "currency_name" : $('#item_currency_code option:selected').text(),
                        "symbol" : $('#item_currency_code option:selected').text().split(" - ")[0],
                        "unit_price" : $('#item_unit_price').val(),
                        "total_price" : $('#item_total_price').val(),
                        });

                        $.each(fq_items,(index,row) => {
                          if(row.item_code == $('#item_item_code').val()){
                              xindex = index;
                              foundx = true;
                              return false;
                          }
                        });
                        
                        if(foundx){
                          fq_items[xindex].q_count =  fq_items[xindex].q_count + 1;
                        }
                        
                        // curr_quote = curr_quote + row.q_count;
                        console.log(fq_items.sum("q_count"));
                        console.log(req_quote);

                        if(parseInt(fq_items.sum("q_count")) >= parseInt(req_quote))
                        {
                          $('#btnResetQ').prop('disabled', false); $('#btnSaveQ').prop('disabled', false); 
                        } else {
                          $('#btnResetQ').prop('disabled', true); $('#btnSaveQ').prop('disabled', true); 
                        }
            
                        renderItems(fq_items,$('#fq-items-dt tbody'),'forQ',$('#fq_purpose').val());
          }

          renderItems(qt_items, $('#q-details-dt tbody'),'quote',$('#fq_purpose').val());
          // computeGrandTotal($('#item_currency_code option:selected').text().split(" - ")[0],qt_items,$('#fq_grand_total'));
          $('#QdetModal').modal('close');
        } else {
          alert("Please fill-up all details before saving!")
        }
    };

    const saveQuote = () => {
      document.getElementById("quote_form").submit();
      $('#btnSaveQ').prop('disabled', true);
    };
    
    const cancelQuote = () => {
      //
    };

    const loadApprover = () => {
      $.get('../approver/{{Auth::user()->emp_no}}/RFQ/my_matrix', (response) => {
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

    const renderItems = (items, table, loc, purpose) => {

      table.html("");
      $.each(items, (index, row) => {
        var id = parseInt(index) + 1;
        if(loc=='add'){

          if(purpose=='Project'){
            table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.assy_code+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td class="left-align">'+row.uom_code+'</td>'+
                      '<td class="left-align">'+row.delivery_date+'</td>'+
                      '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="deleteItem(\''+index+'\',\'add\')"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                      '<input type="hidden" name="itm_delivery_date[]" value="'+row.delivery_date+'"/>'+
                      '<input type="hidden" name="itm_assy_code[]" value="'+row.assy_code+'"/>'+
                      '<input type="hidden" name="itm_item_code[]" value="'+row.item_code+'"/>'+
                      '<input type="hidden" name="itm_quantity[]" value="'+row.quantity+'"/>'+
                      '<input type="hidden" name="itm_uom_code[]" value="'+row.uom_code+'"/>'+
                      '</tr>'
                    );
          } else {
            table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td class="left-align">'+row.uom_code+'</td>'+
                      '<td class="left-align">'+row.delivery_date+'</td>'+
                      '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="deleteItem(\''+index+'\',\'add\')"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                      '<input type="hidden" name="itm_delivery_date[]" value="'+row.delivery_date+'"/>'+
                      '<input type="hidden" name="itm_item_code[]" value="'+row.item_code+'"/>'+
                      '<input type="hidden" name="itm_quantity[]" value="'+row.quantity+'"/>'+
                      '<input type="hidden" name="itm_uom_code[]" value="'+row.uom_code+'"/>'+
                      '</tr>'
                    );
          }
          if(items.length > 0){
            $('#btnAddSave').prop('disabled', false);
          };

        } else if (loc=='edit'){
          
          if(purpose=='Project'){
            table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.assy_code+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td class="left-align">'+row.uom_code+'</td>'+
                      '<td class="left-align">'+row.delivery_date+'</td>'+
                      '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="deleteItem(\''+index+'\',\'edit\')"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                      '<input type="hidden" name="e_itm_delivery_date[]" value="'+row.delivery_date+'"/>'+
                      '<input type="hidden" name="e_itm_assy_code[]" value="'+row.assy_code+'"/>'+
                      '<input type="hidden" name="e_itm_item_code[]" value="'+row.item_code+'"/>'+
                      '<input type="hidden" name="e_itm_quantity[]" value="'+row.quantity+'"/>'+
                      '<input type="hidden" name="e_itm_uom_code[]" value="'+row.uom_code+'"/>'+
                      '</tr>'
                    );
          } else {
            table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td class="left-align">'+row.uom_code+'</td>'+
                      '<td class="left-align">'+row.delivery_date+'</td>'+
                      '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="deleteItem(\''+index+'\',\'edit\')"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                      '<input type="hidden" name="e_itm_delivery_date[]" value="'+row.delivery_date+'"/>'+
                      '<input type="hidden" name="e_itm_item_code[]" value="'+row.item_code+'"/>'+
                      '<input type="hidden" name="e_itm_quantity[]" value="'+row.quantity+'"/>'+
                      '<input type="hidden" name="e_itm_uom_code[]" value="'+row.uom_code+'"/>'+
                      '</tr>'
                    );
          }

        } else if (loc=='forQ'){

          if(purpose=='Project'){
            table.append('<tr>'+
              '<td class="left-align">'+id+'</td>'+
              '<td class="left-align">'+row.assy_code+'</td>'+
              '<td class="left-align">'+row.item_code+'</td>'+
              '<td class="left-align">'+row.item_desc+'</td>'+
              '<td class="left-align">'+row.quantity+'</td>'+
              '<td class="left-align">'+row.uom_code+' - '+row.uom_name+'</td>'+
              '<td class="left-align">'+row.delivery_date+'</td>'+
              '<td class="left-align">'+row.q_count+'</td>'+
              '<td class="left-align"><p><label><i id="'+id+'" class="green-text material-icons" onclick="quoteDet(\''+$('#fq_rfq_code').val()+'\',\''+row.item_code+'\',\''+row.item_desc+'\',\''+row.assy_code+'\',\''+row.uom_code+'\',\''+row.quantity+'\',\''+row.delivery_date+'\',\''+id+'\',\''+row.status+'\')">note_add</i></label></p></td>'+
              '</tr>'
            );
          } else {
            table.append('<tr>'+
              '<td class="left-align">'+id+'</td>'+
              '<td class="left-align">'+row.item_code+'</td>'+
              '<td class="left-align">'+row.item_desc+'</td>'+
              '<td class="left-align">'+row.quantity+'</td>'+
              '<td class="left-align">'+row.uom_code+' - '+row.uom_name+'</td>'+
              '<td class="left-align">'+row.delivery_date+'</td>'+
              '<td class="left-align">'+row.q_count+'</td>'+
              '<td class="left-align"><p><label><i id="'+id+'" class="green-text material-icons" onclick="quoteDet(\''+$('#fq_rfq_code').val()+'\',\''+row.item_code+'\',\''+row.item_desc+'\',\''+""+'\',\''+row.uom_code+'\',\''+row.quantity+'\',\''+row.delivery_date+'\',\''+id+'\',\''+row.status+'\')">note_add</i></label></p></td>'+
              '</tr>'
            );
          }

        } else if (loc=='quote'){
          table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.ven_name+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.spq+'</td>'+
                      '<td class="left-align">'+row.moq+'</td>'+
                      '<td class="left-align">'+row.leadtime+" days(s)"+'</td>'+
                      '<td class="left-align">'+row.currency_name+'</td>'+
                      '<td class="left-align">'+row.symbol+" "+row.unit_price+'</td>'+
                      '<td class="left-align">'+row.total_price+'</td>'+
 
                      '<input type="hidden" name="qt_rfq_code[]" value="'+row.rfq_code+'"/>'+
                      '<input type="hidden" name="qt_assy_code[]" value="'+row.assy_code+'"/>'+
                      '<input type="hidden" name="qt_item_code[]" value="'+row.item_code+'"/>'+
                      '<input type="hidden" name="qt_uom_code[]" value="'+row.uom_code+'"/>'+
                      '<input type="hidden" name="qt_required_qty[]" value="'+row.required_qty+'"/>'+
                      '<input type="hidden" name="qt_required_delivery_date[]" value="'+row.required_delivery_date+'"/>'+
                      '<input type="hidden" name="qt_status[]" value="'+row.status+'"/>'+
                      '<input type="hidden" name="qt_ven_code[]" value="'+row.ven_code+'"/>'+
                      '<input type="hidden" name="qt_spq[]" value="'+row.spq+'"/>'+
                      '<input type="hidden" name="qt_moq[]" value="'+row.moq+'"/>'+
                      '<input type="hidden" name="qt_ven_delivery[]" value="'+row.ven_delivery+'"/>'+
                      '<input type="hidden" name="qt_leadtime[]" value="'+row.leadtime+'"/>'+
                      '<input type="hidden" name="qt_currency_code[]" value="'+row.currency_code+'"/>'+
                      '<input type="hidden" name="qt_unit_price[]" value="'+row.unit_price+'"/>'+
                      '<input type="hidden" name="qt_total_price[]" value="'+row.total_price+'"/>'+
                      '</tr>'
                    );
          
          // if(items.length > 0){ 
          //   $('#btnResetQ').prop('disabled', false); $('#btnSaveQ').prop('disabled', false); 
          // } else {
          //   $('#btnResetQ').prop('disabled', true); $('#btnSaveQ').prop('disabled', true); 
          // }

        } else if (loc=='quote_view'){
          table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.ven_name+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.spq+'</td>'+
                      '<td class="left-align">'+row.moq+'</td>'+
                      '<td class="left-align">'+row.leadtime+" days(s)"+'</td>'+
                      '<td class="left-align">'+row.currency_name+'</td>'+
                      '<td class="left-align">'+row.symbol+" "+row.unit_price+'</td>'+
                      '<td class="left-align">'+row.symbol+" "+row.total_price+'</td>'+
                      '</tr>');
        } else {
          if(purpose=='Project'){
            table.append('<tr>'+
                    '<td class="left-align">'+id+'</td>'+
                    '<td class="left-align">'+row.assy_code+'</td>'+
                    '<td class="left-align">'+row.item_code+'</td>'+
                    '<td class="left-align">'+row.item_desc+'</td>'+
                    '<td class="left-align">'+row.quantity+'</td>'+
                    '<td class="left-align">'+row.uom_code+' - '+row.uom_name+'</td>'+
                    '<td class="left-align">'+row.delivery_date+'</td>'+
                    '</tr>'
                  );
          } else {
            table.append('<tr>'+
                    '<td class="left-align">'+id+'</td>'+
                    '<td class="left-align">'+row.item_code+'</td>'+
                    '<td class="left-align">'+row.item_desc+'</td>'+
                    '<td class="left-align">'+row.quantity+'</td>'+
                    '<td class="left-align">'+row.uom_code+' - '+row.uom_name+'</td>'+
                    '<td class="left-align">'+row.delivery_date+'</td>'+
                    '</tr>'
                  );
          }
        }
      });
    };

    const removeItem = () => {
        var index = $('#del_index').val();
        var item_index = $('#del_item_index').val();
        var loc = $('#del_loc').val();
        if(loc == 'add'){

          add_items.splice(index,1);
          renderItems(add_items,$('#items-dt tbody'),'add',$('#purpose').val());
          $('#removeItemModal').modal('close');
          if(add_items.length  == 0 ){ $('#btnAddSave').prop('disabled', true); } else { $('#btnAddSave').prop('disabled', false); }

        } else {

          edit_items.splice(index,1);
          renderItems(edit_items,$('#edit-items-dt tbody'),'edit',$('#edit_purpose').val());
          $('#removeItemModal').modal('close');
          console.log(edit_items.length);
          if(edit_items.length  == 0 ){ $('#btnEditSave').prop('disabled', true); } else { $('#btnEditSave').prop('disabled', false); }

        }
    };

    const deleteItem = (index,loc,item_index) => {
      $('#del_index').val(index);
      $('#del_loc').val(loc);
      $('#del_item_index').val(item_index);
      $('#removeItemModal').modal('open');
    };

    const addItem = (loc, item_qty = 0, purpose) => {
      var found = false;
      var cindex = 0;
      if(loc=='add')
      {
        if($('#add_quantity').val() <= 0){
          alert('Quantity must be greater than 0!');
        }else{
          if(purpose == 'Project'){
            $.each(add_items,(index,row) => {
              if(row.item_code == $('#add_item_code').val() && row.assy_code == $('#add_assy_code').val()){
                cindex = index;
                found = true;
                return false;
              }
            });
            if(found){
              var itm_qtys = parseInt(item_qty) + parseInt(add_items[cindex].quantity);
              add_items[cindex].quantity = parseInt(add_items[cindex].quantity) + parseInt($('#add_quantity').val());
              add_items[cindex].uom_code = $('#add_uom_code').val();

              renderItems(add_items,$('#items-dt tbody'),'add',purpose);
              resetItemDetails("add");
            }else{
              add_items.push({"delivery_date": $('#add_delivery_date').val(),
                              "assy_code": $('#add_assy_code').val(),
                              "item_code": $('#add_item_code').val(),
                              "item_desc": $('#add_item_desc').val(),
                              "uom_code": $('#add_uom_code').val(),
                              "quantity": parseInt($('#add_quantity').val()),
                            });
              renderItems(add_items,$('#items-dt tbody'),'add',purpose);
              resetItemDetails("add");
            }
          } else {
            $.each(add_items,(index,row) => {
              if(row.item_code == $('#add_item_code').val()){
                cindex = index;
                found = true;
                return false;
              }
            });
            if(found){
              var itm_qtys = parseInt(item_qty) + parseInt(add_items[cindex].quantity);
              add_items[cindex].quantity = parseInt(add_items[cindex].quantity) + parseInt($('#add_quantity').val());
              add_items[cindex].uom_code = $('#add_uom_code').val();

              renderItems(add_items,$('#items-dt tbody'),'add',purpose);
              resetItemDetails("add");
            }else{
              add_items.push({"delivery_date": $('#add_delivery_date').val(),
                              "item_code": $('#add_item_code').val(),
                              "item_desc": $('#add_item_desc').val(),
                              "uom_code": $('#add_uom_code').val(),
                              "quantity": parseInt($('#add_quantity').val()),
                            });
              renderItems(add_items,$('#items-dt tbody'),'add',purpose);
              resetItemDetails("add");
            }
          }
        }
      } else if(loc=='edit') {
        if($('#edit_quantity').val() <= 0){
          alert('Quantity must be greater than 0!');
        }else {
          if(purpose == 'Project'){
            $.each(edit_items,(index,row) => {
              if(row.item_code == $('#edit_item_code').val() && row.assy_code == $('#edit_assy_code').val()){
                cindex = index;
                found = true;
                return false;
              }
            });
            if(found){
              var itm_qtys = parseInt(item_qty) + parseInt(edit_items[cindex].quantity);
              edit_items[cindex].quantity = parseInt(edit_items[cindex].quantity) + parseInt($('#edit_quantity').val());
              edit_items[cindex].uom_code = $('#edit_uom_code').val();

              renderItems(edit_items,$('#edit-items-dt tbody'),'edit',purpose);
              resetItemDetails("edit");
            }else{
              edit_items.push({"delivery_date": $('#edit_delivery_date').val(),
                              "assy_code": $('#edit_assy_code').val(),
                              "item_code": $('#edit_item_code').val(),
                              "item_desc": $('#edit_item_desc').val(),
                              "uom_code": $('#edit_uom_code').val(),
                              "quantity": parseInt($('#edit_quantity').val()),
                            });
              renderItems(edit_items,$('#edit-items-dt tbody'),'edit',purpose);
              resetItemDetails("edit");
            }
          } else {
            $.each(edit_items,(index,row) => {
              if(row.item_code == $('#edit_item_code').val()){
                cindex = index;
                found = true;
                return false;
              }
            });
            if(found){
              var itm_qtys = parseInt(item_qty) + parseInt(edit_items[cindex].quantity);
              edit_items[cindex].quantity = parseInt(edit_items[cindex].quantity) + parseInt($('#edit_quantity').val());
              edit_items[cindex].uom_code = $('#edit_uom_code').val();

              renderItems(edit_items,$('#edit-items-dt tbody'),'edit',purpose);
              resetItemDetails("edit");
            }else{
              edit_items.push({"delivery_date": $('#edit_delivery_date').val(),
                              "item_code": $('#edit_item_code').val(),
                              "item_desc": $('#edit_item_desc').val(),
                              "uom_code": $('#edit_uom_code').val(),
                              "quantity": parseInt($('#edit_quantity').val()),
                            });
              renderItems(edit_items,$('#edit-items-dt tbody'),'edit',purpose);
              resetItemDetails("edit");
            }

            console.log(edit_items);
          }
        }
      }
    };


  var request = $('#request-dt').DataTable({
        "processing": true,
 
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/purchasing/rfq/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}",
        "columns": [
            {  "data": "id" },

            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  @if($permission[0]["view"]==true || $permission[0]["masterlist"]==true)
                    return '<a href="#!" onclick="viewRFQ('+data+')">'+ row.rfq_code +'</a>';
                  @else
                    return row.rfq_code;
                  @endif
                }
            },

            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.purpose;
                }
            },

            { "data": "id",
                "render": function (data, type, row, meta) {
                  if(row.purpose=='Project')
                  {
                    return row.project_code;
                  } else {
                    return "";
                  }
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
                    case 'For Approval':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Approval</span>';
                      break;
                    case 'For Review':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Review</span>';
                      break;
                    case 'For User Review':
                      return  '<span class="new badge blue white-text" data-badge-caption="">For User Review</span>';
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
                    @if($permission[0]["edit"]==true || $permission[0]["masterlist"]==true)
                      return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editRFQ('+data+')"><i class="material-icons">create</i></a>';
                    @else
                      return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" disabled><i class="material-icons">create</i></a>';
                    @endif
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
        "ajax": "/api/reiss/purchasing/rfq/all_approval/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}",
        "columns": [
            {  "data": "id" },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  @if($permission[0]["view"]==true || $permission[0]["masterlist"]==true)
                    return '<a href="#!" onclick="viewRFQ('+data+')">'+ row.rfq_code; +'</a>';
                  @else
                    return row.rfq_code;
                  @endif
                }
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.employee_details.full_name;;
                }
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.purpose;
                }
            },
            { "data": "id",
                "render": function (data, type, row, meta) {
                  if(row.purpose=='Project')
                  {
                    return row.project_code;
                  } else {
                    return "";
                  }
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
                    case 'For Approval':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Approval</span>';
                      break;
                    case 'For Review':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Review</span>';
                      break;
                    case 'For User Review':
                      return  '<span class="new badge blue white-text" data-badge-caption="">For User Review</span>';
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
                  return  '<a href="#" class="btn-small blue darken3 waves-effect waves-dark" onclick="appRFQ('+data+')"><i class="material-icons">rate_review</i></a>';
                }
            },   
        ]
  });

  var forRFQ = $('#for-rfq-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/purchasing/rfq/all_for_rfq",
        "columns": [
            {  "data": "id" },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  @if($permission[0]["view"]==true || $permission[0]["masterlist"]==true)
                    return '<a href="#!" onclick="viewRFQ('+data+')">'+ row.rfq_code; +'</a>';
                  @else
                    return  row.rfq_code; 
                  @endif
                }
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.employee_details.full_name;;
                }
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.purpose;
                }
            },
            { "data": "id",
                "render": function (data, type, row, meta) {
                  if(row.purpose=='Project')
                  {
                    return row.project_code;
                  } else {
                    return "";
                  }
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
                  @if($permission[0]["masterlist"]==true)
                    return  '<a href="#" class="btn-small teal darken-1 waves-effect waves-dark" onclick="forQuotation('+data+')"><i class="material-icons">assignment</i></a>';
                  @else
                    return  '<a href="#" class="btn-small teal darken-1 waves-effect waves-dark" disabled><i class="material-icons">assignment</i></a>';
                  @endif
                }
            },   
        ]
  });
  
  var forRev = $('#for-rev-dt').DataTable({
    "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/purchasing/rfq/all_for_rev/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}",
        "columns": [
            {  "data": "id" },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  @if($permission[0]["view"]==true || $permission[0]["masterlist"]==true)
                    return '<a href="#!" onclick="viewRFQ('+data+')">'+ row.rfq_code; +'</a>';
                  @else
                    return row.rfq_code;
                  @endif
                }
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.purpose;
                }
            },
            { "data": "id",
                "render": function (data, type, row, meta) {
                  if(row.purpose=='Project')
                  {
                    return row.project_code;
                  } else {
                    return "";
                  }
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
                    case 'For Approval':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Approval</span>';
                      break;
                    case 'For Review':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Review</span>';
                      break;
                    case 'For User Review':
                      return  '<span class="new badge blue white-text" data-badge-caption="">For User Review</span>';
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
                  return  '<a href="#" class="btn-small blue darken3 waves-effect waves-dark" onclick="appRFQ('+data+')"><i class="material-icons">find_in_page</i></a>';
                }
            },   
        ]
  });

  
</script>
    <!-- End of SCRIPTS -->
@endsection