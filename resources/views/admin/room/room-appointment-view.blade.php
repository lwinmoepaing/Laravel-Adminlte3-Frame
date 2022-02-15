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
                 <div class="col-lg-8 col-sm-12">
                     <div class="form-group">
                         <select class="custom-select" id="branch_id" name="branch_id">
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
                     <button type="submit" class="btn btn-outline-primary btn-block"> <i class="fa fa-search"></i> Search </button>
                 </div>
             </div>
         </form>
     </div>

     <div class="card p-4 mt-3">
        <div class="row">

            @foreach ($rooms as $key => $room)
                <div class="col-md-4 mb-3">
                    <a
                        class="
                            card min-130 upcoming-section p-3 border
                            {{ $room->status == 1 ? 'border-success' : ($room->status == 2 ? 'border-danger' : 'border-warning' )}}
                        "
                    href="{{ route('admin.rooms.room-detail', [ 'id' => $room->id ]) }}">
                        <div class="w-100 ml-3">
                        <div class="row">
                            <div class="col-md-12">
                            <h5 class="my-2">
                                {{ $room->room_name }}
                                <div class="float-right">
                                    <h6>{{$room->status_name}}</h6>
                                </div>
                            </h5>
                            </div>

                            <div class="col-md-12 my-3">
                                <div class="flex-center-helper">
                                        <div class="flex-1-helper">
                                           {{ $room->branch->branch_name }}
                                        </div>
                                        {{-- <div class="border border-primary rounded p-1 ml-2">
                                            10:30 AM
                                        </div> --}}
                                </div>
                            </div>

                            {{-- <div class="col-md-12 my-3">
                                <span>Client</span>
                                <h6 class="mt-2"><i class="fa fa-user mr-2" style="font-size: 16px;"></i>Aung Aung</h6>
                                <span>09 782417621, Sein Gay Har, aungaung@gmail.com</span>
                            </div>

                            <div class="col-md-12 my-3">
                                <span>uab officer</span>
                                <h6 class="mt-2"><i class="fa fa-user mr-2" style="font-size: 16px;"></i>Zaw Zaw</h6>
                                <span>Fintech & Digital</span>
                            </div> --}}
                        </div>
                        </div>
                    </a>
                </div>
            @endforeach

            {{-- <div class="col-md-4 mb-2">
              <a class="card min-380 upcoming-section p-3 border border-danger" href="#!">
                <div class="w-100 ml-3">
                  <div class="row">
                    <div class="col-md-12">
                      <h5 class="my-2">
                        <b>Room 2</b>
                      </h5>
                    </div>
                    <div class="col-md-12 my-3">
                      <span>Client</span>
                      <h6 class="mt-2"><i class="fa fa-user mr-2" style="font-size: 16px;"></i>Aung Aung</h6>
                      <span>09 782417621, Sein Gay Har, aungaung@gmail.com</span>
                    </div>

                    <div class="col-md-12 my-3">
                      <span>uab officer</span>
                      <h6 class="mt-2"><i class="fa fa-user mr-2" style="font-size: 16px;"></i>Zaw Zaw</h6>
                      <span>Fintech & Digital</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-4 mb-2">
              <a class="card min-380 upcoming-section p-3 border border-success" href="#!">
                <div class="w-100 ml-3">
                  <div class="row">
                    <div class="col-md-12">
                      <h5 class="my-2">
                        <b>Room 3</b>
                      </h5>
                    </div>
                    <div class="col-md-12 my-3">
                      <span>Client</span>
                      <h6 class="mt-2"><i class="fa fa-user mr-2" style="font-size: 16px;"></i>Aung Aung</h6>
                      <span>09 782417621, Sein Gay Har, aungaung@gmail.com</span>
                    </div>

                    <div class="col-md-12 my-3">
                      <span>uab officer</span>
                      <h6 class="mt-2"><i class="fa fa-user mr-2" style="font-size: 16px;"></i>Zaw Zaw</h6>
                      <span>Fintech & Digital</span>
                    </div>
                  </div>
                </div>
              </a>
            </div> --}}

        </div>
     </div>

     </div>
   </div>
@endsection
