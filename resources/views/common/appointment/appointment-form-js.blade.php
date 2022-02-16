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

        // Visitor
        var visitorFormControl = [
        {
            label: 'Visitor Phone',
            type: 'tel',
            name: 'phone',
        },{
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
        var visitorList = [];

        // Initial Step
        createVisitor(); // For Default one form

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
            console.log('Call Check Is Valid');
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
                                            id: '',
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

            var groupList = $('<div>', {
                class: name === 'email' || name === 'phone' ? 'input-group' : ''
            })
                .append(inputHtml)
            if (name === 'email') {
                groupList.append(delHtml);
            }

            if (name === 'phone') {
                groupList.append(phoneSearchHtml);
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
                    console.log(key, value);
                    return value && value.trim() ? true : false;
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

            setTimeout(function () {
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
</script>
