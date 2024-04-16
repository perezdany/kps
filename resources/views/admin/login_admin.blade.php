@php
  use App\Models\Departement;
  use App\Models\Utilisateur;
@endphp

@extends('layouts/base_login')

@section('content')

  <div class="login-box">
    <div class="login-logo">
      <a href="index2.html"><b>Admin</b>istration</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Veuillez saisir vos informations de connexion SVP</p>
       @if(session('success'))
        <div class="alert-success">{{session('success')}}</div>


        @endif

        @if(session('error'))
          <div class="alert-error">{{session('error')}}</div>


        @endif
      <form action="login_admin" method="post">
        @csrf
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Login" name="login">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Mot de passe" name="password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            
        <select class="form-control" name="departement" required>
                 
                @php
                    //on récupère les départements de la base
                    $department = Departement::all();
    
                @endphp
                
                @foreach($department as $department)
                    
                  <option value="{{$department->id_departement}}">{{$department->desig_departement}}</option>  
                   
                @endforeach
        </select>
        <span class="glyphicon glyphicon-check form-control-feedback"></span>
            
          </div>
          <div class="row">
            <div class="col-xs-8">
              <!--<div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>-->
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Connexion</button>
            </div>
            <!-- /.col -->
          </div>
      </form>

      <!--<div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
          Facebook</a>
        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
          Google+</a>
      </div>-->
      <!-- /.social-auth-links -->

      <a href="#">Mot de passe oublié</a><br>
      <!--<a href="register.html" class="text-center">Register a new membership</a>-->

    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->
@endsection
