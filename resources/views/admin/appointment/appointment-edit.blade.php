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

                {{-- Visitor Information Form --}}
                <h5> Visitor Information </h5>
                <div id="visitorInformationContainer">
                    {{-- Visitor Information With Javascript --}}
                </div>


                <div class="text-center">
                    <a href="javascript:void(0)" class="text-decoration-underline" id="addNewVisitorBtn">Add new +</a>
                </div>
                {{-- Visitor Information Form Finished --}}

                {{-- Staff Information --}}
                <h5> uab Staff Information </h5>

                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="staff_email">uab Staff Email</label>
                            <input type="email" class="form-control @error('staff_email') is-invalid @enderror" id="staff_email" name="staff_email" value="{{ $appointment->staff_email }}">
                            <div class="invalid-feedback" id="emailError">
                                Required Staff Email or invalid email or not found
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="staff_branch">Branch</label>
                            <select class="custom-select" id="staff_branch" name="branch">
                                @foreach ($branches as $key => $branch)
                                <option value="{{ $branch->id }}" {{ $appointment->branch_id === $branch->id ? 'selected' : ''}}>{{ $branch->branch_name }} ({{ $branch->township->township_name }})</option>
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
                                    <option value="{{ $department->id }}">{{ $department->department_name }}</option>
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
                            <input autocomplete="off" type="text" class="form-control @error('staff_name') is-invalid @enderror" id="staff_name" name="staff_name" value="{{ $appointment->staff_name }}">
                            <div class="invalid-feedback">
                                Required Staff Name
                            </div>
                        </div>
                    </div>

                </div>
                {{-- Staff Information Finished --}}

                {{-- Submit Button --}}
                <button class="btn btn-primary btn-block" type="button" id="submitButton">Submit form</button>
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



        // Visitor
        var visitorFormControl = [
        {
            label: "id",
            type: "hidden",
            name: "id",
        },
        {
            label: 'Visitor Phone',
            type: 'tel',
            name: 'phone',
        },
        {
            label: 'Visitor Name',
            type: 'text',
            name: 'name',
        }, {
            label: 'Company Name',
            type: 'text',
            name: 'company_name',
        }, {
            label: 'Email',
            type: 'email',
            name: 'email',
        }];
        var defaultVisitor = {id: '', name: '', phone: '', company_name: '', email: '', isTouched: false};
        var visitorList = {!! $appointment->visitors !!};

        // Initial Step
        buildVisitorList(); // For Default Editing

        $(addNewVisitorBtn).click(createVisitor);

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
                },
                branchInput: {
                    value: $(branchInput).val(),
                    container: branchInput,
                },
                staffNameInput: {
                    value: $(staffNameInput).val().trim(),
                    container: staffNameInput,
                },
                emailInput: {
                    value: $(emailInput).val().trim(),
                    container: emailInput,
                },
                departInput: {
                    value: $(departInput).val().trim(),
                    container: departInput,
                }
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

        [titleInput, staffNameInput, emailInput, departInput].forEach(function (parent) {
            $(parent).on('keyup', (val) => {
                var value = $(parent).val().trim();
                if (value) {
                    if ($(parent).hasClass('is-invalid')) {
                        $(parent).removeClass('is-invalid');
                    };

                    var isEmail = $(parent).is('input[type="email"]');
                    if (isEmail) {
                        if(validateEmail(value)) {
                            $(parent).removeClass('is-invalid');
                        } else {
                            if (isTouched) {
                                $(parent).addClass('is-invalid');
                            }
                        }
                    }
                } else {
                    if (isTouched) {
                        $(parent).addClass('is-invalid');
                    }
                }
            })
        });

        function createVisitor() {
            var isValid = checkIsValidVisitor();

            if (!isValid) {
                $('#warning_toast').toast('show');
                return;
            }

            if (visitorList.length > 0 ) {
                var getLastInfo = visitorList[visitorList.length - 1];
                var newList = JSON.parse(JSON.stringify(defaultVisitor));
                newList.company_name = JSON.parse(JSON.stringify(getLastInfo.company_name));
                visitorList.push(newList);
            } else {
                visitorList.push(JSON.parse(JSON.stringify(defaultVisitor)));
            }

            buildVisitorList();
        }

        function createVisitorField(index, label, type, name, value) {
            var visitorFieldId = 'visitors[' + index +'][' + name + ']';
            var visitorFieldClass = 'visitors_' + index +'_' + name;
            var isIndexZero = index === 0;

            if (name === 'id') {
                return $('<input>',
                    {type: type, class: 'form-control d-none' + visitorFieldClass, id: visitorFieldClass, name: visitorFieldId, autocomplete: "off", value: value }
                );
            }

            var labelHtml = $('<label>', {for: visitorFieldId}).html(isIndexZero ? label : '');

            var inputHtml = $('<input>',
                    {type: type, class: 'form-control ' + visitorFieldClass, id: visitorFieldClass, name: visitorFieldId, autocomplete: "chrome-off"}
                )
                .val(value)
                .on('keyup', function (event) {
                    var value = event.target.value.trim();
                    var isEmail = name === 'email';
                    var container =  $(this);

                    visitorList[index][name] = value;

                    if (visitorList[index].isTouched && !value.trim()) {
                        $(container).addClass('is-invalid');
                    } else {
                        if(isEmail) {
                            if(validateEmail(value)) {
                                $(container).removeClass('is-invalid');
                            } else {
                                if(visitorList[index].isTouched) {
                                    $(container).addClass('is-invalid');
                                }
                            }
                        } else {
                            $(container).removeClass('is-invalid');
                        }
                    }
                })

            var invalidHtml = $('<div>', {class: 'invalid-feedback'}).html('Required ' +  (type === 'email' ? label + ' or invalid email' : label));


            var delHtml = $('<div>', {class: 'input-group-append'}).append(
                $('<button>', { class: 'btn btn-secondary right-radius', type: 'button', disabled: isIndexZero})
                    .html('<i class="fa fa-close"></i>')
                    .click(function () {
                        visitorList = visitorList.filter((data, i) => i !== index );
                        buildVisitorList();
                    })

            );

            var groupList = $('<div>', {class: name === 'email' || name === 'phone' ? 'input-group' : ''})
                .append(inputHtml)

            var phoneSearchHtml = $('<div>', {class: 'input-group-append'}).append(
                $('<button>', { class: 'btn btn-info right-radius', type: 'button'})
                    .html('<i class="fa fa-search text-white"></i>')
                    .click(function () {
                        // visitorList = visitorList.filter((data, i) => i !== index );
                        // buildVisitorList();
                        var phoneNo = $('#' + visitorFieldClass).val();
                        if (phoneNo) {

                            $('#visitor-search-loading').removeClass('d-none');
                            setTimeout( function () {
                                getVisitorBy({by: 'phone', phone_no: phoneNo }).then(function (res) {
                                    if (res.isSuccess === true) {
                                        visitorList[index] = {
                                            id: visitorList[index].id || '',
                                            name: res.data.name,
                                            phone: res.data.phone,
                                            company_name: res.data.company_name,
                                            email: res.data.email,
                                            isTouched: true
                                        }
                                        buildVisitorList();
                                    } else {
                                        $('#visitor_searching_toast').toast('show');
                                    }
                                });
                            }, 500);
                        }
                    })

            );

            if (name === 'phone') {
                groupList.append(phoneSearchHtml);
            }

            if (name === 'email') {
                groupList.append(delHtml);
            }

            groupList.append(invalidHtml);

            var visitorField = $('<div>', {class: "col-sm-6 col-md-3"})
                .append(
                    $('<div>', {class: "form-group"})
                        .append(labelHtml)
                        .append(groupList)
                );
            return visitorField;
        }

        function buildVisitorList() {
            var container = $('#visitorInformationContainer');
            $(container).empty();

            visitorList.forEach(function (formList, index) {
                var row = $('<div>', {class: 'row', id: 'visitorRow_' + index + ''});
                visitorFormControl.forEach(function (ctrlForm) {
                    var eachField = createVisitorField(index, ctrlForm.label, ctrlForm.type, ctrlForm.name, formList[ctrlForm.name]);
                    row.append(eachField);
                });
                container.append(row);
            })
        }

        function checkIsValidVisitor() {
            var isValidAllForm = true;
            visitorList.forEach(function (list, visitorIndex) {
                if (list.isTouched === false) {list.isTouched = true;}
                Object.keys(list).forEach(function (key) {
                    var isValid = checkEachValid(key, list[key]);
                    if (!isValid) {
                        isValidAllForm = false;
                        var eachContainer = '#visitors_'+visitorIndex+'_'+key+'';
                        $(eachContainer).addClass('is-invalid');
                    }
                });
            });

            return isValidAllForm;
        }

        function checkEachValid(key, value) {
            switch (key) {
                case 'id':
                    return true;
                case 'email':
                    return validateEmail(value);
                case 'isTouched':
                    return true;
                default:
                    return typeof value === 'string' ? (
                        value && value.trim() ? true : false
                    ) : true;
            }
        }

        function validateEmail (email){
            return !!String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        };

        function checkIsValidOfficerEmail () {
            var isValid = false;
            var preLoader = $('#officer-loading');
            var url = "{{ route('appointment.checkStaffEmail') }}";
            var email = $(emailInput).val();
            $(preLoader).removeClass('d-none');
            var csrf = "{{ csrf_token() }}";

            return axios.post(url, {
                _token: csrf,
                email: email
            }, {
                headers: {
                    'Content-Type': 'application/json',
                },
            }).then(function(res) {
                $(preLoader).addClass('d-none');
                console.log('Finished Fetching');
                var response = res.status === 200 ? res.data : null;
                if (response && response.isSuccess === true) {
                    return true;
                }
                return false;
            }).catch(function(err) {
                $(preLoader).addClass('d-none');
                console.log('Finished Fetching');
                console.log(err);

                return false;
            });
        }

        function getVisitorBy (params) {
            var byPhone = params.by === 'phone' ? true : false;
            var searchWith = byPhone ? params.phone_no : params.email;
            var isValid = false;
            var preLoader = $('#visitor-search-loading');
            var url = "{{ route('appointment.checkVisitor') }}";
            $(preLoader).removeClass('d-none');
            var csrf = "{{ csrf_token() }}";
            var body = {
                _token: csrf,
            };

            if (byPhone) {
                body.phone = searchWith;
            } else {
                body.email = searchWith;
            }

            console.log('Body', body);

            return axios.post(url, body, {
                headers: {
                    'Content-Type': 'application/json',
                },
            }).then(function(res) {
                $(preLoader).addClass('d-none');
                console.log('Finished Fetching');
                var response = res.status === 200 ? res.data : null;
                if (response && response.isSuccess === true) {
                    return response;
                } else {
                    return {isSuccess: false}
                }
            }).catch(function(err) {
                $(preLoader).addClass('d-none');
                console.log('Finished Fetching');
                console.log(err);
                return {isSuccess: false};
            });


        }

        // Validator
        $(submitBtn).click(function (event) {
            isTouched = true;
            var isValidForm = checkIsValid();
            var isValidVisitor = checkIsValidVisitor();

            if (!isValidForm || !isValidVisitor) {
                event.preventDefault();
                return ;
            }

            $('#officer-loading').removeClass('d-none');

            setTimeout(() => {
                checkIsValidOfficerEmail().then(isValidOfficerEmail => {
                if (!isValidOfficerEmail) {
                    event.preventDefault();
                    $('#officer_warning_toast').toast('show');
                    $(emailInput).focus();
                    $(emailInput).addClass('is-invalid');
                    return;
                } else {
                    $(formSubmit).submit();
                }
            });
            }, 800);

        });

        $('#testEmail').click(function() {
          checkIsValidOfficerEmail().then(isValid => {
            console.log('isValid ---', isValid);
          });
        });

        function resetTimepicker() {
            $(timePicker).datetimepicker('destroy');
            $(timePicker).val('');
        }
    });

    // console.log('AXIOS');
    // console.log(axios);

</script>
@endpush
