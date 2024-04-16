@php
  use App\Http\Controllers\AppartController;
@endphp
@extends('layouts/base_admin')

@section('user')
  {{auth()->user()->login}}
@endsection

@section('location')
  Détails Sur appartement
@endsection

@section('content')
  <!-- Main content -->

   <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
            @php
                $get = (new AppartController())->GetAppartById($id);
            @endphp
            @foreach($get as $appart)
                <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fa fa-eye"></i> Détails sur l'appartement {{$appart->designation_appart}}
                    
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                   <h4>{{$appart->designation_appart}}</h4>
                  <address>
                    <strong> Type: {{$appart->libele_type_appart}} </strong><br>
                   <b>Nombre de lits:</b> {{$appart->nb_lit}} <br>
                    <b>Nombre de douches:</b> {{$appart->nb_douche}} <br>
                    
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  
                  <address>
                    <strong>Note: {{$appart->note}}/5</strong><br><br>
                    @if($appart->internet_wifi == 0)
                        INTERNET WIFI DISPONIBLE<br>
                    @else
                        INTERNET WIFI NON DISPONIBLE<br>
                    @endif
                      
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Tarif: {{$appart->prix}}/jours</b><br>
                  <br>
                  <p>
                    {{$appart->description}}
                  </p>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

             

              <div class="row">
             
                <div class="col-6">
                  <p class="lead">Aperçu</p>

                  <div class="table-responsive">
                    <img class="img-fluid" src="{{Storage::url($appart->path)}}" alt="{{$appart->designation_appart}}">
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row --> 
            @endforeach
             

             
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

  
  