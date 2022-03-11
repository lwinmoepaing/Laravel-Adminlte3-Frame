@extends('layouts.client-layout')

@section('title', 'uab | Appointment Request Form')

@section('content')

@include('common.pre-loader')

@include('common.uab-mobile-header')

<div aria-live="assertive" aria-atomic="true" >
    <div class="toast" id="not_found_people_searching" style="position: absolute; top: 10px; right: 10px;" data-autohide="true" data-delay="4000">
        <div class="toast-header bg-danger text-white">
            <strong class="mr-auto text-white">Please Search Again!</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body bg-white" id="warning_text">
            Not Found User.
        </div>
    </div>
</div>

<div aria-live="assertive" aria-atomic="true" >
    <div class="toast" id="cant_invite_self" style="position: absolute; top: 10px; right: 10px;" data-autohide="true" data-delay="4000">
        <div class="toast-header bg-warning text-white">
            <strong class="mr-auto">Note !</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body bg-white">
            Can't Inivte YourSelf
        </div>
    </div>
</div>

<div aria-live="assertive" aria-atomic="true" >
    <div class="toast" id="aleready_invited_person" style="position: absolute; top: 10px; right: 10px;" data-autohide="true" data-delay="4000">
        <div class="toast-header bg-warning text-white">
            <strong class="mr-auto ">Please Search Again !</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body bg-white">
            User is already invited.
        </div>
    </div>
</div>

<div aria-live="assertive" aria-atomic="true" >
    <div class="toast" id="not_found_people_searching" style="position: absolute; top: 10px; right: 10px;" data-autohide="true" data-delay="4000">
        <div class="toast-header bg-danger text-white">
            <strong class="mr-auto text-white">Please Search Again !</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body bg-white" id="warning_text">
            Not Found User.
        </div>
    </div>
</div>

<div aria-live="assertive" aria-atomic="true" >
    <div class="toast" id="err_message" style="position: absolute; top: 10px; right: 10px;" data-autohide="true" data-delay="4000">
        <div class="toast-header bg-danger text-white">
            <strong class="mr-auto text-white">Form Warning !</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body bg-white" id="err_message_text">
            Not Found User.
        </div>
    </div>
</div>

<div class="container-fluid">
    {{-- Appointment Request Form --}}
    <div class="max-w-1000 mx-auto">

        <h5 class="mt-3 mb-2"> Create Appointment </h5 >

        @include('common.flash-message')

        <nav aria-label="breadcrumb mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('client.dashboard', $generalParams) }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#!">Create</a></li>
            </ol>
        </nav>

        <div class="card px-3 py-3 mb-3">
            <h6 class="mt-2">
                {{ $user->name }}
            </h6>
            <h6 class="text-default">
                {{ $user->phone }}
                {{ $user->company ? ', ' . $user->company : '' }}
            </h6>
            @if ($user->email)
                <h6 class="text-default">
                    {{ $user->email }}
                </h6>
            @endif
        </div>

        <h6 class="text-default mt-1 mb-2 pl-1">Meeting Title</h6>

        <div class="form-group">
            <input autocomplete="off" type="text" class="form-control py-4 border-none" id="titleInput" name="appointment_id">
            <div class="invalid-feedback">
                Required meeting title
             </div>
        </div>



        <div class="d-flex">
            <div class="flex-1 mr-1">
                <h6 class="text-default mt-1 mb-2 pl-1">Date</h6>
                <div class="input-group date " data-target-input="nearest" id="timePickerContainer">
                    <input name="time" autocomplete="off" type="text" class="form-control py-4 border-none datetimepicker-input " id="datePicker" data-toggle="datetimepicker" data-target="#datePicker" value="">
                    <div class="invalid-feedback">
                        Required appointment Date
                    </div>
                </div>
            </div>

            <div class="flex-1 ml-1">
                <h6 class="text-default mt-1 mb-2 pl-1">Time</h6>
                <div class="input-group date " data-target-input="nearest" id="timePickerContainer">
                    <input name="time" autocomplete="off" type="text" class="form-control py-4 border-none datetimepicker-input " id="timePicker" data-toggle="datetimepicker" data-target="#timePicker" value="">
                    <div class="invalid-feedback">
                        Required appointment Time
                    </div>
                </div>
            </div>
        </div>

        <h6 class="text-default mt-1 mb-2 pl-1">Location</h6>

        <div class="form-group">
            <select class="custom-select border-none h-50-helper" id="staff_branch" name="branch">
                <option value="1">uabTower@ Times City (Kamaryut)</option>
                <option value="2">Hledan (Kamaryut)</option>
            </select>
            <div class="invalid-feedback">
                Required Branch
            </div>
        </div>

        <h6 class="text-default mt-4 mb-3 pl-1">Invite People</h6>

        <div id="invitePeopleList">
            {{-- Invited User List --}}
        </div>

        <div class="input-group">
            <input
                type="tel"
                class="form-control h-50-helper border-none invite_phone placehoder-color"
                id="invite_phone"
                name="visitors[0][phone]"
                autocomplete="chrome-off"
                placeholder="Phone"
            >
            <div class="input-group-append">
                <button class="btn btn-secondary px-4 right-radius h-50-helper" type="button" id="inviteBtn">
                    Add
                </button>
            </div>
            <div class="invalid-feedback">Required Visitor Phone</div>
        </div>

        <div class="mb-3 pl-1">
            <div class="">
                <b style="color: #FFC107"> You can only invite uabpay user. </b>
            </div>
        </div>

        <div class="mt-1 mb-3">
            <a class="card upcoming-section p-3 mb-2 text-center d-block bg-primary text-white" href="#!" id="createButton">
                Create
            </a>
        </div>

    </div>
    {{-- Appointment Request Form Finished --}}
