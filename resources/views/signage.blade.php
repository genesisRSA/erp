
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RGC Digital Signage</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/template.css') }}" rel="stylesheet">
    </head>
    <body style="background-color: black;overflow: hidden;">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel" data-keyboard="true" data-interval="false">
            <div class="carousel-inner">
                @foreach ($signages as $sign)
                    @if($sign->is_video == 0)
                        <div class="carousel-item">
                            <img class="d-block w-100" src="/{{$sign->source_url}}">
                        </div>
                    @else
                        <div class="carousel-item">
                            <video src="/{{$sign->source_url}}" muted autoplay></video>
                        </div>
                    @endif
                @endforeach
            </div>
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
                    interval: 5000
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

                var totalItems = {{count($signages)}};

                var currentIndex = $('div.active').index() + 1;

                if(totalItems == currentIndex && totalItems == 0){
                    setTimeout(function(){ location.reload(); },5000);
                }


                $('video').on('play', function (e) {
                    $("#carousel").carousel('pause');
                    e.muted = false;
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

                $('.carousel-item > img').css({'width': '100%', 'height': '100%', 'overflow-y': 'hidden'});

                $('.carousel-item > video').css({'width': '100%', 'height': '100%', 'overflow-y': 'hidden'});

        </script>
    </body>
</html>
            