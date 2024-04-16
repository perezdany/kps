@php
  use App\Http\Controllers\DepartementController;
@endphp
@extends('layouts/base_admin')

@section('user')
  {{auth()->user()->login}}
@endsection

@section('poste')
  {{$admin->libele_poste}}
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
              <h3 class="box-title">Appartements</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="add_appart" method="post" enctype="multipart/form-data">
              @csrf
              <div class="box-body">
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Nom de l'appartement :</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="Entrez le nom et le prénom" onkeyup="this.value=this.value.toUpperCase()" required name="thename">
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Type d'apaprtement :</label>

                  <div class="col-sm-8">
                    <select class="form-control" name="type" required>
                     
                       @php   
                          //tous les appart maintenant mais ceux qui sont libre

                          //prendre tous les types d'apparts  <option>{{$all->id}}</option>
                          $appart = DB::table('typeapparts')->get();
                         
                      @endphp
                          
                      
                      @foreach($appart as $type)
                          
                        <option value="{{$type->id_type_appart}}">{{$type->libele_type_appart}}</option>
                         
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Tarif :</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="prix unitaire" required name="prix">
                  </div>
                </div>
               
                <div class="form-group">
                    <label  class="col-sm-4 control-label">Nombre de lits :</label>
                    <div class="col-sm-8">
    
                      <input type="number" class="form-control" min="1" max="10" required name="lits">
                    </div>
                </div>
                <div class="form-group">
                    <label  class="col-sm-4 control-label">Nombre de douches :</label>
                    <div class="col-sm-8">
    
                      <input type="number" class="form-control" min="1" max="10" required name="douches">
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Choisir une photo</label>
                  <div class="col-sm-8">
                    <input class="form-control" type="file" name="photo" accept="image/png, image/jpeg">

                    <p class="help-block">Photo.</p>
                  </div>
                 
                </div>

                <div class="form-group">
                  <label  class="col-sm-4 control-label">Internet Wifi :</label>

                  <div class="col-sm-8">
                    <select class="form-control" name="wifi" required>
                          
                      <option value="1">OUI</option>
                      <option value="0">NON</option>

                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label  class="col-sm-4 control-label">Une description :</label>

                  <div class="col-sm-8">
                   <textarea class="form-control" name="description" required></textarea>
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