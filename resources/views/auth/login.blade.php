@extends('layouts.auth-layout')

@section('title', 'Uab Visitor Management')

@section('content')

<div>
    <div class="login_wrapper">
        <div class="animate form login_form">
        <div>
            <img src="{{URL('/images/auth/uab-logo.png')}}" class="brand-logo d-block mx-auto uab-logo" alt="">
        </div>
        <section class="login_content">
            <form method="POST" action="{{ route('login') }}">

                @csrf

                <h1>Login Form</h1>

                <div>
                    <input type="text" class="form-control" name="email" placeholder="Username" required="" />

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div>
                    <input type="password" class="form-control" name="password" placeholder="Password" required="" />
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn-primary btn-block submit text-white">Log in</button>
                </div>

                <div class="my-3">
                    <a class="text-primary" href="{{route('appointment.view')}}">Request Appointment By Visitor</a>
                </div>
                <div class="my-3">
                    <a class="text-primary" href="{{route('appointment.invite-visitor')}}">Invite Appointment to Visitors</a>
                </div>

                <div class="clearfix"></div>
            </form>
        </section>
        </div>
    </div>
</div>

@endsection

@push('body-scripts')
<script>
    (function() {
        console.log(Date.today());
    })()
</script>
@endpush
