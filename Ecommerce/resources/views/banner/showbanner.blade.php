@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="content-wrapper p-2">   
    <div class="container-fluid">
        <div class="card">
            <div class="card-header row">
                    <div class="col-sm-2">
                        {{ __('Banner') }}
                    </div>
                    <div class="col-sm-8"></div>
                    <div class="col-sm-2">
                        <a href="" target="_blank" class="btn btn-info btn-sm" role="button">Preview</a>
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
                        <th scope="col">Banner Heading</th>
                        <th scope="col">Banner Description</th>
                        <th scope="col">Banner Image</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banners as $banner )
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$banner->heading}}</td>
                                <td>{{$banner->description}}</td>
                                <td><img src="{{asset('images/banner/'.$banner->banner_image)}}" alt="Asset Image" width="100px" height="100px"></td>
                                <td><a href="editbanner/{{ $banner->id }}" class="btn btn-warning btn-sm" role="button">Edit</a> | <a type="button" class="btn btn-danger btn-sm dtlban" data-bs-toggle="modal" data-bs-target="#staticBackdrop" aid="{{$banner->id}}">
                                    Delete</a>
                                </td>
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
        $(document).ready(function(){
            $(".dtlban").click(function(e){
                var aid = $(this).attr("aid");
                if(confirm("Are you sure ?")){
                    $.ajax({
                        url:"{{url('/deletebanner')}}",
                        type:'post',
                        method:'patch',
                        data:{_token:'{{csrf_token()}}',aid:aid},
                        success:function(response){
                            window.location.reload();
                        },
                        error: function(jqXHR, status, err){
                            window.location.reload();
                        }
                    }) 
                }
            })
        })
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
                        columns: [0,1,2,3]
                    }
            },
            {
                extend: 'excel',
                footer: false,
                exportOptions: {
                        columns: [0,1,2,3]
                    }
            },
            {
                extend: 'pdf',
                title:'Banner',
                footer: true,
                exportOptions: {
                        columns: [0,1,2,3]
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
