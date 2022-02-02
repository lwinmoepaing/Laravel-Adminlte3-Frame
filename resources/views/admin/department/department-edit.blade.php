@extends('layouts.admin-layout')

@section('content')

  <div class="container main-wrapper mt-2">

    <nav aria-label="breadcrumb" class="mx-auto max-w-600">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('admin.index') }}" role="button">Dashboard</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('admin.data.department') }}" role="button">Department</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Edit
          </li>
        </ol>
    </nav>

    <div class="card p-3 mt-3 mx-auto max-w-600" href="#!">
        <div class="w-100">
            @include('common.flash-message')

            <form action="{{route('admin.data.department-edit-submit', ['id' => $department->id])}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="nameInput">ID</label>
                            <input readonly disabled autocomplete="off" type="text" class="form-control" id="nameInput" value="#{{ $department->id }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="nameInput">Name</label>
                            <input autocomplete="off" type="text" class="form-control @error('department_name') is-invalid @enderror" id="nameInput" name="department_name" value="{{ old('department_name') ? old('department_name') : $department->department_name }}">
                            <div class="invalid-feedback">
                                @error('department_name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-block btn-primary icon-btn-position mt-2"><i class="fa text-white fa-edit"></i> Submit </button>
                        <a href="{{ route('admin.data.department')}}" role="button" class="btn btn-outline-danger btn-block icon-btn-position"><i class="fa text-white fa-back"></i> Cancel </a>
                    </div>
                </div>

            </form>
        </div>
    </div>

  </div>
@endsection


