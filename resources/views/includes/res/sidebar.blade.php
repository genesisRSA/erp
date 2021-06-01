<a href="#" data-target="slide-out" class="sidenav-trigger hide-on-med-and-up blue-text text-darken-4"><i class="material-icons">menu</i></a>
<ul id="slide-out" class="sidenav sidenav-fixed">
    <div class="card" style="margin:0;">
        <div class="card-image">
            <img src="{{ asset('images/resbanner.png') }}">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">power_settings_new</i></a>
            <span class="card-title flow-text">{{Auth::user()->name}}</span>
        </div>
    </div>
    <li @if($page=='home')class="active"@endif><a href="{{route('res.home')}}" class="waves-effect waves-light"><i class="material-icons">dashboard</i>Dashboard</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">ERP Process</a></li>
    <li>
      <ul class="collapsible collapsible-accordion">
        <li @if($page=='masterdata') class="active" @endif>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">storage</i>Master Data</a>
          <div class="collapsible-body">
            <ul>
              <li @if($subpage=='customer') class="active" @endif><a href="{{ route('customer.index')}}">Customers</a></li>
              <li @if($subpage=='vendor') class="active" @endif><a href="{{ route('vendor.index')}}">Vendors</a></li>
              <li @if($subpage=='itemcategories') class="active" @endif><a href="{{ route('item_category.index')}}">Item Categories</a></li>
              <li @if($subpage=='itemsubcat') class="active" @endif><a href="{{ route('item_subcategory.index')}}">Item Sub-Categories</a></li>
              <li @if($subpage=='itemmaster') class="active" @endif><a href="{{ route('item_master.index') }}">Item Master</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li @if($page=='products') class="active" @endif>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">build</i>Products</a>
          <div class="collapsible-body">
            <ul>              
              <li @if($subpage=='productcategories') class="active" @endif><a href="{{ route('product_category.index') }}">Product Categories</a></li>
              <li @if($subpage=='productlist') class="active" @endif><a href="{{ route('product.index') }}">Product List</a></li>
              <li @if($subpage=='assemblylist') class="active" @endif><a href="{{ route('assembly.index') }}">Assembly List</a></li>
              <li @if($subpage=='fabricationlist') class="active" @endif><a href="{{ route('fabrication.index') }}">Fabrication List</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li @if($page=='sales') class="active" @endif>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">request_page</i>Sales</a>
          <div class="collapsible-body">
            <ul>
              <li @if($subpage=='salesdashboard') class="active" @endif><a href="/reiss/dashboard/sales">Sales Dashboard</a></li>
              <li @if($subpage=='visit') class="active" @endif><a href="{{ route('visit.index') }}">Sales Visit</a></li>
              <li @if($subpage=='forecast') class="active" @endif><a href="{{ route('forecast.index') }}">Sales Forecast</a></li>
              <li @if($subpage=='quotation') class="active" @endif><a href="{{ route('quotation.index') }}">Sales Quotation</a></li>
              <li @if($subpage=='order') class="active" @endif><a href="{{ route('order.index') }}">Sales Order</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li @if($page=='projects') class="active" @endif>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">build_circle</i>Projects</a>
          <div class="collapsible-body">
            <ul>  
              <li @if($subpage=='list') class="active" @endif><a href="{{ route('projects.index') }}">Project List</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li @if($page=='dcc') class="active" @endif>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">grading</i>Document Control Centre</a>
          <div class="collapsible-body">
            <ul>
              <li><a href="#!">PO Specs</a></li>
              <li><a href="#!">Design Review</a></li>
              <li><a href="#!">Bill of Materials</a></li>
              <li @if($subpage=='drawings') class="active" @endif><a href="{{ route('drawing.index') }}">Drawings</a></li>
              <li><a href="#!">Software Documentation</a></li>
              <li><a href="#!">Manuals</a></li>
              <li @if($subpage=='procedures') class="active" @endif><a href="{{ route('procedure.index') }}">Procedures</a></li>
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
        <li @if($page=='inventory') class="active" @endif>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">archive</i>Parts Preparation</a>
          <div class="collapsible-body">
            <ul>
              <li @if($subpage=='receiving') class="active" @endif><a href="{{ route('receiving.index') }}">Receiving</a></li>
           
 
              <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                  <li @if($page=='inventory' && ($subpage == 'store' || $subpage == 'vendor')) class="active" @endif>
                    <a class="collapsible-header waves-effect waves-light" style="padding-left:29px;"><i class="material-icons"></i>Returned Items</a>
                    <div class="collapsible-body">
                      <ul>
                        <li @if($subpage=='store') class="active" @endif>
                          <a href="{{ route('return.index') }}">Return to Store</a>
                        </li>
                        <li @if($subpage=='vendor') class="active" @endif>
                          <a href="{{ route('rtv.index') }}">Return to Vendor</a>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </li>

              <li @if($subpage=='inventory') class="active" @endif><a href="{{ route('list.index') }}">Inventory List</a></li>
              <li @if($subpage=='location') class="active" @endif><a href="{{ route('location.index') }}">Inventory Location</a></li>
              <li @if($subpage=='issuance') class="active" @endif><a href="{{ route('issuance.index') }}">Inventory Issuance</a></li>
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
        <li @if($page=='admin')class="active"@endif>
          <a class="collapsible-header waves-effect waves-light" style="padding-left:32px;"><i class="material-icons">admin_panel_settings</i>Admin Panel</a>
          <div class="collapsible-body">
            <ul>
              <li @if($subpage=='permission') class="active" @endif><a href="{{ route('permission.index') }}">Site Permission</a></li>
              <li @if($subpage=='approver') class="active" @endif><a href="{{ route('approver.index') }}">Approver Matrix</a></li>
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
              <li @if($subpage=='currency') class="active" @endif><a href="{{ route('currency.index')}}">Currencies</a></li>
              <li @if($subpage=='uom') class="active" @endif><a href="{{ route('uom.index')}}">Units</a></li>
              <li @if($subpage=='payment_term') class="active" @endif><a href="{{ route('payment_term.index')}}">Payment Terms</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
  </ul>
    <form id="logout-form" action="{{ route('reiss.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>