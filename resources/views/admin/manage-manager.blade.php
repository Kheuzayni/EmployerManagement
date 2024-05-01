@extends('layout/admin-layout')

@section('space-work')
    
<div class="card">
            <div class="card-body">
              <h5 class="card-title">Add new managers</h5>

              <!-- Form -->
              <form class="row g-3">
                <div class="col-md-12">
                  <input type="text" class="form-control" placeholder="Your Name">
                </div>
                <div class="col-md-6">
                  <input type="email" class="form-control" placeholder="Email">
                </div>
                <div class="col-md-6">
                  <input type="password" class="form-control" placeholder="Password">
                </div>
                <div class="col-12">
                  <input type="text" class="form-control" placeholder="Address">
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" placeholder="City">
                </div>
                <div class="col-md-4">
                  <select id="inputState" class="form-select">
                    <option selected>Choose...</option>
                    <option>Test 1</option>
                    <option>...</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="text" class="form-control" placeholder="Zip">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- Form -->

            </div>
          </div>
@endsection