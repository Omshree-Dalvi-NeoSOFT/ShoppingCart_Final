@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="content-wrapper p-2">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">{{ __('Settings') }}</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" id="successMessage" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{route('updateSettings')}}" method="POST">
                    @csrf
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"  name="registration" <?php if($settings['registration'] == 1){echo "checked";} ?>>
                        <label class="form-check-label text-bold" for="flexSwitchCheckDefault">Receive Mails on New User Registration</label>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"  name="orders" <?php if($settings['order'] == 1){echo "checked";} ?>>
                        <label class="form-check-label text-bold" for="flexSwitchCheckChecked">Receive Mails on New Order Placed</label>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"  name="contact" <?php if($settings['contact'] == 1){echo "checked";} ?>>
                        <label class="form-check-label text-bold" for="flexSwitchCheckChecked">Receive Mails on New Contact Request</label>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
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
