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
                        <h3 class="mb-0">Edit Review</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Review</li>
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
                <div class="row g-4">
                    <!--begin::Col-->
                    <div class="col-md-12">
                        <!--begin::Quick Example-->
                        <div class="card card-primary card-outline mb-4">
                            <!--begin::Header-->
                            <div class="card-header">
                                <div class="card-title">Input Review Data</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form action="{{url('/manage/review-update/'.$review->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="customer_name" class="form-label">Select Product</label>
                                        <select name="product_id" id="product_id" class="form-control">
                                            @foreach ($products as $product)
                                                <option value="{{$product->id}}" @if ($product->id == $review->product_id)
                                                    selected
                                                @endif>{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="customer_name" class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" value="{{$review->customer_name}}" name="customer_name" id="customer_name" required/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="comments" class="form-label">Customer Message</label>
                                        <textarea name="comments" id="comments" class="form-control" required>{{$review->comments}}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Customer Rating</label>
                                        <input type="number" class="form-control" value="{{$review->rating}}" name="rating" id="rating" required/>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="image" id="inputGroupFile02" accept="image/*"/>
                                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                    </div>
                                    @if ($review->image != null)
                                        <img src="{{$review->image}}" height="50" width="50">
                                    @endif
                                </div>
                                <!--end::Body-->
                                <!--begin::Footer-->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <!--end::Footer-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Quick Example-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
