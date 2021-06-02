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
      /* box-shadow: 0 3px 20px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08) inset; */
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
          Return to Vendor</h4>
    </div>
  </div>
  <div class="row main-content">
    <ul id="project_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
      <li class="tab col s12 m4 l4"><a class="active" href="#Return">Return Item</a></li>
      <li class="tab col s12 m4 l4"><a href="#Approval">Approval</a></li>
      <li class="tab col s12 m4 l4"><a href="#Process">Process</a></li>
      <li class="tab col s12 m4 l4"><a href="#Receiving">Receiving</a></li>
    </ul>

    <div id="Return" name="Return">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="return-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
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
        <a href="#!" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Return to Vendor" onclick="openModal();"><i class="material-icons">add</i></a>
      @endif
    </div>

    <div id="Approval" name="Approval">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="approval-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Site</th>
                    <th>Return Code</th>
                    <th>Requestor</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
    </div>

    <div id="Process" name="Process">
      <div class="card" style="margin-top: 0px">
        <div class="card-content">
          <table class="responsive-table highlight" id="process-dt" style="width: 100%">
            <thead>
              <tr>
                  <th>ID</th>
                  <th>Site</th>
                  <th>Return Code</th>
                  <th>Requestor</th>
                  <th>Reason</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

    <div id="Receiving" name="Receiving">
      <div class="card" style="margin-top: 0px">
        <div class="card-content">
          <table class="responsive-table highlight" id="receiving-dt" style="width: 100%">
            <thead>
              <tr>
                  <th>ID</th>
                  <th>Vendor</th>
                  <th>Return Code</th>
                  <th>Requestor</th>
                  <th>Reason</th>
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
    <form method="POST" action="{{route('rtv.store')}}">
    @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4>Add Return to Vendor</h4>
        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#issuance">Return Details</a></li>
           <li class="tab col s12 m4 l4"><a href="#signatories">Signatories</a></li>
        </ul><br>

        <div id="issuance" name="issuance">
          <div class="row"  style="margin-bottom: 0px;">
              <div class="input-field col s12 m6 l6">
                <input id="add_rtv_code" name="rtv_code" type="text" class="validate" placeholder="" value="RTV{{date('Ymd')}}-00{{$count}}" required readonly>
                <label for="rtv_code">Return to Vendor Code<sup class="red-text">*</sup></label>
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
              <input type="hidden" id="add_item_desc" name="item_desc">
              <input id="add_item_code" name="item_code" type="text" class="validate" autocomplete="" placeholder="" disabled>
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
    <form method="POST" action="{{route('rtv.patch')}}">
      @csrf
        <div class="modal-content" style="padding-bottom: 0px;">
          <h4>Edit Return Details</h4> 
          <input type="hidden" id="edit_id" name="id">
          <ul id="tabs-swipe-demo" class="tabs edit">
            <li class="tab col s12 m4 l4"><a class="active" href="#edit_issuance">Return Details</a></li>
             <li class="tab col s12 m4 l4"><a href="#edit_signatories">Signatories</a></li>
          </ul><br>
          
          <div id="edit_issuance" name="edit_issuance">
            <div class="row"  style="margin-bottom: 0px;">
                <div class="input-field col s12 m6 l6">
                  <input id="edit_rtv_code" name="rtv_code" type="text" class="validate" placeholder="" required readonly>
                  <label for="rtv_code">Return Code<sup class="red-text">*</sup></label>
                </div>
            </div>
  
            <div class="row" style="margin-bottom: 0px;">
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
  
              <div class="input-field col s12 m6 l6">
                <textarea id="edit_reason" name="reason" class="materialize-textarea" placeholder=""></textarea>
                <label for="reason">Reason<sup class="red-text">*</sup></label>
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
                <input type="hidden" id="edit_item_desc" name="item_desc">
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
      <h4>Return to Vendor Details</h4> 
      <ul id="tabs-swipe-demo" class="tabs view">
        <li class="tab col s12 m4 l4"><a class="active" href="#view_rtv">Return Details</a></li>
        <li class="tab col s12 m4 l4"><a href="#view_signatories">Signatories</a></li>
      </ul><br>

      <div id="view_rtv" name="view_rtv">
        <div class="row">
            <div class="input-field col s12 m6 l6">
              <input id="view_rtv_code" name="rtv_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Return to Vendor Code</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12 m6 l6">
              <input id="view_site_code" name="site_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Site</label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="view_reason" name="reason" type="text" class="validate" placeholder="" readonly>
              <label class="active">Reason</label>
            </div>
        </div>

        <div class="row" style="display: none" id="view_project_details">
            <div class="input-field col s12 m6 l6">
              <input id="view_project_code" name="project_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Project</label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="view_assy_code" name="assy_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Assembly</label>
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
    <form method="post" action="{{route('rtv.approve')}}">
    @csrf
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4>Return to Vendor Details</h4> 
      <input type="hidden" id="app_id" name="id">
      <ul id="tabs-swipe-demo" class="tabs app">
        <li class="tab col s12 m4 l4"><a class="active" href="#app_issuance">Issuance Details</a></li>
        <li class="tab col s12 m4 l4"><a href="#app_signatories">Signatories</a></li>
      </ul><br>

      <div id="app_issuance" name="app_issuance">
        <div class="row">
            <div class="input-field col s12 m6 l6">
              <input id="app_rtv_code" name="rtv_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Return to Vendor Code</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12 m6 l6">
              <input id="app_site_code" name="site_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Site</label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="app_reason" name="purpose" type="text" class="validate" placeholder="" readonly>
              <label class="active">Reason</label>
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

  <div id="processModal" class="modal">
    <form method="POST" action="{{route('rtv.rtv_item')}}">
      @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4  >Process Return to Vendor</h4> 
        <ul id="tabs-swipe-demo" class="tabs issue">
          <li class="tab col s12 m4 l4"><a class="active" href="#process">Return Details</a></li>
          <li class="tab col s12 m4 l4"><a href="#process_sig">Signatories</a></li>
        </ul><br>

        <div id="process" name="process">
          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="process_rtv_code" name="rtv_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Return to Vendor Code</label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="process_site_code" name="site_code" type="text" class="validate" placeholder="" readonly>
              <label class="active">Site</label>
            </div>
          </div>

          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="process_requestor" name="requestor" type="text" class="validate" placeholder="" readonly>
              <label class="active">Returned By</label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="process_reason" name="reason" type="text" class="validate" placeholder="" readonly>
              <label class="active">Purpose</label>
            </div>
          </div>

          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <select id="process_vendor" name="vendor" required>
                <option value="" disabled selected>Choose your option</option>
                @foreach ($vendor as $vendors)
                  <option value="{{$vendors->ven_code}}">{{$vendors->ven_name}}</option>
                @endforeach
              </select>
              <label for="add_site_code">Vendor<sup class="red-text"></sup></label>
            </div>
          </div>


          <div class="row" style="margin-bottom: 0px;">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="process-items-dt">
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

        <div id="process_sig" name="process_sig">
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
        <button class="green waves-effect waves-light btn" id="btnIssue" disabled><i class="material-icons left">check_circle</i>Return to Vendor</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
  </div>

  <div id="prepareModal" class="modal">
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4 >Item Details To Prepare</h4><br>
        <input type="hidden" name="id" id="item_id">

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m6 l6">
            <input type="hidden" name="location_code" id="location_code">
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
      <button class="green waves-effect waves-light btn" id="btnCollect" onclick="collectItem();" disabled><i class="material-icons left">add_shopping_cart</i>Prepare</button>
      <button class="red waves-effect waves-light btn" id="btnColCan" onclick="issItemsCan();"><i class="material-icons left">cancel</i>Cancel</button>
    </div>
  </div>

  <div id="receiveModal" class="modal">
 <form method="POST" action="{{route('rtv.rcv_item')}}">
      @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4>Receiving Item Details</h4><br>
        <div class="card-body">

            <div class="row"  style="margin-bottom: 0px;">
              <div class="input-field col s12 m6 l6">
                <input id="rtv_code" name="rtv_code" type="text" class="" placeholder="" readonly >
                <label for="rtv_code">Return to Vendor Code<sup class="red-text"></sup></label>
              </div>
            </div>
            <div class="row"  style="margin-bottom: 0px;">
              <div class="input-field col s12 m6 l6">
                <input id="rtv_vendor" name="vendor" type="text" class="" placeholder="" readonly >
                <label for="vendor">Vendor<sup class="red-text"></sup></label>
              </div>

              <div class="input-field col s12 m6 l6">
                <input id="rtv_received_by" name="received_by" type="text" class="validate" placeholder="Please input receiver name here.." required>
                <label for="received_by">Received By<sup class="red-text">*</sup></label>
              </div>
            </div>

            <div class="row" style="margin-bottom: 0px;">
              <div class="col s12 m12 l12">
                <div class="card">
                  <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
                  <div class="card-content" style="padding: 10px; padding-top: 0px">
                    <table class="highlight" id="rcv-items-dt">
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

      
            <div id="signature-pad" class="e-signature-pad">
              <label for="rcv_signature_pad" style="font-size: 18px">Signature:</label>
              <div class="e-signature-pad--body">
                  <canvas id="e-signature-pad" 
                          name="rcv_signature_pad" 
                          style="width: 100%; 
                                height: 250px;       
                             max-width: 1000px;
                             max-height: 315px;">
                  </canvas>
              </div>
              <div class="signature-pad--footer txt-center">
                  <div class="signature-pad--actions txt-center">
                      <div class="col s12 m4 l4 left-align"> 
                          <button type="button" class="blue waves-effect waves-light btn" data-action="clear"><i class="material-icons left">layers_clear</i>Clear</button>
                      </div>
                      <br>
                    </div>
                </div>
            </div>
       
        </div>
      <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
        <button type="button" class="green waves-effect waves-light btn" id="btnReceive" onclick="receive();" disabled><i class="material-icons left">check_circle</i>Receive</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
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
        <h4>Reset Return to Vendor</h4><br><br>
        <div class="row">
            <div class="col s12 m6">
                <input type="hidden" name="reset_loc" id="reset_loc">
                <p>Are you sure you want to reset <strong>Return to Vendor Details</strong>?</p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="green waves-effect waves-light btn" id="btnReset" onclick="resetDetails();" ><i class="material-icons left">check_circle</i>Yes</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
    </div>
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
  <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>

  <script type="text/javascript">
    var issueCount = {{$count}};
    const str = new Date().toISOString().slice(0, 10);
    var newtoday = str.replace(/[^a-zA-Z0-9]/g,"");
    var add_items = [];
    var edit_items = [];
    var view_items = [];
    var app_items = [];
    var proc_items = [];
    var rcv_items = [];

    var wrapper = document.getElementById("signature-pad");
    var clearButton = wrapper.querySelector("[data-action=clear]");
    var changeColorButton = wrapper.querySelector("[data-action=change-color]");
    var savePNGButton = wrapper.querySelector("[data-action=save-png]");
    var saveJPGButton = wrapper.querySelector("[data-action=save-jpg]");
    var saveSVGButton = wrapper.querySelector("[data-action=save-svg]");
    var canvas = wrapper.querySelector("canvas");
    var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)'
    });

    $(document).ready(function () {

        if(localStorage.getItem("Status"))
        {
          var html = '<i class="material-icons left">info</i><span>'+localStorage.getItem("Status")+'</span>';
          M.toast({html: html+'<button class="btn-flat red-text toast-action" onclick="M.Toast.dismissAll()">DISMISS</button>'});
          localStorage.clear();
        }
      
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


        $('#rtv_received_by').on('keyup', function(){
          console.log($(this).val().length);
          if($(this).val().length > 0)
          {
            if(trim($(this).val())){
              $('#btnReceive').prop('disabled', false);
            }
          } else {
            $('#btnReceive').prop('disabled', true);
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
      rcv_items = [];
      $('#receiveModal').modal('open');
      $.get('rtv/'+id, (response) => {
        var data = response.data[0];
        $('#rtv_code').val(data.rtv_code);
        $('#rtv_vendor').val(data.vendors.ven_name);
   
        $.get('list/'+data.rtv_code+'/items', (response) => {
          var datax = response.data;
          $.each(datax, (index, row) => {
            if(row.status=='Return to Vendor'){
                  rcv_items.push({"trans_code": row.trans_code,
                            "item_code": row.item_code,
                            "item_desc": row.item_details.item_desc,
                            "quantity": row.quantity,
                            "status": row.status,
                            "is_check": false,
                            "inventory_location": row.inventory_location_code,
                            });
            }
          });
          renderItems(rcv_items,$('#rcv-items-dt tbody'),'rcv');
        });

      });
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
        } else if(loc=='rcv'){
          var id = parseInt(index) + 1;
          table.append('<tr>'+
                    '<td class="left-align">'+id+'</td>'+
                    '<td class="left-align">'+row.item_code+'</td>'+
                    '<td class="left-align">'+row.item_desc+'</td>'+
                    '<td class="left-align">'+row.quantity+'</td>'+
                    '<td class="left-align">'+row.status+'</td>'+
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

    const receive = () => {
      var canvas = document.getElementById('e-signature-pad');
      var rtv_code = $('#rtv_code').val();
      var received_by = $('#rtv_received_by').val();
      var dataURL = canvas.toDataURL();
      $.ajax({
        type: "POST",
        url: "/reiss/inventory/rtv/rcv_item",
        data: { 
          "_token": "{{ csrf_token() }}",
          "imgBase64": dataURL,
          "rtv_code": rtv_code,
          "received_by": received_by,
        }
      }).done(function(data) {
        if (data) {
            localStorage.setItem("Status","Item Successfully Received by the Vendor!")
            window.location.reload(); 
        }
      });
    }

    function resizeCanvas() {
        var ratio =  Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    window.onresize = resizeCanvas;

    clearButton.addEventListener("click", function (event) {
        signaturePad.clear();
    });

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
                    case "Received":
                      return  '<span class="new badge teal white-text" data-badge-caption="">Received by Vendor</span>';
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
                    case 'For Approval':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Approval</span>';
                      break;
                    case 'For Review':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Review</span>';
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
                    case 'For Approval':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Approval</span>';
                      break;
                    case 'For Review':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Review</span>';
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
                  return  '<a href="#" class="btn-small teal darken-1 waves-effect waves-dark" onclick="receiveRTV('+data+')"><i class="material-icons">assignment_turned_in</i></a>';
                }
            },   
        ]
  });
  
  </script>
    <!-- End of SCRIPTS -->
@endsection