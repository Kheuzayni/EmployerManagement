

@extends('layout/employee-layout')
@section('space-work')
    <div class="pagetitle">
      <h4>Employee Baye</h4>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered ">

                <li class="col-xl-3 nav-item ">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-enfant">Enfants</button>
                </li>

                <li class="nav-item col-xl-3">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-district">Districts</button>
                </li>

                <li class="nav-item col-xl-3">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-posteCentreSante">Poste/Centre de santé</button>
                </li>

                <li class="nav-item col-xl-3">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-regionale">Régionale</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-enfant" id="profile-enfant">
                  <div class="modal-body"><br/>
                    <form class="row g-3" id="">
                      <div class="col-md-12">
                        <label for="ageanniversaiere"><span>Q1 : </span> L'age au dernier anniversaire</label>
                        <input type="date" class="form-control" placeholder="Années..." name="ageanniversaiere">
                        <span id="ageanniversaiere_error" class="text-danger"></span>
                      </div>
                      <div class="col-md-12">
                          <label><span>Q2 : Sexe</span></label><br>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" id="sexe_homme" name="sexe" value="homme">
                              <label class="form-check-label" for="sexe_homme">Homme</label>
                          </div>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" id="sexe_femme" name="sexe" value="femme">
                              <label class="form-check-label" for="sexe_femme">Femme</label>
                          </div>
                          <span id="sexe_error" class="text-danger"></span>
                      </div>
                      <div class="col-md-12">
                          <label><span>Vas-t-il à l'école</span></label><br>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" id="ecole_oui" name="sexe" value="homme">
                              <label class="form-check-label" for="ecole_oui">Oui</label>
                          </div>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" id="ecole_non" name="sexe" value="femme">
                              <label class="form-check-label" for="ecole_non">Non</label>
                          </div>
                          <span id="ecole_error" class="text-danger"></span>
                      </div>
                      <div class="text-center">
                      <button type="submit" class="btn btn-primary">Next</button>
                    </div>
                  </div>
                </div>

                <div class="tab-pane fade profile-district pt-3" id="profile-district">

                  <!-- Profile Edit Form -->
                  <form>
                  <div class="col-md-12">
                          <label><span>Connaissez-vous les différentes MTN</span></label><br>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" id="connaissance_oui" name="sexe" value="homme">
                              <label class="form-check-label" for="connaissance_oui">Oui</label>
                          </div>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" id="connaissance_non" name="sexe" value="femme">
                              <label class="form-check-label" for="connaissance_non">Non</label>
                          </div>
                          <span id="connaissance_error" class="text-danger"></span>
                      </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Next</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-posteCentreSante">

                  <!-- Settings Form -->
                  <form>
                    Input here
                    <div class="row mt-4">
                        <div class="col-md-6 text-left">
                            <button type="button" class="btn btn-secondary">Previous</button>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-primary">Next</button>
                        </div>
                    </div>
                  </form><!-- End settings Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-regionale">
                  <!-- Change Password Form -->
                  <form>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>
@endsection