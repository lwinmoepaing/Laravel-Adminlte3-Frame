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
                <a href="{{ route('admin.data.department') }}" role="button" disabled>Department</a>
            </li>
            </ol>
        </nav>
    </div>


    <div class="card pt-3 pb-2 px-4 mt-3">
        <a  href="{{ route('admin.data.department-create') }}" class="btn btn-primary btn-block"> <i class="fa fa-building-o text-white"></i> <i class="fa fa-plus text-white"></i> Add Department </a>
    </div>


    <div class="card p-4 mt-3">

        @include('common.flash-message')

        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Department Name</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($departments as $department )
                    <tr>
                        <th scope="row">{{ $department->id }}</th>
                        <td>{{ $department->department_name }}</td>
                        <td>
                            <a href="{{ route('admin.data.department-edit', ['id' => $department->id ]) }}" role="button" type="button" class="btn btn-sm btn-success icon-btn-position"><i class="fa text-white fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{  $departments->links() }}
    </div>

    </div>
  </div>


@endsection
