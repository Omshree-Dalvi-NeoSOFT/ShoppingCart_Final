@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="content-wrapper p-2">   
    <div class="container-fluid">
        <div class="card">
            <div class="card-header row">
                <div class="col-sm-2">
                    {{ __('Reply') }}
                </div>
            </div>

            <div class="card-body">
            @if (session('status'))
                    <div class="alert alert-success" id="successMessage" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{route('postreplyContact')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$contact->id}}"/>
                    <div class="row justify-content-center">
                        <div class="col-md-12 mb-3">
                            <label for="prodname" class="col-md-12 col-form-label text-md-end">{{ __('From (Admin)') }}</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="from" value="omshreedalvi98@gmail.com"  autocomplete="from" readonly >
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="to" class="col-md-12 col-form-label text-md-end">{{ __('To,') }}</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="to" value="{{$contact->email}}"  autocomplete="to" readonly >
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="prodname" class="col-md-12 col-form-label text-md-end">{{ __('Subject') }}</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}"  autocomplete="subject" autofocus>
                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="col-md-12 mb-3">
                            <label for="mailbody" class="col-md-3 form-label text-md-end">{{ __('Mail Body') }}</label>
                            <div class="col-md-12">
                                <textarea class="form-control @error('mailbody') is-invalid @enderror" id="mailbody" name="mailbody" value="{{ old('mailbody') }}" rows="6"></textarea>
                                @error('mailbody')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send Mail') }}
                            </button>
                        </div>
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
