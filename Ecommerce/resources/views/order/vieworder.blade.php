@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="content-wrapper p-2">   
    <div class="container-fluid">
        <div class="card">
            <div class="card-header row">
                <div class="col-sm-2">
                    {{ __('Orders') }}
                </div>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" id="successMessage" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-8">
                        <table class="table" id="example1">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Customer Email</th>
                            <th scope="col">Customer Address</th>
                            <th scope="col">Customer Phone</th>
                            <th scope="col">Customer ZipCode</th>
                            <th scope="col">Order Amount</th>
                            <th scope="col">Order Amount (Coupon)</th>
                            <th scope="col">Coupon Name/Code</th>
                            <th scope="col">Coupon Amount</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userdetails as $detail )
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$detail->firstname}} {{$detail->lastname}}</td>
                                    <td>{{$detail->email}}</td>
                                    <td>{{$detail->address1}}</td>
                                    <td>{{$detail->phone}}</td>
                                    <td>{{$detail->zip}}</td>
                                    @foreach ($orderdetails as $ordetail)
                                        @if ($ordetail->userdetail_id == $detail->id)
                                            <td>{{$ordetail->grandtotal}}</td>
                                            <td>{{$ordetail->finalTotal}}</td>
                                            @if ($ordetail->coupon_id)
                                                @foreach ($coupons as $coupon)
                                                    @if ($coupon->id == $ordetail->coupon_id)
                                                    <td>{{$coupon->code}}</td>
                                                    <td>{{$coupon->value}}</td>
                                                    @endif
                                                @endforeach 
                                            @else
                                            <td>--</td>
                                            <td>--</td>
                                            @endif
                                            
                                        @endif
                                    @endforeach
                                    <td><a href="displayorder/{{ $detail->id }}" class="btn btn-info btn-sm" role="button">Details</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
                
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
                columns: [0,1,2,3,4,5,6,7,8,9]
            }
       },
       {
           extend: 'excel',
           footer: false,
           exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9]
            }
       },
       {
           extend: 'pdf',
           footer: true,
           exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9]
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
