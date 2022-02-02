@extends('layouts.admin-layout')

@section('content')

  <div class="container main-wrapper mt-2">

    <nav aria-label="breadcrumb" class="mx-auto max-w-600">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('admin.index') }}" role="button">Dashboard</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('admin.data.branch') }}" role="button">Branch</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Edit
          </li>
        </ol>
    </nav>

    <div class="card p-3 mt-3 mx-auto max-w-600" href="#!">
        <div class="w-100">
            @include('common.flash-message')

            <form action="{{route('admin.data.branch-edit-submit', ['id' => $branch->id])}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="nameInput">Branch Name</label>
                            <input autocomplete="off" type="text" class="form-control @error('branch_name') is-invalid @enderror" id="nameInput" name="branch_name" value="{{ old('branch_name') ? old('branch_name') : $branch->branch_name }}">
                            <div class="invalid-feedback">
                                Required Branch Name
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="nameInput">Branch Address</label>
                            <input autocomplete="off" type="text" class="form-control @error('branch_address') is-invalid @enderror" id="nameInput" name="branch_address" value="{{ old('branch_address') ? old('branch_address') : $branch->branch_address }}">
                            <div class="invalid-feedback">
                                Required Branch Address
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="township_id">Township</label>
                            <select class="custom-select" id="township_id" name="township_id">
                                @foreach ($townships as $key => $township)
                                <option
                                    value="{{ $township->id }}"
                                    {{ (old('township_id') == $township->id ? 'selected' : $branch->township_id == $township->id) ? 'selected' : ''}}
                                >{{ $township->township_name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Required Township
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-block btn-primary icon-btn-position mt-2"><i class="fa text-white fa-edit"></i> Submit </button>
                        <a href="{{ route('admin.data.branch')}}" role="button" class="btn btn-outline-danger btn-block icon-btn-position"><i class="fa text-white fa-back"></i> Cancel </a>
                    </div>
                </div>

            </form>
        </div>
    </div>

  </div>
@endsection


