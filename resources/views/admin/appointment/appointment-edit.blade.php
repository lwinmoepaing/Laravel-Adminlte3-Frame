@extends('layouts.admin-layout')

@section('title', 'Appointment Creating' )

@section('content')

@include('common.pre-loader')

<div class="container-fluid mt-2">
    {{-- Appointment Request Form --}}
    <div class="max-w-1000 mx-auto">
        <nav aria-label="breadcrumb mb-2">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.appointment.appointment-view') }}">Appointments</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.appointment.appointment-detail', ['appointment_id' => $appointment->id]) }}">ID - {{ $appointment->id}} </a></li>
            <li class="breadcrumb-item active" aria-current="page"> Edit </li>
            </ol>
        </nav>

        @include('common.flash-message')

        @error('visitors.*')
            <div aria-live="assertive" aria-atomic="true" >
                <div class="toast" id="error_toast" style="position: absolute; top: 10px; right: 10px; z-index: 10000" data-autohide="true" data-delay="4000">
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
            <div class="toast" id="warning_toast" style="position: absolute; top: 10px; right: 10px; z-index: 10000" data-autohide="true" data-delay="4000">
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
        {{-- Warning Toast For Visitor Informations Finished --}}

        <div class="card px-4 pt-2 pb-4 ">
            <h1> Appointment Request Form </h1>
            <h5> Meeting Information </h5>

            <form action="{{route('admin.appointment.appointment-edit-submit', ['appointment_id' => $appointment->id])}}" method="POST" id="appoint-form-submit">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="title">Meeting Title</label>
                            <input autocomplete="off" type="text" class="form-control @error('title') is-invalid @enderror" id="titleInput" name="title" value="{{ $appointment->title }}">
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
                                <input readonly name="date" autocomplete="off" type="text" class="form-control datetimepicker-input @error('date') is-invalid @enderror" id="datePicker" data-toggle="datetimepicker" data-target="#datePicker" value="{{ $appointment->meeting_date }}"/>
                                <div class="invalid-feedback">
                                    Required appointment date
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group ">
                            <label for="title">Select Time</label>
                            <div class="input-group date "  data-target-input="nearest">
                                <input readonly name="time" autocomplete="off" type="text" class="form-control datetimepicker-input @error('time') is-invalid @enderror" id="timePicker" data-toggle="datetimepicker" data-target="#timePicker" value="{{ $appointment->meeting_timer }}"/>
                                <div class="invalid-feedback">
                                    Required selected time
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Organizer Information --}}
                <div class="my-3">
                    <span> <i class="fa fa-user mr-2 text-info" style="font-size: 16px;"></i> Organizer</span>
                    <h6 class="mt-2">
                        {{ $organizer->name }}
                    </h6>

                    <h6 class="text-default">
                        {{ $organizer->phone }} {{ $organizer->email ? ', ' . $organizer->email : ''}}
                    </h6>
                    <hr>
                </div>
                {{-- Organizer Information Finished --}}

                {{-- Visitor Information Form --}}
                <div class="my-3">
                    <span> <i class="fa fa-user-plus mr-2 text-info" style="font-size: 16px;"></i> Invited Persons ({{$invited_person_count}})</span>
                </div>

                <div id="visitorInformationContainer">
                    {{-- Visitor Information With Javascript --}}
                    @foreach ($showInvitedPerson as $index => $person)
                        <div>
                            <input type="hidden" name="visitors[{{$index}}][type]" value="{{$person['type']}}" id="person_{{$person['type']}}_id_{{$person['id']}}_typeinput">
                            <input type="hidden" name="visitors[{{$index}}][id]" value="{{$person['id']}}" id="person_{{$person['type']}}_id_{{$person['id']}}_idinput">
                            <input type="hidden" name="visitors[{{$index}}][status]" value="{{$person['pivot']['status']}}" id="person_{{$person['type']}}_id_{{$person['id']}}_statusinput">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h6 class="mt-2">
                                        {{$person['name']}}
                                    </h6>
                                    <h6 class="text-default">
                                        {{$person['phone']}}
                                    </h6>
                                </div>
                                <div class="flex-1 text-right d-flex align-items-center justify-content-end">
                                    <div class="btn-group invitedPersonButtons mr-2" role="group" aria-label="First group" id="person_{{$person['type']}}_id_{{$person['id']}}">
                                        <button type="button" data-value="2" class="btn invite-btn-changable btn-outline-success {{$person['pivot']['status'] === 2 ? 'outline-active' : ''}}">Accepted</button>
                                        <button type="button" data-value="3" class="btn invite-btn-changable btn-outline-danger mx-1  {{$person['pivot']['status'] === 3 ? 'outline-active' : ''}}">Can't Go</button>
                                        <button type="button" data-value="1" class="btn invite-btn-changable btn-outline-warning  {{$person['pivot']['status'] === 1 ? 'outline-active' : ''}}">Pending</button>
                                      </div>
                               </div>
                            </div>
                            <hr class="mt-1">
                        </div>
                    @endforeach
                </div>


                {{-- Visitor Information Form Finished --}}

                {{-- Submit Button --}}
                <button class="btn btn-primary btn-block" type="button" id="submitButton">Submit form</button>
                <a  class="btn btn-secondary btn-block" href="{{ route('admin.appointment.appointment-detail', ['appointment_id' => $appointment->id]) }}"> Go Back </a>

                {{-- Submit Button Finished --}}
            </form>
        </div>
    </div>

    {{-- Appointment Request Form Finished --}}
