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
                        <h3 class="mb-0">Review List</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Review List</li>
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
                                <h3 class="card-title">Review List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Product</th>
                                            <th>Image</th>
                                            <th>Customer Name</th>
                                            <th>Comments</th>
                                            <th>Rating</th>
                                            <th style="width: 40px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reviews as $review)
                                        <tr class="align-middle">
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$review->product->name}}</td>
                                            <td>
                                                @if ($review->image != null)
                                                    <img src="{{$review->image}}" height="50" width="50">
                                                @else
                                                    <i class="fas fa-user"></i>
                                                @endif
                                            </td>
                                            <td>{{$review->customer_name}}</td>
                                            <td>{{$review->comments}}</td>
                                            <td>{{$review->rating}}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{url('/manage/review-edit/'.$review->id)}}" class="btn btn-primary">Edit</a>
                                                    <a href="{{url('/manage/review-delete/'.$review->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
