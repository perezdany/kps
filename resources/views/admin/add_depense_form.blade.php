@php
  use App\Http\Controllers\DepenseController;
  use App\Http\Controllers\AppartController;
@endphp
@extends('layouts/base_admin')

@section('user')
  {{auth()->user()->login}}
@endsection

@section('poste')
  {{auth()->user()->libele_poste}}
@endsection

@section('location')
  Dépenses
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
              <h3 class="box-title">Dépenses</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="add_depense" method="post">
              @csrf
              <div class="box-body">
                <div class="form-group">
                  <label  class="col-sm-2 control-label">Objet:</label>

                  <div class="col-sm-10">
                    <textarea type="text" class="form-control" name="objet"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-2 control-label">Date:</label>

                  <div class="col-sm-10">
                    <input type="date" class="form-control" name="date" >
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-2 control-label">Appartement:</label>

                  <div class="col-sm-10">
                    <select  class="form-control" name="appart" >
                        @php
                            $get = (new AppartController())->AllAppart();
                        @endphp
                        @foreach($get as $appart)
                            <option value="{{$appart->id}}">{{$appart->designation_appart}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label  class="col-sm-2 control-label">Montant:</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="montant" >
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