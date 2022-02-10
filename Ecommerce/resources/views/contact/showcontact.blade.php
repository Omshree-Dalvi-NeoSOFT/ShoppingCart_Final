@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="content-wrapper p-2">   
    <div class="container-fluid">
        <div class="card">
            <div class="card-header row">
                <div class="col-sm-2">
                    {{ __('Contact Notifications') }}
                </div>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" id="successMessage" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <table class="table" id="example1">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sender Name</th>
                        <th scope="col">Sender Email</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Message</th>
                        <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact )
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$contact->name}}</td>
                                <td>{{$contact->email}}</td>
                                <td>{{$contact->subject}}</td>
                                <td>{{$contact->message}}</td>

                                    @if ($contact->status == 0)
                                    <td><a href="replycontact/{{ $contact->id }}" class="btn btn-success btn-sm" role="button">Reply</a></td>
                                    @else
                                    <td class="text text-danger">Replied</td>
                                    @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
       $(function () {
            $('#example1').DataTable( {
                "responsive": false, 
                "lengthChange": false,
                "autoWidth": false,
                dom: 'Blfrtip',
                buttons: [
                    {
                extend: 'csv',
                footer: false,
                exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
            },
            {
                extend: 'excel',
                footer: false,
                exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
            },
            {
                extend: 'pdf',
                title:'ContactUs',
                footer: true,
                exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
            }
            ]
            } ).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
        setTimeout(function() {
        $('#successMessage').fadeOut('fast');
    }, 3000);
    </script>
@endsection
