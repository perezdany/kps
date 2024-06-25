@php
    use App\Http\Controllers\AppartController;
    
@endphp


@extends('layouts/base')

@section('title')
	@if(auth()->user() != null)
        Mon Espace
    @else
       KPS IMMOBILIER
    @endif
@endsection


@if(auth()->user() != null)
   @section('manage_account')
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Compte</a>
            <div class="dropdown-menu rounded-0 m-0">
                <a href="#" class="dropdown-item">Mon profil</a>
                <a href="logout" class="dropdown-item">Déconnexion</a>
                @if(auth()->user()->id != null)
                       
                    <a href="my_cart" class="dropdown-item">Mon Panier <span class="btn btn-dark">
                  
                        @php 
                            $my_cart = DB::table('shoppingcarts')->whereInstance(auth()->user()->email)->count();
                        @endphp

                        
                        {{$my_cart}} 

                        
                    
                    </span></a>
               @endif
            </div>
        </div>
    @endsection

    @section('user')
        {{auth()->user()->nom_prenoms}}
    @endsection
@else
    
@endif
   




@section('content')
	<!-- Room Start -->
        <div class="container-xxl py-5">
            <div class="container">
               @php
                    $appart = new AppartController();
                    //compter le nombre d'appart
                    $nombre_appart = $appart->CountAppart();

                    //prendre les trois premiers d'abord
                    $first_three = $appart->getFirstThree();

                    //la session utilisateurs
                    $the_user = session('theuser');
                   
                @endphp
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Visitez</h6>
                    <h1 class="mb-5">Nos <span class="text-primary text-uppercase">Appartements</span></h1>
                </div>
               
                @php
                    $get = $appart->AllAppart();

                @endphp
                <div class="row g-4">
                    @foreach($get as $get)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="room-item shadow rounded overflow-hidden">
                                <div class="position-relative"><!--l'image-->
                                    <img class="img-fluid" src="{{Storage::url($get->path)}}" alt="{{$get->designation_appart}}">
                                    <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">
                                    {{$get->prix_jour}}/Jour & {{$get->prix_nuit}}/Nuit</small>
                                    <br>
                            
                                </div>
                                <div class="p-4 mt-2">
                                    <div class="d-flex justify-content-between mb-3"><!--nom et note-->
                                        <h5 class="mb-0">{{$get->designation_appart}}</h5>
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
                                    <p class="text-body mb-3">Découvrez le confort dans cet appartement de {{$get->note}} étoiles pour <b>{{$get->prix_nuit}} LA NUIT </b> ou  <b>{{$get->prix_jour}} LE JOUR </b>. Vous pouvez voir plus de détails en cliquant sur le bouton</p>
                                    <div class="d-flex justify-content-between">
                                        <form action="display_details", method="post">
                                            @csrf
                                            <input type="text" value="{{$get->id}}" style="display: none" name="id_appart">
                                            <button class="btn btn-sm btn-primary rounded py-2 px-4">Voir les détails</button>
                                        </form>
                                        
                                        @if(auth()->user() != null)
                                            <form method="post" action="add_cart">
                                                @csrf
                                                <input type="text" name="id_appart" value="{{$get->id}}" style="display: none;">
                                                <input type="text" name="user_email" value="{{auth()->user()->email}}" style="display: none;">
                                                <button class="btn btn-sm btn-dark rounded py-2 px-4" >Ajouter au panier</button>
                                            </form>

                                        @else

                                          <a class="btn btn-sm btn-dark rounded py-2 px-4" href="customer_login">Ajouter au panier</a>
                                        @endif
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $id = $get->id;

                        @endphp
                    @endforeach
                           
                </div>
            </div>
        </div>
    <!-- Room End -->
@endsection