@extends('layouts.client-layout')

@section('title', 'uab | Appointment Request Form')

@section('content')

@include('common.pre-loader')

@include('common.uab-headbar')

<div class="container-fluid">
    {{-- Appointment Request Form --}}
    <div class="max-w-1000 mx-auto">

        @include('common.flash-message')

        @error('visitors.*')
            <div aria-live="assertive" aria-atomic="true" >
                <div class="toast" id="error_toast" style="position: absolute; top: 10px; right: 10px;" data-autohide="true" data-delay="4000">
                    <div class="toast-header bg-danger text-white">
                        <strong class="mr-auto">Warning Form</strong>
                        <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        Visitors Informations are something wrong!
                    </div>
                </div>
            </div>
        @enderror

        {{-- Warning Toast For Visitor Informations --}}
        <div aria-live="assertive" aria-atomic="true" >
            <div class="toast" id="warning_toast" style="position: absolute; top: 10px; right: 10px;" data-autohide="true" data-delay="4000">
                <div class="toast-header bg-warning text-white">
                    <strong class="mr-auto">Information tips!!</strong>
                    <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body" id="warning_text">
                    At first, You need to fill all visitors information.
                </div>
            </div>
        </div>

        <div aria-live="assertive" aria-atomic="true" >
            <div class="toast" id="officer_warning_toast" style="position: absolute; top: 10px; right: 10px;" data-autohide="true" data-delay="4000">
                <div class="toast-header bg-primary text-white">
                    <strong class="mr-auto text-white">Retry Staff Email!!</strong>
                    <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body" id="warning_text">
                    Not Found Staff Email Address
                </div>
            </div>
        </div>

        <div aria-live="assertive" aria-atomic="true" >
            <div class="toast" id="visitor_searching_toast" style="position: absolute; top: 10px; right: 10px;" data-autohide="true" data-delay="4000">
                <div class="toast-header bg-primary text-white">
                    <strong class="mr-auto text-white">Not Found!!</strong>
                    <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body" id="warning_text">
                    Not Found Visitor Search Result
                </div>
            </div>
        </div>
        {{-- Warning Toast For Visitor Informations Finished --}}

        <form  autocomplete="off" action="{{route('appointment.invite-visitor-submit')}}" method="POST" id="appoint-form-submit">
        @csrf
            <h1> Appointment Request Form </h1>

            {{-- Staff Information --}}
            <h5> uab Staff Information </h5>

            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="staff_email">uab Staff Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control @error('staff_email') is-invalid @enderror" id="staff_email" name="staff_email" value="{{ old('staff_email') }}">

                            <div class="input-group-append">
                                <button class="btn btn-info right-radius" type="button" id="checkOfficerEmailToFill">
                                    <i class="fa fa-search text-white"></i>
                                </button>
                            </div>

                            <div class="invalid-feedback" id="emailError">
                                Required Staff Email or invalid email or not found
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="staff_branch">Branch</label>
                        <select class="custom-select" id="staff_branch" name="branch">
                            @foreach ($branches as $key => $branch)
                            <option value="{{ $branch->id }}" {{ old('branch') === $branch->id ? 'selected' : ''}}>{{ $branch->branch_name }} ({{ $branch->township->township_name }})</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Required Branch
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 d-none">
                    <div class="form-group">
                        <label for="staff_department">Department</label>
                        <select class="custom-select" id="staff_department" name="department">
                            @foreach ($departments as $key => $department)
                            <option value="{{ $department->id }}" {{ old('department') === $department->id ? 'selected' : ''}}>{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Required Department
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="staff_name">uab Staff Name</label>
                        <input autocomplete="off" type="text" class="form-control @error('staff_name') is-invalid @enderror" id="staff_name" name="staff_name" value="{{ old('staff_name') }}">
                        <div class="invalid-feedback">
                            Required Staff Name
                        </div>
                    </div>
                </div>

            </div>
            {{-- Staff Information Finished --}}


            <h5> Meeting Information </h5>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="title">Meeting Title</label>
                        <input autocomplete="off" type="text" class="form-control @error('title') is-invalid @enderror" id="titleInput" name="title" value="{{ old('title') }}">
                        <div class="invalid-feedback">
                           Required meeting title
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="title">Select Appointment Date</label>
                        <div class="input-group date"  data-target-input="nearest">
                            <input readonly name="date" autocomplete="off" type="text" class="form-control datetimepicker-input @error('date') is-invalid @enderror" id="datePicker" data-toggle="datetimepicker" data-target="#datePicker" value="{{ old('date') }}"/>
                            <div class="invalid-feedback">
                                Required appointment date
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group ">
                        <label for="title">Select Time</label>
                        <div class="input-group date "  data-target-input="nearest" id="timePickerContainer">
                            <input readonly name="time" autocomplete="off" type="text" class="form-control datetimepicker-input @error('time') is-invalid @enderror" id="timePicker" data-toggle="datetimepicker" data-target="#timePicker" value="{{ old('time') }}"/>
                            <div class="invalid-feedback">
                                Required selected time
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Visitor Information Form --}}
            <h5> Visitor Information </h5>
            <div id="visitorInformationContainer">
                {{-- Visitor Information With Javascript --}}
            </div>


            <div class="text-center mb-3">
                <a href="javascript:void(0)" class="text-decoration-underline" id="addNewVisitorBtn">Add new +</a>
            </div>
            {{-- Visitor Information Form Finished --}}

            {{-- Submit Button --}}
            <button class="btn btn-primary btn-block" type="button" id="submitButton">Submit form</button>
            {{-- Submit Button Finished --}}
        </form>

    </div>

    {{-- Appointment Request Form Finished --}}
</div>



@push('body-scripts')
    @includeIf('common.appointment.appointment-form-js')
@endpush

@endsection
