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
                        <h3 class="mb-0">Update Website Settings</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Website Settings</li>
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
                                <div class="card-title">Input Settings Data</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form action="{{url('/manage/website-settings/update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" value="{{$websiteSettings->phone}}" name="phone" id="phone" required/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" value="{{$websiteSettings->email}}" name="email" id="email" required/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" name="address" id="address" required>{{$websiteSettings->address}}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="facebook" class="form-label">Facebook Link (Optional)</label>
                                        <input type="text" class="form-control" name="facebook" value="{{$websiteSettings->facebook}}" id="facebook"/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="twitter" class="form-label">Twitter Link (Optional)</label>
                                        <input type="text" class="form-control" name="twitter" value="{{$websiteSettings->twitter}}" id="twitter"/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="instagram" class="form-label">Instagram Link (Optional)</label>
                                        <input type="text" class="form-control" name="instagram" value="{{$websiteSettings->instagram}}" id="instagram"/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="youtube" class="form-label">Youtube Link (Optional)</label>
                                        <input type="text" class="form-control" name="youtube" value="{{$websiteSettings->youtube}}" id="youtube"/>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="logo" id="logo" accept="image/*"/>
                                        <label class="input-group-text" for="logo">Upload Logo</label>
                                    </div>
                                    <img src="{{$websiteSettings->logo}}" width="150" height="70" class="mb-2">

                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="hero_image" id="hero_image" accept="image/*"/>
                                        <label class="input-group-text" for="hero_image">Upload Hero Image</label>
                                    </div>
                                    <img src="{{$websiteSettings->hero_image}}" width="800X300" height="300">
                                    
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
