@php
  use App\Http\Controllers\UserController;
@endphp
@extends('layouts/base_admin')

@section('user')
  {{auth()->user()->login}}
@endsection

@section('location')
  Clients
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
              <h3 class="box-title">CLIENTS</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                @php
                  $all = (new UserController())->displayAllCustomers();
                @endphp

                <thead>
                  <tr>
                    <th>Nom & Prénom(s)</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Adresse Géographique</th>
                    <th>Membre depuis:</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($all as $all)

                  <tr>
                 
                    <td>{{$all->nom_prenoms}}</td>
                    <td>{{$all->email}}</td>
                     <td>{{$all->tel }}</td>
                    <td>{{$all->adress_geo }}</td>
                    <td>{{$all->member_since }}</td>
                     <td align="center">

                        <form action="deleteCustomer" method="post">
                          @csrf
                          <input type="text" name="id_client" value="{{$all->id}}" style="display: none;">
                          <button class="btn btn-danger"><span class="fa fa-trash"></span></button>
                        </form>
                        
                      <form action="edit_customer_form" method="post">
                         @csrf
                          <input type="text" name="id_client" value="{{$all->id}}" style="display: none;">
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
                    <th>Adresse Géographique</th>
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
        <div class="row">
          <div class="col-xs-3">
          </div>
          <div class="col-xs-6">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Ajouter un Client</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <a href="add_customer"><button class="btn btn-block btn-lg btn-primary">ALLER AU FORMULAIRE</button></a>
              </div>
              <!-- /.box-body -->
          
            </div>
            <!-- /.box -->
            
          </div>
          <div class="col-xs-3">
          </div>
        </div>
  
         
      </div>
      <!-- /.row -->
  
    </section>
    <!-- /.content -->


@endsection

  
  