<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Costing</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/template.css') }}" rel="stylesheet">
        <link href="{{ asset('datatables/datatables.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="d-flex flex-row bg-white">
            <div class="m-3 main-content">
                <table id="report-dt" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>PO No.</th>
                            <th>PR No.</th>
                            <th>Item Code</th>
                            <th>Item Description</th>
                            <th>UOM</th>
                            <th>Request Qty</th>
                            <th>Unit Price</th>
                            <th>VAT</th>
                            <th>Net Price</th>
                            <th>Currency</th>
                            <th>RR No.</th>
                            <th>Received Qty.</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </body>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();

        var report_dt = $('#report-dt').DataTable({
            "responsive": true,
            "pagingType": "full",
            "ajax": "/api/report/costing",
            "columns": [
                { "data": "PONumber" },
                { "data": "PurchaseRequestNumber" },
                { "data": "ItemCode" },
                { "data": "Description" },
                { "data": "UnitOfMeasureCode" },
                { "data": "RequestedQuantity" },
                { "data": "UnitPrice" },
                { "data": "VatAmount" },
                { "data": "NetPrice" },
                { "data": "Currency" },
                { "data": "RRNumber" },
                { "data": "ReceivedQuantity" },
            ]
        });
    });
</script>



</html>
            