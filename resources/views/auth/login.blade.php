@extends('layouts.auth-layout')

@section('title', 'Uab Visitor Management')

@section('content')

<div>
    <div class="login_wrapper">
        <div class="animate form login_form">
        <div>
            <img src="{{URL('/images/auth/uab-logo.png')}}" class="brand-logo d-block mx-auto" alt="" style="width: 220px; height: auto;">
        </div>
        <section class="login_content">
            <form action="{{ route('login') }}" method="POST">

            @csrf

            <h1>Login Form</h1>

            <div>
                <input type="text" class="form-control" placeholder="Username" required="" />
            </div>

            <div>
                <input type="password" class="form-control" placeholder="Password" required="" />
            </div>

            <div>
                <button class="btn btn-primary btn-block submit text-white">Log in</button>
            </div>

            <div class="my-3">
                <a class="text-primary" href="{{route('appointment.view')}}">Request Appointment</a>
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
