@php
  use App\Http\Controllers\DepartementController;
  use App\Http\Controllers\AppartController;

  use App\Models\Appart
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
       Enregistrements
       
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
              <h3 class="box-title">Départements</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="save_reservation" method="post">
              @csrf
              <div class="box-body">
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Choisir l'appartement :</label>

                  <div class="col-sm-8">
                    <select class="form-control" name="appart" required>
                     
                       @php   
                          //tous les appart maintenant mais ceux qui sont libre

                          //prendre tous les apparts  <option>{{$all->id}}</option>
                          $appart = DB::table('apparts')->get();
                         //var_dump($appart);
                      @endphp
                          
                      
                      @foreach($appart as $all)
                          
                          @php
                              //dd($appart->id);
                              //voir si l'appart qui a ce id est oqp
                              $busy = (new AppartController())->AppartBusy($all->id);
                             
                              //var_dump (empty($busy));
                              if(empty(get_object_vars($busy)))//donc l'appart est libre
                              {
                                 echo'<b><option value="'.$all->id.'">'.$all->designation_appart.' || tarif:'.$all->prix.'</option></b>';
                                  
                              }
                              else
                              {
                                  
                                 
                              }
                          @endphp
                          
                         
                      @endforeach
                  </select>
                                            
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Date d'entrée(*) :</label>

                  <div class="col-sm-8">
                    <input type="date" class="form-control"  name="date_debut" required>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Nombre de jours(*) :</label>

                  <div class="col-sm-8">
                    <input type="number" class="form-control" value="0" name="jours" min="0" max="31"required>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Nombre de mois :</label>

                  <div class="col-sm-8">
                    <input type="number" class="form-control" value="0" name="mois" min="0" max="12"required>
                  </div>
                </div>

                <div class="form-group">
                    <label  class="col-sm-4 control-label">Email du client :</label>
                    <div class="col-sm-8">
    
                      <input type="email" class="form-control" name="email" required >
                    </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Mode de Paiement (*) :</label>
                  <div class="col-sm-8">
                     <select class="form-control" name="modepaiement" required>
    
                         @php   
                            //tous les types de paiement

                            //prendre tous les apparts  <option>{{$all->id}}</option>
                            $appart = DB::table('modepaiements')->get();
                           //var_dump($appart);
                        @endphp
                            
                        
                        @foreach($appart as $all)
                            
                          <option value={{$all->id_mode_paie}}>{{$all->libele_mode_paie}}</option>
                            
                           
                        @endforeach
                    </select>
                
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Paiement (*) :</label>
                  <div class="col-sm-8"> 
                    <select class="form-control" name="paiement" required>
                            
                        @php   
                            //tous les types de paiement

                            //prendre tous les apparts  <option>{{$all->id}}</option>
                            $appart = DB::table('paiements')->get();
                           //var_dump($appart);
                        @endphp
                            
                        
                        @foreach($appart as $all)
                            
                            <option value={{$all->id_paiement}}>{{$all->libele_paiement}}</option> 
                          
                            
                           
                        @endforeach
                    </select>
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