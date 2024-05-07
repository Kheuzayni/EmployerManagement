@extends('layout/admin-layout')

@section('space-work')
<div class="card">
  <div class="card-header">All Managers & Agents <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addmodal">Add New</button></div>
  <div class="card-body">
     {{-- these two spans will display flash messages --}}
     <span class="alert alert-success" id="alert-success" style="display: none;"></span>
     <span class="alert alert-danger" id="alert-danger" style="display: none;"></span>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-SklKzAZtUbKlaL8KhVF5kspdGtqOO1XlfbekDGcEGzU4mSshmhpg9AhgoNMKzWs3WxutKB9lchCCiSfRqftKXw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <table class="table table-sm table-bordered table-striped">
        <thead>
          <tr>
            <th>Num</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Description</th>
            <th colspan="2">Actions</th>
          </tr>
        </thead>
        <tbody>
            @if (count($all_managers) > 0)
                @foreach ($all_managers as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->first_name}} {{$item->last_name}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->phone_number}}</td>
                        <td>{{$item->description}}</td>
                        <td>
                          <button class="btn btn-primary btn-sm editBtn" data-id="{{$item->user_id}}" data-fname="{{$item->first_name}}" data-lname="{{$item->last_name}}" data-phone="{{$item->phone_number}} data-description="{{$item->description}}" data-email="{{$item->email}}" data-bs-toggle="modal" data-bs-target="#editModal">
                            <i class="fa-regular fa-pen-to-square"></i>
                          </button>
                        </td>
                        <td>
                        <button class="btn btn-danger btn-sm deleteBtn" data-id="{{$item->user_id}}" data-name="{{$item->name}}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                          <i class="fas fa-trash"></i>
                        </button>

                          <!-- <button class="btn btn-danger btn-sm deleteBtn" data-id="{{$item->user_id}}" data-name="{{$item->name}}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i>
                          </button> -->
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                  <td colspan="5">No data found!</td>
                </tr>
            @endif
        </tbody>
      </table>


  </div>
</div>
{{-- add modal start here --}}
<div class="modal fade" id="addmodal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Register New Manager/Agent</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <!-- No Labels Form -->
         <form class="row g-3" id="addManager" method="POST">
          @csrf
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder="Your First Name" name="fname">
            <span id="fname_error" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder="Your Last Name" name="lname">
            <span id="lname_error" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <input type="email" class="form-control" placeholder="Email" name="email">
            <span id="email_error" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder="Phone number" name="phone">
            <span id="phone_error" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder="Description" name="description">
            <span id="description" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <select class="form-select" name="role">
                <option >Select a role for this user</option>
                <option value="manager">Manager</option>
                <option value="agent">Agent</option>
            </select>
          </div>
        <!-- End No Labels Form -->
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

{{-- edit modal start here --}}
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Manager/Agent</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <!-- No Labels Form -->
         <form class="row g-3" id="editManagerForm">
          {{-- this is a hidden manager_id --}}
          <input type="hidden" name="manager_id" id="manager_id"> 
          {{-- this input will be hidden, but used to carry the managers user_id --}}
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder="Your First Name" name="fname" id="fname">
            <span id="fname_edit_error" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder="Your Last Name" name="lname" id="lname">
            <span id="lname_edit_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <input type="email" class="form-control" placeholder="Email" name="email" id="email">
            <span id="email_edit_error" class="text-danger"></span> 
            {{-- this span for showing validation errors is differet from those from add form also the jquery function for display validation errors is different--}}
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Phone number" name="phone" id="phone">
            <span id="phone_edit_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Description" name="description" id="description">
            <span id="description_edit_error" class="text-danger"></span>
          </div>
        <!-- End No Labels Form -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-succeess editBTN">Update</button> 
      </div>
    </form>
    </div>
  </div>
</div>
{{-- ends here --}}

