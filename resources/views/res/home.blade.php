<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.min.css') }}"  media="screen,projection"/>
      <title>RGC Enterprise System</title>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <style>
        header, main, footer {
          padding-left: 300px;
        }

        @media only screen and (max-width : 992px) {
          header, main, footer {
            padding-left: 0;
          }
        }
      </style> 
    </head>
    <body>
      <ul id="slide-out" class="sidenav sidenav-fixed">
        <li><a href="#" class="waves-effect waves-teal"><i class="material-icons">dashboard</i>Dashboard</a></li>
        <li><div class="divider"></div></li>
        <li><a class="subheader">ERP Process</a></li>
        <li>
          <ul class="collapsible collapsible-accordion">
            <li>
              <a class="collapsible-header waves-effect waves-teal" style="padding-left:32px;"><i class="material-icons">storage</i>Master Data</a>
              <div class="collapsible-body">
                <ul style="padding-left:32px;">
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
              <a class="collapsible-header waves-effect waves-teal" style="padding-left:32px;"><i class="material-icons">build</i>Products</a>
              <div class="collapsible-body">
                <ul style="padding-left:32px;">
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
              <a class="collapsible-header waves-effect waves-teal" style="padding-left:32px;"><i class="material-icons">request_page</i>Sales</a>
              <div class="collapsible-body">
                <ul style="padding-left:32px;">
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
              <a class="collapsible-header waves-effect waves-teal" style="padding-left:32px;"><i class="material-icons">build_circle</i>Projects</a>
              <div class="collapsible-body">
                <ul style="padding-left:32px;">
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
              <a class="collapsible-header waves-effect waves-teal" style="padding-left:32px;"><i class="material-icons">grading</i>Document Control Centre</a>
              <div class="collapsible-body">
                <ul style="padding-left:32px;">
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
              <a class="collapsible-header waves-effect waves-teal" style="padding-left:32px;"><i class="material-icons">shopping_cart</i>Purchasing</a>
              <div class="collapsible-body">
                <ul style="padding-left:32px;">
                  <li><a href="#!">Request for Quotation</a></li>
                  <li><a href="#!">Purchase Request</a></li>
                  <li><a href="#!">Purchase Order</a></li>
                  <li><a href="#!">Purchase Order Amendment</a></li>
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
              <a class="collapsible-header waves-effect waves-teal" style="padding-left:32px;"><i class="material-icons">admin_panel_settings</i>Admin Panel</a>
              <div class="collapsible-body">
                <ul style="padding-left:32px;">
                  <li><a href="#!">Permission</a></li>
                  <li><a href="#!">Approval Matrix</a></li>
                </ul>
              </div>
            </li>
          </ul>
        </li>
      </ul>
      <script src="{{ asset('js/app.js') }}"></script>
      <!--JavaScript at end of body for optimized loading-->
      <script type="text/javascript">
        $(document).ready(function(){
          $('.sidenav').sidenav();
          $('.collapsible').collapsible();
        });
      </script>
      <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
    </body>
  </html>
        