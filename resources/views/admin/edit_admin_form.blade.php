@php
  use App\Models\Departement;
  use App\Models\Utilisateur;
  use App\Http\Controllers\UserController;
@endphp
@extends('layouts/base_login')

@section('content')
  <div class="register-box">
    <div class="register-logo">
      <a href="../../index2.html"><b>Admin</b>istration</a>
    </div>

    <div class="register-box-body">
      <p class="login-box-msg">Modifier le compte utilisateur</p>
      @if(session('success'))
        <div class="alert-success">{{session('success')}}</div>


      @endif

      @if(session('error'))
        <div class="alert-error">{{session('error')}}</div>


      @endif
      @php
        $get = (new UserController())->GetAdminById($id);
      @endphp
      @foreach($get as $user)
        <form action="edit_admin" method="post">
            @csrf
            <input type="text" value="{{$user->id}}" style="display:none;" name="id_user">
            <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Nom complet" name="name" value="{{$user->nom_prenoms_users}}" required onkeyup="this.value=this.value.toUpperCase()">
            <span class="glyphicon glyphicon-user form-control-feedback" ></span>
            </div>
            <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email" value="{{$user->email_users}}" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Téléphone" name="tel" value="{{$user->tel_users}}" required>
            <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="pseudo ou appellé encore login ex:toto, tata..." value="{{$user->login}}" name="login" required>
            <span class="glyphicon glyphicon-check form-control-feedback"></span>
            </div>
        
            <div class="form-group has-feedback">
            <select class="form-control" name="departement" required>
                <option value="{{$user->id_departement}}">{{$user->desig_departement}}</option>  
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
            <input type="text" class="form-control" placeholder="Intitulé du poste" name="poste" value="{{$user->libele_poste}}" required>
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

      <!--modifier le mot de passe -->
      <p class="login-box-msg">Modifier le moit de passe</p>
        <form action="edit_admin_pass" method="post">
            @csrf
            <input type="text" value="{{$user->id}}" style="display:none;" name="id_user">
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
            <div class="row">
                <div class="col-xs-3">
                    
                </div>
                <div class="col-xs-6">
                    <button type="submit" class="btn btn-success btn-block btn-flat">Modifier</button>
                </div>
                <div class="col-xs-3">
                    
                </div>
            <!-- /.col -->
            </div>
        </form>
        
      @endforeach
      
        <div class="row">
        <br><br><hr>
                <div class="col-xs-6">
                    <a href="/dashboard"><button class="btn btn-primary btn-block btn-flat">Retour</button></a>
                </div>
                
            <!-- /.col -->
            </div>
      
    </div>
    <!-- /.form-box -->
  </div>
@endsection