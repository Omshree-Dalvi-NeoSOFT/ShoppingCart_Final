@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="content-wrapper p-2">   
    <div class="container-fluid">
        <div class="card">
            <div class="card-header row">
                <div class="col-sm-2">
                    {{ __('Category') }}
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
                        <th scope="col">Category Name</th>
                        <th scope="col">Category Description</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category as $cat )
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$cat->cat_name}}</td>
                                <td>{{$cat->cat_description}}</td>
                                <td><a href="editcategory/{{ $cat->id }}" class="btn btn-warning btn-sm" role="button">Edit</a> | <a type="button" class="btn btn-danger btn-sm dtlban" data-bs-toggle="modal" data-bs-target="#staticBackdrop" aid="{{$cat->id}}">
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
                if(confirm("Category will be deleted ! Do you want to continue ?")){
                    $.ajax({
                        url:"{{url('/deletecategory')}}",
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
                        columns: [0,1,2]
                    }
            },
            {
                extend: 'excel',
                footer: false,
                exportOptions: {
                        columns: [0,1,2]
                    }
            },
            {
                extend: 'pdf',
                title:'Category',
                footer: true,
                exportOptions: {
                        columns: [0,1,2]
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
