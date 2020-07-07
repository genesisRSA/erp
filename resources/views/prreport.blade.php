<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PR Report</title>

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
                            <th>PurchaseRequestId</th>
                            <th>PRNumber</th>
                            <th>PurchaseRequestDate</th>
                            <th>Remarks</th>
                            <th>LineNumber</th>
                            <th>ItemCode</th>
                            <th>Description</th>
                            <th>RequestedQuantity</th>
                            <th>TargetDeliveryDate</th>
                            <th>Status</th>
                            <th>UOM</th>
                            <th>OutstandingQuantity</th>
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
        $('[data-toggle="tooltip"]').tooltip()

        var report_dt = $('#report-dt').DataTable({
            "responsive": true,
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ],
            "pagingType": "full",
            "ajax": "/api/report/prreport",
            "columns": [
                { "data": "PurchaseRequestId" },
                { "data": "PRNumber" },
                { "data": "PurchaseRequestDate" },
                { "data": "Remarks" },
                { "data": "LineNumber" },
                { "data": "ItemCode" },
                { "data": "Description" },
                { "data": "RequestedQuantity" },
                { "data": "TargetDeliveryDate" },
                { "data": "Status" },
                { "data": "UOM" },
                { "data": "OutstandingQuantity" },
            ]
        })
    })
</script>



</html>
            