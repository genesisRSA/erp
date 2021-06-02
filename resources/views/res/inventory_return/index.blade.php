@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title">
          <span class="grey-text darken-4">Parts Preparation<i class="material-icons">arrow_forward_ios</i></span>
          <span class="grey-text darken-4">Returned Items<i class="material-icons">arrow_forward_ios</i></span>
          Return to Store</h4>
    </div>
  </div>
  <div class="row main-content">
    <div id="rts" name="rts">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="request-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Site</th>
                    <th>Return Code</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      
      @if($permission[0]["add"]==true)
        <a href="#!" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Return to Store" onclick="openModal();"><i class="material-icons">add</i></a>
      @endif
    </div>
  </div>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('return.store')}}">
    @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4 >Add Return To Store</h4><br>
          <div class="col s12 m12 l12 row">
            <h6 style="padding: 10px;padding-top: 10px;margin-bottom: 0px;background-color:#0d47a1;border-right-width: 20px;margin-top: 0+;margin-top: 0px;margin-right: 10px;margin-left: 10px;" class="white-text"><b>Return Details</b></h6>
          </div>
          
          <div class="row"  style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="add_return_code" name="return_code" type="text" class="validate" placeholder="" value="RTN{{date('Ymd')}}-00{{$count}}" required readonly>
              <label for="return_code">Return Code<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input type="hidden" name="site_code" id="site_code">
              <select id="add_site_code" name="add_site_code" required>
                  <option value="" disabled selected>Choose your option</option>
                  @foreach ($sites as $site)
                    <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
                  @endforeach
              </select>
              <label for="add_site_code">Site<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <textarea id="add_reason" name="reason" class="materialize-textarea" placeholder=""></textarea>
              <label for="reason">Reason<sup class="red-text">*</sup></label>
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
              <input id="add_location_code" name="location_code" type="text" class="validate" autocomplete="" placeholder="Please click here before scanning location.." disabled>
              <label for="location_code">Location<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input type="hidden" id="add_item_desc" name="item_desc">
              <input id="add_item_code" name="item_code" type="text" class="validate" autocomplete="" placeholder="" disabled>
              <span id="add_max_stock" name="add_max_stock" class="badge">Maximum Stock: 0</span>
        
              <label for="item_code">Item Code<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="add_quantity" name="quantity" type="number" class="validate" placeholder="" disabled>
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
                          <th>Location</th>
                          <th>Quantity</th>
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
                  <input id="edit_issuance_code" name="issuance_code" type="text" class="validate" placeholder="" value="ISS{{date('Ymd')}}-00{{$count}}" required readonly>
                  <label for="issuance_code">Issuance Code<sup class="red-text">*</sup></label>
                </div>
            </div>
  
            <div class="row" style="margin-bottom: 0px;">
              <div class="input-field col s12 m6 l6">
                <input type="hidden" name="purpose" id="purpose_edit">
                <select id="edit_purpose" name="edit_purpose" required>
                    <option value="" disabled selected>Choose your option</option>
                    <option value="Office Use">Office Use</option>
                    <option value="Project">Project</option>
                </select>
                <label for="edit_purpose">Purpose<sup class="red-text">*</sup></label>
              </div>
  
              <div class="input-field col s12 m6 l6">
                <input type="hidden" name="site_code" id="site_code_edit">
                <select id="edit_site_code" name="edit_site_code" required>
                    <option value="" disabled selected>Choose your option</option>
                    @foreach ($sites as $site)
                      <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
                    @endforeach
                </select>
                <label for="edit_site_code">Site<sup class="red-text">*</sup></label>
              </div>
            </div>
  
            <div class="row" style="display: none; margin-bottom: 0px;" id="edit_project_details">
              <div class="input-field col s12 m6 l6">
                  <input type="hidden" name="project_code" id="project_code_edit">
                  <select id="edit_project_code" name="edit_project_code">
                      <option value="" disabled selected>Choose your option</option>
                  </select>
                  <label for="edit_project_code">Project Code<sup class="red-text">*</sup></label>
                </div>
  
                <div class="input-field col s12 m6 l6">
                  <input type="hidden" name="assy_code" id="assy_code_edit">
                  <select id="edit_assy_code" name="edit_assy_code">
                    <option value="" disabled selected>Choose your option</option>
                  </select>
                  <label for="edit_assy_code">Assy Code<sup class="red-text">*</sup></label>
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
                <input id="edit_quantity" name="quantity" type="number" class="validate" placeholder="" disabled>
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
          <button class="green waves-effect waves-light btn" id="btnEditSave" disabled><i class="material-icons left">check_circle</i>Save</button>
          <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
        </div>

    </form>
  </div>

  <div id="viewModal" class="modal">
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4 >Returned Item Details</h4><br>
 
        <div class="row"  style="margin-bottom: 0px;">
          <div class="input-field col s12 m6 l6">
            <input id="view_return_code" name="return_code" type="text" class="validate" placeholder="" readonly>
            <label for="return_code">Return Code<sup class="red-text"></sup></label>
          </div>
          <div class="input-field col s12 m6 l6">
            <input id="view_site_code" name="site_code" type="text" class="validate" placeholder="" readonly>
            <label for="site_code">Site<sup class="red-text"></sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m6 l6">
            <textarea id="view_reason" name="reason" class="materialize-textarea" placeholder=""></textarea>
            <label for="reason">Reason<sup class="red-text"></sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="view_status" name="status" type="text" class="validate" placeholder="" readonly>
            <label for="status">Status<sup class="red-text"></sup></label>
          </div>
        </div>

        <div class="row">
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
          <div class="row">
              <div class="input-field col s12 m6 l6">
                <input id="issue_issuance_code" name="issuance_code" type="text" class="validate" placeholder="" readonly>
                <label class="active">Issuance Code</label>
              </div>
          </div>

          <div class="row">
              <div class="input-field col s12 m6 l6">
                <input id="issue_site_code" name="site_code" type="text" class="validate" placeholder="" readonly>
                <label class="active">Site</label>
              </div>

              <div class="input-field col s12 m6 l6">
                <input id="issue_purpose" name="purpose" type="text" class="validate" placeholder="" readonly>
                <label class="active">Purpose</label>
              </div>
          </div>

          <div class="row" style="display: none" id="issue_project_details">
              <div class="input-field col s12 m6 l6">
                <input id="issue_project_code" name="project_code" type="text" class="validate" placeholder="" readonly>
                <label class="active">Project</label>
              </div>

              <div class="input-field col s12 m6 l6">
                <input id="issue_assy_code" name="assy_code" type="text" class="validate" placeholder="" readonly>
                <label class="active">Assembly</label>
              </div>
          </div>

          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="issue-items-dt">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Item Code</th>
                        <th>Item Description</th>
                        <th>Quantity</th>
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
        </div>

        <div id="issue_signatories" name="issue_signatories">
          <div class="row">
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

          <div class="row">
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
        <button class="green waves-effect waves-light btn" id="btnIssue" disabled><i class="material-icons left">check_circle</i>Issue</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
  </div>

  <div id="issDetModal" class="modal">
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4 >Item Details To Collect</h4><br>
        <input type="hidden" name="id" id="item_id">

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m6 l6">
            <input type="hidden" name="location_code" id="location_code">
            {{-- <select id="item_location_code" name="item_location_code" required>
                    <option value="" disabled selected>Choose your option</option>
                    @foreach ($inventloc as $invl)
                        <option value="{{$invl->location_code}}">{{$invl->location_name}}</option>      
                    @endforeach
                </select>
            --}}
            <input id="item_location_code" name="item_location_code" type="text" class="validate" placeholder="Click here before scanning location..">
            <label for="item_location_code">Inventory Location<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="item_item_code" name="item_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Item Code</label>
            </div>
            <div class="input-field col s12 m6 l6">
              <input id="item_item_desc" name="item_desc" type="text" class="validate" placeholder="" readonly>
              <label class="active">Item Description</label>
            </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="item_quantity" name="quantity" type="text" class="validate" placeholder="" readonly>
              <label class="active">Quantity</label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="item_uom" name="uom" type="text" class="validate" placeholder="" readonly>
              <label class="active">Unit of Measure</label>
            </div>
        </div>

  

    </div>

    <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
      <button class="green waves-effect waves-light btn" id="btnCollect" onclick="collectItem();" disabled><i class="material-icons left">add_shopping_cart</i>Collect</button>
      <button class="red waves-effect waves-light btn" id="btnColCan" onclick="issItemsCan();"><i class="material-icons left">cancel</i>Cancel</button>
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
        <h4>Reset Return Details</h4><br><br>
        <div class="row">
            <div class="col s12 m6">
                <input type="hidden" name="reset_loc" id="reset_loc">
                <p>Are you sure you want to reset <strong>Return Details</strong>?</p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="green waves-effect waves-light btn" id="btnReset" onclick="resetDetails();" ><i class="material-icons left">check_circle</i>Yes</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
    </div>
  </div> 

  <div id="voidModal" class="modal">
    <form method="POST" action="{{route('return.void')}}">
        @csrf
        <div class="modal-content" style="padding-bottom: 0px;">
            <h4>Void Returned Items</h4>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="void_id">
                    <p>Are you sure you want to void this <strong>Return Record</strong>?</p>
                </div>
            </div>

            <div class="col s12 m12 l12 row">
              <h6 style="padding: 10px;padding-top: 10px;margin-bottom: 0px;background-color:#0d47a1;border-right-width: 20px;margin-top: 0+;margin-top: 0px;margin-right: 10px;margin-left: 10px;" class="white-text"><b>Return Details</b></h6>
            </div>
     
            <div class="row"  style="margin-bottom: 0px;">
              <div class="input-field col s12 m6 l6">
                <input id="void_return_code" name="return_code" type="text" class="validate" placeholder="" readonly>
                <label for="return_code">Return Code<sup class="red-text"></sup></label>
              </div>
              <div class="input-field col s12 m6 l6">
                <input id="void_site_code" name="site_code" type="text" class="validate" placeholder="" readonly>
                <label for="site_code">Site<sup class="red-text"></sup></label>
              </div>
            </div>
    
            <div class="row" style="margin-bottom: 0px;">
              <div class="input-field col s12 m6 l6">
                <textarea id="void_reason" name="reason" class="materialize-textarea" placeholder=""></textarea>
                <label for="reason">Reason<sup class="red-text"></sup></label>
              </div>
    
              <div class="input-field col s12 m6 l6">
                <input id="void_status" name="status" type="text" class="validate" placeholder="" readonly>
                <label for="status">Status<sup class="red-text"></sup></label>
              </div>
            </div>
    
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="card">
                  <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
                  <div class="card-content" style="padding: 10px; padding-top: 0px">
                    <table class="highlight" id="void-items-dt">
                      <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item Code</th>
                            <th>Item Description</th>
                            <th>Quantity</th>
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

        <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
          <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Yes</button>
          <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
        </div>
    </form>
  </div>

  <div id="removeItemModal" class="modal">
    <div class="modal-content">
      <h4  >Remove Item</h4>
      <div class="row">
          <div class="col s12 m12 l12">
              <input type="hidden" name="id" id="del_index">
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

    var returnCount = {{$count}};
    const str = new Date().toISOString().slice(0, 10);
    var newtoday = str.replace(/[^a-zA-Z0-9]/g,"");
    var add_items = [];
    var edit_items = [];
    var view_items = [];
    var void_items = [];
    var app_items = [];
    var iss_items = [];

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
          $('#site_code').val($(this).val());
        });
        
        $('#add_purpose').on('change', function(){
          if($(this).val()=='Project')
          {
            var x = document.getElementById('project_details');
              x.style.display = "block";
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
          if($(this).val()){
            $.get('../item_master/getItemDetails/'+$(this).val(), (response) => {
              var data = response.data;
              $('#add_max_stock').html('Maximum Stock: '+data.maximum_stock);
            });
          };
        });

        $('#btnAdd').on('click', function(){
          if($('#add_item_code').val() && $('#add_quantity').val())
          {
            if($('#add_quantity').val() % 1 != 0)
            {
              alert("Decimal point is not allowed! Please input whole number on quantity.");
            } else {
              $.get('../item_master/getItemDetails/'+$('#add_item_code').val(), (response) => {
                var item = response.data;
                if(item!=null){
                  $.get('receiving/'+$('#add_item_code').val()+'/'+$('#add_location_code').val()+'/getCurrentStock', (response) => {
                    var current_stock = parseInt(response.data) + parseInt($('#add_quantity').val());
                    var maximum_stock = parseInt(item.maximum_stock);
                    $('#add_item_desc').val(item.item_desc);
                    addItem('add',current_stock, maximum_stock); 
                  });
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
        
        $('#edit_purpose').on('change', function(){
          if($(this).val()=='Project')
          {
            var x = document.getElementById('edit_project_details');
              x.style.display = "block";
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

        $('#edit_btnAdd').on('click', function(){
          if($('#edit_item_code').val() &&
              $('#edit_quantity').val()  
          ){
            if($('#edit_quantity').val() % 1 != 0)
            {
              console.log('not allowed');
              alert("Decimal point is not allowed! Please input whole number on quantity.");
            } else {
              $.get('../item_master/getItemDetails/'+$('#edit_item_code').val(), (response) => {
                var item = response.data;
                if(item!=null){
                  $.get('receiving/'+$('#edit_item_code').val()+'/'+$('#edit_location_code').val()+'/getCurrentStock', (response) => {
                    var current_stock = parseInt(response.data) + parseInt($('#edit_quantity').val());
                    var maximum_stock = parseInt(item.maximum_stock);
                    addItem('edit',item_qty, maximum_stock);
                  });
                } else {
                  alert('Item code does not exist! Please the check item code before adding item details..');
                }
              });
            }
          }else{
            alert("Please fill up product details!");
          }
        });

        $('#item_location_code').on('change', function(){
          $.get('../inventory/location/getlocation/'+$('#item_location_code').val(), (response) => {
            var data = response.data;
            // console.log(data);
            if(data!=null)
              { 
                $.get('receiving/'+$('#item_item_code').val()+'/'+$(this).val()+'/getCurrentStock', (response) => {
                  var current_stock = parseInt(response.data);
                  var request_qty = parseInt($('#item_quantity').val());
                  if(current_stock < request_qty)
                  {
                    alert("Current stock of the item: "+$('#item_item_code').val()+" is not sufficient for the request!");
                    $(this).val("");
                  } else {
                    $('#btnCollect').prop('disabled', false);
                  }
                });
              }else{
                alert("Inventory location doesn't exist! Please re-scan inventory location.")
                $('#btnCollect').prop('disabled', true);
              };
          }); 
        });

        $('#item_location_code').on('keyup', function(){
          $.get('../inventory/location/getlocation/'+$('#item_location_code').val(), (response) => {
            var data = response.data;
            // console.log(data);
            if(data!=null)
              { 
                $.get('receiving/'+$('#item_item_code').val()+'/'+$(this).val()+'/getCurrentStock', (response) => {
                  var current_stock = parseInt(response.data);
                  var request_qty = parseInt($('#item_quantity').val());
                  if(current_stock < request_qty)
                  {
                    alert("Current stock of the item: "+$('#item_item_code').val()+" is not sufficient for the request!");
                    $(this).val("");
                  } else {
                    $('#btnCollect').prop('disabled', false);
                  }
                });
              }else{
                alert("Inventory location doesn't exist! Please re-scan inventory location.")
                $('#btnCollect').prop('disabled', true);
              };
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
        if( trim($('#add_return_code').val()) &&
          trim($('#add_reason').val()) &&
          $('#add_site_code').val())
        {
          $('#btnAdd').prop('disabled', false);
          $('#add_location_code').prop('disabled', false);
          $('#add_item_code').prop('disabled', false);
          $('#add_quantity').prop('disabled', false);
          $('#add_reason').prop('readonly', true);

          var set = document.getElementById('add_set');
              set.style.display = "none";
          var reset = document.getElementById('add_reset');
              reset.style.display = "block";
        } else {
          alert('Please fill up all return details before setting-up items!');
        }
      }  
    };

    const resetDetails = () => {
      var loc = $('#reset_loc').val();
      if(loc=="add"){
         
        $('#add_site_code option[value=""]').prop('selected', true);
        $('#add_site_code').formSelect();
        $('#add_reason').prop('readonly', false);
        $('#add_reason').val("");
        $('#add_location_code').prop('disabled', true);
        $('#add_location_code').val("");
        $('#add_item_code').prop('disabled', true);
        $('#add_item_code').val("");
        $('#add_quantity').prop('disabled', true);
        $('#add_quantity').val("");
        
        $('#btnAdd').prop('disabled', true);
        var set = document.getElementById('add_set');
            set.style.display = "block";
        var reset = document.getElementById('add_reset');
            reset.style.display = "none";

        add_items = [];
        renderItems(add_items, $('#items-dt tbody'), 'add');
        $('#btnAddSave').prop('disabled', true);
        $('#resetModal').modal('close');

      } else {

      }
    };

    const resetItemDetails = (loc) => {
      if(loc=="add"){
        $('#add_item_code').val("");
        $('#add_quantity').val("");
        $('#add_location_code').val("");
      } else {
        $('#edit_item_code').val("");
        $('#edit_quantity').val("");
        $('#edit_location_code').val("");
      }
    };

    const issuanceCode = (site, loc) => {
        if(loc=='add'){
          $('#add_return_code').val( site + '-RTN' + newtoday + '-00' + returnCount );
        } else {
          var str = $('#edit_return_code').val();
          var count = str.substr(-3, 3);
          $('#edit_return_code').val( site + '-RTN' + newtoday + '-' + count);
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
      $('#add_reason').prop('readonly', false);
      $('#add_reason').val("");
      $('#add_location_code').prop('disabled', true);
      $('#add_location_code').val("");
      $('#add_item_code').prop('disabled', true);
      $('#add_item_code').val("");
      $('#add_quantity').prop('disabled', true);
      $('#add_quantity').val("");
      
      $('#btnAdd').prop('disabled', true);
      var set = document.getElementById('add_set');
          set.style.display = "block";
      var reset = document.getElementById('add_reset');
          reset.style.display = "none";

      add_items = [];
      renderItems(add_items, $('#items-dt tbody'), 'add');
      $('#btnAddSave').prop('disabled', true);
      $('#addModal').modal('open');
    };

    const resetModal = (loc) => {
      $('#reset_loc').val(loc);
      $('#resetModal').modal('open');
    }

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
        $('#edit_site_code option[value="'+data.site_code+'"]').prop('selected', true);
        $('#edit_site_code').prop('disabled', false);
        $('#edit_site_code').formSelect();
        $('#edit_purpose option[value="'+data.purpose+'"]').prop('selected', true);
        $('#edit_purpose').prop('disabled', false);
        $('#edit_purpose').formSelect();

        $('#edit_item_code').prop('disabled', true);
        $('#edit_quantity').prop('disabled', true);
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
          $.get('../projects/'+data.site_code+'/project',(response) => {
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
                            "quantity": row.quantity,
                            });
          });
          renderItems(edit_items,$('#edit-items-dt tbody'),'edit');
        });

      });
    };

    const viewReturn = (id) => {
      view_items = [];
      $('#viewModal').modal('open');
      $.get('return/'+id, (response) => {
        var data = response.data[0];
        // console.log(data);
        $('#view_id').val(id);
        $('#view_return_code').val(data.return_code);
        $('#view_site_code').val(data.sites.site_desc);
        $('#view_reason').val(data.reason);
        $('#view_status').val(data.status);

        if(data.status == 'Returned'){
          $.get('list/'+data.return_code+'/items', (response) => {
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
        } else {
          $.get('list/'+data.return_code+'/voided', (response) => {
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

    const voidItem = (id) => {
      void_items = [];
      $('#voidModal').modal('open');
      $.get('return/'+id, (response) => {
        var data = response.data[0];
        console.log(data);
        $('#void_id').val(id);
        $('#void_return_code').val(data.return_code);
        $('#void_site_code').val(data.sites.site_desc);
        $('#void_reason').val(data.reason);
        $('#void_status').val(data.status);

        $.get('list/'+data.return_code+'/items', (response) => {
          var data = response.data;
          // console.log(data);
          $.each(data, (index, row) => {
            void_items.push({"item_code": row.item_code,
                            "item_desc": row.item_details.item_desc,
                            "inventory_location": row.inventory_location_code,
                            "quantity": row.quantity,
                            "status": row.status,
                            });
          });
          renderItems(void_items,$('#void-items-dt tbody'),'void');
        });

      });
    }
 
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
                            "quantity": row.quantity,
                            "status": row.status,
                            });
            
          });
          // calculateGrandTotal('$',app_items,$('#app_grand_total'));
          renderItems(app_items,$('#app-items-dt tbody'),'app');
        });

      });
    };

    const issIssuance = (id) => {
      iss_items = [];
      $('#issueModal').modal('open');
      $('.tabs.issue').tabs('select','issue_issuance');
      $.get('issuance/'+id, (response) => {
        var data = response.data[0];
        var matrix = JSON.parse(data.matrix);
        var matrix_h = JSON.parse(data.matrix_h);
        if(matrix != null) renderSignatoriesTable(matrix,$('#issue-matrix-dt tbody'));
        if(matrix_h != null) renderSignatoriesTable(matrix_h,$('#issue-matrix-dt-h tbody'),true);

        $('#issue_issuance_code').val(data.issuance_code);
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
            iss_items.push({"trans_code": data.issuance_code,
                            "item_code": row.item_code,
                            "item_desc": row.item_details.item_desc,
                            "quantity": row.quantity,
                            "status": row.status,
                            "is_check": false,
                            "inventory_location": row.inventory_location_code,
                            });
          });
          // calculateGrandTotal('$',issue_items,$('#issue_grand_total'));
          renderItems(iss_items,$('#issue-items-dt tbody'),'issue');
        });

      });
    };

    const issItems = (trans_code, item_code, id) => {
      $('#issDetModal').modal('open');
      $.get('issuance/'+trans_code+'/'+item_code+'/item_details', (response) => {
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
      iss_items[id].inventory_location = "";
      iss_items[id].is_check = false;
      renderItems(iss_items,$('#issue-items-dt tbody'),'issue');

      $('#issDetModal').modal('close');
    };

    const collectItem = () => {
      var index = $('#item_id').val();
          index = index - 1;

      iss_items[index].inventory_location = $('#item_location_code').val();
      iss_items[index].is_check = true;
      renderItems(iss_items,$('#issue-items-dt tbody'),'issue');
      $('#issDetModal').modal('close');
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
                      '<td class="left-align">'+row.location_code+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="deleteItem(\''+index+'\',\'add\')"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                      '<input type="hidden" name="itm_item_code[]" value="'+row.item_code+'"/>'+
                      '<input type="hidden" name="itm_quantity[]" value="'+row.quantity+'"/>'+
                      '<input type="hidden" name="itm_inventory_location[]" value="'+row.location_code+'"/>'+
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
                      '<input type="hidden" name="e_itm_inventory_location[]" value="'+row.location_code+'"/>'+
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
                                // '<td class="left-align"><p><label><input id="'+id+'" class="filled-in" checked="checked" type="checkbox" value="'+id+'" disabled/><span></span></label></p></td>'+
                                '<td class="left-align"><p><label><input id="'+id+'" class="filled-in" checked="checked" type="checkbox" value="'+id+'"  onclick="issItems(\''+row.trans_code+'\',\''+row.item_code+'\','+id+')"/><span></span></label></p></td>'+
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
                                '<td class="left-align"><p><label><input id="'+id+'" class="with-gap" type="checkbox" value="'+id+'" onclick="issItems(\''+row.trans_code+'\',\''+row.item_code+'\','+id+')"/><span></span></label></p></td>'+
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
        } else if (loc=='void'){
            var id = parseInt(index) + 1;
            table.append('<tr>'+
                                '<td class="left-align">'+id+'</td>'+
                                '<td class="left-align">'+row.item_code+'</td>'+
                                '<td class="left-align">'+row.item_desc+'</td>'+
                                '<td class="left-align">'+row.quantity+'</td>'+
                                '<td class="left-align"><span class="new badge blue white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
                                '<input type="hidden" name="vd_itm_item_code[]" value="'+row.item_code+'"/>'+
                                '<input type="hidden" name="vd_itm_quantity[]" value="'+row.quantity+'"/>'+
                                '<input type="hidden" name="vd_itm_inventory_location[]" value="'+row.inventory_location+'"/>'+
                                '</tr>'
                              );
          
        } else {
          var id = parseInt(index) + 1;
          if(row.status=='Returned'){
            table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td class="left-align"><span class="new badge blue white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
                      '</tr>'
                    );
          } else {
            table.append('<tr>'+
                      '<td class="left-align">'+id+'</td>'+
                      '<td class="left-align">'+row.item_code+'</td>'+
                      '<td class="left-align">'+row.item_desc+'</td>'+
                      '<td class="left-align">'+row.quantity+'</td>'+
                      '<td class="left-align"><span class="new badge black white-text" data-badge-caption="">'+row.status+'</span></td>'+ 
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

    const addItem = (loc, current_stock = 0, maximum_stock = 0) => {
      var found = false;
      var cindex = 0;

      $.get('list/'+$('#add_item_code').val()+'/'+$('#add_location_code').val()+'/item_details', (response) => {
        var datax = response.data;
        if(datax!=null)
        {
          if(loc=='add')
          {
            if($('#add_quantity').val() <= 0){
              alert('Quantity must be greater than 0!');
            }else{
              $.each(add_items,(index,row) => {
                if(row.item_code == $('#add_item_code').val() && row.location_code == $('#add_location_code').val()){
                  cindex = index;
                  found = true;
                  return false;
                }
              });

              if(found){
                  var current_stocks = parseInt(current_stock) + parseInt(add_items[cindex].quantity);
                  if(current_stocks > maximum_stock)
                  {
                    alert("You're above the maximum stock level of the item!");
                  } else  if(current_stocks == maximum_stock) {
                    alert("You reach the maximum stock level of the item!");
                  } 
                  add_items[cindex].quantity = parseInt(add_items[cindex].quantity) + parseInt($('#add_quantity').val());
                  renderItems(add_items,$('#items-dt tbody'),'add');
                  resetItemDetails("add");
              }else{
                  var current_stocks = parseInt(current_stock);
                  if(current_stocks > maximum_stock)
                  {
                    alert("You're above the maximum stock level of the item!");
                  } else  if(current_stocks == maximum_stock) {
                    alert("You reach the maximum stock level of the item!");
                  } 
                  add_items.push({ "item_code": $('#add_item_code').val(),
                                  "item_desc": $('#add_item_desc').val(),
                                  "location_code": $('#add_location_code').val(),
                                  "quantity": parseInt($('#add_quantity').val()),
                                });
                  renderItems(add_items,$('#items-dt tbody'),'add');
                  resetItemDetails("add");
              }
              $('#add_max_stock').html('Maximum Stock: 0');
            }
          } else if(loc=='edit') {

            if($('#edit_quantity').val() <= 0){
              alert('Quantity must be greater than 0!');
            }else{
              $.each(edit_items,(index,row) => {
                if(row.item_code == $('#edit_item_code').val() && row.location_code == $('#edit_location_code')){
                  cindex = index;
                  found = true;
                  return false;
                }
              });

              if(found){
                  var current_stocks = parseInt(current_stock) + parseInt(edit_items[cindex].quantity);
                  if(current_stocks > maximum_stock)
                  {
                    alert("You're above the maximum stock level of the item!");
                  } else  if(current_stocks == maximum_stock) {
                    alert("You reach the maximum stock level of the item!");
                  } 
                  edit_items[cindex].quantity = parseInt(edit_items[cindex].quantity) + parseInt($('#edit_quantity').val());
                  $('#btnEditSave').prop('disabled', false);
                  renderItems(edit_items,$('#edit-items-dt tbody'),'edit');
                  resetItemDetails("edit");
 
              }else{
                  var current_stocks = parseInt(current_stock);
                  if(current_stocks > maximum_stock)
                  {
                    alert("You're above the maximum stock level of the item!");
                  } else  if(current_stocks == maximum_stock) {
                    alert("You reach the maximum stock level of the item!");
                  } 
                  edit_items.push({ "item_code": $('#edit_item_code').val(),
                                    "item_desc": $('#edit_item_desc').val(),
                                    "location_code": $('#edit_location_code').val(),
                                    "quantity": parseInt($('#edit_quantity').val()),
                                  });
                  $('#btnEditSave').prop('disabled', false);
                  renderItems(edit_items,$('#edit-items-dt tbody'),'edit');
                  resetItemDetails("edit");
              }
            }

          }
        } else {
          alert("Item is not belong on the scanned location! Please check item location!");
        }
      });


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
          "ajax": "/api/reiss/inventory/return/all",
          "columns": [
              {  "data": "id" },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.sites.site_desc;
                  }
              },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return '<a href="#!" onclick="viewReturn('+data+')">'+row.return_code+'</a>';
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
                      case "Returned":
                        return  '<span class="new badge blue white-text" data-badge-caption="">Returned</span>';
                        break;
                      case "Voided":
                        return  '<span class="new badge black white-text" data-badge-caption="">Voided</span>';
                        break;
                    }
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    if(row.status=='Returned'){
                      return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="voidItem('+data+')"><i class="material-icons">grid_off</i></a>';
                    } else {
                      return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" disabled><i class="material-icons">grid_off</i></a>';
                    }
                  }
              },   
          ]
    });
 

  </script>
    <!-- End of SCRIPTS -->
@endsection