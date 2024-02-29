@extends('layouts/layoutMaster')

@section('title', 'User List ')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
//    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss'
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/moment/moment.js',
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
//    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/cleavejs/cleave.js',
    'resources/assets/vendor/libs/cleavejs/cleave-phone.js'

  ])
@endsection

@section('page-script')
  @vite('resources/assets/js/app-user-list.js')
@endsection

@section('content')

    <div>
      <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary ms-auto my-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">
          <i class="fas fa-add px-2"></i> Add User
        </button>
      </div>

      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
      <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="add-new-user pt-0" id="addNewUserForm" onsubmit="return false">
          <div class="mb-3">
            <label class="form-label" for="add-user-fullname">Full Name</label>
            <input type="text" class="form-control" id="add-user-fullname" placeholder="John" name="name" aria-label="John" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="add-user-email">Email</label>
            <input type="text" id="add-user-email" class="form-control" placeholder="john@example.com" aria-label="john@example.com" name="email" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="add-user-contact">Phone Number</label>
            <input type="text" id="add-user-contact" class="form-control phone-mask" placeholder="+254 (07) 12345678" aria-label="" name="phone_number" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="station">Gender</label>
            <select id="gender" class="select2 form-select" name="gender">
              <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" for="station">Station</label>
            <select id="county" class="select2 form-select" name="station_id">
              <option value="">Select County</option>
              @foreach($stations as $station)
                <option value="{{ $station->id }}">{{ $station->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" for="role">Roles</label>
            <select id="county" class="select2 form-select" name="role">
              <option value="">Select Role</option>
              @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" for="country">Country</label>
            <select id="country" name="county" class="select2 form-select">
              <option value="">Select</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" for="country">Sub-Country</label>
            <select id="subcountry" name="subcounty" class="select2 form-select">
              <option value="">Select</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" for="country">Ward</label>
            <select id="ward" name="ward" class="select2 form-select">
              <option value="">Select</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
      </div>
    </div>
    </div>

    <div class="card">
    <livewire:tables.users/>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-47zltbR5t0u5JP07I/FL9l9CIrJ84P2a6QFyNX8onp+Wr9gW+prX5KpZd3X5aEzhGfxO2dFJAx7L1UwP4a9Cdw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-ZMiCrZKHpfbX7vEa4X+k4Q4HRhuL86N1k7aJ6KjRzCazbQhY9fB8YdVpU9bK/sHc3d0D1A7usgOB+khM7fMd0w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $('.select2').select2();
    $('.select2-container').each(function () {
      var container = $(this);
      container.find('.select2-search__field').after('<input type="text" class="second-search-input" placeholder="Second Search">');
    });
    $(document).on('click', function (e) {
      if (!$(e.target).closest('.select2-container').length) {
        $('.select2').select2('close');
      }
    });
  </script>
  <script>
    $(document).ready(function () {
      var countySelect = $('#county');
      var subcountySelect = $('#subcounty');
      var wardSelect = $('#ward');

      countySelect.change(function () {
        var selectedCountyId = countySelect.val();
        $.get('subcounties/list/' + selectedCountyId)
          .done(function (data) {
            subcountySelect.html('<option value="">Select Sub-County</option>');
            wardSelect.html('<option value="">Select Ward</option>');

            $.each(data, function (index, subcounty) {
              subcountySelect.append('<option value="' + subcounty.id + '">' + subcounty.subcounty_name + '</option>');
            });
          })
          .fail(function (error) {
            console.error('Error:', error);
          });
      });

      subcountySelect.change(function () {
        var selectedSubcountyId = subcountySelect.val();

        $.get('wards/list/' + selectedSubcountyId)
          .done(function (data) {
            wardSelect.html('<option value="">Select Ward</option>');

            $.each(data, function (index, ward) {
              wardSelect.append('<option value="' + ward.id + '">' + ward.name + '</option>');
            });
          })
          .fail(function (error) {
            console.error('Error:', error);
          });
      });
    });


  </script>
@endsection
