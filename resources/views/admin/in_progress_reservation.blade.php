@php
  use App\Http\Controllers\ReservationController;
@endphp
@extends('layouts/base_admin')

@section('user')
  {{auth()->user()->login}}
@endsection

@section('location')
  Réservations en attente
@endsection

@section('content')
  <!-- Main content -->

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">RESERVATIONS EN ATTENTE DE VALIDATION</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                @php
                  $all = (new ReservationController())->AllPoolReservation();
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
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($all as $all)

                  <tr>
                 
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
                      @elseif($all->solder == 0)
                        Réservation soldée
                      @endif
                    </td>
                    <td>
                       <button class="btn btn-danger"><span class="fa fa-trash"></span></button>
                      @if($all->validate == 0)
                        <form action="validate" method="post">
                          @csrf
                          <input type="text" value="{{$all->id_reservation}}" name="id_reservation" style="display:none;">
                          <button class="btn btn-success"><span class="fa fa-check"></span></button>  
                        </form>
                        
                      
                      @endif
                       <button class="btn btn-primary"><span class="fa fa-edit"></span></button>
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
    </section>
    <!-- /.content -->

@endsection

  
  