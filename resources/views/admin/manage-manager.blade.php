@extends('layout.admin-layout')

@section('space-work')

<div class="card">
  <div class="card-header">All managers <button type="button" class="btn btn-success btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addModal">Add new</button></div>
  <div class="card-body">
    {{-- these two spans will display flash messages --}}
    <span class="alert alert-success" id="alert-success" style="display: none;"></span>
    <span class="alert alert-danger" id="alert-danger" style="display: none;"></span>
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
      @if (count($all_managers) > 0)
        @foreach ($all_managers as $manager)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $manager->first_name }} {{ $manager->middle_name }} {{ $manager->last_name }}</td>
            <td>{{ $manager->phone_number }}</td>
            <td>{{ $manager->description }}</td>
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

{{-- add modal start here --}}
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Register New Manager</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <form class="row g-3" id="addManager">
          @csrf
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
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Description" name="description">
            <span id="description" class="text-danger"></span>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success addBtn">Save</button>     
      </div>
    </form>
    </div>
  </div>
</div>
{{-- ends here --}}


{{-- our scripts starts here --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function(){
    // on submit of the form
    $('#addManager').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this); // Utilisation de FormData pour obtenir les données du formulaire
        $.ajax({
            url: '{{ route("RegisterManager") }}', //this is our submission route
            type: 'POST',
            data: formData, // Utilisation de FormData
            processData: false,
            contentType: false,
            beforeSend:function(){
                $('.addBtn').prop('disabled', true); //here we disable the save button
            },
            complete: function(){
                $('.addBtn').prop('disabled', false); // here we enable it again
            },
            success: function(data){
                if(data.success == true){
                    //close modal
                    $('#addModal').modal('hide');
                    // print success message
                    alert(data.msg);
                    // Refresh page
                    location.reload();
                } else if(data.success == false){
                    // handle validation errors
                    $.each(data.msg, function(key, value){
                        $('#' + key + '_error').text(value[0]);
                    });
                } else {
                    alert(data.msg);
                }
            }
        });
        return false;
    });
});

</script>

@endsection
