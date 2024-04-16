@php
    use App\Http\Controllers\AppartController;
    use App\Models\Shoppingcart;
    use App\http\Controllers\ReservationController;
@endphp
@extends('layouts/base_customer')

@section('title')
	Mon Espace
@endsection

@section('user')
	{{auth()->user()->nom_prenoms}}
@endsection

@section('manage_account')
    <div class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Compte</a>
        <div class="dropdown-menu rounded-0 m-0">
            <a href="#" class="dropdown-item">Mon profil</a>
            <a href="logout" class="dropdown-item">Déconnexion</a>
            <a href="my_cart" class="dropdown-item">Mon Panier <span class="btn btn-dark">
                @php
                    $my_cart = DB::table('shoppingcarts')->whereInstance(auth()->user()->email)->count()
                    
                @endphp
            {{$my_cart}}</span></a>
        </div>
    </div>
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
                    <h6 class="section-title text-center text-primary text-uppercase">Réservations</h6>
                    <h1 class="mb-5">Vos Réservations <span class="text-primary text-uppercase">en cours</span></h1>
                </div>

                <div class="row g-4">
                    @php
                        $reservation_en_cours = (new ReservationController())->ReservationInProgess(auth()->user()->id);
                    @endphp

                    @foreach($reservation_en_cours as $get)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="room-item shadow rounded overflow-hidden">
                                <div class="position-relative"><!--l'image-->
                                    <img class="img-fluid" src="{{Storage::url($get->path)}}" alt="{{$get->designation_appart}}">
                                    <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">{{$get->montant}} XOF A payer</small>
                                </div>
                                <div class="p-4 mt-2">
                                    <div class="d-flex justify-content-between mb-3"><!--nom et note-->
                                        <h5 class="mb-0">{{$get->designation_appart}}</h5>
                                        <div class="ps-2">
                                            @for ($i = 0; $i < $get->note; $i++)
                                                <small class="fa fa-star text-primary"></small>
                                            @endfor
                                        </div>
                                        <!--<div class="ps-2">
                                            <small class="fa fa-star text-primary"></small>
                                            <small class="fa fa-star text-primary"></small>
                                            <small class="fa fa-star text-primary"></small>
                                            <small class="fa fa-star text-primary"></small>
                                            <small class="fa fa-star text-primary"></small>
                                        </div>-->
                                    </div>
                                    <div class="d-flex mb-3"><!--lits & caractéristiques-->
                                        <small class="border-end me-3 pe-3"><i class="fa fa-calendar text-primary me-2"></i>Arivée : {{$get->date_debut}} </small>
                                        <small class="border-end me-3 pe-3"><i class="fa fa-calendar text-primary me-2"></i>Départ : {{$get->date_fin}}</small>
                                        
                                        <small><i class="fa fa-info text-primary me-2"></i> Paiemment: {{$get->libele_paiement}}</small>
                                      
                                          
                                        
                                    </div>
                                    <p class="text-body mb-3"><b>EN COURS DE VALIDATION PAR L'ADMINISTRATEUR</b></p>
                                   <div class="d-flex justify-content-between">
                                        <a class="btn btn-sm btn-primary rounded py-2 px-4" href="delete/reservation/{{$get->id_reservation}}">Supprimer</a>
                                        <form action="edit_reservation" method="get">
                                            @csrf
                                            <input type="text" value="{{$get->id_reservation}}" name="id_reservation" style="display: none;" />
                                            <button class="btn btn-sm btn-dark rounded py-2 px-4" type="submit">Modifier</button>
                                        </form>
                                        
                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $id = $get->id;

                        @endphp
                    @endforeach
                   
                    
                </div>
                <br><br><br>
            </div>
        </div>
    <!-- Room End -->
@endsection