</div>

@endsection

@push('body-scripts')
<script>
    $(document).ready(function () {
        $('#error_toast').toast('show');
    });
</script>

<script>
    $(document).ready(function() {
        var titleInput = $('#titleInput');
        var branchInput = $('#staff_branch');
        var staffNameInput = $('#staff_name');
        var emailInput = $('#staff_email');
        var departInput = $('#staff_department');
        var timePicker = $('#timePicker');
        var datePicker = $('#datePicker');
        var addNewVisitor = $('#addNewVisitorBtn');
        var formSubmit = $('#appoint-form-submit');
        var submitBtn = $('#submitButton');
        var yesterday = moment().subtract(1, "days").format("YYYY-MM-DD");

        //  Global Touched
        var isTouched = false;

        $(datePicker).datetimepicker({
            format: 'L',
            minDate: new Date(),
            viewDate: moment('{{$appointment->meeting_time}}', 'DD/MM/YYYY HH:mm:ss a')
        });

        $(timePicker).datetimepicker({
            format: 'LT',
            minDate: new Date(),
        });

        // Set data From laravel
        $(datePicker).val('{{$appointment->meeting_date}}');
        $(timePicker).val('{{$appointment->meeting_timer}}');

        [datePicker].forEach( function(item) {
            $(item)[0].isContentEditable = false;
        });

        $(datePicker).on("change.datetimepicker", function() {
            var getDate = $(this).val();
            var isToday = moment().isSame(getDate, 'day');

            if (isToday) {
                resetTimepicker();
                $(timePicker).datetimepicker({
                    format: 'LT',
                    minDate: new Date(),
                });
            } else {
                resetTimepicker();
                $(timePicker).datetimepicker({
                    format: 'LT',
                    minDate: new Date(yesterday),
                });
            }
        });


        // Time Picker Validator
        [timePicker, datePicker].forEach(function (pickers) {
            $(pickers).on("change.datetimepicker", function (param) {
                if ($(pickers).val() && $(pickers).hasClass('is-invalid')) {
                    $(pickers).removeClass('is-invalid');
                }
            });
        });

        function checkIsValid () {
            var isValid = true;
            var form = {
                title: {
                    value: $(titleInput).val().trim(),
                    container: titleInput,
                },
                datePicker: {
                    value: $(datePicker).val().trim(),
                    container: datePicker,
                },
                timePicker: {
                    value: $(timePicker).val().trim(),
                    container: timePicker,
                },
            };

            Object.keys(form).forEach(function (key) {
                if(!form[key].value) {
                    $(form[key].container).addClass('is-invalid');
                    isValid = false;
                } else if (key === 'emailInput') {
                    if (!validateEmail(form[key].value)) {
                        $(form[key].container).addClass('is-invalid');
                        isValid = false;
                    }
                } else {
                    $(form[key].container).removeClass('is-invalid');
                }
            });
            return isValid;
        };

        [titleInput].forEach(function (parent) {
            $(parent).on('keyup', function (val) {
                var value = $(parent).val().trim();
                if (value) {
                    if ($(parent).hasClass('is-invalid')) {
                        $(parent).removeClass('is-invalid');
                    };
                } else {
                    if (isTouched) {
                        $(parent).addClass('is-invalid');
                    }
                }
            })
        });

        // Validator
        $(submitBtn).click(function (event) {
            isTouched = true;
            var isValidForm = checkIsValid();


            if (!isValidForm) {
                event.preventDefault();
                return ;
            }

            console.log(isValidForm);

            $(formSubmit).submit();
        });

        $('#testEmail').click(function() {
        });

        function resetTimepicker() {
            $(timePicker).datetimepicker('destroy');
            $(timePicker).val('');
        }

        if ($('.invite-btn-changable')) {
            $('.invite-btn-changable').each(function (index, value) {
                $(value).click(function () {
                    var parent = $(this).parent();
                    var children = $(parent).children();
                    var statusValue = $(this).data('value');
                    var parentID = $(parent).attr('id');

                    $(children).each(function (index, child) {
                        $(children).removeClass('outline-active');
                    });

                    $(this).addClass('outline-active');
                    $('#' + parentID + '_statusinput').val(statusValue);
                    console.log(parentID);
                });
            });
        }
    });
</script>
@endpush
