@extends('layouts.guest')
@section('title','Verify Email')
@section('content')
<section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center form-bg-image" data-background-lg="{{ asset('volt/assets/img/illustrations/signin.svg') }}">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success">
                            A new verification link has been sent to the email address you provided during registration.
                        </div>
                    @endif
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <div class="avatar avatar-lg mx-auto mb-3"><img class="rounded-circle" alt="Image placeholder" src="{{ asset('volt/assets/img/team/profile-picture-3.jpg') }}"></div>
                        <h1 class="h3">{{ auth()->user()->name }}</h1>
                        <p>{{ auth()->user()->email }}</p>
                        <p class="text-gray">Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
                    </div>
                    <form class="mt-5" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-gray-800">Resend Verification Email</button>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
        
                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-outline-danger">Logout</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
