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
                        <h3 class="mb-0">Edit Product</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
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
                                <div class="card-title">Input Product Data</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form action="{{ url('/manage/product-update/'.$product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 col-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Product Name</label>
                                                <input type="text" class="form-control" name="name" id="name" value="{{$product->name}}" />
                                                 @error('name')
                                                     <span class="text-danger">{{$message}}</span>
                                                 @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 col-12">
                                            <div class="mb-3">
                                                <label for="sku_code" class="form-label">Product SKU Code (Optional)</label>
                                                <input type="text" class="form-control" name="sku_code" id="sku_code" value="{{$product->sku_code}}"/>
                                                @error('sku_code')
                                                     <span class="text-danger">{{$message}}</span>
                                                 @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 col-12">
                                            <div class="mb-3">
                                                <label for="cat_id" class="form-label">Select Category</label>
                                                <select name="cat_id" id="cat_id" class="form-control">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" @if ($category->id == $product->cat_id)
                                                            selected
                                                        @endif>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('cat_id')
                                                     <span class="text-danger">{{$message}}</span>
                                                 @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 col-12">
                                            <div class="mb-3">
                                                <label for="subcat_id" class="form-label">Select SubCategory (optional)</label>
                                                <select name="subcat_id" id="subcat_id" class="form-control">
                                                    <option value="" disabled>Select Subcategory</option>
                                                    @foreach ($subCategories as $subcategory)
                                                        <option value="{{ $subcategory->id }}" @if ($subcategory->id == $product->subcat_id)
                                                            selected
                                                        @endif>{{ $subcategory->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('subcat_id')
                                                     <span class="text-danger">{{$message}}</span>
                                                 @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 col-12">
                                            <div class="mb-3" id="color_fields">
                                                <label for="color_name" class="form-label">Color (Optional)</label>
                                                @if ($product->color->isNotEmpty())
                                                    @foreach ($product->color as $singleColor)
                                                        <input type="text" class="form-control mb-2" name="color_name[]" value="{{$singleColor->color_name}}" placeholder="Color Name" id="color_name"/>
                                                    @endforeach
                                                @else
                                                    <input type="text" class="form-control mb-2" name="color_name[]" placeholder="Color Name" id="color_name"/>
                                                @endif
                                                <button type="button" class="btn btn-primary mt-2" id="add_color">Add More</button>

                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 col-12">
                                            <div class="mb-3" id="size_fields">
                                                <label for="size_name" class="form-label">Size (Optional)</label>
                                                @if ($product->size->isNotEmpty())
                                                    @foreach ($product->size as $singleSize)
                                                        <input type="text" class="form-control mb-2" name="size_name[]" value="{{$singleSize->size_name}}" placeholder="Size Name" id="size_name"/>
                                                    @endforeach
                                                @else
                                                    <input type="text" class="form-control mb-2" name="size_name[]" placeholder="Size Name" id="size_name"/>  
                                                @endif
                                                <button type="button" class="btn btn-primary mt-2" id="add_size">Add More</button>

                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-6">
                                            <div class="mb-3">
                                                <label for="buying_price" class="form-label">Product Buying Price</label>
                                                <input type="number" class="form-control" name="buying_price" id="buying_price" value="{{$product->buying_price}}"/>
                                                @error('buying_price')
                                                     <span class="text-danger">{{$message}}</span>
                                                 @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-6">
                                            <div class="mb-3">
                                                <label for="regular_price" class="form-label">Product Regular Price</label>
                                                <input type="number" class="form-control" name="regular_price" id="regular_price" value="{{$product->regular_price}}"/>
                                                @error('regular_price')
                                                     <span class="text-danger">{{$message}}</span>
                                                 @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-6">
                                            <div class="mb-3">
                                                <label for="discount_price" class="form-label">Product Discount Price (Optional)</label>
                                                <input type="number" class="form-control" name="discount_price" id="discount_price" value="{{$product->discount_price}}"/>
                                                @error('discount_price')
                                                     <span class="text-danger">{{$message}}</span>
                                                 @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 col-12">
                                            <div class="mb-3">
                                                <label for="qty" class="form-label">Product Quantity</label>
                                                <input type="number" class="form-control" name="qty" id="qty" value="{{$product->qty}}"/>
                                                @error('qty')
                                                     <span class="text-danger">{{$message}}</span>
                                                 @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 col-12">
                                            <div class="mb-3">
                                                <label for="product_type" class="form-label">Product Type</label>
                                                <select name="product_type" id="product_type" class="form-control">
                                                    <option value="hot" @if ($product->product_type == "hot")
                                                        selected
                                                    @endif>Hot Product</option>
                                                    <option value="new" @if ($product->product_type == "new")
                                                        selected
                                                    @endif>New Product</option>
                                                    <option value="regular" @if ($product->product_type == "regular")
                                                        selected
                                                    @endif>Regular Product</option>
                                                    <option value="discount" @if ($product->product_type == "discount")
                                                        selected
                                                    @endif>Discount Product</option>
                                                </select>
                                                @error('product_type')
                                                     <span class="text-danger">{{$message}}</span>
                                                 @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="summernote" class="form-label">Product Description</label>
                                                <textarea name="description" class="form-control" id="summernote">{{$product->description}}</textarea>
                                                @error('description')
                                                     <span class="text-danger">{{$message}}</span>
                                                 @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="summernote_two" class="form-label">Product Policy (Optional)</label>
                                                <textarea name="product_policy" class="form-control" id="summernote_two">{{$product->product_policy}}</textarea>
                                                @error('product_policy')
                                                     <span class="text-danger">{{$message}}</span>
                                                 @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-12">
                                            <div class="input-group mb-3">
                                                <input type="file" class="form-control" name="image"
                                                    id="image" accept="image/*" />
                                                <label class="input-group-text" for="image">Main Image</label>
                                            </div>
                                            <img src="{{$product->image}}" height="100" width="100" class="mb-3">
                                            @error('image')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-12">
                                            <div class="input-group mb-3">
                                                <input type="file" class="form-control" name="gallery_image[]"
                                                    id="gallery_image" accept="image/*" multiple/>
                                                <label class="input-group-text" for="gallery_image">Gallery Image</label>
                                            </div>
                                            @foreach ($product->galleryImage as $singleImage)
                                                <img src="{{$singleImage->image}}" height="100" width="100" class="mb-3">
                                            @endforeach
                                            @error('gallery_image')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
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

@push('script')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#summernote_two').summernote();
        });
    </script>

{{-- Add More Color --}}
    <script>
        $(document).ready(function(){
            $("#add_color").click(function(){
                $(this).before('<input type="text" class="form-control mb-2" name="color_name[]" placeholder="Color Name" id="color_name"/>')
            })
        });
    </script>

    {{-- Add More Size --}}
    <script>
        $(document).ready(function(){
            $("#add_size").click(function(){
                $(this).before('<input type="text" class="form-control mb-2" name="size_name[]" placeholder="Size Name" id="size_name"/>')
            })
        });
    </script>

@endpush
