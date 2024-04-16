@php
  use App\Models\Departement;
  use App\Models\Utilisateur;
@endphp
@extends('layouts/base_login')

@section('content')
  <div class="register-box">
    <div class="register-logo">
      <a href="../../index2.html"><b>Admin</b>istration</a>
    </div>

    <div class="register-box-body">
      <p class="login-box-msg">Enregistrement d'un nouvel utilisateur</p>
      @if(session('success'))
        <div class="alert-success">{{session('success')}}</div>


      @endif

      @if(session('error'))
        <div class="alert-error">{{session('error')}}</div>


      @endif
     
      <form action="register_user" method="post">
        @csrf
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Nom complet" name="name" required onkeyup="this.value=this.value.toUpperCase()">
          <span class="glyphicon glyphicon-user form-control-feedback" ></span>
        </div>
        <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Email" name="email" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Téléphone" name="tel" required>
          <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="pseudo ou appellé encore login ex:toto, tata..." name="login" required>
          <span class="glyphicon glyphicon-check form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Mot de Passe" name="pass" id="pwd1" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Confirmez le mot de passe" name="confirm_pass" id="pwd2" onkeyup="verifyPassword()" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback" id="match">
                                      
                                      
        </div>
        <script type="text/javascript">
                            
            /*UN SCRIPT QUI VA VERFIER SI LES DEUX PASSWORDS MATCHENT*/
            function verifyPassword()
            {
              var msg; 
              var str = document.getElementById("pwd1").value; 

              /*if (str.match( /[0-9]/g) && 
                  str.match( /[A-Z]/g) && 
                  str.match(/[a-z]/g) && 
                  str.match( /[^a-zA-Z\d]/g) &&
                  str.length >= 10) 
                msg = "<p style='color:green'>Mot de passe fort.</p>"; 
              else 
                msg = "<p style='color:red'>Mot de passe faible.</p>"; 
              document.getElementById("msg").innerHTML= msg; */
              //var _ = require('underscore');
              var text1 = document.getElementById('pwd1').value;
              var text2 = document.getElementById('pwd2').value;
              
              if((text1 == text2))
              {
                var theText = "<p style='color:green'>Correspond.</p>"; ;
                document.getElementById("match").innerHTML= theText; 
              }
              else
              {
                var theText = "<p style='color:red'>Ne correspond pas.</p>";
                document.getElementById("match").innerHTML= theText; 
              }
            }
              
        </script>
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
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Intitulé du poste" name="poste" required>
          <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <!--<div class="checkbox icheck">
              <label>
                <input type="checkbox"> I agree to the <a href="#">terms</a>
              </label>
            </div>-->
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Enregistrer</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!--<div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
          Facebook</a>
        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
          Google+</a>
      </div>-->

      <a href="login_admin" class="text-center">J'ai déjà un compte</a>
    </div>
    <!-- /.form-box -->
  </div>
@endsection