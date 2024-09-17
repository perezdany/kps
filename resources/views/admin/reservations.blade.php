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
                    <th>Montant Restant</th>
                    <th>Etat</th>
                    <th >Action</th>
                   
                  </tr>
                </thead>
                <tbody>
                @foreach($all as $all)

                  <tr style="vertical-align: middle;">
                 
                    <td>@php echo date('d/m/Y',strtotime($all->date)) @endphp à @php echo date('H:i:s',strtotime($all->heure)) @endphp</td>
                    <td>{{$all->nom_prenoms}}</td>
                    <td>{{$all->designation_appart}}</td>
                    <td>@php echo date('d/m/Y',strtotime($all->date_debut)) @endphp</td>
                    <td>@php echo date('d/m/Y',strtotime($all->date_fin)) @endphp</td>
                    <td>{{$all->libele_paiement}}</td>
                    <td>{{$all->libele_mode_paie}}</td>
                    <td>@php echo number_format($all->montant, 0, ',', ' ')@endphp</td>
                    <td>
                      @php
                        $rest = ($all->montant_paye - $all->montant);
                        if($rest < 0)
                        {

                          echo number_format((-1 * $rest), 0, ',', ' ');
                        }

                      @endphp
                </td>
                    <td>
                      @if($all->validate == 0)
                        En attente de validation
                      @else
                        @if($all->solder == 0)
                          @if($all->id_paiement >= 3)
                            <form action="to_pay_form" method="post">
                              @csrf
                              <input type="text" name="id_reservation" style="display: none;" value="{{$all->id_reservation}}">
                              <button class="btn btn-warning"><span class="fa fa-check"></span>PAYER UNE TRANCHE</button>
                            </form>

                          @else
                            <form action="solder" method="post">
                              @csrf
                              <input type="text" name="id_reservation" style="display: none;" value="{{$all->id_reservation}}">
                              <button class="btn btn-warning"><span class="fa fa-check"></span>SOLDER</button>
                            </form>
                          @endif
                          
                        
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
                  <th>Montant Restant</th>
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

  
  