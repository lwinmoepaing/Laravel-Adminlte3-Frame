@extends('layouts.admin-layout')

@section('content')

    <div class="container main-wrapper mt-2">

        <nav aria-label="breadcrumb" class="mx-auto max-w-600">
            <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route('admin.index') }}" role="button">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route('admin.data.staff') }}" role="button">Staff</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
            </ol>
        </nav>

        <div class="card p-3 mt-3 mx-auto max-w-600" href="#!">
            <div class="w-100">
                @include('common.flash-message')

                <form action="{{ route('admin.data.staff-create-submit') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="nameInput">Name</label>
                                <input autocomplete="off" type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name') ? old('name') : '' }}">
                                <div class="invalid-feedback">
                                    Required Name
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input
                                    autocomplete="off"
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') ? old('email') : ''}}"
                                    class="
                                        form-control
                                        @error('email') is-invalid @enderror
                                        @if ($alreadyEmail = Session::get('already-email'))
                                            is-invalid
                                        @endif
                                    "
                                >
                                <div class="invalid-feedback">
                                    @error('email')
                                        {{ $message }}
                                    @enderror

                                    @if ($alreadyEmail)
                                        {{ $alreadyEmail }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input autocomplete="off" type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') ? old('phone') : ''}}">
                                <div class="invalid-feedback">
                                    Required Phone Number
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="branch_id">Branch</label>
                                <select class="custom-select" id="branch_id" name="branch_id">
                                    @foreach ($branches as $key => $branch)
                                    <option
                                        value="{{ $branch->id }}"
                                        {{ old('branch_id') == $branch->id ? 'selected' : ''}}
                                    >{{ $branch->branch_name }} ({{ $branch->township->township_name }})
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Required Branch
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="department_id">Department (Optional)</label>
                                <select class="custom-select" id="department_id" name="department_id">
                                    @foreach ($departments as $key => $department)
                                    <option
                                        value="{{ $department->id }}"
                                        {{ old('department_id') == $department->id ? 'selected' : ''}}
                                    >{{ $department->department_name }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Required Department
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="staff_role_id">Staff Role (Optional)</label>
                                <select class="custom-select" id="staff_role_id" name="staff_role_id">
                                    @foreach ($staffRoles as $key => $staff_role)
                                    <option
                                        value="{{ $staff_role->id }}"
                                        {{ old('staff_role_id') == $staff_role->id ? 'selected' : ''}}
                                    >{{ $staff_role->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Required Staff Role
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-12">
                            @if ($restoreMessage = Session::get('restore'))
                                <a id="restoreBtn" class="text-decoration-underline" href="#!"> {{ $restoreMessage }} </a>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-block btn-primary icon-btn-position mt-2"><i class="fa text-white fa-edit"></i> Submit </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <form id="recovery-form" action="{{route('admin.data.staff-recover')}}" method="POST" class="d-none">
        @csrf
        <input type="hidden" name="email" value="{{old('email')}}">
    </form>
@endsection

@push('body-scripts')
<script>
    $(document).ready(function () {
        $('#restoreBtn').click(function() {
            var url = '{{route('admin.data.staff-recover')}}';
            var email = '{{old('email')}}'
            var form = $('#recovery-form');
            $(form).attr('action', url)
            $(form).submit();
        });
    });
</script>
@endpush
