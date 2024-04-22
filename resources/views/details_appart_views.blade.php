@php
    use App\Http\Controllers\AppartController;
    use App\Models\Shoppingcart;
    
    use App\http\Controllers\ReservationController;
@endphp
@extends('layouts/base')

@section('title')
	KPS IMMOBILIER
@endsection


@section('content')

	<!-- Room Start -->
        <!-- Booking Start -->
            <div class="container-fluid wow fadeIn" data-wow-delay="0.1s">
                <div class="container">
                    <div class="bg-white" style="padding: 35px;">
                        <div class="row g-2">
                            <div class="col-md-12">
                                @if(session('success'))
                                        <div class="alert-success">{{session('success')}}</div>


                                        @endif

                                        @if(session('error'))
                                            <div class="alert-error">{{session('error')}}</div>


                                        @endif
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        <!-- Booking End -->
        <div class="container-xxl py-5">
            <div class="container">
                
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">APPARTEMENT</h6>
                    <h1 class="mb-5">Détails<span class="text-primary text-uppercase">de l'appartement</span></h1>
                </div>

                <div class="row g-4">
                    <div class="col-lg-2 col-md-2 wow fadeInUp" data-wow-delay="0.1s">
                    </div>
                    @php
                        $details = (new AppartController())->GetAppartById($id);
                    @endphp

                    @foreach($details as $get)
                        <div class="col-lg-8 col-md-8 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="room-item shadow rounded overflow-hidden">
                                <div class="text-center"><!--l'image-->
                                    <img class="img-fluid" src="{{Storage::url($get->path)}}" alt="{{$get->designation_appart}}">
                                    <small class="start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-2 ms-4">{{$get->prix}} XOF </small>
                                </div>
                                <div class="p-4 mt-2">
                                    <div class="d-flex justify-content-between mb-3"><!--nom et note-->
                                        <h5 class="mb-0">{{$get->designation_appart}}</h5>
                                        <h5 class="mb-0">Type d'appartement : {{$get->libele_type_appart}}</h5>
                                        <div class="ps-2">
                                            @for ($i = 0; $i < $get->note; $i++)
                                                <small class="fa fa-star text-primary"></small>
                                            @endfor
                                        </div>
                                     
                                    </div>
                                    <div class="d-flex mb-3"><!--lits & caractéristiques-->
                                        <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i>{{$get->nb_lit}} Lits</small>
                                        <small class="border-end me-3 pe-3"><i class="fa fa-bath text-primary me-2"></i>{{$get->nb_douche}} Salle de Bain</small>
                                        @if($get->note == 0)
                                            <small><i class="fa fa-wifi text-primary me-2"></i>pas de Wifi</small>
                                        @else
                                            <small><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>
                                        @endif
                                        
                                    </div>
                                    <p class="text-body mb-3"><b>{{$get->description}}</b></p>
                                   
                                </div>
                                <div class="d-flex justify-content-between">
                                    <form action="", method="post">
                                            @csrf
                                            <input type="text" value="{{$get->id}}" style="display: none" name="id_appart">
                                            <button class="btn btn-sm btn-primary rounded py-2 px-4">Noter Cet appartement</button>
                                    </form>     
                                    @if(auth()->user() != null)
                                        <form method="post" action="add_cart">
                                            @csrf
                                            <input type="text" name="id_appart" value="{{$get->id}}" style="display: none;">
                                            <input type="text" name="user_email" value="{{auth()->user()->email}}" style="display: none;">
                                            <button class="btn btn-sm btn-dark rounded py-2 px-4" >Ajouter au panier</buton>
                                        </form>

                                    @else

                                        <a class="btn btn-sm btn-dark rounded py-2 px-4" href="customer_login">Ajouter au panier</a>
                                    @endif
                                    
                               </div>
                            </div>
                        </div>
                        @php
                            $id = $get->id;

                        @endphp
                    @endforeach

                    <div class="col-lg-2 col-md-2 wow fadeInUp" data-wow-delay="0.1s">
                    </div>
                    
                </div>
                <br><br><br>
            </div>
        </div>
    <!-- Room End -->
@endsection