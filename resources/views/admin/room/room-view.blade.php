@extends('layouts.admin-layout')

@section('content')

  <div class="container main-wrapper mt-2">

   <div>
        <nav aria-label="breadcrumb" class="mx-auto">
            <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route('admin.index') }}" role="button">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route('admin.rooms.index') }}" role="button" disabled>Room</a>
            </li>
            </ol>
        </nav>
    </div>


    <div class="card pt-3 pb-2 px-4 mt-3">
        <form action="" method="GET">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="form-group">
                        <select class="custom-select" id="branch_id" name="branch_id">
                            <option value=""> Search By Branch </option>
                            @foreach ($branches as $key => $branch)
                            <option
                                value="{{ $branch->id }}"
                                {{ $branchQuery == $branch->id ? 'selected' : ''}}
                            >{{ $branch->branch_name }} ({{ $branch->township->township_name }})
                            </option>
                            @endforeach
                        </select>

                        {{-- <input autocomplete="off" placeholder="Search By Email" type="text" class="form-control" id="nameInput" name="email" value="{{ $branchQuery ?? '' }}"> --}}
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="form-group">
                        <select class="custom-select" id="status" name="status">
                            <option value=""> Search By Status </option>
                            @foreach ($statusList as $key => $status)
                            <option
                                value="{{ $status }}"
                                {{ $statusQuery == $status ? 'selected' : ''}}
                            >{{ $key }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <button type="submit" class="btn btn-outline-primary btn-block"> <i class="fa fa-search"></i> Search </button>
                </div>
            </div>
        </form>

        <a  href="{{ route('admin.rooms.room-create') }}" class="btn btn-primary btn-block"> <i class="fa fa-clone text-white"></i>  <i class="fa fa-plus text-white"></i> Create Room </a>
    </div>

    <div class="card p-4 mt-3">

        @include('common.flash-message')

        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Room Name</th>
                <th scope="col">Branch</th>
                <th scope="col">Current Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room )
                    <tr>
                        <th scope="row">{{ $room->id }}</th>
                        <td>{{ $room->room_name }}</td>
                        <td>{{ $room->branch->branch_name }}</td>
                        <td>{{ $room->status_name }}</td>
                        <td>
                            <a href="{{ route('admin.rooms.room-detail', [ 'id' => $room->id ]) }}" role="button" type="button" class="btn btn-sm btn-primary icon-btn-position"><i class="fa text-white fa-eye"></i></a>
                            <a href="{{ route('admin.rooms.room-edit', [ 'id' => $room->id ]) }}" role="button" type="button" class="btn btn-sm btn-success icon-btn-position"><i class="fa text-white fa-edit"></i></a>
                            <a href="#!" class="btn btn-sm btn-danger icon-btn-position deleteRoom" data-id="{{$room->id}}" ><i class="fa text-white fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{  $rooms->links() }}
    </div>

    </div>
  </div>


    <form id="remove-room-form" action="{{route('admin.rooms.room-remove', ['id' => '0'])}}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('body-scripts')
<script>
    $(document).ready(function () {
        $('.deleteRoom').click(function() {
            var url = '{{route('admin.rooms.room-remove', ['id' => '0'])}}';
            var id = $(this).data('id');
            var isTrue = confirm('Are you sure to delete?');
            var form = $('#remove-room-form');
            $(form).attr('action', url + id)
            if (isTrue) $(form).submit();
        });
    });
</script>
@endpush
