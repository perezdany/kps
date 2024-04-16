@php
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
  Appartements
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
              <h3 class="box-title">APPARTEMENTS</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                @php
                  $all = (new AppartController())->AllAppart();
                @endphp

                <thead>
                  <tr>
                    <th>Désignation</th>
                    <th>Type</th>
                    <th>Tarifs</th>
                    <th>Nombre de lits</th>
                    <th>Nombre de douche</th>
                    <th>Note</th>
                    <th>Internet WI-FI</th>
                    <th >Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($all as $all)

                  <tr>
                 
                    <td>{{$all->designation_appart}}</td>
                    <td>{{$all->libele_type_appart}}</td>
                     <td>{{$all->prix}}</td>
                    <td>{{$all->nb_lit}}</td>
                    <td>{{$all->nb_douche}}</td>
                    <td>{{$all->note}}</td>
                    <td>
                      @if($all->internet_wifi == 1)
                        OUI
                      @else
                        NON
                      @endif
                    </td>

                    <td>
                      <div class="btn-group">
                        <form action="deleteappart" method="post">
                          @csrf
                          <input type="text" name="id_appart" style="display: none;" value="{{$all->id}}">
                          <button class="btn btn-danger"><span class="fa fa-trash"></span></button>  
                        </form>
                        <form action="about_appart" method="post">
                           @csrf
                          <input type="text" name="id_appart" style="display: none;" value="{{$all->id}}">
                          <button class="btn btn-success"><span class="fa fa-eye"></span></button>
                        </form>
                        
                        <form action="edit_appart_form" method="post">
                           @csrf
                          <input type="text" name="id_appart" style="display: none;" value="{{$all->id}}">
                          <button class="btn btn-primary"><span class="fa fa-edit"></span></button>
                        </form>
                        
                      </div>
                    </td>  
                 
                    <!--<td></td>
                      
                    <td>
                       
                    </td>-->


                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Désignation</th>
                    <th>Type</th>
                    <th>Tarifs</th>
                    <th>Nombre de lits</th>
                    <th>Nombre de douche</th>
                    <th>Note</th>
                    <th>Internet WI-FI</th>
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
              <h3 class="box-title">Ajouter un appartement</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <a href="add_appart"><button class="btn btn-block btn-lg btn-primary">ALLER AU FORMULAIRE</button></a>
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

  
  