</div>

@push('body-scripts')
<script>
    $(document).ready(function () {
        $('#error_toast').toast('show');
    });
</script>

<script>
    $(document).ready(function() {
        var titleInput = $('#titleInput');
        var inviteButton = $('#inviteBtn');
        var submitButton = $("#createButton");
        var timePicker = $('#timePicker');
        var datePicker = $('#datePicker');
        var invitePhoneInput = $('#invite_phone');
        var inviteListContainer = $('#invitePeopleList');
        var yesterday = moment().subtract(1, "days").format("YYYY-MM-DD");
        var csrf = "{{ csrf_token() }}";
        var invitedPeople = [];

        //  Global Touched
        var isTouched = false;

        $(datePicker).datetimepicker({
            format: 'L',
            minDate: new Date(),
        });

        $(timePicker).datetimepicker({
            format: 'LT',
            minDate: new Date(),
        });

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
            $(pickers).on("change.datetimepicker", (param) => {
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
                }
            };

            Object.keys(form).forEach(function (key) {
                if(!form[key].value) {
                    $(form[key].container).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(form[key].container).removeClass('is-invalid');
                }
            });
            return isValid;
        };

        [titleInput].forEach(function (parent) {
            $(parent).on('keyup', (val) => {
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

        if ($(inviteButton)) {
            $(inviteButton).click(searchInvitorByPhone);
        }

        if ($(submitButton)) {
            $(submitButton).click(submit);
        }

        function resetTimepicker() {
            $(timePicker).datetimepicker('destroy');
            $(timePicker).val('');
        }

        function searchInvitorByPhone () {
            var isValid = false;
            var preLoader = $('#search-loading');
            var url = "{{ route('common.check-invite-member') }}";
            var phone = $(invitePhoneInput).val();
            var body = { _token: csrf, phone: phone };

            if (!phone) return;

            $(preLoader).removeClass('d-none');
            console.log(body);

            return axios.post(url, body, {
                headers: {
                    'Content-Type': 'application/json',
                },
            }).then(function(res) {
                $(preLoader).addClass('d-none');
                var response = res.status === 200 ? res.data : null;
                if (response.isSuccess) {
                    makeNewInvitor(response.data, response.type)
                } else {
                    $('#not_found_people_searching').toast('show');
                }
            }).catch(function(err) {
                $(preLoader).addClass('d-none');
                console.log(err);
                return false;
            });
        }

        function makeNewInvitor(data, type) {
            var creatorPhone = '{{ $generalParams['phone'] }}';
            var userData = {
                id: data.id,
                name: data.name,
                email: data.email || '',
                phone: data.phone,

            }
            var isInviteSelf = creatorPhone == data.phone;

            if (isInviteSelf) {
                $('#cant_invite_self').toast('show');
                return;
            }

            var isAlreadyPhone = invitedPeople.some(function (people) {
                return people.phone == data.phone;
            });

            if (isAlreadyPhone) {
                $('#aleready_invited_person').toast('show');
                return;
            }

            invitedPeople.push(Object.assign(data, {type: type}));
            $(invitePhoneInput).val('');
            buildForm();
        }

        function buildForm () {
            $(inviteListContainer).empty();
            invitedPeople.forEach(function (peopleList, index) {
                var wrapper = $('<div>', {class: 'card px-3 py-2 mb-3', id: 'invite_people_' + index + ''});
                var row = $('<div>', {class: 'd-flex'});
                var nameAndPhone = $('<div>', {class: 'flex-1 mr-1'})
                    .append($('<h6>', {class: 'mt-2'}).html(peopleList.name))
                    .append($('<h6>', {class: 'text-default'}).html(peopleList.phone));
                var deleteButton = $('<div>', {class: 'flex-1 ml-1 text-right d-flex align-items-center justify-content-end'})
                    .append(
                        $('<buuton>', {class: 'btn btn-danger btn-sm'})
                            .click(function () {
                                invitedPeople = invitedPeople.filter(function (ppl) {
                                    return !(ppl.id === peopleList.id && ppl.type === peopleList.type)
                                });
                                buildForm();
                            })
                            .html('Remove')
                    );
                inviteListContainer.append(wrapper.append(row.append(nameAndPhone).append(deleteButton)));
            });
        }

        function submit() {
            isTouched = true;
            var isValidForm = checkIsValid();
            var isValidInvitors = checkIsValidInvitors();
            if (!isValidForm || !isValidInvitors) {
                return ;
            }

            var myPersonal = {!!$user!!};
            myPersonal.is_organizer = true;
            var newList = [myPersonal].concat(invitedPeople);
            var url = '';
            var body = {
                _token: csrf,
                title: $(titleInput).val().trim(),
                date: $(datePicker).val().trim(),
                time: $(timePicker).val().trim(),
                branch: $('#staff_branch').val(),
                invite_persons: newList
            };
            var loading = $('#loading');
            $(loading).removeClass('d-none');

            return axios.post(url, body, {
                headers: {
                    'Content-Type': 'application/json',
                },
            }).then(function(res) {
                $(loading).addClass('d-none');
                var response = res.status === 200 ? res.data : null;
                if (response.isSuccess) {
                    console.log(response)
                    var redirectUrl = "{{ url('/client/appointment-detail') }}";
                    var id = response.data.id;
                    var urlWithParams = redirectUrl + '/' + id + '?phone={{ $generalParams["phone"]}}&name={{$generalParams["name"]}}'
                    // window.location.href = urlWithParams;
                    console.log(urlWithParams)
                } else {
                    $('#err_message').toast('show');
                    $('#err_message_text').html('Something went wrong. plz try again.');
                }
            }).catch(function(err) {
                $(loading).addClass('d-none');
                $('#err_message').toast('show');
                $('#err_message_text').html(err.message);
                console.log(err);
                return false;
            });
        }

        function checkIsValidInvitors() {
            var myPersonal = {!!$user!!};
            var newList = invitedPeople.concat([myPersonal]);

            if (!invitedPeople.length) {
                $('#err_message').toast('show');
                $('#err_message_text').html('Please add invited person.');
                return false;
            }

            var isSomeStaff = newList.some(function (some) {
                return some.type === 'staff';
            })

            if (!isSomeStaff) {
                $('#err_message').toast('show');
                $('#err_message_text').html('You need required at lease one staff.');
                return false;
            }

            return true;
        }

    });
</script>
@endpush

@endsection
