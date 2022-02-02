@extends('layouts.admin-layout')

@section('content')

  <div class="container main-wrapper mt-2">

    <nav aria-label="breadcrumb" class="mx-auto max-w-600">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('admin.index') }}" role="button">Dashboard</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('admin.data.division') }}" role="button">Division</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Create
          </li>
        </ol>
    </nav>

    <div class="card p-3 mt-3 mx-auto max-w-600" href="#!">
        <div class="w-100">
            @include('common.flash-message')

            <form action="{{route('admin.data.division-create-submit')}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="nameInput">Division Name</label>
                            <input autocomplete="off" type="text" class="form-control @error('division_name') is-invalid @enderror" id="nameInput" name="division_name" value="{{ old('division_name') ? old('division_name') : '' }}">
                            <div class="invalid-feedback">
                                Required Division Name
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-block btn-primary icon-btn-position mt-2"><i class="fa text-white fa-edit"></i> Submit </button>
                        <a href="{{ route('admin.data.division')}}" role="button" class="btn btn-outline-danger btn-block icon-btn-position"><i class="fa text-white fa-back"></i> Cancel </a>
                    </div>
                </div>

            </form>
        </div>
    </div>

  </div>
@endsection


