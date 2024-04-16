@php
    use App\Http\Controllers\AppartController;
    use App\Models\Appart;
    use App\Models\Shoppingcart;
    
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
                    <h1 class="mb-5">Mon <span class="text-primary text-uppercase">panier</span></h1>
                </div>
                @php
                    //utiliser un compteur pour vérifier si on a un multiple de 3 ou pas
                    $compte = 0;

                    $appart = new AppartController();//pour aller chercher des infos dans la base au cas ou
                @endphp

                @if (Cart::count() > 0)
                    @while ($compte < Cart::count())
                        @php
                           // $get = $appart->getWithId($last_id);

                        @endphp
                        <div class="row g-4">
                            @foreach(Cart::content() as $get)
                                @php
                                    $to_the_db = Shoppingcart::where('instance', auth()->user()->email)->where('identifier',  $get->rowId)->first();
                                    //var_dump($to_the_db);
                                @endphp
                                @if($to_the_db)

                                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                        <div class="room-item shadow rounded overflow-hidden">
                                            <div class="position-relative"><!--l'image-->
                                                <img class="img-fluid" src="{{Storage::url($get->model->path)}}" alt="{{$get->model->designation_appart}}">
                                                <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">{{$get->model->prix}}/Nuit</small>
                                            </div>
                                            <div class="p-4 mt-2">
                                                <div class="d-flex justify-content-between mb-3"><!--nom et note-->
                                                    <h5 class="mb-0">{{$get->model->designation_appart}}</h5>
                                                    <div class="ps-2">
                                                        @for ($i = 0; $i < $get->model->note; $i++)
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
                                                    <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i>{{$get->model->nb_lit}} Lits</small>
                                                    <small class="border-end me-3 pe-3"><i class="fa fa-bath text-primary me-2"></i>{{$get->model->nb_douche}} Salle de Bain</small>
                                                    @if($get->model->note == 0)
                                                        <small><i class="fa fa-wifi text-primary me-2"></i>pas de Wifi</small>
                                                    @else
                                                        <small><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>
                                                    @endif
                                                    
                                                </div>
                                                <p class="text-body mb-3">Découvrez le confort dans cet appartement de {{$get->model->note}} étoiles pour {{$get->model->prix}} la nuit. Vous pouvez voir plus de détails en cliquant sur le bouton</p>
                                               <div class="d-flex justify-content-between">
                                               
                                                    <a class="btn btn-sm btn-primary rounded py-2 px-4" href="my_cart/deleteItem/{{$get->rowId}}/{{auth()->user()->email}}">Retirer du panier</a>
                                                    @if( auth()->user()->id != null)
                                                        <form method="post" action="reservation_form">
                                                            @csrf
                                                            <input type="text" name="id_appart" value="{{$get->model->id}}" style="display: none;">
                                                            
                                                            <button class="btn btn-sm btn-dark rounded py-2 px-4" >Réserver</button>
                                                        </form>

                                                     
                                                    @endif
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else


                                @endif
                                
                                @php
                                    $id = $get->id_appart;
                                    $compte = $compte + 3;

                                    //Si c'est un multiple de 3 on va créer une autre ligne encore 
                                    if(Cart::count() % 3 != 0)
                                    {
                                        //$the_last = $appart->GetLast($last_id);
                                    }
                                    

                                @endphp
                              
                            @endforeach
                           
            
                        </div>
                   
                    @endwhile
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    
                        <a href="viderpanier/{{auth()->user()->email}}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Vider mon panier</a>
                               
                    </div>
                @else
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                            <h6 class="section-title text-center text-primary text-uppercase">Votre panier est vide</h6>
                           
                        </div>


                @endif 
              


            </div>
        </div>
    <!-- Room End -->
@endsection