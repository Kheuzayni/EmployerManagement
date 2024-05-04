@extends('layout.admin-layout')

@section('space-work')

<div class="card">
  <div class="card-header">All managers <button type="button" class="btn btn-success btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addModal">Add new</button></div>
  <div class="card-body">
    {{-- these two spans will display flash messages --}}
    <span class="alert alert-success" id="alert-success" style="display: none;"></span>
    <span class="alert alert-danger" id="alert-danger" style="display: none;"></span>
    <table class="table table-hover table-bordered">
      <thead class="table-primary">
        <tr>
          <th scope="col">Num</th>
          <th scope="col">Name</th>
          <th scope="col">Phone Number</th>
          <th scope="col">Descriptions</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($all_managers as $manager)
          <tr>
            <th>{{ $loop->iteration }}</th>
            <td>{{ $manager->first_name }} {{ $manager->middle_name }} {{ $manager->last_name }}</td>
            <td>{{ $manager->phone_number }}</td>
            <td>{{ $manager->description }}</td>
            <td>
              <!-- Icone pour modifier -->
              <a href="#" >
                <i class="btn btn-primary btn-sm bi-pencil"></i>
              </a>
              <!-- Icone pour supprimer -->
              <a href="#" class="btn btn-danger btn-sm deleteBtn" data-id="{{ $manager->user_id }}" data-name="{{ $manager->name }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">No data found</td>
          </tr>
        @endforelse
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

{{-- Delete modal start here --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Manager</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <div class="card-title text-danger">Are you sure to delete this manager? </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger deleteBTN">Yes Delete it</button> 
      </div>
    </div>
  </div>
</div>
{{-- Delete modal end here --}}


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
                    printSuccessMsg(data.msg);
                    // Refresh page
                    location.reload();
                } else if(data.success == false){
                    // handle validation errors
                    printValidationErrorMsg(data.msg);
                } else {
                    // handle other errors
                    printErrorMsg(data.msg);
                }
            },
            error: function(xhr, status, error) {
                // handle AJAX errors
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                printErrorMsg(errorMessage);
            }
        });
        return false;
    });
    // Gérer le clic sur le bouton de suppression
$('.deleteBtn').on('click', function(){
    // Récupérer les attributs data-id et data-name de l'élément cliqué
    var user_id = $(this).data('id');
    var user_name = $(this).data('name');
    
    // Mettre à jour les données du modal de confirmation avec les informations du manager à supprimer
    $('#deleteModal').find('.modal-body').text('Are you sure you want to delete ' + user_name + '?');
    
    // Stocker l'ID de l'utilisateur dans un attribut data de la modal pour le récupérer plus tard
    $('#deleteModal').data('userId', user_id);
    
    // Afficher le modal de confirmation
    $('#deleteModal').modal('show');
});

// Gérer le clic sur le bouton de confirmation de suppression dans le modal
$('.deleteBTN').on('click', function(){
    // Récupérer l'ID de l'utilisateur à supprimer à partir des données de la modal
    var user_id = $('#deleteModal').data('userId');
    
    // Construire l'URL de suppression en remplaçant les parties variables
    var url = "{{ route('deleteManager', ':user_id') }}";
    url = url.replace(':user_id', user_id);
    
    // Effectuer la requête AJAX de suppression avec l'URL correcte
    $.ajax({
        url: url,
        type: 'GET',
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('.deleteBTN').prop('disabled', true);
        },
        complete: function(){
            $('.deleteBTN').prop('disabled', false);
        },
        success: function(data){
            if(data.success == true){
                $('#deleteModal').modal('hide');
                printSuccessMsg(data.msg);
                var reloadInterval = 5000;
                function reloadPage() {
                    location.reload(true);
                }
                var intervalId = setInterval(reloadPage, reloadInterval);
            } else {
                printErrorMsg(data.msg);
            }
        }
    });
});


    function printEditValidationErrorMsg(msg){
        $.each(msg, function(field_name, error){
            // this will find a input id for error 
            $(document).find('#'+field_name+'_edit_error').text(error);
        });
    }

    function printValidationErrorMsg(msg){
        $.each(msg, function(field_name, error){
            // this will find a input id for error 
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
      // if form successfully submitted reset form
      document.getElementById('addManager').reset();
    }
});

</script>

@endsection
