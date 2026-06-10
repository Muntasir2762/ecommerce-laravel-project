@extends('admin.master')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Order List</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order List</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Order List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Order Date</th>
                                            <th>Invoice</th>
                                            <th>Customer Info</th>
                                            <th>Product(s)</th>
                                            <th>Delivery Charge</th>
                                            <th>Price</th>
                                            <th>Courier</th>
                                            <th>Status</th>
                                            <th style="width: 40px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                        <tr class="align-middle">
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$order->created_at}}</td>
                                            <td>{{$order->invoice_number}}</td>
                                            <td>
                                                <p style="color: red">IP:{{$order->ip_address}}</p>
                                                Name: {{$order->name}}
                                                <p style="color: green"><b>Phone: {{$order->phone}}</b></p>
                                                <p><b>Address: {{$order->address}}</b></p>
                                            </td>
                                            <td>
                                                @foreach ($order->orderDetails as $details)
                                                    <img src="{{$details->product->image}}" height="100" width="100"><br>
                                                    {{$details->product->name}} X 1 <br>
                                                @endforeach
                                            </td>
                                            <td>{{$order->charge}}</td>
                                            <td>{{$order->price}}</td>
                                            <td>{{$order->courier_name ?? "N.A"}}</td>
                                            <td>
                                                <span class="badge badge-info" style="color: rgb(91, 91, 163)">{{$order->status}}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="#" class="btn btn-primary">Edit</a>
                                                    <a href="#" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$orders->links('pagination::bootstrap-5')}}
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