{{-- delete modal start here --}}
{{-- delete modal start here --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Manager/Agent</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <div class="card-title text-danger">Are you sure to delete this manager/agent? </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger deleteBTN">Yes! Delete it</button> 
      </div>
    </div>
  </div>
</div>
{{-- ends here --}}

{{-- ends here --}}

{{-- our scripts starts here --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
  $(document).ready(function(){
    // on submit of the form
    $('#addManager').submit(function(e){
                e.preventDefault();
                let formData = $(this).serialize(); //get all form details
                $.ajax({
                    url: '{{ route("RegisterUser")}}', //this is our submission route
                    type: 'POST',
                    data: formData,
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend:function(){
                        $('.addBtn').prop('disabled', true); //here we disable the save button
                    },
                    complete: function(){
                        $('.addBtn').prop('disabled', false); // here we enable it again
                    },
                    success: function(data){
                        if(data.success == true){
                            //close modal
                            $('#addmodal').modal('hide');
                            // print success message
                            printSuccessMsg(data.msg);
                            //reload the page after 5 seconds
                            setTimeout(function(){
                                window.location.reload();
                            }, 5000);
                        }else if(data.success == false){
                            printErrorMsg(data.msg);
                        }else{
                            printValidationErrorMsg(data.msg);
                        }
                    }
                });
                return false;
                
            });

            // here delete functionality
            $('.deleteBtn').on('click',function(){
                var user_id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                $('#first_name').html('');
                $('#first_name').html(name);
                $('.deleteBTN').attr('data-id', user_id);
            });

            $('.deleteBTN').on('click',function(){
                var user_id = $(this).attr('data-id');
                var deleteUrl = "{{ route('deleteManager', ['id' => ':user_id']) }}".replace(':user_id', user_id);
                $.ajax({
                    url: deleteUrl,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend:function(){
                        $('.deleteBTN').prop('disabled', true);
                    },
                    complete: function(){
                        $('.deleteBTN').prop('disabled', false);
                    },
                    success: function(data){
                        if(data.success == true){
                            $('#deleteModal').modal('hide');
                            printSuccessMsg(data.msg);
                            //reload the page after 5 seconds
                            setTimeout(function(){
                                window.location.reload();
                            }, 5000);
                        }else{
                            printErrorMsg(data.msg);
                        }
                    }
                });
            });

            // edit functionality
            $('.editBtn').on('click',function(){
                var manager_id = $(this).attr('data-id');
                var fname = $(this).attr('data-fname');
                var lname = $(this).attr('data-lname');
                var phone = $(this).attr('data-phone');
                var description = $(this).attr('data-description');
                var email = $(this).attr('data-email');

                $('#fname').val(fname);
                $('#lname').val(lname);
                $('#phone').val(phone);
                $('#description').val(description);
                $('#email').val(email);
                $('#manager_id').val(manager_id);
            });

             $('#editManagerForm').submit(function(e){
                    e.preventDefault();
                    let formData = $(this).serialize();

                    $.ajax({
                        url: '{{ route("editManager")}}',
                        data: formData,
                        type: 'GET',
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend:function(){
                            $('.editButton').prop('disabled', true);
                        },
                        complete: function(){
                            $('.editButton').prop('disabled', false);
                        },
                        success: function(data){
                            if(data.success == true){
                                $('#editModal').modal('hide');
                                printSuccessMsg(data.msg);
                                //reload the page after 5 seconds
                                setTimeout(function(){
                                    window.location.reload();
                                }, 5000);
                            }else if(data.success == false){
                                printErrorMsg(data.msg);
                            }else{
                                printEditValidationErrorMsg(data.msg);
                            }
                    }
                    });
                });

                function printEditValidationErrorMsg(msg){
                  $.each(msg, function(field_name, error){
                      $(document).find('#'+field_name+'_edit_error').text(error);
                  });
                }

                function printValidationErrorMsg(msg){
                  $.each(msg, function(field_name, error){
                      $(document).find('#'+field_name+'_error').text(error);
                  });
                }

                function printErrorMsg(msg){
                  $('#alert-danger').html('');
                  $('#alert-danger').css('display','block');
                  $('#alert-danger').append(''+msg+'');
                }

                function printSuccessMsg(msg){
                  $('#alert-success').html('');
                  $('#alert-success').css('display','block');
                  $('#alert-success').append(''+msg+'');
                }
  });
</script>
@endsection
