@extends('layouts.client-layout')

@section('title', 'Uab: Appointment Request Form')

@section('content')

<div>

    {{-- Appointment Request Form --}}
    <div class="container">
        <h1> Appointment Request Form </h1>
        <h5> Meeting Information </h5>

        <form action="{{route('appointment.view')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="title">Meeting Title</label>
                        <input type="text" class="form-control" id="title" name="title" required="required">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="title">Select Appointment Date</label>
                        <div class="input-group date"  data-target-input="nearest">
                            <input readonly name="date" type="text" class="form-control datetimepicker-input" id="datePicker" data-toggle="datetimepicker" data-target="#datePicker" required/>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="title">Select Time</label>
                        <div class="input-group date"  data-target-input="nearest">
                            <input readonly name="time" type="text" class="form-control datetimepicker-input" id="timePicker" data-toggle="datetimepicker" data-target="#timePicker" required/>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Visitor Information Form --}}
            <h5> Visitor Information </h5>
            <div id="visitorInformationContainer">
                {{-- Jquery Quik --}}
            </div>

            <div class="text-center">
                <a href="#!" class="text-decoration-underline" id="addNewVisitorBtn">Add new +</a>
            </div>
            {{-- Visitor Information Form Finished --}}

            {{-- Staff Information --}}
            <h5> uab Staff Information </h5>

            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="title">Branch</label>
                        <input type="text" class="form-control" id="staff_branch" name="branch" required >
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="title">uab Staff Name</label>
                        <input type="text" class="form-control" id="staff_name" name="staff_name" required >
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="title">uab Staff Email</label>
                        <input type="text" class="form-control" id="staff_email" name="staff_email" required >
                    </div>
                </div>
            </div>
            {{-- Staff Information Finished --}}

            {{-- Submit Button --}}
            <button class="btn btn-primary btn-block" type="submit">Submit form</button>
            {{-- Submit Button Finished --}}
        </form>

    </div>
    {{-- Appointment Request Form Finished --}}
</div>

@push('body-scripts')
<script>
    $(document).ready(function() {
        var timePicker = $('#timePicker');
        var datePicker = $('#datePicker');
        var addNewVisitor = $('#addNewVisitorBtn');

        $(datePicker).datetimepicker({format: "L"});
        $(timePicker).datetimepicker({format: 'LT'});

        [datePicker, timePicker].forEach( function(item) {
            $(item)[0].isContentEditable = false;
        });

        // Visitor
        var visitorFormTypeList = [{
            label: 'Your Name',
            type: 'text',
            name: 'name',
        }, {
            label: 'Your Phone',
            type: 'tel',
            name: 'phone',
        }, {
            label: 'Company Name',
            type: 'text',
            name: 'co_name',
        }, {
            label: 'Email',
            type: 'text',
            name: 'email',
        }];
        var defaultVisitor = {name: '', phone: '', co_name: '', email: ''};
        var visitorList = [];

        $(addNewVisitorBtn).click(function() {
            var container = $('#visitorInformationContainer');
            $(container).empty();
            visitorList.push(JSON.parse(JSON.stringify(defaultVisitor)));

            visitorList.forEach(function (formList, index) {
                var row = $('<div>', {class: 'row', id: 'visitorRow[' + index + ']'});
                visitorFormTypeList.forEach(function (form) {
                    var eachField = createVisitorField(index, form.label, form.type, form.name, formList[form.name]);
                    row.append(eachField);
                });
                container.append(row);
            })
        });


        function createVisitorField(index, label, type, name, value) {
            // <div class="col-sm-6 col-md-3">
            //     <div class="form-group">
            //         <label for="visitor[0].name">Your Name</label>
            //         <input type="text" class="form-control" id="visitor[0].name">
            //     </div>
            // </div>

            var visitorFieldId = 'visitor[' + index +'][' + name + ']';
            var visitorField = $('<div>', {class: "col-sm-6 col-md-3"}).append(
                $('<div>', {class: "form-group"})
                    .append(
                        $('<label>', {for: visitorFieldId}).html(label)
                    )
                    .append(
                        $('<input>', {type: type, class: 'form-control', id: visitorFieldId, name: visitorFieldId, required: 'required'})
                        .val(value)
                        .on('keyup', function (event) {
                            visitorList[index][name] = event.target.value;
                        })
                    )
            );

            return visitorField;
        }

        $(addNewVisitorBtn).click();
    });
</script>
@endpush

@endsection
