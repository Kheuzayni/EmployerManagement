@extends('layout/admin-layout')

@section('space-work')

<div class="card">
  <div class="card-header">All managers <button type="button" class="btn btn-success btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addModal">Add new</button></div>
  <div class="card-body">
    <table class="table table-sm table-bordered table-striped">
      <thead>
        <tr>
          <td>Num</td>
          <td>Name</td>
          <td>Phone Number</td>
          <td>Descriptions</td>
          <td colspan="2">Actions</td>
        </tr>
      </thead>
      <tbody>
      @if (count($all_Managers) > 0)
        @foreach ($all_Managers as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->first_name }} {{ $item->middle_name }} {{ $item->last_name }}</td>
            <td>{{ $item->phone_number }}</td>
            <td>{{ $item->description }}</td>
          </tr>
        @endforeach
      @else
        <tr>
          <td colspan="5" style="text-align: center;">No data found</td>
        </tr>
      @endif
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register New Manager</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add new managers</h5>
                        <form class="row g-3" id="addManager">
                          <div class="col-md-12">
                          <input type="text" class="form-control" placeholder="Your First Name" name="fname">
                          <span id="fname_error" class="text-danger"></span>
                          </div>
                          <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="Your Middle Name" name="mname">
                            <span id="mname_error" class="text-danger"></span>
                          </div>
                          <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="Your Last Name" name="lname">
                            <span id="lname_error" class="text-danger"></span>
                          </div>
                          <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="Email" name="email">
                            <span id="email_error" class="text-danger"></span>
                          </div>
                          <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Phone number" name="phone">
                            <span id="phone_error" class="text-danger"></span>
                      </div>           
                        <div class="modal-footer">
                        </form>
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success addBtn">Save</button>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection