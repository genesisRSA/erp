@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Parts Preparation<i class="material-icons">arrow_forward_ios</i></span>Inventory Issuance</h4>
    </div>
  </div>
  <div class="row main-content">
    <ul id="project_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
      <li class="tab col s12 m4 l4"><a class="active" href="#Request">Request</a></li>
      <li class="tab col s12 m4 l4"><a class="active" href="#Approval">Approval</a></li>
      <li class="tab col s12 m4 l4"><a class="active" href="#Issuance">Issuance</a></li>
    </ul>

    <div id="Request" name="ongoing">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="request-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Issuance Code</th>
                    <th>Purpose</th>
                    <th>Project Code</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      
      @if($permission[0]["add"]==true)
        <a href="#!" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Inventory Issuance" onclick="openModal();"><i class="material-icons">add</i></a>
      @endif
    </div>

    <div id="Issuance" name="Issuance">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="issuance-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Issuance Code</th>
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
      
      {{-- @if($permission[0]["add"]==true)
        <a href="#!" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Inventory Issuance" onclick="openModal();"><i class="material-icons">add</i></a>
      @endif --}}
    </div>

    <div id="Approval" name="Approval">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="approval-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Issuance Code</th>
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

  </div>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('issuance.store')}}">
    @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4>Add Issuance Request</h4>
        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#issuance">Issuance Details</a></li>
           <li class="tab col s12 m4 l4"><a href="#signatories">Signatories</a></li>
        </ul><br>

        <div id="issuance" name="issuance">
          <input type="hidden" name="site_code" id="add_site_code" value="{{$employee->site_code}}">
          <div class="row"  style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="add_issuance_code" name="issuance_code" type="text" class="validate" placeholder="" value="{{$employee->site_code}}-ISS{{date('Ymd')}}-00{{$count}}" required readonly>
              <label for="issuance_code">Issuance Code<sup class="red-text"></sup></label>
            </div>
 
            <div class="input-field col s12 m6 l6">
              <input type="hidden" name="purpose" id="purpose">
              <select id="add_purpose" name="add_purpose" required>
                  <option value="" disabled selected>Choose your option</option>
                  <option value="Office Use">Office Use</option>
                  <option value="Project">Project</option>
              </select>
              <label for="add_purpose">Purpose<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row" style="display: none; margin-bottom: 0px;" id="project_details">
            <div class="input-field col s12 m6 l6">
                <input type="hidden" name="project_code" id="project_code">
                <select id="add_project_code" name="add_project_code">
                    <option value="" disabled selected>Choose your option</option>
                </select>
                <label for="add_project_code">Project Name<sup class="red-text">*</sup></label>
              </div>

              <div class="input-field col s12 m6 l6">
                <input type="hidden" name="assy_code" id="assy_code">
                <select id="add_assy_code" name="add_assy_code">
                  <option value="" disabled selected>Choose your option</option>
                </select>
                <label for="add_assy_code">Assembly Name<sup class="red-text">*</sup></label>
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
                  <table class="highlight" id="items-dt">
                    <thead>
                      <tr>
                          <th>ID</th>
                          <th>Item Code</th>
                          <th>Item Description</th>
                          <th>Quantity</th>
                          <th>Unit of Measure</th>
                          <th>Action</th>
                      </tr>
                    </thead>
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
    <form method="POST" action="{{route('issuance.patch')}}">
      @csrf
        <div class="modal-content" style="padding-bottom: 0px;">
          <h4>Edit Issuance Request</h4> 
          <input type="hidden" id="edit_id" name="id">
          <ul id="tabs-swipe-demo" class="tabs edit">
            <li class="tab col s12 m4 l4"><a class="active" href="#edit_issuance">Issuance Details</a></li>
             <li class="tab col s12 m4 l4"><a href="#edit_signatories">Signatories</a></li>
          </ul><br>
          
          <div id="edit_issuance" name="edit_issuance">
            <div class="row"  style="margin-bottom: 0px;">
              <div class="input-field col s12 m6 l6">
                <input id="edit_issuance_code" name="issuance_code" type="text" class="validate" placeholder="" value="{{$employee->site_code}}-ISS{{date('Ymd')}}-00{{$count}}" required readonly>
                <label for="issuance_code">Issuance Code<sup class="red-text">*</sup></label>
              </div>

              <div class="input-field col s12 m6 l6">
                <input type="hidden" name="purpose" id="purpose_edit">
                <select id="edit_purpose" name="edit_purpose" required>
                    <option value="" disabled selected>Choose your option</option>
                    <option value="Office Use">Office Use</option>
                    <option value="Project">Project</option>
                </select>
                <label for="edit_purpose">Purpose<sup class="red-text">*</sup></label>
              </div>
            </div>
  
            <div class="row" style="display: none; margin-bottom: 0px;" id="edit_project_details">
              <div class="input-field col s12 m6 l6">
                  <input type="hidden" name="project_code" id="project_code_edit">
                  <select id="edit_project_code" name="edit_project_code">
                      <option value="" disabled selected>Choose your option</option>
                  </select>
                  <label for="edit_project_code">Project Name<sup class="red-text">*</sup></label>
                </div>
  
                <div class="input-field col s12 m6 l6">
                  <input type="hidden" name="assy_code" id="assy_code_edit">
                  <select id="edit_assy_code" name="edit_assy_code">
                    <option value="" disabled selected>Choose your option</option>
                  </select>
                  <label for="edit_assy_code">Assembly Name<sup class="red-text">*</sup></label>
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
                      <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item Code</th>
                            <th>Item Description</th>
                            <th>Quantity</th>
                            <th>Unit of Measure</th>
                            <th>Action</th>
                        </tr>
                      </thead>
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
      <h4>Inventory Issuance Details</h4> 
      <ul id="tabs-swipe-demo" class="tabs view">
        <li class="tab col s12 m4 l4"><a class="active" href="#view_issuance">Issuance Details</a></li>
        <li class="tab col s12 m4 l4"><a href="#view_signatories">Signatories</a></li>
      </ul><br>

      <div id="view_issuance" name="view_issuance" style="margin-bottom: 0px">
        <div class="row" style="margin-bottom: 0px">
            <div class="input-field col s12 m6 l6">
              <input id="view_issuance_code" name="issuance_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Issuance Code</label>
            </div>
        {{-- </div>

        <div class="row">
            <div class="input-field col s12 m6 l6">
              <input id="view_site_code" name="site_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Site</label>
            </div> --}}

            <div class="input-field col s12 m6 l6">
              <input id="view_purpose" name="purpose" type="text" class="validate" placeholder="" readonly>
              <label class="active">Purpose</label>
            </div>
        </div>

        <div class="row" style="display: none; margin-bottom: 0px" id="view_project_details">
            <div class="input-field col s12 m6 l6">
              <input id="view_project_code" name="project_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Project</label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="view_assy_code" name="assy_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Assembly</label>
            </div>
        </div>

        <div class="row" style="margin-bottom: 0px">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight" id="view-items-dt">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Item Code</th>
                      <th>Item Description</th>
                      <th>Quantity</th>
                      <th>Unit of Measure</th>
                      <th>Status</th>
                    </tr>
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
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Issued Item(s)</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight responsive-table" id="issued-items-dt">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Item Code</th>
                      <th>Description</th>
                      <th>Unit of Measure</th>
                      <th>Issuance Qty.</th>
                      <th>Date Issued</th>
           
                    </tr>
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
    <form method="post" action="{{route('issuance.approve')}}">
    @csrf
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4>Inventory Issuance Details</h4> 
      <input type="hidden" id="app_id" name="id">
      <ul id="tabs-swipe-demo" class="tabs app">
        <li class="tab col s12 m4 l4"><a class="active" href="#app_issuance">Issuance Details</a></li>
        <li class="tab col s12 m4 l4"><a href="#app_signatories">Signatories</a></li>
      </ul><br>

      <div id="app_issuance" name="app_issuance">
        <div class="row">
            <div class="input-field col s12 m6 l6">
              <input id="app_issuance_code" name="issuance_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Issuance Code</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12 m6 l6">
              <input id="app_site_code" name="site_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Site</label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="app_purpose" name="purpose" type="text" class="validate" placeholder="" readonly>
              <label class="active">Purpose</label>
            </div>
        </div>

        <div class="row" style="display: none" id="app_project_details">
            <div class="input-field col s12 m6 l6">
              <input id="app_project_code" name="project_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Project</label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="app_assy_code" name="assy_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Assembly</label>
            </div>
        </div>

        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight" id="app-items-dt">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Item Code</th>
                      <th>Item Description</th>
                      <th>Quantity</th>
                      <th>Unit of Measure</th>
                      <th>Status</th>
                    </tr>
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
          
          <button id="btnRej" name="btnSubmit" value="Rejected" class="red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Reject&nbsp;&nbsp;&nbsp;</button>

          <a href="#!" class="modal-close orange waves-effect waves-dark btn"><i class="material-icons left">keyboard_return</i>Cancel&nbsp;&nbsp;</a>
        </div>
        
      </div>
    </div>
    </form>
  </div>

  <div id="issueModal" class="modal">
    <form method="POST" action="{{route('issuance.issue_item')}}">
      @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4  >Inventory Issuance</h4> 
        <ul id="tabs-swipe-demo" class="tabs issue">
          <li class="tab col s12 m4 l4"><a class="active" href="#issue_issuance">Issuance Details</a></li>
          <li class="tab col s12 m4 l4"><a href="#issue_signatories">Signatories</a></li>
        </ul><br>

        <div id="issue_issuance" name="issue_issuance">
          <div class="row" style="margin-bottom: 0px">
              <div class="input-field col s12 m6 l6">
                <input id="issue_issuance_code" name="issuance_code" type="text" placeholder="" readonly>
                <label class="active">Issuance Code</label>
              </div>
              
              <div class="input-field col s12 m6 l6">
                <input id="issue_requestor" name="requestor" type="text" placeholder="" readonly>
                <label class="requestor">Requestor</label>
              </div>
          </div>

          <div class="row" style="margin-bottom: 0px">
              <div class="input-field col s12 m6 l6">
                <input id="issue_site_code" name="site_code" type="text" placeholder="" readonly>
                <label class="active">Site</label>
              </div>

              <div class="input-field col s12 m6 l6">
                <input id="issue_purpose" name="purpose" type="text" placeholder="" readonly>
                <label class="active">Purpose</label>
              </div>
          </div>

          <div class="row" style="display: none; margin-bottom: 0px;" id="issue_project_details">
              <div class="input-field col s12 m6 l6">
                <input id="issue_project_code" name="project_code" type="text" placeholder="" readonly>
                <label class="active">Project</label>
              </div>

              <div class="input-field col s12 m6 l6">
                <input id="issue_assy_code" name="assy_code" type="text" placeholder="" readonly>
                <label class="active">Assembly</label>
              </div>
          </div>

          <div class="row" style="margin-bottom: 0px">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight responsive-table" id="issue-items-dt">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Item Code</th>
                        <th>Description</th>
                        <th>Unit of Measure</th>
                        <th>Requested Qty.</th>
                        <th>Pending Qty.</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
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
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Issued Item(s)</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight responsive-table" id="issued-items-dt">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Item Code</th>
                        <th>Description</th>
                        <th>Unit of Measure</th>
                        <th>Issuance Qty.</th>
                        <th>Date Issued</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="issue_signatories" name="issue_signatories">
          <div class="row" style="margin-bottom: 0px">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="issue-matrix-dt">
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

          <div class="row" style="margin-bottom: 0px">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Approval History</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="issue-matrix-dt-h">
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
            <button type="button" class="orange waves-effect waves-light btn right-align" id="btnIssReset" onclick="resetISSDetails();" disabled><i class="material-icons left">loop</i>Reset Details</button>
          </div>
          <div class="row col s12 m8 l8 right-align">
            <button class="green waves-effect waves-light btn" id="btnIssue" disabled><i class="material-icons left">check_circle</i>Issue</button>
            <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div id="issDetModal" class="modal">
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4 >Item Details To Collect</h4><br>
        <input type="hidden" name="id" id="item_id">
        <input type="hidden" name="id" id="item_trans_code">

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m4 l4">
            <input type="hidden" name="item_status" id="item_status">
            <input type="hidden" name="location_code" id="location_code">
            <input id="item_location_code" name="item_location_code" type="text"   placeholder="Click here before scanning location..">
            <label for="item_location_code">Inventory Location <sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m4 l4">
            <input id="item_location_name" name="item_location_name" type="text"  placeholder="" readonly>
            <label for="item_location_name">Location Name<sup class="red-text"></sup></label>
          </div>
        </div>

        <div id="item_details" class="row" style="margin-bottom: 0px; display:none">
            <div class="input-field col s12 m4 l4">
              <input id="item_item_code" name="item_code" type="text" placeholder="" readonly>
              <input type="hidden" id="item_cs" name="item_cs">
              <span id="item_current_stock" name="item_current_stock" class="badge" style="font-size: 12px">Current Stock: 0</span>
              <label class="active">Item Code</label>
            </div>
            <div class="input-field col s12 m4 l4">
              <input id="item_item_desc" name="item_desc" type="text" placeholder="" readonly>
              <label class="active">Item Description</label>
            </div> 
            <div class="input-field col s12 m4 l4">
              <input type="hidden" id="item_from_value" name="from_value">
              <input type="hidden" id="item_to_value" name="to_value">
              <input type="hidden" id="item_conv_id" name="conv_id">
 
              <select id="item_uom" name="item_uom">
                <option value="" disabled selected>Choose your option</option>
              </select>
              <label for="item_uom">Unit of Measure <sup class="red-text">*</sup></label>
            </div>  
        </div>

        <div id="item_qty" class="row" style="margin-bottom: 0px; display:none">
          {{-- <div class="input-field col s12 m4 l4">
            <input id="item_uom_type" name="uom_type" type="text" placeholder="" readonly>
            <label class="uom_type">Unit Type</label>
            </div>   
            <div class="input-field col s12 m4 l4">
            <select id="item_unit_convert" name="unit_convert">
              <option value="" selected disabled>Choose your option</option>
            </select>
            <label for="unit_convert">Unit Conversion<sup class="red-text">*</sup></label>
          </div> --}}

            <div class="input-field col s12 m4 l4">
              <input type="hidden" name="item_qty" id="item_item_qty">
              <span id="item_rqst_uom" class="badge green lighten-3 black-text"></span>
              <input id="item_quantity" name="quantity" type="number" placeholder="" readonly>
              <label class="active">Requested Quantity</label>
            </div>   

            <div class="input-field col s12 m4 l4">
              <span id="item_iss_uom" class="badge blue lighten-1 white-text"></span>
              <input type="hidden" id="item_uom_code" name="item_uom_code">
              <input id="item_quantity_iss" name="quantity_iss" type="number" class="validate" placeholder="0">
              <label class="active">Issuance Quantity <sup class="red-text">*</sup></label>
            </div>
        </div>

        <div id="item_pend" class="row" style="margin-bottom: 0px; display:none">
    

            <div class="input-field col s12 m4 l4">
              <input type="hidden" name="item_qty_rem" id="item_qty_rem">
              <span id="item_qty_uom" class="badge amber lighten-3 black-text"></span>
              <input id="item_quantity_rem" name="quantity_rem" type="number" placeholder="" value="0" readonly>
              <label class="active">Pending Quantity</label>
            </div>


        </div>
 
    </div>

    <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
      <div class="row col s12 m12 l12">
        <div class="row col s12 m4 l4 left-align" style="margin-left: 20px;">
          <button type="button" class="orange waves-effect waves-light btn right-align" id="btnItemReset" onclick="resetColDetails();" disabled><i class="material-icons left">loop</i>Reset Details</button>
        </div>
 
        <div class="row col s12 m8 l8 right-align">
          <button class="green waves-effect waves-light btn" id="btnCollect" onclick="collectItem();" disabled><i class="material-icons left">add_shopping_cart</i>Collect</button>
          <button class="red waves-effect waves-light btn" id="btnColCan" onclick="issItemsCan();"><i class="material-icons left">cancel</i>Cancel</button>
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
        <h4>Reset Issuance Request</h4><br><br>
        <div class="row">
            <div class="col s12 m6">
                <input type="hidden" name="reset_loc" id="reset_loc">
                <p>Are you sure you want to reset <strong>Issuance Request Details</strong>?</p>
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
        <h4>Reset Item Details</h4><br><br>
        <div class="row">
            <div class="col s12 m6">
                <input type="hidden" name="reset_loc" id="reset_loc">
                <p>Are you sure you want to reset <strong>Item Details to Collect</strong>?</p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="green waves-effect waves-light btn" id="btnReset" onclick="resetCollection();" ><i class="material-icons left">check_circle</i>Yes</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
    </div>
  </div> 

  <div id="resetIssModal" class="modal bottom-sheet">
    <div class="modal-content">
        <h4>Reset Issuance Details</h4><br><br>
        <div class="row">
            <div class="col s12 m6">
                <input type="hidden" name="reset_loc" id="reset_loc">
                <p>Are you sure you want to reset <strong>Issuance Details</strong>?</p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="green waves-effect waves-light btn" id="btnReset" onclick="resetIss();" ><i class="material-icons left">check_circle</i>Yes</button>
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
    var issueCount = {{$count}};
    const str = new Date().toISOString().slice(0, 10);
    var newtoday = str.replace(/[^a-zA-Z0-9]/g,"");
    
    var add_items = [];
    var edit_items = [];
    var view_items = [];
    var app_items = [];
    var iss_items = [];
    var all_iss_items = [];
    var iss_list = [];
    

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
          projectCode($(this).val(), 'add');
          $('#site_code').val($(this).val());
        });
        
        $('#add_purpose').on('change', function(){
          if($(this).val()=='Project')
          {
            var x = document.getElementById('project_details');
              x.style.display = "block";
              issuanceCode('{{$employee->site_code}}', 'add');
              projectCode('{{$employee->site_code}}', 'add');
          } else {
            var x = document.getElementById('project_details');
              x.style.display = "none";
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
                var data = response.data;
                var select = '<option value="" disabled selected>Choose your option</option>';
                $.each(data, (index,row) => {
                    select += '<option value="'+row.uom_details.uom_code+'">'+row.uom_details.uom_name+'</option>';
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
          if($('#add_item_code').val() && 
            $('#add_quantity').val() &&
            $('#add_uom_code').val())
          {
            if($('#add_quantity').val() % 1 != 0)
            {
              alert("Decimal point is not allowed! Please input whole number on quantity.");
            } else {
              $.get('../item_master/getItemDetails/'+$('#add_item_code').val(), (response) => {
                var item = response.data;
                if(item!=null){
                  var item_qty = parseInt($('#add_quantity').val());
                  var safety_stock = parseInt(item.safety_stock);
                  addItem('add',item_qty, safety_stock);
                } else {
                  alert('Item code does not exist! Please the check the item code before adding item..');
                }
              });
            }
            
          }else{
            alert("Please fill-up all item details!");
          }
        });



        $('#edit_site_code').on('change', function(){
          issuanceCode($(this).val(), 'edit');
          projectCode($(this).val(), 'edit');
          $('#site_code_edit').val($(this).val());
        });
        
        $('#edit_purpose').on('change', function(){
          if($(this).val()=='Project')
          {
            var x = document.getElementById('edit_project_details');
              x.style.display = "block";
              issuanceCode('{{$employee->site_code}}', 'edit');
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
                var data = response.data;
                var select = '<option value="" disabled selected>Choose your option</option>';
                $.each(data, (index,row) => {
                    select += '<option value="'+row.uom_details.uom_code+'">'+row.uom_details.uom_name+'</option>';
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
          if($('#edit_item_code').val() &&
            $('#edit_quantity').val() &&
            $('#edit_uom_code').val())
          {
            $.get('../item_master/getItemDetails/'+$('#edit_item_code').val(), (response) => {
              var item = response.data;
              if(item!=null){
                $.get('receiving/'+item.item_code+'/'+$('#edit_inventory_location').val()+'/getCurrentStock', (response) => {
                  var item_qty = parseInt($('#edit_quantity').val());
                  var safety_stock = parseInt(item.safety_stock);
                  addItem('edit',item_qty, safety_stock);
                });
              } else {
                alert('Item code does not exist! Please the check item code before adding item details..');
              }
            });
          }else{
            alert("Please fill-up all item details!");
          }
        });



        $('#item_location_code').on('keyup', function(e){
          if(e.which == 13){       
            $.get('../inventory/location/getlocation/'+trim($('#item_location_code').val()), (response) => {
              var data = response.data;
           
              $.get('../item_master/getItemDetailsLoc/'+trim($('#item_item_code').val())+'/'+trim(data.required_item_category), (response) => {
                var datax = response.data;
              
                if(datax){
                  $('#item_location_name').val(data.location_name);
                  if(data!=null)
                  { 
                    $.get('receiving/'+trim($('#item_item_code').val())+'/'+trim($(this).val())+'/getCurrentStock', (response) => {
                      var current_stock = parseInt(response.data);
                      var uom = datax.uom_code;
                      $('#item_current_stock').html("Current Stock: "+current_stock+uom.toLowerCase());
                      $('#item_cs').val(current_stock);
                      
                      var request_qty = parseInt($('#item_quantity_rem').val()); // need to convert based on conversion id before checking if sufficient for the request.
                      $('#btnCollect').prop('disabled', false);
                      $('#btnItemReset').prop('disabled', false);
                      $(this).prop('readonly', true);
                      var x = document.getElementById('item_details');
                          x.style.display = "block";
                      var y = document.getElementById('item_qty');
                          y.style.display = "block";
                      var z = document.getElementById('item_pend');
                          z.style.display = "block";
  
                    });
                  }else{
                    alert("Inventory location doesn't exist! Please re-scan inventory location.")
                    $('#btnCollect').prop('disabled', true);
                  };
                } else {
                  alert("Item does not exist on the scanned location! Please check and re-scan item.")
                  $(this).val("");
                }

              });
            }); 
          }
        });
        
        $('#item_quantity_iss').on('blur', function(){
          if(parseFloat($(this).val()) > 0){
            if($('#item_status').val() == 'Pending'){

                     $.get('../uom_conversion/rev_convert/'+$('#item_iss_uom').html()+'/'+$('#item_rqst_uom').html(), (response) => {
  
                      var convert_val = response.data.uom_to_value;
                          convert_val = parseFloat(convert_val) * parseFloat($(this).val());
                      var check_qty = parseFloat($('#item_quantity').val()) - parseFloat(convert_val);
                      if( check_qty >= 0){
                        $('#item_quantity_rem').val(parseFloat($('#item_quantity').val()) - parseFloat(convert_val));
                      } else {
                        alert('Issuance quantity exceed to requested quantity!');
                        $('#item_quantity_iss').val("");
                        $('#item_quantity_rem').val(0);
                        $('#item_qty_rem').val(0);
                      }
                    });

            } else {

                    var conv_value = parseFloat($(this).val()) * parseFloat($('#item_to_value').val())
                      rem_stock = parseFloat($('#item_cs').val()) - parseFloat(conv_value);
                    $.get('../uom_conversion/rev_convert/'+$('#item_iss_uom').html()+'/'+$('#item_rqst_uom').html(), (response) => {
    
                      var convert_val = response.data.uom_to_value;
                          convert_val = parseFloat(convert_val) * parseFloat($(this).val());
                      var check_qty = parseFloat($('#item_qty_rem').val()) - parseFloat(convert_val);
                      if( check_qty >= 0){
                        $('#item_quantity_rem').val(parseFloat($('#item_qty_rem').val()) - parseFloat(convert_val));
                      } else {
                        alert('Issuance quantity exceed to requested quantity!');
                        $('#item_quantity_iss').val("");
                        $('#item_quantity_rem').val(0);
                      }
                    });

            }
          } else {
            if($(this).val()){
              alert('Issuance quantity must be greater than zero!');
              $('#item_quantity_iss').val("");
              $('#item_quantity_rem').val(parseInt($('#item_qty_rem').val()));
            }  
          }
        });
 
        $('#item_uom').on('change', function(){
          $.get('../uom_conversion/conv_values/'+$(this).val(), (response) => {
            $('#item_from_value').val(response.data.uom_from_value);  
            $('#item_to_value').val(response.data.uom_to_value);

            $('#item_iss_uom').html(response.data.uom_to.toLowerCase());
            $('#item_uom_code').val(response.data.uom_to.toLowerCase());
            $('#item_conv_id').val($(this).val());
            
            $('#item_quantity_iss').val("");
            var qty = parseInt($('#item_item_qty').val()) * parseFloat($('#item_to_value').val());
            var n = qty.toFixed(7);
          });
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
      input_total.val(symbol+" "+FormatNumber(total ? parseInt(total) : 0));
    };

    const calculateGrandTotal = (symbol, products, field_grand_total) => {
        var grand_total = 0.0;
        $.each(products,(index,row) => {
            grand_total = parseInt(grand_total) + parseInt(row.total_price);
        });

        field_grand_total.val(symbol+" "+FormatNumber(grand_total));
    };

    const setDetails = (loc) => {
      if(loc=="add"){
        if($('#add_issuance_code').val() &&
          $('#add_purpose').val())
        {
          if($('#add_purpose').val()=='Project')
          {
            if( $('#add_project_code').val() &&  
                $('#add_assy_code').val())
            {
              $('#btnAdd').prop('disabled', false);
              $('#add_item_code').prop('disabled', false);
              $('#add_quantity').prop('disabled', false);
              $('#add_uom_type').prop('disabled', false);
              $('#add_uom_type').formSelect();
              $('#add_uom_code').prop('disabled', false);
              $('#add_uom_code').formSelect();

              $('#add_purpose').prop('disabled', true);
              $('#add_purpose').formSelect();
              $('#add_project_code').prop('disabled', true);
              $('#add_project_code').formSelect();
              $('#add_assy_code').prop('disabled', true);
              $('#add_assy_code').formSelect();

              var set = document.getElementById('add_set');
                  set.style.display = "none";
              var reset = document.getElementById('add_reset');
                  reset.style.display = "block";
            } else {
              alert('Please fill up all issuance details before setting-up items!');
            }
          } else {
            $('#btnAdd').prop('disabled', false);
            $('#add_item_code').prop('disabled', false);
            $('#add_quantity').prop('disabled', false);
            $('#add_uom_type').prop('disabled', false);
            $('#add_uom_type').formSelect();
            $('#add_uom_code').prop('disabled', false);
            $('#add_uom_code').formSelect();

            $('#add_purpose').prop('disabled', true);
            $('#add_purpose').formSelect();
            $('#add_project_code').prop('disabled', true);
            $('#add_project_code').formSelect();
            $('#add_assy_code').prop('disabled', true);
            $('#add_assy_code').formSelect();

            var set = document.getElementById('add_set');
                set.style.display = "none";
            var reset = document.getElementById('add_reset');
                reset.style.display = "block";
          }
        } else {
          alert('Please fill up all issuance details before setting-up items!');
        }
      } else {
        
        if($('#edit_issuance_code').val() &&
            $('#edit_purpose').val()) 
        {
          if($('#edit_purpose').val()=='Project')
          {
            if( $('#edit_project_code').val() &&  
                $('#edit_assy_code').val())
            {
              $('#edit_btnAdd').prop('disabled', false);
              $('#edit_item_code').prop('disabled', false);
              $('#edit_quantity').prop('disabled', false);
              $('#edit_uom_type').prop('disabled', false);
              $('#edit_uom_type').formSelect();
              $('#edit_uom_code').prop('disabled', false);
              $('#edit_uom_code').formSelect();

              $('#edit_purpose').prop('disabled', true);
              $('#edit_purpose').formSelect();
              
              $('#edit_project_code').prop('disabled', true);
              $('#edit_project_code').formSelect();
              $('#edit_assy_code').prop('disabled', true);
              $('#edit_assy_code').formSelect();

              var set = document.getElementById('edit_set');
                  set.style.display = "none";
              var reset = document.getElementById('edit_reset');
                  reset.style.display = "block";
            } else {
              alert('Please fill up all issuance details before setting-up items!');
            }
          } else {
            $('#edit_btnAdd').prop('disabled', false);
            $('#edit_item_code').prop('disabled', false);
            $('#edit_quantity').prop('disabled', false);
            $('#edit_uom_type').prop('disabled', false);
            $('#edit_uom_type').formSelect();
            $('#edit_uom_code').prop('disabled', false);
            $('#edit_uom_code').formSelect();

            $('#edit_purpose').prop('disabled', true);
            $('#edit_purpose').formSelect();
            $('#edit_project_code').prop('disabled', true);
            $('#edit_project_code').formSelect();
            $('#edit_assy_code').prop('disabled', true);
            $('#edit_assy_code').formSelect();

            var set = document.getElementById('edit_set');
                set.style.display = "none";
            var reset = document.getElementById('edit_reset');
                reset.style.display = "block";
          }
        } else {
          alert('Please fill up all issuance details before setting-up items!');
        }
      }
    };

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
          $('#add_uom_type').prop('disabled', true);
          $('#add_uom_type').formSelect();
          $('#add_uom_code').prop('disabled', true);
          $('#add_uom_code').formSelect();

          $('#add_purpose').prop('disabled', false);
          $('#add_purpose').formSelect();
          $('#add_site_code').prop('disabled', false);
          $('#add_site_code').formSelect();
          $('#add_project_code').prop('disabled', false);
          $('#add_project_code').formSelect();
          $('#add_assy_code').prop('disabled', false);
          $('#add_assy_code').formSelect();

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

          $('#add_purpose').prop('disabled', false);
          $('#add_purpose').formSelect();
          $('#add_site_code').prop('disabled', false);
          $('#add_site_code').formSelect();
          $('#add_project_code').prop('disabled', false);
          $('#add_project_code').formSelect();
          $('#add_assy_code').prop('disabled', false);
          $('#add_assy_code').formSelect();

          var set = document.getElementById('add_set');
              set.style.display = "block";
          var reset = document.getElementById('add_reset');
              reset.style.display = "none";
          var x = document.getElementById('project_details');
              x.style.display = "none";
        } 
        add_items = [];
        renderItems(add_items,$('#items-dt tbody'),'add');
        $('#btnAddSave').prop('disabled', false);
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
        $('#add_item_code').val("");
        $('#add_item_desc').val("");
        $('#add_quantity').val("");
        $('#add_uom_type').val("");
        $('#add_uom_type').formSelect();
        $('#add_uom_code').val("");
        $('#add_uom_code').formSelect();
      } else {
        $('#edit_item_code').val("");
        $('#edit_item_desc').val("");
        $('#edit_quantity').val("");
        $('#edit_uom_type').val("");
        $('#edit_uom_type').formSelect();
        $('#edit_uom_code').val("");
        $('#edit_uom_code').formSelect();
      }
    };

    const resetCollection = () => {
      var trans_code = $('#item_trans_code').val();
      var item_code = $('#item_item_code').val();
      var item_rem = $('#item_qty_rem').val();
      var id = $('#item_id').val();
      $.get('issuance/'+trans_code+'/'+item_code+'/item_details', (response) => {
        var data = response.data;
          item_rem > 0 ? $('#item_status').val('Issued with Pending') : $('#item_status').val('Pending');
          $('#item_id').val(id);
          $('#item_trans_code').val(trans_code);
          $('#item_item_code').val(data.item_code);
          $('#item_item_desc').val(data.item_details.item_desc);
          $('#item_uom_type').val(data.uom_type);
          $('#item_uom').val(data.uom_code);
          $('#item_quantity').val(data.quantity);
          $('#item_location_code').prop('readonly', false);
          $('#item_location_code').val("");
          $('#item_location_name').val("");

          $('#item_qty_rem').val(item_rem);
          $('#item_quantity_rem').val(item_rem);
          $('#item_quantity_iss').val("");

          $.get('../uom_conversion/conversions/'+data.uom_type, (response) => {
            var data = response.data;
            var select = '<option value="" disabled selected>Choose your option</option>';
            $.each(data, (index,row) => {
                select += '<option value="'+row.id+'">'+row.uom_cnv_name+'</option>';
            });
            $('#item_unit_convert').html(select);
            $('#item_unit_convert').formSelect();
          });

          var x = document.getElementById('item_details');
              x.style.display = "none";
          var y = document.getElementById('item_qty');
              y.style.display = "none";
          var z = document.getElementById('item_pend');
              z.style.display = "none";
          $('#btnCollect').prop('disabled', true);
          $('#btnItemReset').prop('disabled', true);
          $('#resetColModal').modal('close');
      });
    };

    const resetColDetails = () => {
      $('#resetColModal').modal('open');
    };

    const resetIss = () => {
      iss_items = [];
      iss_list = []
      $.get('list/'+trim($('#issue_issuance_code').val())+'/items', (response) => {
          var datax = response.data;
          console.log(datax);
          $.each(datax, (index, row) => {
            if(row.status == 'Pending'){
              iss_items.push({"trans_code": trim($('#issue_issuance_code').val()),
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
            } else if(row.status == 'Issued'){
              iss_items.push({"trans_code": trim($('#issue_issuance_code').val()),
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
            } else if(row.status == 'Issued with Pending'){
              iss_list.push({"trans_code": trim($('#issue_issuance_code').val()),
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

          renderItems(iss_items,$('#issue-items-dt tbody'),'issue');
          renderItems(iss_list,$('#issued-items-dt tbody'),'issued_items');
          $('#btnIssue').prop('disabled', true);
          $('#btnIssReset').prop('disabled', true);
          $('#resetIssModal').modal('close');
        });
    };

    const resetISSDetails = () => {
      $('#resetIssModal').modal('open');
    };

    const issuanceCode = (site, loc) => {
        if(loc=='add'){
          $('#add_issuance_code').val( site + '-ISS' + newtoday + '-00' + issueCount );
        } else {
          var str = $('#edit_issuance_code').val();
          var count = str.substr(-3, 3);
          $('#edit_issuance_code').val( site + '-ISS' + newtoday + '-' + count);
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
      $('#add_purpose option[value=""]').prop('selected', true);
      $('#add_purpose').formSelect(); 

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
      renderItems(add_items,$('#items-dt tbody'),'add');
      $('#btnAddSave').prop('disabled', true);
      $('#addModal').modal('open');
      loadApprover();
    };

    const resetModal = (loc) => {
      $('#reset_loc').val(loc);
      $('#resetModal').modal('open');
    };

    const editIssuance = (id) => {
      edit_items = [];
      $('#editModal').modal('open');
      $('.tabs.edit').tabs('select','edit_issuance');
      $.get('issuance/'+id, (response) => {
        var data = response.data[0];
        var matrix = JSON.parse(data.matrix);
        if(matrix != null) renderSignatoriesTable(matrix,$('#edit-matrix-dt tbody'));
        $('#edit_id').val(id);
        $('#edit_issuance_code').val(data.issuance_code);
 
        $('#edit_purpose option[value="'+data.purpose+'"]').prop('selected', true);
        $('#edit_purpose').prop('disabled', false);
        $('#edit_purpose').formSelect();

        $('#edit_item_code').prop('disabled', true);
        $('#edit_item_code').val("");

        $('#edit_item_desc').prop('readonly', true);
        $('#edit_item_desc').val("");

        $('#edit_quantity').prop('disabled', true);
        $('#edit_quantity').val("");

        $('#edit_uom_type').prop('disabled', true);
        $('#edit_uom_type').formSelect();

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

          $.get('../projects/view/'+data.project_code+'/view_assy', (response) => {
            var datax = response.data;
            var select = '<option value="" disabled selected>Choose your option</option>';
            $.each(datax, (index,row) => {
                select += '<option value="'+row.assy_code+'">'+row.assy_desc+'</option>';
            });
            $('#edit_assy_code').html(select);
            $('#edit_assy_code').formSelect();
            $('#edit_assy_code option[value="'+data.assy_code+'"]').prop('selected', true);
            $('#edit_assy_code').prop('disabled', false);
            $('#edit_assy_code').formSelect();
          });

          $('#project_code_edit').val(data.project_code);
          $('#assy_code_edit').val(data.assy_code);
          var x = document.getElementById('edit_project_details');
              x.style.display = "block";
        } else {
          var x = document.getElementById('edit_project_details');
              x.style.display = "none";
        }

        $.get('list/'+data.issuance_code+'/items', (response) => {
          var data = response.data;
          $.each(data, (index, row) => {
            edit_items.push({"item_code": row.item_code,
                            "item_desc": row.item_details.item_desc,
                            "uom_code": row.uom_code,
                            "quantity": row.quantity,
                            });
          });
          renderItems(edit_items,$('#edit-items-dt tbody'),'edit');
        });

      });
    };

    const viewIssuance = (id) => {
      view_items = [];
      iss_list = [];
      $('#viewModal').modal('open');
      $('.tabs.view').tabs('select','view_issuance');
      $.get('issuance/'+id, (response) => {
        var data = response.data[0];
        var matrix = JSON.parse(data.matrix);
        var matrix_h = JSON.parse(data.matrix_h);
        if(matrix != null) renderSignatoriesTable(matrix,$('#view-matrix-dt tbody'));
        if(matrix_h != null) renderSignatoriesTable(matrix_h,$('#view-matrix-dt-h tbody'),true);

        $('#view_issuance_code').val(data.issuance_code);
        $('#view_purpose').val(data.purpose);

        if(data.purpose=='Project')
        {
          $('#view_project_code').val(data.projects.project_name);
          $('#view_assy_code').val(data.assy.assy_desc);
          var x = document.getElementById('view_project_details');
              x.style.display = "block";
        } else {
          var x = document.getElementById('view_project_details');
              x.style.display = "none";
        }

        $.get('list/'+data.issuance_code+'/items', (response) => {
          var datax = response.data;
          if(data.status=='Issued'){
            $.each(datax, (index, row) => {
              if(row.status=='Issued'){
                view_items.push({"item_code": row.item_code,
                              "item_desc": row.item_details.item_desc,
                              "uom_code": row.uom_code,
                              "quantity": row.quantity,
                              "status": row.status,
                              });
              } else if (row.status == 'Issued with Pending'){
                  iss_list.push({"trans_code": data.issuance_code,
                              "item_code": row.item_code,
                              "item_desc": row.item_details.item_desc,
                              "req_qty": row.quantity,
                              "uom_code": row.uom_code,
                              "rem_qty": 0, 
                              "iss_qty": row.quantity,
                              "tbi_qty": 0,
                              "status": row.status,
                              "iss_date": row.trans_date,
                              "is_check": false,
                              "inventory_location": row.inventory_location_code,
                              });
              }
            });
          } else {
            $.each(datax, (index, row) => {
              view_items.push({"item_code": row.item_code,
                              "item_desc": row.item_details.item_desc,
                              "uom_code": row.uom_code,
                              "quantity": row.quantity,
                              "status": row.status,
                              });
              if (row.status == 'Issued with Pending'){
                iss_list.push({"trans_code": data.issuance_code,
                              "item_code": row.item_code,
                              "item_desc": row.item_details.item_desc,
                              "req_qty": row.quantity,
                              "uom_code": row.uom_code,
                              "rem_qty": 0, 
                              "iss_qty": row.quantity,
                              "tbi_qty": 0,
                              "status": row.status,
                              "iss_date": row.trans_date,
                              "is_check": false,
                              "inventory_location": row.inventory_location_code,
                              });
              }
            });
          }
    
          renderItems(view_items,$('#view-items-dt tbody'),'view');
          renderItems(iss_list,$('#issued-items-dt tbody'),'issued_items');

        });

      });
    };

    const appIssuance = (id) => {
      app_items = [];
      $('#appModal').modal('open');
      $('.tabs.app').tabs('select','app_issuance');
      $.get('issuance/'+id, (response) => {
        var data = response.data[0];
        var matrix = JSON.parse(data.matrix);
        var matrix_h = JSON.parse(data.matrix_h);
        if(matrix != null) renderSignatoriesTable(matrix,$('#app-matrix-dt tbody'));
        if(matrix_h != null) renderSignatoriesTable(matrix_h,$('#app-matrix-dt-h tbody'),true);

        $('#app_id').val(id);
        $('#app_issuance_code').val(data.issuance_code);
        $('#app_site_code').val(data.sites.site_desc);
        $('#app_purpose').val(data.purpose);

        if(data.purpose=='Project')
        {
          $('#app_project_code').val(data.projects.project_name);
          $('#app_assy_code').val(data.assy.assy_desc);
          var x = document.getElementById('app_project_details');
              x.style.display = "block";
        } else {
          var x = document.getElementById('app_project_details');
              x.style.display = "none";
        }

        $.get('list/'+data.issuance_code+'/items', (response) => {
          var data = response.data;
          $.each(data, (index, row) => {
            app_items.push({"item_code": row.item_code,
                            "item_desc": row.item_details.item_desc,
                            "uom_code": row.uom_code,
                            "quantity": row.quantity,
                            "status": row.status,
                            });
            
          });
          renderItems(app_items,$('#app-items-dt tbody'),'app');
        });

      });
    };

    const issIssuance = (id) => {
      iss_items = [];
      iss_list = [];
      all_iss_items = [];
      $('#issueModal').modal('open');
      $('.tabs.issue').tabs('select','issue_issuance');
      $.get('issuance/'+id, (response) => {
        var data = response.data[0];
        var matrix = JSON.parse(data.matrix);
        var matrix_h = JSON.parse(data.matrix_h);
        if(matrix != null) renderSignatoriesTable(matrix,$('#issue-matrix-dt tbody'));
        if(matrix_h != null) renderSignatoriesTable(matrix_h,$('#issue-matrix-dt-h tbody'),true);

        $('#btnIssue').prop('disabled', true);
        $('#btnIssReset').prop('disabled', true);


        $('#issue_issuance_code').val(data.issuance_code);
        $('#issue_requestor').val(data.employee_details.full_name);
        $('#issue_site_code').val(data.sites.site_desc);
        $('#issue_purpose').val(data.purpose);

        if(data.purpose=='Project')
        {
          $('#issue_project_code').val(data.projects.project_name);
          $('#issue_assy_code').val(data.assy.assy_desc);
          var x = document.getElementById('issue_project_details');
              x.style.display = "block";
        } else {
          var x = document.getElementById('issue_project_details');
              x.style.display = "none";
        }

        $.get('list/'+data.issuance_code+'/items', (response) => {
          var datax = response.data;
    
          $.each(datax, (index, row) => {
            if(row.status == 'Pending'){
              iss_items.push({"trans_code": data.issuance_code,
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
                          "iss_index": 0,
                          });
            } else if(row.status == 'Issued'){
              iss_items.push({"trans_code": data.issuance_code,
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
                          "iss_index": 0,
                          });
            } else if(row.status == 'Issued with Pending'){
              iss_list.push({"trans_code": data.issuance_code,
                          "item_code": row.item_code,
                          "item_desc": row.item_details.item_desc,
                          "req_qty": row.quantity,
                          "uom_code": row.uom_code,
                          "rem_qty": 0, 
                          "iss_qty": row.quantity,
                          "tbi_qty": 0,
                          "conv_id": row.uom_conv_id,
                          "status": row.status,
                          "iss_date": row.trans_date,
                          "is_check": false,
                          "inventory_location": row.inventory_location_code,
                          });
            }
          });

          if(data.status=="Approved"){
            renderItems(iss_items,$('#issue-items-dt tbody'),'issue');
            renderItems(iss_list,$('#issued-items-dt tbody'),'issued_items');
          } else {
            $.get('list/'+data.issuance_code+'/items_issued', (response) => {
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
          
        });
      });
    };

    const issItems = (trans_code, item_code, item_rem = 0, id) => {
      $('#issDetModal').modal('open');
      $.get('issuance/'+trans_code+'/'+item_code+'/item_details', (response) => {
        var data = response.data;
          item_rem > 0 ? $('#item_status').val('Issued with Pending') : $('#item_status').val('Pending');
          $('#item_id').val(id);
          $('#item_trans_code').val(trans_code);
          $('#item_item_code').val(data.item_code);
          $('#item_item_desc').val(data.item_details.item_desc);

          $('#item_location_code').prop('readonly', false);
          $('#item_location_code').val("");
          $('#item_location_name').val("");
          
          $('#item_item_qty').val(data.quantity);
          $('#item_quantity').val(data.quantity);
          $('#item_qty_rem').val(item_rem);
          $('#item_quantity_rem').val(item_rem);
          $('#item_quantity_iss').val("");

          $('#item_rqst_uom').html(data.uom_code.toLowerCase());
          $('#item_rqst_uom').val(data.uom_code.toLowerCase());
          $('#item_qty_uom').html(data.uom_code.toLowerCase());

          $.get('../item_master/getItemDetails/'+data.item_code, (response) => {
            var item = response.data;
  
              $.get('../uom_conversion/conversions/'+item.uom_code, (response) => {
                var datax = response.data;
                var select = '<option value="" disabled>Choose your option</option>';
                $.each(datax, (index,row) => {
                    if(row.uom_details.uom_code == data.uom_code){
                      select += '<option value="'+row.id+'" selected>'+row.uom_details.uom_name+'</option>';

                      $.get('../uom_conversion/conv_values/'+row.id, (response) => {
                        $('#item_from_value').val(response.data.uom_from_value);  
                        $('#item_to_value').val(response.data.uom_to_value);
                        
                        $('#item_iss_uom').html(response.data.uom_to.toLowerCase());
                        $('#item_uom_code').val(response.data.uom_to.toLowerCase());
                        $('#item_conv_id').val(row.id);
            
                      });

                    } else {
                      select += '<option value="'+row.id+'">'+row.uom_details.uom_name+'</option>';
                    }
                });
                $('#item_uom').html(select);
                $('#item_uom').formSelect();
              });
          });

          var x = document.getElementById('item_details');
              x.style.display = "none";
          var y = document.getElementById('item_qty');
              y.style.display = "none";
          var z = document.getElementById('item_pend');
              z.style.display = "none";
          $('#btnCollect').prop('disabled', true);
          $('#btnItemReset').prop('disabled', true);
      });
    };

    const issItemsCan = () => {
      var id = $('#item_id').val();
      var status = $('#item_status').val();
      $('#'+id).prop('checked', false);
      id = id - 1;

      iss_items[id].inventory_location = "";
      if(status=='Pending'){
        iss_items[id].rem_qty = 0;
        iss_items[id].iss_qty = 0;
      } else {

      }

      iss_items[id].is_check = false;
      renderItems(iss_items,$('#issue-items-dt tbody'),'issue');

      $('#issDetModal').modal('close');
    };

    const collectItem = () => {
      if($('#item_status').val() == 'Pending'){
        if(trim($('#item_location_code').val()) && trim($('#item_quantity_iss').val()) && trim($('#item_quantity_iss').val()) > 0)
        {
          var index = $('#item_id').val();
              index = index - 1;
 
          if($('#item_from_value').val() == $('#item_to_value').val()){
            iss_items[index].iss_index = index;
            iss_items[index].inventory_location = $('#item_location_code').val();
            iss_items[index].rem_qty = $('#item_quantity_rem').val();
            iss_items[index].iss_qty = parseFloat($('#item_quantity_iss').val());
            iss_items[index].tbi_qty = $('#item_quantity_iss').val();
            iss_items[index].conv_id = $('#item_conv_id').val();
            iss_items[index].iss_uom = $('#item_iss_uom').html().toUpperCase();
            iss_items[index].is_check = true;
            renderItems(iss_items,$('#issue-items-dt tbody'),'issue');

            iss_list.push({"trans_code": $('#item_trans_code').val(),
                            "item_code": $('#item_item_code').val(),
                            "item_desc": $('#item_item_desc').val(),
                            "req_qty": $('#item_quantity').val(),
                            "uom_code": $('#item_iss_uom').html().toUpperCase(),
                            "rem_qty": $('#item_quantity_rem').val(), 
                            "iss_qty": parseFloat($('#item_quantity_iss').val()),
                            "tbi_qty": parseFloat($('#item_quantity_iss').val()),
                            "conv_id": $('#item_conv_id').val(),
                            "status": 'Pending',
                            "iss_date": "{{date('Y-m-d H:i:s')}}",
                            "is_check": false,
                            "inventory_location": $('#item_location_code').val(),
                            "iss_index": index,
                          });
            renderItems(iss_list,$('#issued-items-dt tbody'),'issued_items');
          } else {
            iss_items[index].iss_index = index;
            iss_items[index].inventory_location = $('#item_location_code').val();
            iss_items[index].rem_qty = $('#item_quantity_rem').val();
            iss_items[index].iss_qty = parseFloat($('#item_quantity_iss').val());
            iss_items[index].tbi_qty = $('#item_quantity_iss').val();
            iss_items[index].conv_id = $('#item_conv_id').val();
            iss_items[index].iss_uom = $('#item_iss_uom').html().toUpperCase();
            iss_items[index].is_check = true;
            renderItems(iss_items,$('#issue-items-dt tbody'),'issue');
            
            iss_list.push({"trans_code": $('#item_trans_code').val(),
                            "item_code": $('#item_item_code').val(),
                            "item_desc": $('#item_item_desc').val(),
                            "req_qty": $('#item_quantity').val(),
                            "uom_code": $('#item_iss_uom').html().toUpperCase(),
                            "rem_qty": $('#item_quantity_rem').val(), 
                            "iss_qty": parseFloat($('#item_quantity_iss').val()),
                            "tbi_qty": parseFloat($('#item_quantity_iss').val()),
                            "conv_id": $('#item_conv_id').val(),
                            "status": 'Pending',
                            "iss_date": "{{date('Y-m-d H:i:s')}}",
                            "is_check": false,
                            "inventory_location": $('#item_location_code').val(),
                            "iss_index": index,
                          });
            renderItems(iss_list,$('#issued-items-dt tbody'),'issued_items');
          }
          
          $('#issDetModal').modal('close');
        } else {
          alert('Please fill-up all details to collect!')
        }
      } else {
        if(trim($('#item_location_code').val()) && trim($('#item_quantity_iss').val()) && trim($('#item_quantity_iss').val()) > 0)
        {
          var index = $('#item_id').val();
              index = index - 1;

          if($('#item_from_value').val() == $('#item_to_value').val()){
            iss_items[index].iss_index = index;
            iss_items[index].inventory_location = $('#item_location_code').val();
            iss_items[index].rem_qty = $('#item_quantity_rem').val();
            iss_items[index].iss_qty = parseFloat(iss_items[index].iss_qty) + parseFloat($('#item_quantity_iss').val());
            iss_items[index].tbi_qty = $('#item_quantity_iss').val();
            iss_items[index].conv_id = $('#item_conv_id').val();
            iss_items[index].iss_uom = $('#item_iss_uom').html().toUpperCase();
            iss_items[index].is_check = true;
            renderItems(iss_items,$('#issue-items-dt tbody'),'issue');

            iss_list.push({"trans_code": $('#item_trans_code').val(),
                            "item_code": $('#item_item_code').val(),
                            "item_desc": $('#item_item_desc').val(),
                            "req_qty": $('#item_quantity').val(),
                            "uom_code": $('#item_iss_uom').html().toUpperCase(),
                            "rem_qty": $('#item_quantity_rem').val(), 
                            "iss_qty": parseFloat($('#item_quantity_iss').val()),
                            "tbi_qty": parseFloat($('#item_quantity_iss').val()),
                            "conv_id": $('#item_conv_id').val(),
                            "status": 'Pending',
                            "iss_date": "{{date('Y-m-d H:i:s')}}",
                            "is_check": false,
                            "inventory_location": $('#item_location_code').val(),
                            "iss_index": index,
                          });
            renderItems(iss_list,$('#issued-items-dt tbody'),'issued_items');
          } else {
            iss_items[index].iss_index = index;
            iss_items[index].inventory_location = $('#item_location_code').val();
            iss_items[index].rem_qty = $('#item_quantity_rem').val();
            iss_items[index].iss_qty = parseFloat(iss_items[index].iss_qty) + parseFloat($('#item_quantity_iss').val());
            iss_items[index].tbi_qty = $('#item_quantity_iss').val();
            iss_items[index].conv_id = $('#item_conv_id').val();
            iss_items[index].iss_uom = $('#item_iss_uom').html().toUpperCase();
            iss_items[index].is_check = true;
            renderItems(iss_items,$('#issue-items-dt tbody'),'issue');

            iss_list.push({"trans_code": $('#item_trans_code').val(),
                            "item_code": $('#item_item_code').val(),
                            "item_desc": $('#item_item_desc').val(),
                            "req_qty": $('#item_quantity').val(),
                            "uom_code": $('#item_iss_uom').html().toUpperCase(),
                            "rem_qty": $('#item_quantity_rem').val(), 
                            "iss_qty": parseFloat($('#item_quantity_iss').val()),
                            "tbi_qty": parseFloat($('#item_quantity_iss').val()),
                            "conv_id": $('#item_conv_id').val(),
                            "status": 'Pending',
                            "iss_date": "{{date('Y-m-d H:i:s')}}",
                            "is_check": false,
                            "inventory_location": $('#item_location_code').val(),
                            "iss_index": index,
                          });
            renderItems(iss_list,$('#issued-items-dt tbody'),'issued_items');
          }

          $('#issDetModal').modal('close');
        } else {
          alert('Please fill-up all details to collect!')
        }
      }
    };

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
                      '<td class="left-align">'+row.uom_code+'</td>'+
                      '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="deleteItem(\''+index+'\',\'add\')"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                      '<input type="hidden" name="itm_item_code[]" value="'+row.item_code+'"/>'+
                      '<input type="hidden" name="itm_quantity[]" value="'+row.quantity+'"/>'+
                      '<input type="hidden" name="itm_uom_code[]" value="'+row.uom_code+'"/>'+
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
        } else if (loc=='edit') {
          var id = parseInt(index) + 1;
          table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td class="left-align">'+row.uom_code+'</td>'+
                      '<td><button type="button" class="btn-small red waves-effect waves-light" disabled><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                      '<input type="hidden" name="e_itm_item_code[]" value="'+row.item_code+'"/>'+
                      '<input type="hidden" name="e_itm_quantity[]" value="'+row.quantity+'"/>'+
                      '<input type="hidden" name="e_itm_uom_code[]" value="'+row.uom_code+'"/>'+
                      '<input type="hidden" name="e_itm_inventory_location[]" value=" "/>'+
                      '<input type="hidden" name="e_itm_currency[]" value=" "/>'+
                      '<input type="hidden" name="e_itm_currency_code[]" value=" "/>'+
                      '<input type="hidden" name="e_itm_unit_price[]" value=" "/>'+
                      '<input type="hidden" name="e_itm_total_price[]" value=" "/>'+
                      '</tr>'
                    );
        } else if (loc=='issue') {
        
          var id = parseInt(index) + 1;
          if( row.status=="Issued"){
            table.append('<tr class="disabled">'+
                                '<td class="left-align">'+id+'</td>'+
                                '<td class="left-align">'+row.item_code+'</td>'+
                                '<td class="left-align">'+row.item_desc+'</td>'+
                                '<td class="left-align">'+row.uom_code+'</td>'+
                                '<td class="left-align">'+row.req_qty+'</td>'+
                                '<td class="left-align">0</td>'+
                                '<td class="left-align"><span class="new badge black white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
                                '<td class="left-align"><p><label><input id="'+id+'" class="filled-in" checked="checked" type="checkbox" value="'+id+'" disabled/><span style="margin-top: 10px;"></span></label></p></td>'+
                                '<input type="hidden" name="i_itm_item_code[]" value="'+row.item_code+'"/>'+
                                '<input type="hidden" name="i_itm_quantity[]" value="'+row.req_qty+'"/>'+
                                '<input type="hidden" name="i_itm_quantity_rem[]" value="'+row.rem_qty+'"/>'+
                                '<input type="hidden" name="i_itm_quantity_iss[]" value="'+row.iss_qty+'"/>'+
                                '<input type="hidden" name="i_itm_quantity_tbi[]" value="'+row.tbi_qty+'"/>'+
                                '<input type="hidden" name="i_itm_conv_id[]" value="'+row.conv_id+'"/>'+
                                '<input type="hidden" name="i_itm_iss_uom[]" value="'+row.iss_uom+'"/>'+
                                '<input type="hidden" name="i_itm_inventory_location[]" value="'+trim(row.inventory_location)+'"/>'+
                                '<input type="hidden" name="i_itm_currency[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_currency_code[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_unit_price[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_total_price[]" value=" "/>'+
                                '</tr>'
                              );
          } else if (row.is_check==true) {
            table.append('<tr>'+
                                '<td class="left-align">'+id+'</td>'+
                                '<td class="left-align">'+row.item_code+'</td>'+
                                '<td class="left-align">'+row.item_desc+'</td>'+
                                '<td class="left-align">'+row.uom_code+'</td>'+
                                '<td class="left-align">'+row.req_qty+'</td>'+
                                '<td class="left-align">'+row.rem_qty+'</td>'+
                                '<td class="left-align"><span class="new badge blue white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
                                '<td class="left-align"><p><label><input id="'+id+'" class="filled-in" checked="checked" type="checkbox" value="'+id+'" disabled/><span style="margin-top: 10px;"></span></label></p></td>'+
                                '<input type="hidden" name="i_itm_item_code[]" value="'+row.item_code+'"/>'+
                                '<input type="hidden" name="i_itm_quantity[]" value="'+row.req_qty+'"/>'+
                                '<input type="hidden" name="i_itm_quantity_rem[]" value="'+row.rem_qty+'"/>'+
                                '<input type="hidden" name="i_itm_quantity_iss[]" value="'+row.iss_qty+'"/>'+
                                '<input type="hidden" name="i_itm_quantity_tbi[]" value="'+row.tbi_qty+'"/>'+
                                '<input type="hidden" name="i_itm_conv_id[]" value="'+row.conv_id+'"/>'+
                                '<input type="hidden" name="i_itm_iss_uom[]" value="'+row.iss_uom+'"/>'+
                                '<input type="hidden" name="i_itm_inventory_location[]" value="'+trim(row.inventory_location)+'"/>'+
                                '<input type="hidden" name="i_itm_currency[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_currency_code[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_unit_price[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_total_price[]" value=" "/>'+
                                '</tr>'
                              );
              $('#btnIssue').prop('disabled', false);
              $('#btnIssReset').prop('disabled', false);
          } else {
            table.append('<tr>'+
                                '<td class="left-align">'+id+'</td>'+
                                '<td class="left-align">'+row.item_code+'</td>'+
                                '<td class="left-align">'+row.item_desc+'</td>'+
                                '<td class="left-align">'+row.uom_code+'</td>'+
                                '<td class="left-align">'+row.req_qty+'</td>'+
                                '<td class="left-align">'+row.rem_qty+'</td>'+
                                '<td class="left-align"><span class="new badge blue white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
                                '<td class="left-align"><p><label><input id="'+id+'" class="with-gap" type="checkbox" value="'+id+'" onclick="issItems(\''+row.trans_code+'\',\''+row.item_code+'\',\''+row.rem_qty+'\','+id+')"/><span style="margin-top: 10px;"></span></label></p></td>'+
                                '<input type="hidden" name="i_itm_item_code[]" value="'+row.item_code+'"/>'+
                                '<input type="hidden" name="i_itm_quantity[]" value="'+row.req_qty+'"/>'+
                                '<input type="hidden" name="i_itm_quantity_rem[]" value="'+row.rem_qty+'"/>'+
                                '<input type="hidden" name="i_itm_quantity_iss[]" value="'+row.iss_qty+'"/>'+
                                '<input type="hidden" name="i_itm_quantity_tbi[]" value="'+row.tbi_qty+'"/>'+
                                '<input type="hidden" name="i_itm_conv_id[]" value="'+row.conv_id+'"/>'+
                                '<input type="hidden" name="i_itm_iss_uom[]" value="'+row.iss_uom+'"/>'+
                                '<input type="hidden" name="i_itm_inventory_location[]" value="'+trim(row.inventory_location)+'"/>'+
                                '<input type="hidden" name="i_itm_currency[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_currency_code[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_unit_price[]" value=" "/>'+
                                '<input type="hidden" name="i_itm_total_price[]" value=" "/>'+
                                '</tr>'
                              );
          }

        } else if (loc=='issued_items') {
          var id = parseInt(index) + 1;
          if(row.status=='Pending'){
            table.append('<tr>'+
                        '<td class="left-align">'+id+'</td>'+
                        '<td class="left-align">'+row.item_code+'</td>'+
                        '<td class="left-align">'+row.item_desc+'</td>'+
                        '<td class="left-align">'+row.uom_code+'</td>'+
                        '<td class="left-align">'+row.iss_qty+'</td>'+
                        '<td class="left-align">'+row.iss_date+'</td>'+
                        '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="deleteItem(\''+index+'\',\'issuance\',\''+row.iss_index+'\')"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                        // '<td><button type="button" class="btn-small red waves-effect waves-light" disabled><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                        '<input type="hidden" name="itm_item_code[]" value="'+row.item_code+'"/>'+
                        '<input type="hidden" name="itm_quantity[]" value="'+row.iss_qty+'"/>'+
                        '<input type="hidden" name="itm_uom_code[]" value="'+row.uom_code+'"/>'+
                        '<input type="hidden" name="itm_inventory_location[]" value="'+row.inventory_location+'"/>'+
                        '<input type="hidden" name="itm_currency[]" value=" "/>'+
                        '<input type="hidden" name="itm_currency_code[]" value=" "/>'+
                        '<input type="hidden" name="itm_unit_price[]" value=" "/>'+
                        '<input type="hidden" name="itm_total_price[]" value=" "/>'+
                        '</tr>'
                      );
          } else {
            table.append('<tr>'+
                        '<td class="left-align">'+id+'</td>'+
                        '<td class="left-align">'+row.item_code+'</td>'+
                        '<td class="left-align">'+row.item_desc+'</td>'+
                        '<td class="left-align">'+row.uom_code+'</td>'+
                        '<td class="left-align">'+row.iss_qty+'</td>'+
                        '<td class="left-align">'+row.iss_date+'</td>'+
                        '<input type="hidden" name="itm_item_code[]" value="'+row.item_code+'"/>'+
                        '<input type="hidden" name="itm_quantity[]" value="'+row.iss_qty+'"/>'+
                        '<input type="hidden" name="itm_uom_code[]" value="'+row.uom_code+'"/>'+
                        '<input type="hidden" name="itm_inventory_location[]" value="'+row.inventory_location+'"/>'+
                        '<input type="hidden" name="itm_currency[]" value=" "/>'+
                        '<input type="hidden" name="itm_currency_code[]" value=" "/>'+
                        '<input type="hidden" name="itm_unit_price[]" value=" "/>'+
                        '<input type="hidden" name="itm_total_price[]" value=" "/>'+
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
                      '<td class="left-align">'+row.uom_code+'</td>'+
                      '<td class="left-align"><span class="new badge black white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
                      '</tr>'
                    );
          } else if(row.status=='Rejected'){
            table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td class="left-align">'+row.uom_code+'</td>'+
                      '<td class="left-align"><span class="new badge red white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
                      '</tr>'
                    );
          } else if(row.status=='Issued with Pending'){
   
          } else {
            table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td class="left-align">'+row.uom_code+'</td>'+
                      '<td class="left-align"><span class="new badge blue white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
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
          renderItems(add_items,$('#items-dt tbody'),'add');
          $('#removeItemModal').modal('close');
          if(add_items.length  == 0 ){ $('#btnAddSave').prop('disabled', true); }
        } else {

          $.get('../item_master/getItemDetails/'+trim(iss_list[index].item_code), (response) => { 
            if(response.data.uom_code == iss_list[index].uom_code){
              iss_items[item_index].rem_qty = parseFloat(iss_items[item_index].rem_qty) + parseFloat(iss_list[index].tbi_qty);
            } else {
              
            }

            iss_items[item_index].inventory_location = "";
            iss_items[item_index].iss_qty = 0;
            iss_items[item_index].tbi_qty = 0;
            iss_items[item_index].conv_id = "";
            iss_items[item_index].iss_uom = "";
            iss_items[item_index].is_check = false;
            renderItems(iss_items,$('#issue-items-dt tbody'),'issue');

            iss_list.splice(index,1);
            renderItems(iss_list,$('#issued-items-dt tbody'),'issued_items');

            $('#btnIssReset').prop('disabled', true);
            $('#btnIssue').prop('disabled', true);
            $('#removeItemModal').modal('close');

          });

        }
    };

    const deleteItem = (index,loc,item_index) => {
      $('#del_index').val(index);
      $('#del_loc').val(loc);
      $('#del_item_index').val(item_index);
      $('#removeItemModal').modal('open');
    };

    const addItem = (loc, item_qty = 0, safety_stock = 0) => {
      var found = false;
      var cindex = 0;
      if(loc=='add')
      {
        if(parseInt($('#add_unit_price').val()) <= 0){
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
              add_items[cindex].quantity = parseInt(add_items[cindex].quantity) + parseInt($('#add_quantity').val());
              add_items[cindex].uom_code = $('#add_uom_code').val();

              renderItems(add_items,$('#items-dt tbody'),'add');
              resetItemDetails("add");
          }else{
              var itm_qtys = parseInt(item_qty);
            if(safety_stock <= itm_qtys)
            {
              add_items.push({ "item_code": $('#add_item_code').val(),
                              "item_desc": $('#add_item_desc').val(),
                              "uom_code": $('#add_uom_code').val(),
                              "quantity": parseInt($('#add_quantity').val()),
                            });
              renderItems(add_items,$('#items-dt tbody'),'add');
              resetItemDetails("add");
            } else {
              add_items.push({ "item_code": $('#add_item_code').val(),
                              "item_desc": $('#add_item_desc').val(),
                              "uom_code": $('#add_uom_code').val(),
                              "quantity": parseInt($('#add_quantity').val()),
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
              edit_items[cindex].quantity = parseInt(edit_items[cindex].quantity) + parseInt($('#edit_quantity').val());
              edit_items[cindex].uom_code = $('#edit_uom_code').val();

              $('#btnEditSave').prop('disabled', false);
              renderItems(edit_items,$('#edit-items-dt tbody'),'edit');
              resetItemDetails("edit");
            
          }else{
              var itm_qtys = parseInt(item_qty) + parseInt(edit_items[cindex].quantity);
              if(safety_stock <= itm_qtys)
            {
              edit_items.push({ "item_code": $('#edit_item_code').val(),
                                "item_desc": $('#edit_item_desc').val(),
                                "uom_code": $('#edit_uom_code').val(),
                                "quantity": parseInt($('#edit_quantity').val()),
                              });
              $('#btnEditSave').prop('disabled', false);
              renderItems(edit_items,$('#edit-items-dt tbody'),'edit');
              resetItemDetails("edit");
            } else {
              edit_items.push({ "item_code": $('#edit_item_code').val(),
                                "item_desc": $('#edit_item_desc').val(),
                                "uom_code": $('#edit_uom_code').val(),
                                "quantity": parseInt($('#edit_quantity').val()),
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
      $.get('../approver/{{Auth::user()->emp_no}}/Issuance/my_matrix', (response) => {
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

    var request = $('#request-dt').DataTable({
          "lengthChange": false,
          "pageLength": 15,
          "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
          "pagingType": "full",
          "ajax": "/api/reiss/inventory/issuance/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}",
          "columns": [
              {  "data": "id" },

              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return '<a href="#!" onclick="viewIssuance('+data+')">'+ row.issuance_code; +'</a>';
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
                      return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editIssuance('+data+')"><i class="material-icons">create</i></a>';
                    } else {
                      return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" disabled><i class="material-icons">create</i></a>';
                    }
            
                  }
              },   
          ]
    });

    var issuance = $('#issuance-dt').DataTable({
          "lengthChange": false,
          "pageLength": 15,
          "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
          "pagingType": "full",
          "ajax": "/api/reiss/inventory/issuance/issuance",
          "columns": [
              {  "data": "id" },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return '<a href="#!" onclick="viewIssuance('+data+')">'+ row.issuance_code; +'</a>';
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
                    return  '<a href="#" class="btn-small teal darken-1 waves-effect waves-dark" onclick="issIssuance('+data+')"><i class="material-icons">shopping_cart</i></a>';
                  }
              },   
          ]
    });

    var approval = $('#approval-dt').DataTable({
          "lengthChange": false,
          "pageLength": 15,
          "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
          "pagingType": "full",
          "ajax": "/api/reiss/inventory/issuance/all_approval/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}",
          "columns": [
              {  "data": "id" },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return '<a href="#!" onclick="viewIssuance('+data+')">'+ row.issuance_code; +'</a>';
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
                    return  '<a href="#" class="btn-small blue darken3 waves-effect waves-dark" onclick="appIssuance('+data+')"><i class="material-icons">rate_review</i></a>';
                  }
              },   
          ]
    });
  </script>
    <!-- End of SCRIPTS -->
@endsection