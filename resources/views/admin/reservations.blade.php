@php
  use App\Http\Controllers\ReservationController;
@endphp
@extends('layouts/base_admin')

@section('user')
  {{auth()->user()->login}}
@endsection

@section('poste')
  {{auth()->user()->libele_poste}}
@endsection

@section('location')
  Historique de réservation
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
              <h3 class="box-title">HISTORIQUE DES RESERVATIONS</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                @php
                  $all = (new ReservationController())->ReservationDisplayAll();
                @endphp

                <thead>
                  <tr>
                    <th>Horodatage</th>
                    <th>Client</th>
                    <th>Appartement</th>
                    <th>Date d'entrée</th>
                    <th>Date de sortie</th>
                    <th>Type de paiement</th>
                    <th>Paiement par:</th>
                    <th>Montant</th>
                    <th>Etat</th>
                    <th >Action</th>
                   
                  </tr>
                </thead>
                <tbody>
                @foreach($all as $all)

                  <tr style="vertical-align: middle;">
                 
                    <td>{{$all->date}} à {{$all->heure}}</td>
                    <td>{{$all->nom_prenoms}}</td>
                    <td>{{$all->designation_appart}}</td>
                    <td>{{$all->date_debut}}</td>
                    <td>{{$all->date_fin}}</td>
                    <td>{{$all->libele_paiement}}</td>
                    <td>{{$all->libele_mode_paie}}</td>
                    <td>{{$all->montant}}</td>
                    <td>
                      @if($all->validate == 0)
                        En attente de validation
                      @else
                        @if($all->solder == 0)
                          Réservation non soldée
                        @else
                          Réservation  soldée
                        @endif

                      @endif
                    </td>

                    <td align="center">
                     <form action="deleteReservation" method="post">
                        @csrf
                        <input type="text" name="id_reservation" style="display: none;" value="{{$all->id_reservation}}">
                        <button class="btn btn-danger"><span class="fa fa-trash"></span></button>
                      </form>
                      @if($all->validate == 0)
                        <form action="validate" method="post">
                          @csrf
                          <input type="text" name="id_reservation" style="display: none;" value="{{$all->id_reservation}}">
                          <button class="btn btn-success"><span class="fa fa-check"></span></button>
                        </form>
                      @endif
                      <form action="edit_reserv_form" method="post">
                        @csrf
                        <input type="text" value="{{$all->id_reservation}}" style="display:none;" name="id_reservation">
                        <button class="btn btn-primary"><span class="fa fa-edit"></span></button>
                      </form>
                    </td>
               
                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                 <th>Horodatage</th>
                  <th>Client</th>
                  <th>Appartement</th>
                  <th>Date d'entrée</th>
                  <th>Date de sortie</th>
                  <th>Type de paiement</th>
                  <th>Paiement par:</th>
                  <th>Montant</th>
                  <th>Etat</th>
                  <th >Action</th>
                 
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
              <h3 class="box-title">Réservations en  attentes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <a href="pool_reserv"><button class="btn btn-block btn-lg btn-primary">VOIR</button></a>
            </div>
            <!-- /.box-body -->
        
          </div>
          <!-- /.box -->
          
        </div>
        <div class="col-xs-3">
        </div>
      </div>

      <div class="row">
        <div class="col-xs-3">
        </div>
        <div class="col-xs-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Ajouter une réservation</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <a href="save_reservation"><button class="btn btn-block btn-lg btn-primary">ALLER AU FORMULAIRE</button></a>
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

  
  