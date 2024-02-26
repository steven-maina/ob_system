@extends('layouts/layoutMaster')

@section('title', 'View Profile')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-user-view.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/modal-edit-user.js',
  'resources/assets/js/app-user-view.js',
  'resources/assets/js/app-user-view-account.js'
])
@endsection

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">User / View /</span> Account
</h4>
<div class="row">
  <!-- User Sidebar -->
  <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
    <!-- User Card -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="user-avatar-section">
          <div class=" d-flex align-items-center flex-column">
            <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ asset('assets/img/avatars/15.png') }}" height="100" width="100" alt="User avatar" />
            <div class="user-info text-center">
              <h4 class="mb-2">{{ auth()->user()->name }}</h4>
              <span class="badge bg-label-secondary mt-1">Author</span>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
          <div class="d-flex align-items-start me-4 mt-3 gap-2">
            <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-checkbox ti-sm'></i></span>
            <div>
              <p class="mb-0 fw-medium">1.23k</p>
              <small>Tasks Done</small>
            </div>
          </div>
          <div class="d-flex align-items-start mt-3 gap-2">
            <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-briefcase ti-sm'></i></span>
            <div>
              <p class="mb-0 fw-medium">568</p>
              <small>Projects Done</small>
            </div>
          </div>
        </div>
        <p class="mt-4 small text-uppercase text-muted">Details</p>
        <div class="info-container">
          <ul class="list-unstyled">
            <li class="mb-2">
              <span class="fw-medium me-1">Phone Number:</span>
              <span>{{ auth()->user()->phone_number }}</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Email:</span>
              <span>{{ auth()->user()->email }}</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Status:</span>
              <span class="badge bg-label-success">
                {{ auth()->user()->status }}
              </span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Role:</span>
              <span>
                @if(auth()->user()->roles->isNotEmpty())
                  {{ auth()->user()->roles->first()->name }}
                @endif
              </span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">County:</span>
              <span>{{ auth()->user()->county->name ?? '' }}</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Sub-County:</span>
              <span>{{ auth()->user()->county->name ?? '' }}</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Ward:</span>
              <span>{{ auth()->user()->ward->name ?? '' }}</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Address:</span>
              <span>{{ auth()->user()->address ?? '' }}</span>
            </li>
            <li class="pt-1">
              <span class="fw-medium me-1">Country:</span>
              <span>{{ auth()->user()->country->name ?? ''}}</span>
            </li>
          </ul>
          <div class="d-flex justify-content-center">
            <a href="javascript:;" class="btn btn-primary me-3" data-bs-target="#editUser" data-bs-toggle="modal">Edit</a>
{{--            <a href="javascript:;" class="btn btn-label-danger suspend-user">Suspended</a>--}}
          </div>
        </div>
      </div>
    </div>
    <!-- /User Card -->
  </div>
  <!--/ User Sidebar -->


  <!-- User Content -->
  <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
    <!-- User Pills -->
    <ul class="nav nav-pills flex-column flex-md-row mb-4">
      <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="ti ti-user-check ti-xs me-1"></i>Account</a></li>
      <li class="nav-item"><a class="nav-link" href="{{route('user.security')}}"><i class="ti ti-lock ti-xs me-1"></i>Security and Password</a></li>
{{--      <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/billing')}}"><i class="ti ti-currency-dollar ti-xs me-1"></i>Billing & Plans</a></li>--}}
{{--      <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/notifications')}}"><i class="ti ti-bell ti-xs me-1"></i>Notifications</a></li>--}}
{{--      <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/connections')}}"><i class="ti ti-link ti-xs me-1"></i>Connections</a></li>--}}
    </ul>
    <!--/ User Pills -->

    <!-- Project table -->
    <div class="card mb-4">
      <h6 class="card-header">Records of Cases Booked</h6>
      <div class="table-responsive mb-3">
          <table class="table table-bordered border-top">
            <thead>
            <tr>
              <th>Booking ID</th>
              <th>Date</th>
              <th class="text-center">Time</th>
              <th>Location</th>
              <th>Offense</th>
              <th>Recorded On</th>
            </tr>
            </thead>
            <tbody>
            @forelse($bookings as $booking)
              <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->booking_date }}</td>
                <td>{{ $booking->booking_time }}</td>
                <td>{{ $booking->location }}</td>
                <td>{{ $booking->offense->name }}</td>
                <td class="text-center">
                  <p>{{ $booking->created_at->diffForHumans() }}</p>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center">
                  <p class="text-rose-400">You Have No bookings Recorded At The Moment.</p>
                </td>
              </tr>
            @endforelse

            </tbody>

          </table>
      </div>
    </div>
    <!-- /Project table -->

    <!-- Activity Timeline -->
{{--    <div class="card mb-4">--}}
{{--      <h5 class="card-header">Your Latest Activity Logs</h5>--}}
{{--      <div class="card-body pb-0">--}}
{{--        <ul class="timeline mb-0">--}}
{{--          <li class="timeline-item timeline-item-transparent">--}}
{{--            <span class="timeline-point timeline-point-primary"></span>--}}
{{--            <div class="timeline-event">--}}
{{--              <div class="timeline-header mb-1">--}}
{{--                <h6 class="mb-0">{{ auth()->user()->action }}</h6>--}}
{{--                <small class="text-muted">12 min ago</small>--}}
{{--              </div>--}}
{{--              <p class="mb-2">Invoices have been paid to the company</p>--}}
{{--              <div class="d-flex">--}}
{{--                <a href="javascript:void(0)" class="me-3">--}}
{{--                  <img src="{{asset('assets/img/icons/misc/pdf.png')}}" alt="PDF image" width="15" class="me-2">--}}
{{--                  <span class="fw-medium text-heading">invoices.pdf</span>--}}
{{--                </a>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </li>--}}
{{--          <li class="timeline-item timeline-item-transparent">--}}
{{--            <span class="timeline-point timeline-point-warning"></span>--}}
{{--            <div class="timeline-event">--}}
{{--              <div class="timeline-header mb-1">--}}
{{--                <h6 class="mb-0">Client Meeting</h6>--}}
{{--                <small class="text-muted">45 min ago</small>--}}
{{--              </div>--}}
{{--              <p class="mb-2">Project meeting with john @10:15am</p>--}}
{{--              <div class="d-flex flex-wrap">--}}
{{--                <div class="avatar me-3">--}}
{{--                  <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Avatar" class="rounded-circle" />--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                  <h6 class="mb-0">Lester McCarthy (Client)</h6>--}}
{{--                  <small>CEO of {{ config('variables.creatorName') }}</small>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </li>--}}
{{--          <li class="timeline-item timeline-item-transparent">--}}
{{--            <span class="timeline-point timeline-point-info"></span>--}}
{{--            <div class="timeline-event">--}}
{{--              <div class="timeline-header mb-1">--}}
{{--                <h6 class="mb-0">Create a new project for client</h6>--}}
{{--                <small class="text-muted">2 Day Ago</small>--}}
{{--              </div>--}}
{{--              <p class="mb-2">5 team members in a project</p>--}}
{{--              <div class="d-flex align-items-center avatar-group">--}}
{{--                <div class="avatar pull-up" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Vinnie Mostowy">--}}
{{--                  <img src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar" class="rounded-circle">--}}
{{--                </div>--}}
{{--                <div class="avatar pull-up" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Marrie Patty">--}}
{{--                  <img src="{{ asset('assets/img/avatars/12.png') }}" alt="Avatar" class="rounded-circle">--}}
{{--                </div>--}}
{{--                <div class="avatar pull-up" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Jimmy Jackson">--}}
{{--                  <img src="{{ asset('assets/img/avatars/9.png') }}" alt="Avatar" class="rounded-circle">--}}
{{--                </div>--}}
{{--                <div class="avatar pull-up" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Kristine Gill">--}}
{{--                  <img src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar" class="rounded-circle">--}}
{{--                </div>--}}
{{--                <div class="avatar pull-up" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Nelson Wilson">--}}
{{--                  <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Avatar" class="rounded-circle">--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </li>--}}
{{--          <li class="timeline-item timeline-item-transparent border-transparent">--}}
{{--            <span class="timeline-point timeline-point-success"></span>--}}
{{--            <div class="timeline-event">--}}
{{--              <div class="timeline-header mb-1">--}}
{{--                <h6 class="mb-0">Design Review</h6>--}}
{{--                <small class="text-muted">5 days Ago</small>--}}
{{--              </div>--}}
{{--              <p class="mb-0">Weekly review of freshly prepared design for our new app.</p>--}}
{{--            </div>--}}
{{--          </li>--}}
{{--        </ul>--}}
{{--      </div>--}}
{{--    </div>--}}
    <!-- /Activity Timeline -->
  </div>
  <!--/ User Content -->
</div>

<!-- Modal -->
@include('_partials/_modals/modal-edit-user')
<!-- /Modal -->
@endsection
