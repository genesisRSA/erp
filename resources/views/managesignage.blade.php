<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RGC Digital Signage</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/template.css') }}" rel="stylesheet">
        <link href="{{ asset('datatables/datatables.css') }}" rel="stylesheet">
    </head>
    <body style="background-color: #eee;">
        <div class="container-fluid">
            <div class="card mb-3 mt-3">
                <h5 class="card-header bg-primary text-white">RGC Digital Signage</h5>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <strong>Success,</strong> {{$message}}
                        </div>
                    @endif
                    <div class="row pt-3 mb-3">
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('signages.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Sign Type  <sup class="text-danger">*</sup></label>
                                    <select class="form-control {{ $errors->has('is_video') ? 'is-invalid' : '' }}" name="is_video" id="is_video">
                                        <option value="" disabled selected>Choose sign type...</option>
                                        <option value="0">Image</option>
                                        <option value="1">Video</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('access_id') }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label id="label_source_url">Image <sup class="text-danger">*</sup></label>
                                    <input type="file" class="form-control {{ $errors->has('source_url') ? 'is-invalid' : '' }}" name="source_url" id="source_url" accept=".jpg,.png" required/>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('source_url') }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label id="label_source_url_vertical">Image Vertical <sup class="text-danger">*</sup></label>
                                    <input type="file" class="form-control {{ $errors->has('source_url_vertical') ? 'is-invalid' : '' }}" name="source_url_vertical" id="source_url_vertical" accept=".jpg,.png" required/>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('source_url') }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status  <sup class="text-danger">*</sup></label>
                                    <select class="form-control {{ $errors->has('is_video') ? 'is-invalid' : '' }}" name="is_enabled" id="is_enabled"  required>
                                        <option value="" disabled selected>Choose sign status...</option>
                                        <option value="1">Enabled</option>
                                        <option value="0">Disabled</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('access_id') }}
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mr-2 float-right">Save</button>
                            </form>
                        </div>
                        <div class="col-md-3 text-center">
                            <label>Preview</label><br>
                            <img src="{{url('/images/hris-banner.png')}}" class="img-thumbnail" id="img_preview" style="width:384px;height:216px;" />
                            <video src="{{url('/videos/sample.mp4')}}" loop muted controls id="vid_preview"  style="width:384px;height:216px;display:none;" ></video>
                        </div>
                        <div class="col-md-3 text-center">
                            <label>Preview Vertical</label><br>
                            <img src="{{url('/images/hris-banner.png')}}" class="img-thumbnail" id="img_preview_vertical" style="height:384px;width:216px;" />
                            <video src="{{url('/videos/sample_vertical.mp4')}}" loop muted controls id="vid_preview_vertical"  style="height:384px;width:216px;display:none;background-color:black;" ></video>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <hr>
                            <table id="signs-dt" class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Preview</th>
                                        <th>Preview Vertical</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            var report_dt = $('#signs-dt').DataTable({
                "autoWidth": false,
                "responsive": true,
                //dom: 'Bfrtip',
                "pagingType": "full",
                "ajax": "/api/signages/all",
                "columns": [
                    { "data": "id" },
                    {
                        "targets": 2,
                        "data": "is_video",
                        "render": function ( data, type, row, meta ) {
                            if(data==0){
                                return "Image";                                
                            }else{
                                return "Video";
                            }
                        }
                    },
                    {
                        "targets": 3,
                        "data": "is_enabled",
                        "render": function ( data, type, row, meta ) {
                            if(data==0){
                                return '<span class="text-danger">Disabled</span>';                                
                            }else{
                                return '<span class="text-success">Enabled</span>';
                            }
                        }
                    },
                    {
                        "targets": 4,
                        "data": "source_url",
                        "render": function ( data, type, row, meta ) {
                            if(row.is_video == 0){
                                return '<img src="/'+data+'" class="img-thumbnail text-center" style="width:384px;height:216px;" />';                             
                            }else{
                                return '<video src="/'+data+'" class="text-center" loop muted controls style="width:384px;height:216px;" ></video>';
                            }
                        }
                    },
                    {
                        "targets": 5,
                        "data": "source_url_vertical",
                        "render": function ( data, type, row, meta ) {
                            if(row.is_video == 0){
                                return '<img src="'+data+'" class="img-thumbnail text-center" style="height:384px;width:216px;" />';                             
                            }else{
                                return '<video src="'+data+'" class="text-center" loop muted controls style="height:384px;width:216px;"></video>';
                            }
                        }
                    },
                    {
                        "targets": 6,
                        "data": "id",
                        "render": function ( data, type, row, meta ) {
                            if(row.is_enabled == 0){
                                return  '<div class="btn-group btn-group-sm"> '+
                                '<a href="signages/'+data+'/enable" class="btn btn-success"><i class="fas fa-edit"></i> Enable</a> '+
                                '<a href="signages/'+data+'/delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a> '+
                                '</div>';

                            }else{
                                return  '<div class="btn-group btn-group-sm">'+
                                '<a href="signages/'+data+'/disable" class="btn btn-warning"><i class="fas fa-edit"></i> Disable</a> '+
                                '<a href="signages/'+data+'/delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a> '+
                                '</div>';
                            }
                        }
                    },
                ]
            })

            $('#is_video').change(function(){
                if($(this).val()==0){
                    $('#label_source_url').html('Image <sup class="text-danger">*</sup>');
                    $('#label_source_url_vertical').html('Image Vertical<sup class="text-danger">*</sup>');
                    $('#img_preview').fadeIn(); 
                    $('#img_preview_vertical').fadeIn();
                    $('#vid_preview').fadeOut();
                    $('#vid_preview_vertical').fadeOut();
                    $('#source_url').attr('accept',".jpg,.png");
                    $('#source_url_vertical').attr('accept',".jpg,.png");
                }else{
                    $('#label_source_url').html('Video <sup class="text-danger">*</sup>');
                    $('#label_source_url_vertical').html('Video Vertical<sup class="text-danger">*</sup>');
                    $('#img_preview').fadeOut();
                    $('#img_preview_vertical').fadeOut();
                    $('#vid_preview').fadeIn();
                    $('#vid_preview_vertical').fadeIn();
                    $('#source_url').attr('accept',".mp4");
                    $('#source_url_vertical').attr('accept',".mp4");
                }
            });

            $('#is_video').val(0);

            function readURL(input,id) {
                var p_id = id;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $(p_id).attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#source_url_vertical").change(function () {
                if($('#is_video').val()==0){
                    readURL(this,'#img_preview_vertical');
                }else{
                    readURL(this,'#vid_preview_vertical');
                }
            });

            $("#source_url").change(function () {
                if($('#is_video').val()==0){
                    readURL(this,'#img_preview');
                }else{
                    readURL(this,'#vid_preview');
                }
            });
        });
    </script>
</html>
            