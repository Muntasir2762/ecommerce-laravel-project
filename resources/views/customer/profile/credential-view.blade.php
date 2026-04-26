@extends('customer.master')

@section('content')
    <div class="body flex-grow-1">
        <div class="container-lg px-4">
            <form action="{{url('/customer/update-credentials')}}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" value="{{$authUser->email}}" placeholder="Your Name*" aria-label="Username"
                        aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="old_password" class="form-control" value="" placeholder="Your Old Password*">
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" value="" placeholder="Your New Password*">
                </div>

                <div class="input-group mt-3">
                    <input type="submit" name="submit" id="submit" class="form-control btn btn-success text-white" value="Update">
                </div>

            </form>
        </div>
    </div>
@endsection
