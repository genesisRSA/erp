
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RGC Digital Signage</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/template.css') }}" rel="stylesheet">
    </head>
    <body>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel" data-keyboard="true" data-interval="false">
            <div class="carousel-inner">
                @foreach ($signages as $sign)
                    @if($sign->is_video == 0)
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="/{{$sign->source_url_vertical}}">
                        </div>
                    @else
                        <div class="carousel-item">
                            <video src="/{{$sign->source_url_vertical}}" playsinline showcontrols></video>
                        </div>
                    @endif
                @endforeach
            </div>
        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript">
                var $myCarousel = $("#carousel");
                $myCarousel.carousel({
                    interval: 5000
                });


                var totalItems = {{count($signages)}};

                var currentIndex = $('div.active').index() + 1;

                $('video').on('play', function (e) {
                    $("#carousel").carousel('pause');
                });
                $('video').on('ended', function (e) {
                    //console.log("currentIndex:"+currentIndex);
                    //console.log("totalItems:"+totalItems);
                    if(currentIndex == totalItems){
                        location.reload();
                    }else{
                        $("#carousel").carousel('cycle');
                    }
                });

                
                $("#carousel").on('slide.bs.carousel', function () {
                    currentIndex = $('div.active').index() + 1;
                    //console.log("currentIndex:"+currentIndex);
                    //console.log("totalItems:"+totalItems);
                });

                $("#carousel").on('slid.bs.carousel', function () {
                   //console.log("currentIndex:"+currentIndex);
                    //console.log("totalItems:"+totalItems);
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

                $('.carousel-item > img').css({'width': 1080, 'height': 1920, 'overflow-y': 'hidden'});

                $('.carousel-item > video').css({'width': 1080, 'height': 1920, 'overflow-y': 'hidden'});

                
                $('#carousel').find('.carousel-item').first().addClass('active');

        </script>
    </body>
</html>
            