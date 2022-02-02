@extends('layouts.admin-layout')

@section('content')

  <div class="container main-wrapper mt-2">

    <nav aria-label="breadcrumb" class="mx-auto max-w-600">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('admin.index') }}" role="button">Dashboard</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('admin.rooms.index') }}" role="button">Room</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Create
          </li>
        </ol>
    </nav>

    <div class="card p-3 mt-3 mx-auto max-w-600" href="#!">
        <div class="w-100">
            @include('common.flash-message')

            <form action="{{route('admin.rooms.room-create-submit')}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="nameInput">Room Name</label>
                            <input autocomplete="off" type="text" class="form-control @error('room_name') is-invalid @enderror" id="nameInput" name="room_name" value="{{ old('room_name') ? old('room_name') : '' }}">
                            <div class="invalid-feedback">
                                Required Room Name
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

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="nameInput">Seat Count (Optional)</label>
                            <input autocomplete="off" type="number" class="form-control @error('seat_count') is-invalid @enderror" id="nameInput" name="seat_count" value="{{ old('seat_count') ? old('seat_count') : '' }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="nameInput">Area (Optional)</label>
                            <input autocomplete="off" type="text" class="form-control @error('area') is-invalid @enderror" id="nameInput" name="area" value="{{ old('area') ? old('area') : '' }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="nameInput">Note (Optional) </label>
                            <input autocomplete="off" type="text" class="form-control @error('note') is-invalid @enderror" id="nameInput" name="note" value="{{ old('note') ? old('note') : '' }}">
                        </div>
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
@endsection


