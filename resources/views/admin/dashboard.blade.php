@php
  Use App\Http\Controllers\Calculator;
  Use App\Http\Controllers\UserController;
  use App\Http\Controllers\ReservationController;
@endphp
@extends('layouts/base_admin')

@section('user')
  {{auth()->user()->login}}
@endsection
@section('poste')
  {{auth()->user()->libele_poste}}
@endsection

@section('content')

	<section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Utilisateurs administrateurs</span>
              <span class="info-box-number">
                @php
                  $nombre = (new Calculator())->SommeUsers();

                @endphp
                {{$nombre}}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-home"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Appartements</span>
              <span class="info-box-number">
                @php
                  $nombre = (new Calculator())->SommeApparts();

                @endphp
                {{$nombre}}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Ventes</span>
              <span class="info-box-number">
                @php
                  $nombre = (new Calculator())->SommeReservations();

                @endphp
                {{$nombre}}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Utilisateurs Clients</span>
              <span class="info-box-number">
                @php
                  $nombre = (new Calculator())->SommeCustomers();

                @endphp
                {{$nombre}}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!--my own chart begining-->
      

    

      <!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <!--VERIFIER LE NIVEAU DE L'UTILISATEUR AVANT D'AFFICHER CERTAINES INFOS -->
          @php
            $get = (new UserController())->getDepartmentLevel(auth()->user()->id);
            //dd($get);
          @endphp
          @foreach($get as $get)
                
            @if($get->niveau == 1)
              <div class="box ">
                <div class="box-header with-border">
                  <h3 class="box-title">Rapport Mensuel</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <!--<div class="btn-group">
                      <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-wrench"></i></button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                      </ul>
                    </div>-->
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                        <p class="text-center">
                          <strong><strong>Recettes Mensuelles année @php
                            echo date('Y');
                          @endphp</strong></strong>
                        </p>

                        <!--my chart-->
                        <canvas id="mychart" aria-label="chart" style="height:180px;"></canvas>

                        <!-- my own chart import-->
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        
                        <script>
                            const ctx = document.getElementById('mychart').getContext('2d');

                            const barchart = new Chart(ctx, {
                                type : "bar",
                                data : {

                                    //LE LABELS POUR LES ABSCISSES DU GRAPHE
                                    labels: ['JANVIER', 'FEVRIER', 'MARS', 'AVRIL', 'MAI', 'JUIN', 'JUILLET', 'AOUT', 'SEPTEMBRE', 'OCTOBRE', 'NOVEMBRE', 'DECEMBRE'],
                                    datasets: [{
                                        label: 'Recettes',
                                        data: @json($data),
                                        backgroundColor: ["#e8daef", " #a9dfbf", " #85929e", "blue", "#229954", " #f1948a ", "#2c3e50", "#fad7a0", "#2874a6", "#f1c40f", "#ebf5fb", "#1c2833"],
                                    }]
                                },
                                options: {
                                    layout: {
                                        padding: 20
                                  }
                                }
                            })
                        </script>
                            <!-- /.chart-responsive -->
                      </div>
                    </div>
                </div>
                
              </div>
            @endif
          @endforeach
        </div>
      </div>
     

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        @php
          $get = (new UserController())->getDepartmentLevel(auth()->user()->id);
        @endphp
        
        @foreach($get as $get)
          @if($get->niveau == 1)
            <div class="col-md-8">
              <!-- MAP & BOX PANE -->
              <!-- TABLE: LATEST ORDERS -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Réservations en attentes de validations</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                      <tr>
                        <th>Horodatage</th>
                        <th>Client</th>
                        <th>Appartement</th>
                        <th>Date d'entrée</th>
                        <th>Date de sortie</th>
                        <th>Type de paiement</th>
                      </tr>
                      </thead>
                      <tbody>
                      @php
                        $all = (new ReservationController())->AllPoolReservation();
                      @endphp
                      @foreach($all as $user)
                        <tr>
                        <td>{{$user->date}} à {{$user->heure}}</td>
                        <td>{{$user->nom_prenoms}}</td>
                        <td>{{$user->designation_appart}}</td>
                        <td>{{$user->date_debut}}</td>
                        <td>{{$user->date_fin}}</td>
                        <td>{{$user->libele_paiement}}</td>
                        </tr>
                      @endforeach
                    
                      
                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                  
                  <a href="pool_reserv" class="btn btn-sm btn-default btn-flat pull-right">Valider les réservations</a>
                </div>
                <!-- /.box-footer -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->

          @endif
        @endforeach
        
        <div class="col-md-4">

          <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Administrateur récement ajoutés</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                @php
                  $get = (new UserController())->GetLastestAdmin();
                @endphp
                @foreach($get as $admin)
                  <li class="item">
                    <div class="product-img">
                      {{$admin->nom_prenoms_users}}/
                      
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">{{$admin->tel_users}}
                        <!--<span class="label label-warning pull-right">$1800</span></a>-->
                      <span class="product-description">
                           {{$admin->libele_poste}}
                          </span>
                    </div>
                  </li>
                @endforeach
                
                
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="users" class="uppercase">Voir tous les utilisateurs</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
@endsection