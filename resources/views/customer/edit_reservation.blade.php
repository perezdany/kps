@php
    use App\Http\Controllers\AppartController;
    use App\Http\Controllers\ReservationController;
    use App\Models\Appart;
    use App\Models\Shoppingcart;
    use App\Models\Reservation;
    
@endphp

@extends('layouts/base_customer')

@section('title')
    Mon Espace
@endsection

@if(session()->has('nom') AND session()->has('theuser'))
   @section('manage_account')
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Compte</a>
            <div class="dropdown-menu rounded-0 m-0">
                <a href="#" class="dropdown-item">Mon profil</a>
                <a href="logout" class="dropdown-item">Déconnexion</a>
                @if(session('theuser') != null)
                       
                    <a href="my_cart" class="dropdown-item">Mon Panier <span class="btn btn-dark">
                  
                        @php 
                            $my_cart = DB::table('shoppingcarts')->whereInstance(session('theuser')->email)->count();
                        @endphp

                        
                        {{$my_cart}} 

                        
                    
                    </span></a>
               @endif
            </div>
        </div>
    @endsection

    @section('user')
        {{session('nom')}}
    @endsection
@else
    
@endif

@section('content')
     <!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url(../img/carousel-1.jpg);">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center pb-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Réservation</h1>
                    <!--<nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Contact</li>
                        </ol>
                    </nav>-->
                </div>
            </div>
        </div>
        <!-- Page Header End -->

         <!-- Booking Start -->
        <div class="container-fluid booking pb-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container">
                <div class="bg-white shadow" style="padding: 35px;">
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


        <!-- Contact Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Formulaire de Réservation</h6>
                    <h1 class="mb-5"><span class="text-primary text-uppercase">Veuillez remplir le formulaire (*) obligatoire</span></h1>
                </div>
                <div class="row g-4">
                    <div class="col-md-3"></div>
                    
                    <div class="col-md-6">
                        <div class="wow fadeInUp" data-wow-delay="0.2s">
                            @if(request('id_reservation') != null)
                                <form method="post" action="edit_reservation/edit">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control"  name="id_reservation" value="{{request('id_reservation')}}" required style="display: none;">
                                                <label></label>
                                            </div>
                                        </div>
                                        @php
                                            //on récupère l'appart en question depuis la base de données
                                            //$getThe_appart = Appart::where('id', request('id_appart'))->first();
                                            
                                            //on va récupérer en suite toutes les infos de la réservation

                                            $reservation = (new ReservationController())->SelectAReservation(request('id_reservation'));
                                           
                                        @endphp

                                        @foreach($reservation as $reservation)
                                            <div class="col-md-12">
                                                <div class="form-floating">

                                                    <select class="form-control" name="appart" required>

                                                       <option value="{{$reservation->id}}"> <b>{{$reservation->designation_appart}} || tarif: {{$reservation->prix}}</b>
                                                        </option> 
                                                       
                                                         @php   
                                                            //tous les appart maintenant mais ceux qui sont libre

                                                            //prendre tous les apparts  <option>{{$all->id}}</option>
                                                            $appart = DB::table('apparts')->get();
                                                           
                                                        @endphp
                                                            
                                                        
                                                        @foreach($appart as $all)
                                                            
                                                            @php
                                                                
                                                                //voir si l'appart qui a ce id est oqp
                                                                $busy = (new AppartController())->AppartBusy($all->id);
                                                               
                                                                
                                                                if(empty(get_object_vars($busy)))//donc l'appart est libre
                                                                {
                                                                   echo'<b><option value="'.$all->id.'">'.$all->designation_appart.' || tarif:'.$all->prix.'</option></b>';
                                                                    
                                                                }
                                                                else
                                                                {
                                                                    
                                                                    
                                                                    //NOT get_bojet_var permet de voir si l'objet a des attribut
                                                                }
                                                            @endphp
                                                            
                                                           
                                                        @endforeach
                                                    </select>
                                                    
                                                    <label >Choisir l'appartement(*)</label>
                                                </div>
                                            </div>
                                       
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="date" class="form-control"  name="date_debut" value="{{$reservation->date_debut}}" required>
                                                    <label>Date d'entrée (*)</label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" value="{{$reservation->jours}}" name="jours" min="0" max="31"required>
                                                    <label for="">Nombre de jours</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" value="{{$reservation->mois}}" name="mois" min="0" max="12"required>
                                                    <label for="">Nombre de mois</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="email" class="form-control" value="{{$reservation->email}}" name="email" required>
                                                    <label for="">Email du Client(*)</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select class="form-control" name="modepaiement" required>
                                    
                                                         @php   
                                                            //tous les types de paiement

                                                            //prendre tous les apparts  <option>{{$all->id}}</option>
                                                            $appart = DB::table('modepaiements')->get();
                                                           
                                                        @endphp
                                                            <option value={{$reservation->id_mode_paie}}>{{$reservation->libele_mode_paie}}</option>
                                                        
                                                        @foreach($appart as $all)
                                                            
                                                          <option value={{$all->id_mode_paie}}>{{$all->libele_mode_paie}}</option>
                                                            
                                                           
                                                        @endforeach
                                                    </select>
                                                    
                                                    <label >Type de paiement(*)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select class="form-control" name="paiement" required>
                                    
                                                        @php   
                                                            //tous les types de paiement

                                                            //prendre tous les apparts  <option>{{$all->id}}</option>
                                                            $appart = DB::table('paiements')->get();
                                                           
                                                        @endphp
                                                            
                                                            <option value={{$reservation->id_paiement}}>{{$reservation->libele_paiement}}</option> 
                                                        
                                                        @foreach($appart as $all)
                                                            
                                                            <option value={{$all->id_paiement}}>{{$all->libele_paiement}}</option> 
                                                          
                                                            
                                                           
                                                        @endforeach
                                                    </select>
                                                    
                                                    <label >Type de paiement(*)</label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-3">
                                               
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-primary w-100 py-3" type="submit">Valider</button>
                                            </div>
                                                
                                        @endforeach    
                                        
                                        <div class="col-3">
                                            
                                        </div>
                                      
                                        
                                    </div>
                                </form>
                            @else
                                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                               
                                    <h3 class="mb-5"><span class="text-primary text-uppercase">Aucune réservation détectée!</span></h3>
                                </div>
                            @endif
                           
                        </div>
                        <hr>
                        <br>
                        <p>
                            
                        </p>
                    </div>
                    
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
        <!-- Contact End -->

@endsection