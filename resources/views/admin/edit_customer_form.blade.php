@php
  //use App\Http\Controllers\DepartementController;
  use App\Http\Controllers\UserController;
@endphp
@extends('layouts/base_admin')

@section('user')
  {{auth()->user()->login}}
@endsection

@section('poste')
  {{auth()->user()->libele_poste}}
@endsection

@section('location')
  Départements
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Modification
       
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!--<div class="col-md-3">
          
        </div>-->
        <div class="col-md-6">
          @if(session('success'))
            <div class="alert-success">{{session('success')}}</div>

          @endif

          @if(session('error'))
            <div class="alert-error">{{session('error')}}</div>

          @endif
        </div>
        <!--<div class="col-md-3">
          
        </div>-->
      </div>
      <div class="row">
      
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Compte Utilisateur</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            @php
                $get = (new UserController())->GetCustomerById($id);
            @endphp
            @foreach($get as $customer)
                <form class="form-horizontal" action="edit_customer" method="post">
                    @csrf
                    <input type="text" value="{{$customer->id}}" style="display: none;" name="id_customer">
                    <div class="box-body">
                        <div class="form-group">
                        <label  class="col-sm-4 control-label">Nom & prénom(s) :</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="Entrez le nom et le prénom" onkeyup="this.value=this.value.toUpperCase()" required name="thename"  value="{{$customer->nom_prenoms}}">
                        </div>
                        </div>
                        <div class="form-group">
                        <label  class="col-sm-4 control-label">Email :</label>

                        <div class="col-sm-8">
                            <input type="email" class="form-control" placeholder="Email" require name="email" value="{{$customer->email}}">
                        </div>
                        </div>
                        <div class="form-group">
                        <label  class="col-sm-4 control-label">Téléphone :</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="Ex: 0022515478920" required name="tel" value="{{$customer->tel}}" >
                        </div>
                        </div>
                        <div class="form-group">
                        <label  class="col-sm-4 control-label">Adresse Géographique:</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="Ex : Cocody Vallon, Yopougon Marco etc..." required name="adresse" value="{{$customer->adress_geo}}">
                        </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <!--<button type="submit" class="btn btn-default">Cancel</button>-->
                        <button type="submit" class="btn btn-info pull-right">ENREGISTRER</button>
                    </div>
                    <!-- /.box-footer -->
                </form>

                <form class="form-horizontal" action="edit_customer_pass" method="post">
                    @csrf
                     <input type="text" value="{{$customer->id}}" style="display: none;" name="id_customer">
                    <div class="box-body">
                        
                        <div class="form-group">
                            <label  class="col-sm-4 control-label">Mot de passe:</label>
                            <div class="col-sm-8">
            
                            <input type="password" class="form-control" id="pwd1" required name="password">
                            </div>
                        </div>
                        <div class="form-group">
                        <label  class="col-sm-4 control-label">Confirmez le Mot de passe:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="pwd2" name="confirm_pass" required onkeyup="verifyPassword()">
                        
                        </div>
                        </div>
                        <div class="col-md-12 form-group" id="match">            
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
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <!--<button type="submit" class="btn btn-default">Cancel</button>-->
                        <button type="submit" class="btn btn-info pull-right">MODIFIER LE MOT DE PASSE</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            @endforeach
            
          </div>
          <!-- /.box -->
         
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
@endsection