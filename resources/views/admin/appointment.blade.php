@extends('layouts.admin-layout')

@section('content')

<div class="container-fluid border-bottom bg-white height-57">
    <div class="d-flex main-wrapper mt-0 px-0" style="justify-content: space-between;;">
      <ul class="nav nav-tabs my-navtabs" id="myTab" role="tablist" style="border-bottom: o !important;">
        <li class="nav-item">
          <a class="nav-link height-57 text-flex-center active" id="home-tab" data-toggle="tab" href="#request" role="tab" aria-controls="request" aria-selected="true">Request<span class="ml-2 p-1 badge badge-warning">1</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link height-57 text-flex-center" id="upcoming-tab" data-toggle="tab" href="#upcoming" role="tab" aria-controls="upcoming" aria-selected="false">Upcoming<span class="ml-2 p-1 badge badge-primary">1</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link height-57 text-flex-center" id="occupied-tab" data-toggle="tab" href="#occupied" role="tab" aria-controls="occupied" aria-selected="false">Occupied<span class="ml-2 p-1 badge badge-success">1</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link height-57 text-flex-center" id="finished-tab" data-toggle="tab" href="#finished" role="tab" aria-controls="finished" aria-selected="false">Finished</a>
        </li>
      </ul>

      <a class="btn btn-primary btn-sm text-white custom-appointment-btn " href="appointment-create.html">Create Appointment</a>
    </div>
  </div>

  <div class="px-3 d-block d-lg-none">
    <a class="btn btn-primary btn-block my-3 btn-sm text-white " href="appointment-create.html">Create Appointment</a>
  </div>

  <div class="container main-wrapper mt-0">
    <div class="row">
      <div class="col-12">
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="request" role="tabpanel" aria-labelledby="request-tab">
            <div class="row my-3">
              <div class="col-md-6 mb-2">
                <a class="card upcoming-section p-3" href="{{ route('admin.appointment.detail', ["appintment_id" => "1"]) }}">
                  <!-- <div class="text-center w-10 appointment-time">
                    <span class="d-block border p-3 rounded">
                      <b>10:30</b><br>
                      AM
                    </span>
                  </div> -->
                  <div class="w-100 ml-3">
                    <div class="row">
                      <div class="col-md-12">
                        <h5 class="my-2">
                          <b>API Integration</b>
                          <div class="badge badge-secondary float-right">Pending</div>
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

                      <div class="col-md-12 my-3">
                        <span>Request Time</span>
                        <h6 class="mt-2">
                          <i class="fa fa-calendar mr-2" style="font-size: 16px;"></i>04 Feb 2022   -    10:30 AM
                        </h6>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>


          <div class="tab-pane fade" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
            <div class="row my-3">
              <div class="col-md-6 mb-2">
                <a class="card upcoming-section p-3" href="{{ route('admin.appointment.detail', ["appintment_id" => "1"]) }}">
                  <div class="text-center w-10 appointment-time">
                    <span class="d-block border p-3 rounded">
                      <b>10:30</b><br>
                      AM
                    </span>
                  </div>

                  <div class="w-100 ml-3">
                    <div class="row">
                      <div class="col-md-12">
                        <h5 class="my-2">
                          <b>API Integration</b>
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

                      <div class="col-md-12 my-3">
                        <span>Request Time</span>
                        <h6 class="mt-2">
                          <i class="fa fa-calendar mr-2" style="font-size: 16px;"></i>04 Feb 2022   -    10:30 AM
                        </h6>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <!-- end upcoming -->

          <!-- occupied -->
          <div class="tab-pane fade" id="occupied" role="tabpanel" aria-labelledby="occupied-tab">
            <div class="row my-3">
              <div class="col-md-6 mb-2">
                <a class="card upcoming-section p-3" href="{{ route('admin.appointment.detail', ["appintment_id" => "1"]) }}">
                  <div class="text-center w-10 appointment-time">
                    <span class="d-block border p-3 rounded">
                      <b>10:30</b><br>
                      AM
                    </span>

                    <div class="mt-2 d-block py-2 badge badge-primary">
                      Room 1
                    </div>
                  </div>

                  <div class="w-100 ml-3">
                    <div class="row">
                      <div class="col-md-12">
                        <h5 class="my-2">
                          <b>API Integration</b>
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

                      <div class="col-md-12 my-3">
                        <span>Request Time</span>
                        <h6 class="mt-2">
                          <i class="fa fa-calendar mr-2" style="font-size: 16px;"></i>04 Feb 2022   -    10:30 AM
                        </h6>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <!-- end occupied -->

          <!-- finished -->
          <div class="tab-pane fade" id="finished" role="tabpanel" aria-labelledby="finished-tab">
            <div class="row my-3">
              <div class="col-md-6 mb-2">
                <a class="card upcoming-section p-3" href="{{ route('admin.appointment.detail', ["appintment_id" => "1"]) }}">
                  <div class="text-center w-10 appointment-time">
                    <span class="d-block border p-3 rounded">
                      <b>10:30</b><br>
                      AM
                    </span>

                    <div class="mt-2 d-block py-2 badge badge-primary">
                      Room 1
                    </div>

                    <span class="mt-2 d-block border p-3 rounded">
                      <b>11:30</b><br>
                      AM
                    </span>
                  </div>

                  <div class="w-100 ml-3">
                    <div class="row">
                      <div class="col-md-12">
                        <h5 class="my-2">
                          <b>API Integration</b>
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

                      <div class="col-md-12 my-3">
                        <span>Request Time</span>
                        <h6 class="mt-2">
                          <i class="fa fa-calendar mr-2" style="font-size: 16px;"></i>04 Feb 2022   -    10:30 AM
                        </h6>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <!-- end finished -->
        </div>
      </div>
    </div>
  </div>
@endsection
