@php
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
  Utilisateurs
@endsection

@section('content')
  <!-- Main content -->

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          @if(session('success'))
            <div class="box alert-success">{{session('success')}}</div>

          @endif

          @if(session('error'))
            <div class="box alert-error">{{session('error')}}</div>

          @endif
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">UTILISATEURS</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                @php
                  $all = (new UserController())->displayAllUsers();
                @endphp

                <thead>
                  <tr>
                    <th>Nom & Prénom(s)</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Département</th>
                    <th>Poste</th>
                    <th>Membre depuis:</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($all as $all)

                  <tr>
                 
                    <td>{{$all->nom_prenoms_users}}</td>
                    <td>{{$all->email_users}}</td>
                     <td>{{$all->tel_users }}</td>
                    <td>{{$all->desig_departement }}</td>
                    <td>{{$all->libele_poste }}</td>
                    <td>{{$all->user_since }}</td>
                    <td align="center">
                      <form action="deleteuser" method="post">
                        @csrf
                        <input type="text" name="id_user" value="{{$all->id}}" style="display: none;">
                        <button class="btn btn-danger"><span class="fa fa-trash"></span></button>
                      </form>
                      <form action="edit_admin_form" method="post">
                        @csrf
                        <input type="text" name="id_user" value="{{$all->id}}" style="display: none;">
                        <button class="btn btn-primary"><span class="fa fa-edit"></span></button>
                      </form>
                       
                    </td>


                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Nom & Prénom(s)</th>
                  <th>Email</th>
                  <th>Téléphone</th>
                  <th>Département</th>
                  <th>Poste</th>
                  <th>Membre depuis:</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->

         
      </div>
      <!-- /.row -->
      <!--lien pour ajouetr un utilisateur -->
       <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Ajout d'un utilisateur</h3>

             
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center">
                    <a href="register_user"><button class="btn btn-primary">ALLER AU FORMULAIRE</button></a>
                  </p>

                </div>
                <!-- /.col -->
               
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
          
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
    </section>
    <!-- /.content -->


@endsection

  
  