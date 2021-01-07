@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ route('signages.index') }}" class="mr-3"><i class="fas fa-arrow-left"></i></a> Create Signage</h3>
            <hr>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error,</strong> Please see fields with <i class="fas fa-times"></i> mark on it.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('signages.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="container-fluid">
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
                                    <label>Department  <sup class="text-danger">*</sup></label>
                                    <select class="form-control" name="status" id="status">
                                        <option>HR</option>
                                        <option>Sales</option>
                                        <option>QC</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('access_id') }}
                                    </div>
                                </div>
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
                                    <label id="label_sexpiration_date">Expiration <sup class="text-danger">*</sup></label>
                                    <input type="date" min="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}" class="form-control {{ $errors->has('expiration_date') ? 'is-invalid' : '' }}" name="expiration_date" id="expiration_date" required/>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('expiration_date') }}
                                    </div>
                                </div>
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
                    <div class="row mt-3 float-right border-top">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                        <a href="{{ route('signages.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        
    </script>
 @stop

