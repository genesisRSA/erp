<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title','') - {{strtoupper($site)}}</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/template.css') }}" rel="stylesheet">
        <link href="{{ asset('datatables/datatables.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    </head>
    <body>
        @include('includes.'.$site.'.navbar', ['page' => $page])
        <div class="d-flex flex-row">
            
            <?php
            date_default_timezone_set('Asia/Manila'); ?>
            <div class="d-none d-sm-block">
                @include('includes.'.$site.'.sidebar', ['page' => $page])
            </div>
            <div class="m-3 main-content">
                @yield('content')
            </div>
        </div>
    </body>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>

@include('includes.'.$site.'.js', ['page' => $page])
@include('includes.'.$site.'.modal', ['page' => $page])

</html>
            