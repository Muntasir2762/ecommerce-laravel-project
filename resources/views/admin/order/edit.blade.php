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
                        <h3 class="mb-0">Order Details</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order Details</li>
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
                            <!--begin::Form-->
                            <div class="row g-4">
                                <!--begin::Col-->
                                <form action="{{url('/manage/order-update/'.$order->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!--begin::Quick Example-->
                                            <div class="card card-primary card-outline mb-4">
                                                <!--begin::Header-->
                                                <div class="card-header">
                                                    <div class="card-title">Customer Info</div>
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Form-->
                                                <!--begin::Body-->
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="mb-3 col-md-12">
                                                            <label for="exampleInputEmail1" class="form-label">Invoice
                                                                Number*</label>
                                                            <input type="text" class="form-control" value="{{$order->invoice_number}}" name="invoice_number" id="invoice_number" readonly />
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label for="exampleInputEmail1" class="form-label">Customer
                                                                Name*</label>
                                                            <input type="text" class="form-control" value="{{$order->name}}"
                                                                name="name" id="name" required />
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label for="exampleInputEmail1" class="form-label">Customer
                                                                Phone*</label>
                                                            <input type="text" class="form-control" value="{{$order->phone}}"
                                                                name="phone" id="phone" required />
                                                        </div>
                                                        <div class="mb-3 col-md-12">
                                                            <label for="exampleInputEmail1" class="form-label">Delivery
                                                                Charge*</label>
                                                            <input type="number" class="form-control" value="{{$order->charge}}"
                                                                name="charge" id="charge" required />
                                                        </div>
                                                        <div class="mb-3 col-md-12">
                                                            <label for="exampleInputEmail1"
                                                                class="form-label">Address*</label>
                                                            <textarea class="form-control" name="address" id="address" required>{{$order->address}}</textarea>
                                                        </div>
                                                        <div class="mb-3 col-md-12">
                                                            <label for="exampleInputEmail1"
                                                                class="form-label">Courier*</label>
                                                            <select name="courier_name" class="form-control"
                                                                id="courier_name">
                                                                <option value="">Select Courier</option>
                                                                <option value="steadfast" @if ($order->courier_name == 'steadfast')
                                                                    selected
                                                                @endif>Steadfast</option>
                                                                <option value="pathao" @if ($order->courier_name == 'pathao')
                                                                    selected
                                                                @endif>Pathao</option>
                                                                <option value="others" @if ($order->courier_name == 'others')
                                                                    selected
                                                                @endif>Others</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Body-->
                                                <!--begin::Footer-->
                                                <!--end::Footer-->
                                                <!--end::Form-->
                                            </div>
                                            <!--end::Quick Example-->
                                        </div>
                                        <div class="col-md-6">
                                            <!--begin::Quick Example-->
                                            <div class="card card-primary card-outline mb-4">
                                                <!--begin::Header-->
                                                <div class="card-header">
                                                    <div class="card-title">Product Info</div>
                                                </div>
                                                <div class="card-body">
                                                    @foreach ($order->orderDetails as $detail)
                                                    <div class="mb-5" id="subform" data-id="{{$detail->id}}">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <img src="{{$detail->product->image}}" height="100"
                                                                    width="100"><br>
                                                                {{$detail->product->name}}
                                                            </div>
                                                            <div class="col-md-8">
                                                                <label>Unit Price:</label>
                                                                <input type="number" class="form-control" name="" value="{{$detail->price}}" readonly>
                                                                <label>Quantity:</label>
                                                                <input type="number"
                                                                    class="form-control" name="qty" value="{{$detail->qty}}"
                                                                    required>
                                                                <label>Color:</label><input type="text"
                                                                    class="form-control" name="color" value="{{$detail->color}}">
                                                                <label>Size:</label><input type="text"
                                                                    class="form-control" name="size" value="{{$detail->size}}">
                                                                <input type="button" onclick="submitForm({{$detail->id}})" class="form-control mt-3 btn btn-success" value="Update">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <label>Total Price:</label>
                                                    <input type="number" class="form-control" name="price"
                                                        value="{{$order->price}}" required>
                                                </div>
                                                <!--end::Body-->
                                                <!--begin::Footer-->
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary">Update Order</button>
                                                </div>
                                                <!--end::Footer-->
                                                <!--end::Form-->
                                            </div>
                                            <!--end::Quick Example-->
                                        </div>
                                    </div>
                                </form>
                                <!--end::Col-->
                            </div>
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

@push('script')
    <script>
        function submitForm(id)
        {
            let subform = document.querySelector('#subform[data-id="'+id+'"]');

            formData = new FormData();

            formData.append('_token', '{{csrf_token()}}');
            formData.append('qty', subform.querySelector('[name="qty"]').value);
            formData.append('color', subform.querySelector('[name="color"]').value);
            formData.append('size', subform.querySelector('[name="size"]').value);

            fetch('/manage/order-details/update/'+id,{
                method: 'POST',
                body: formData
            }).then(res => res.json()).then(data =>{
                alert("Updated successfully");
            })
        }
    </script>
@endpush
