@php
  use App\Http\Controllers\DepartementController;
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
              <h3 class="box-title">DEPARTEMENTS</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                @php
                  $all = (new DepartementController())->DisplayAllDepartments();
                @endphp

                <thead>
                  <tr>
                    <th>Numéro</th>
                    <th>Départements</th>
                    
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($all as $all)
                  <tr>
                 
                    <td>{{$all->id_departement}}</td>
                    <td>{{$all->desig_departement}}</td>
                     
                    <td>
                      <form action="deletedepartement" method="post">
                        @csrf
                        <input type="text" name="id_dep" value="{{$all->id_departement}}" style="display: none;">
                        <button class="btn btn-danger"><span class="fa fa-trash"></span></button>
                      </form>
                      <form action="edit_departements" method="post">
                        @csrf
                        <input type="text" name="id_dep" value="{{$all->id_departement}}" style="display: none;">
                        <button class="btn btn-primary"><span class="fa fa-edit"></span></button>
                      </form>
                      
                    </td>

                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Numéro</th>
                  <th>Départements</th>
                    
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
      <div class="row">
        <div class="col-xs-3">
        </div>
        <div class="col-xs-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Ajouter un département</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <a href="add_departement"><button class="btn btn-block btn-lg btn-primary">ALLER AU FORMULAIRE</button></a>
            </div>
            <!-- /.box-body -->
        
          </div>
          <!-- /.box -->
          
        </div>
        <div class="col-xs-3">
        </div>
      </div>
  
    </section>
    <!-- /.content -->


@endsection

  
  