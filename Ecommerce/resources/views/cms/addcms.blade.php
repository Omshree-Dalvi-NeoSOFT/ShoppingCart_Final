@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="content-wrapper p-2">   
    <div class="container-fluid">
        <div class="card">
            <div class="card-header row">
                <div class="col-sm-2">
                        {{ __('Add CMS') }}
                    </div>
                    <div class="col-sm-8"></div>
                    <div class="col-sm-2">
                        <a href="{{route('DisplayCMS')}}" class="btn btn-info btn-sm" role="button">View All CMS</a>
                    </div>
                </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" id="successMessage" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="post" enctype="multipart/form-data" action="{{route('PostAddCMS')}}">
                    @csrf
                    <div class="mb-3">
                        <label for="heading" class="form-label">{{ __('CMS Heading') }} <i class="text text-danger">*</i></label>
                        <input type="text" name="heading" class="form-control @error('heading') is-invalid @enderror" id="heading" placeholder="Heading" value="{{ old('heading') }}" autofocus>
                        @error('heading')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cmsdescription" class="form-label">{{ __('CMS Description   ') }} <i class="text text-danger">( optional )</i></label>
                        <textarea class="form-control @error('cmsdescription') is-invalid @enderror" id="cmsdescription" name="cmsdescription" value="{{ old('cmsdescription') }}" rows="3"></textarea>
                        @error('cmsdescription')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cmsimage" class="form-label">{{ __('File upload CMS Image ') }} <i class="text text-danger">*</i></label>
                        <input type="file" name="cmsimage" class="form-control file-upload-info @error('cmsimage') is-invalid @enderror">
                        @error('cmsimage')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Add CMS') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    setTimeout(function() {
        $('#successMessage').fadeOut('fast');
    }, 3000);
</script>
@endsection
