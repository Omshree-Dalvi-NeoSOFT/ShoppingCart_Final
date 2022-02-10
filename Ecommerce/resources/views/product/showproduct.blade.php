@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="content-wrapper p-2">   
    <div class="container-fluid">
        <div class="card">
            <div class="card-header row">
                <div class="col-sm-2">
                    {{ __('Product') }}
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
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Sub-Cat</th>
                        <th scope="col">Product Colour</th>
                        <th scope="col">Product Quantity</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Product Description</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $prod )
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$prod->prod_name}}</td>
                                @foreach ($prodsubcat as $p )
                                    @if ($prod->sub_category_id == $p->id)
                                    <td>{{$p->subcat_name}}</td>
                                    @endif                                    
                                @endforeach
                                <td>{{$prod->colour}}</td>
                                <td>{{$prod->quantity}}</td>
                                <td>{{$prod->price}}</td>
                                <td>{{$prod->prod_description}}</td>
                                <td><a href="displayproduct/{{ $prod->id }}" class="btn btn-info btn-sm" role="button">Details</a> | <a href="editproduct/{{ $prod->id }}" class="btn btn-warning btn-sm" role="button">Edit</a> | <a type="button" class="btn btn-danger btn-sm dtlban" data-bs-toggle="modal" data-bs-target="#staticBackdrop" aid="{{$prod->id}}">
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
                if(confirm("Product will be deleted ! Do you want to continue ?")){
                    $.ajax({
                        url:"{{url('/deleteproduct')}}",
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
                        columns: [0,1,2,3,4,5,6]
                    }
            },
            {
                extend: 'excel',
                footer: false,
                exportOptions: {
                        columns: [0,1,2,3,4,5,6]
                    }
            },
            {
                extend: 'pdf',
                title:'Product',
                footer: true,
                exportOptions: {
                        columns: [0,1,2,3,4,5,6]
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
