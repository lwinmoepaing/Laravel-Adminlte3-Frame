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
                <a href="{{ route('admin.data.staff') }}" role="button" disabled>Staff</a>
            </li>
            </ol>
        </nav>
    </div>


    <div class="card pt-3 pb-2 px-4 mt-3">
        <form action="" method="GET">
            <div class="row">
                <div class="col-lg-3 col-sm-12">
                    <div class="form-group">
                        <input autocomplete="off" placeholder="Search By Name" type="text" class="form-control" id="nameInput" name="name" value="{{ $queryName ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12">
                    <div class="form-group">
                        <input autocomplete="off" placeholder="Search By Email" type="text" class="form-control" id="emailInput" name="email" value="{{ $queryEmail ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12">
                    <div class="form-group">
                        <input autocomplete="off" placeholder="Search By Phone" type="text" class="form-control" id="phoneInput" name="phone" value="{{ $queryPhone ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12">
                    <button type="submit" class="btn btn-outline-primary btn-block"> <i class="fa fa-search"></i> Search </button>
                </div>
            </div>
        </form>

        <a  href="{{ route('admin.data.staff-create') }}" class="btn btn-primary btn-block"> <i class="fa fa-user-plus text-white"></i> Add Staff </a>
    </div>

    <div class="card p-4 mt-3">

        @include('common.flash-message')

        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Branch</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($staffs as $staff )
                    <tr>
                        <th scope="row">{{ $staff->id }}</th>
                        <td>{{ $staff->name }}</td>
                        <td>{{ $staff->email }}</td>
                        <td>{{ $staff->phone }}</td>
                        <td>{{ $staff->branch->branch_name }}</td>
                        <td>
                            <a href="{{ route('admin.appointment.appointment-create', ['fixed_staff' => $staff->id ]) }}" role="button" type="button" class="btn btn-sm btn-info icon-btn-position"><i class="fa text-white fa-address-book"></i></a>
                            <a href="{{ route('admin.data.staff-detail', ['id' => $staff->id ]) }}" role="button" type="button" class="btn btn-sm btn-primary icon-btn-position"><i class="fa text-white fa-eye"></i></a>
                            <a href="{{ route('admin.data.staff-edit', ['id' => $staff->id ]) }}" role="button" type="button" class="btn btn-sm btn-success icon-btn-position"><i class="fa text-white fa-edit"></i></a>
                            <a href="#!" class="btn btn-sm btn-danger icon-btn-position deleteStaff" data-id="{{$staff->id}}" ><i class="fa text-white fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{  $staffs->links() }}
    </div>

    </div>
  </div>


    <form id="remove-staff-form" action="{{route('admin.data.staff-remove', ['id' => '0'])}}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('body-scripts')
<script>
    $(document).ready(function () {
        $('.deleteStaff').click(function() {
            var url = '{{route('admin.data.staff-remove', ['id' => '0'])}}';
            var id = $(this).data('id');
            var isTrue = confirm('Are you sure to delete?');
            var form = $('#remove-staff-form');
            $(form).attr('action', url + id)
            if (isTrue) $(form).submit();
        });
    });
</script>
@endpush
