<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RGC Digital Signage</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/template.css') }}" rel="stylesheet">
    </head>
    <body style="background-color: #eee;overflow: hidden;">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel" data-keyboard="true" data-interval="false">
            <div class="carousel-inner">
                @foreach ($signages as $sign)
                    @if($sign->is_video == 0)
                        <div class="carousel-item">
                            <img class="d-block w-100" src="/{{$sign->source_url_vertical}}">
                        </div>
                    @else
                        <div class="carousel-item">
                            <video src="/{{$sign->source_url_vertical}}" muted></video>
                        </div>
                    @endif
                @endforeach
                @foreach ($jolist as $jo)
                    <div class="carousel-item">
                        <h1 class="text-center" style="font-size:120px;margin-top:1%;">{{$jo->PROJECTNAME}}</h1>
                        <h1 class="text-center" style="font-size:100px;margin-top:5px;color:red;">({{$jo->JONUMBER}})</h1>
                        <h1 class="text-center mt-3">
                            STATUS : <button class="btn btn-{{$jo->COLORCODESTATUS=='DELIVERED'?'success':'warning'}}" style="font-size:70px;">{{$jo->COLORCODESTATUS}}</button>
                        </h1>
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="card border-secondary ml-3 mr-3" style="font-size:70px;margin-top:100px;">
                                    <div class="card-header">PROJECT DETAILS</div>
                                    <div class="card-body text-secondary">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <strong>CUSTOMER:</strong> {{$jo->CUSTOMER}}
                                            </div>
                                            <div class="col-md-8 text-right">
                                                <strong>PROJECT OWNER:</strong> {{$jo->PROJECTOWNER}}
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <strong>JO DATE:</strong> {{$jo->JODATE}}
                                            </div>
                                            <div class="col-md-8 text-right">
                                                <strong>TARGET DELIVERY DATE:</strong> {{$jo->TARGETDELIVERY}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>QUANTITY:</strong> {{$jo->QUANTITY}}
                                            </div>
                                            <div class="col-md-8 text-right">
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card border-primary" style="font-size:50px;margin-top:50px;">
                                                    <div class="card-header bg-primary text-white">SOFTWARE IN CHARGE</div>
                                                    <div class="card-body text-primary">
                                                        <p class="card-text">{{$jo->SOFTWAREINCHARGE}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card border-info" style="font-size:50px;margin-top:50px;">
                                                    <div class="card-header bg-info text-white">MECHANICAL IN CHARGE</div>
                                                    <div class="card-body text-info">
                                                        <p class="card-text">{{$jo->MECHANICALINCHARGE}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-success ml-3 mr-3" style="font-size:70px;margin-top:20px;">
                                    <div class="card-header bg-success text-white">PROJECT PROGRESS</div>
                                    <div class="card-body text-secondary">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <strong>SALES</strong><br>
                                                <div class="progress bg-danger" style="font-size: 50px;height:60px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{number_format($jo->SALES_PERC, 2, '.', '')}}" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format($jo->SALES_PERC, 2, '.', '')}}%">{{number_format($jo->SALES_PERC, 2, '.', '')}}%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <strong>DESIGN</strong><br>
                                                <div class="progress bg-danger" style="font-size: 50px;height:60px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{number_format($jo->DESIGN_PERC, 2, '.', '')}}" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format($jo->DESIGN_PERC, 2, '.', '')}}%">{{number_format($jo->DESIGN_PERC, 2, '.', '')}}%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <strong>SOFTWARE</strong><br>
                                                <div class="progress bg-danger" style="font-size: 50px;height:60px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{number_format($jo->SOFT_PERC, 2, '.', '')}}" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format($jo->SOFT_PERC, 2, '.', '')}}%">{{number_format($jo->SOFT_PERC, 2, '.', '')}}%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <strong>PURCHASING</strong><br>
                                                <div class="progress bg-danger" style="font-size: 50px;height:60px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{number_format($jo->PURCH_PERC, 2, '.', '')}}" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format($jo->PURCH_PERC, 2, '.', '')}}%">{{number_format($jo->PURCH_PERC, 2, '.', '')}}%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <strong>PRODUCTION</strong><br>
                                                <div class="progress bg-danger" style="font-size: 50px;height:60px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{number_format($jo->PROD_PERC, 2, '.', '')}}" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format($jo->PROD_PERC, 2, '.', '')}}%">{{number_format($jo->PROD_PERC, 2, '.', '')}}%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <strong>ASSEMBLY</strong><br>
                                                <div class="progress bg-danger" style="font-size: 50px;height:60px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{number_format($jo->ASSY_PERC, 2, '.', '')}}" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format($jo->ASSY_PERC, 2, '.', '')}}%">{{number_format($jo->ASSY_PERC, 2, '.', '')}}%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <strong>QC</strong><br>
                                                <div class="progress bg-danger" style="font-size: 50px;height:60px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{number_format($jo->QC_PERC, 2, '.', '')}}" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format($jo->QC_PERC, 2, '.', '')}}%">{{number_format($jo->QC_PERC, 2, '.', '')}}%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                @endforeach
        <!--<a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>-->
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript">
                var $myCarousel = $("#carousel");
                $myCarousel.carousel({
                    interval: 10000
                });

                
                $('#carousel').find('.carousel-item').first().addClass('active');
                $('#carousel').find('.carousel-item').first().each(function(){
                    currentIndex = $('div.active').index() + 1;
                    var vids = $(this).find("video");
                    if(vids.length > 0){
                        vids[0].pause();
                        vids[0].currentTime = 0;
                        vids[0].play();
                    }else{
                    }
                });

                $("#carousel").carousel('cycle');

                var totalItems = {{count($signages)+count($jolist)}};

                var currentIndex = $('div.active').index() + 1;

                if(totalItems == currentIndex && totalItems == 0){
                    setTimeout(function(){ location.reload(); },5000);
                }

                $('video').on('play', function (e) {
                    $("#carousel").carousel('pause');
                });
                $('video').on('ended', function (e) {
                    if(currentIndex == totalItems){
                        location.reload();
                    }else{
                        $("#carousel").carousel('cycle');
                    }
                });

                
                $("#carousel").on('slide.bs.carousel', function () {
                    currentIndex = $('div.active').index() + 1;
                    if(currentIndex == totalItems){
                        location.reload();
                    }
                });

                $("#carousel").on('slid.bs.carousel', function () {
                    var vids = $(this).find(".active video");
                    if(vids.length > 0){
                        vids[0].pause();
                        vids[0].currentTime = 0;
                        vids[0].play();
                    }else{
                        if(currentIndex == totalItems){
                            location.reload();
                        }
                    }
                });
                
                $('.carousel-item > img').css({'width': 1280, 'height': 720, 'overflow-y': 'hidden'});

                $('.carousel-item > video').css({'width': 1280, 'height': 720, 'overflow-y': 'hidden'});
        </script>
    </body>
</html>
            