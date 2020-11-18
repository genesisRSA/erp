<ul id="slide-out" class="sidenav sidenav-fixed">
    <div class="card" style="margin:0;">
        <div class="card-image">
            <img src="{{ asset('images/resbanner.png') }}">
            <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">power_settings_new</i></a>
            <span class="card-title">Franz Delomen</span>
        </div>
    </div>
    <li @if($page=='home')class="active"@endif><a href="#" class="waves-effect waves-light"><i class="material-icons">dashboard</i>Dashboard</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">ERP Process</a></li>
    <li>
      <ul class="collapsible collapsible-accordion">
        <li>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">storage</i>Master Data</a>
          <div class="collapsible-body">
            <ul>
              <li><a href="#!">Customers</a></li>
              <li><a href="#!">Vendors</a></li>
              <li><a href="#!">Item Categories</a></li>
              <li><a href="#!">Item Subcategories</a></li>
              <li><a href="#!">Item Master</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">build</i>Products</a>
          <div class="collapsible-body">
            <ul>
              <li><a href="#!">Product List</a></li>
              <li><a href="#!">Modules</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">request_page</i>Sales</a>
          <div class="collapsible-body">
            <ul>
              <li><a href="#!">Sales Quotation</a></li>
              <li><a href="#!">Sales Order</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">build_circle</i>Projects</a>
          <div class="collapsible-body">
            <ul>
              <li><a href="#!">Project Plans</a></li>
              <li><a href="#!">Project List</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">grading</i>Document Control Centre</a>
          <div class="collapsible-body">
            <ul>
              <li><a href="#!">PO Specs</a></li>
              <li><a href="#!">Design Review</a></li>
              <li><a href="#!">Bill of Materials</a></li>
              <li><a href="#!">Drawings</a></li>
              <li><a href="#!">Software Documentation</a></li>
              <li><a href="#!">Manuals</a></li>
              <li><a href="#!">Procedures</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">shopping_cart</i>Purchasing</a>
          <div class="collapsible-body">
            <ul>
              <li><a href="#!">Request for Quotation</a></li>
              <li><a href="#!">Purchase Request</a></li>
              <li><a href="#!">Purchase Order</a></li>
              <li><a href="#!">Purchase Order Amendment</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">archive</i>Parts Preparation</a>
          <div class="collapsible-body">
            <ul>
              <li><a href="#!">Receiving</a></li>
              <li><a href="#!">Inventory List</a></li>
              <li><a href="#!">Inventory Issuance</a></li>
              <li><a href="#!">Finish Goods</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">Administration</a></li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">admin_panel_settings</i>Admin Panel</a>
          <div class="collapsible-body">
            <ul>
              <li><a href="#!">Site Permission</a></li>
              <li><a href="#!">Approval Matrix</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li @if($page=='parameters')class="active"@endif>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">tune</i>Parameters</a>
          <div class="collapsible-body">
            <ul>
              <li><a href="#!">Accounts</a></li>
              <li><a href="#!">Currencies</a></li>
              <li @if($subpage=='uom')class="active"@endif><a href="{{ route('res.params.uom')}}">Units</a></li>
              <li><a href="#!">Payment Terms</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
  </ul>