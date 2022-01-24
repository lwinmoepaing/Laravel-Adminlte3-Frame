@extends('layouts.client-layout')

@section('title', 'Uab: Appointment Request Form')

@section('content')

<div>
    <h1> Appointment Request Form </h1>
    <div>
        <h4> Meeting Information </h4>
    </div>
</div>

@push('body-scripts')
<script>
    $(document).ready(function() {
        console.log('Ready');
        console.log(Popper);
    });
</script>
@endpush

@endsection
