<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title','') - {{strtoupper($site)}}</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/template.css') }}" rel="stylesheet">
        <link href="{{ asset('datatables/datatables.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="d-flex flex-row">
            @include('includes.'.$site.'.sidebar', ['page' => $page])
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

@include('includes.'.$site.'.js', ['page' => $page])
@include('includes.'.$site.'.modal', ['page' => $page])

</html>
            