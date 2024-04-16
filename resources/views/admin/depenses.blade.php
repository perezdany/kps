@php
  use App\Http\Controllers\DepensesController;
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
              <h3 class="box-title">DEPENSES EFFECTUEES</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                @php
                  $all = (new DepensesController())->displayAll();
                @endphp

                <thead>
                  <tr>
                    <th>Objet</th>
                    <th>Appartement</th>
                    <th>Date</th>
                    <th>Montant</th>
                    
                  </tr>
                </thead>
                <tbody>
                @foreach($all as $all)

                  <tr>
                 
                    <td>{{$all->libele_depense}}</td>
                    <td>{{$all->designation_appart }}</td>
                    <td>{{$all->date}}</td>
                    <td>{{$all->montant_depenses}}</td>
                    
                    <td align="center">
                      <form action="deletedepense" method="post">
                        @csrf
                        <input type="text" name="id_depense" value="{{$all->id_depense}}" style="display: none;">
                        <button class="btn btn-danger"><span class="fa fa-trash"></span></button>
                      </form>
                      <form action="edit_depense_form" method="post">
                        @csrf
                        <input type="text" name="id_depense" value="{{$all->id_depense}}" style="display: none;">
                        <button class="btn btn-primary"><span class="fa fa-edit"></span></button>
                      </form>
                       
                    </td>


                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                   <th>Objet</th>
                    <th>Appartement</th>
                    <th>Date</th>
                    <th>Montant</th>
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
              <h3 class="box-title">Ajout d'une dépense</h3>

             
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center">
                    <a href="add_depense_form"><button class="btn btn-primary">ALLER AU FORMULAIRE</button></a>
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

  
  