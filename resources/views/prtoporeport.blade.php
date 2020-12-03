<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PR to PO Report</title>

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
                            <th>ID</th>
                            <th>PR Number</th>
                            <th>PR Date</th>
                            <th>PR Status</th>
                            <th>PO Number</th>
                            <th>PO Date</th>
                            <th>PR to PO Days</th>
                            <th>Received Date</th>
                            <th>Item</th>
                            <th>Remarks</th>
                            <th>Supplier Name</th>
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
            "order": [[ 2, "desc" ]],
            buttons: [
                'excel', 'pdf', 'print'
            ],
            "pagingType": "full",
            "ajax": "/api/report/prtoporeport",
            "columns": [
                { "data": "ID" },
                { "data": "PRNo" },
                { "data": "PRDate" },
                { "data": "PRStatus" },
                { "data": "PONum",
                  "render": function ( data, type, row, meta ) {
                        if(data){ return data; } else { return '<strong class="text-danger">N/A</strong>'; }
                  }
                },
                { "data": "PODate",
                  "render": function ( data, type, row, meta ) {
                        if(data){ return data; } else { return '<strong class="text-danger">N/A</strong>'; }
                  }
                },
                { "data": "PRtoPODays" },
                { "data": "ReceivedDate",
                  "render": function ( data, type, row, meta ) {
                        if(data){ return data; } else { return '<strong class="text-danger">N/A</strong>'; }
                  }
                },
                { "data": "Item" },
                { "data": "Supplier",
                  "render": function ( data, type, row, meta ) {
                        if(data){ return data; } else { return '<strong class="text-danger">N/A</strong>'; }
                  }
                },
            ]
        })
    })
</script>



</html>
            