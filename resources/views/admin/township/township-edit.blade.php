@extends('layouts.admin-layout')

@section('content')

  <div class="container main-wrapper mt-2">

    <nav aria-label="breadcrumb" class="mx-auto max-w-600">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('admin.index') }}" role="button">Dashboard</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('admin.data.township') }}" role="button">Township</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Edit
          </li>
        </ol>
    </nav>

    <div class="card p-3 mt-3 mx-auto max-w-600" href="#!">
        <div class="w-100">
            @include('common.flash-message')

            <form action="{{route('admin.data.township-edit-submit', ['id' => $township->id])}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="nameInput">Township Name</label>
                            <input autocomplete="off" type="text" class="form-control @error('township_name') is-invalid @enderror" id="nameInput" name="township_name" value="{{ old('township_name') ? old('township_name') : $township->township_name }}">
                            <div class="invalid-feedback">
                                Required Township Name
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="division_id">Division & State</label>
                            <select class="custom-select" id="division_id" name="division_id">
                                @foreach ($divisions as $key => $division)
                                <option
                                    value="{{ $division->id }}"
                                    {{ (old('division_id') == $division->id ? 'selected' : $township->division_id == $division->id) ? 'selected' : ''}}
                                >{{ $division->division_name }}
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
                        <a href="{{ route('admin.data.township')}}" role="button" class="btn btn-outline-danger btn-block icon-btn-position"><i class="fa text-white fa-back"></i> Cancel </a>
                    </div>
                </div>

            </form>
        </div>
    </div>

  </div>
@endsection


