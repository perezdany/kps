@php
    use App\Http\Controllers\AppartController;
    Use App\Http\Controllers\Calculator;
@endphp

@extends('layouts/base')


@section('content')
      <!-- Carousel Start -->
        <div class="container-fluid p-0 mb-5">
            <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="w-100" src="img/carousel-1.jpg" alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h6 class="section-title text-white text-uppercase mb-3 animated slideInDown">Le confort garanti</h6>
                                <h1 class="display-3 text-white mb-4 animated slideInDown">Découvrez des appartements somptueux</h1>
                                <a href="appartements" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Des chambres qui répondent à vos attentes</a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="w-100" src="img/carousel-2.jpg" alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h6 class="section-title text-white text-uppercase mb-3 animated slideInDown">Le confort garanti</h6>
                                <h1 class="display-3 text-white mb-4 animated slideInDown">Découvrez des appartements somptueux</h1>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Des chambres qui répondent à vos attentes</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <!-- Carousel End -->

        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <h6 class="section-title text-start text-primary text-uppercase">Présentation</h6>
                        <h1 class="mb-4">Bienvenue à notre <span class="text-primary text-uppercase">Espace Hotelier!</span></h1>
                        <p class="mb-4">Venez découvrir nos splendides promotion espace de relaxation et nos chambres à couper le souffre avec un rapport qualité/prix battant toutes concurrences. </p>
                        <div class="row g-3 pb-4">
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-hotel fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up">
                                        @php
                                            $nombre = (new Calculator())->SommeApparts();

                                        @endphp
                                        {{$nombre}}
                                        
                                        </h2>
                                        <p class="mb-0">Chambres</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.3s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-users-cog fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up">
                                            @php
                                                $nombre = (new Calculator())->SommeUsers();

                                            @endphp
                                            {{$nombre}}
                                        </h2>
                                        <p class="mb-0">Employés</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.5s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-users fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up">
                                            @php
                                                $nombre = (new Calculator())->SommeCustomers();

                                            @endphp
                                            {{$nombre}}
                                        </h2>
                                        <p class="mb-0">Clients</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-primary py-3 px-5 mt-2" href="about">Visitez</a>
                    </div>
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.1s" src="img/about-1.jpg" style="margin-top: 25%;">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.3s" src="img/about-2.jpg">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-50 wow zoomIn" data-wow-delay="0.5s" src="img/about-3.jpg">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.7s" src="img/about-4.jpg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Room Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Appartements</h6>
                    <h1 class="mb-5">Les mieux <span class="text-primary text-uppercase">Notés</span></h1>
                </div>
                @php
                    $appart = new AppartController();
                    //$nombre_appart = $appart->CountAppart();
                    //on va prendre les apparts les mieux notés.
                    $first_three = $appart->GetMostAccurate();
                    //dd($first_three);
                    //$compte == 0;
                @endphp

                <div class="row g-4">
                    @foreach($first_three as $get)

                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="room-item shadow rounded overflow-hidden">
                                <div class="position-relative"><!--l'image-->
                                    <img class="img-fluid" src="{{Storage::url($get->path)}}" alt="{{$get->designation_appart}}">
                                    <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">{{$get->prix_jour}}/jour & {{$get->prix_nuit}}/Nuit</small>
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
                                        <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i>{{$get->nb_lit}} Lits</small>
                                        <small class="border-end me-3 pe-3"><i class="fa fa-bath text-primary me-2"></i>{{$get->nb_douche}} Salle de Bain</small>
                                        @if($get->note == 0)
                                            <small><i class="fa fa-wifi text-primary me-2"></i>pas de Wifi</small>
                                        @else
                                            <small><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>
                                        @endif
                                        
                                    </div>
                                    <p class="text-body mb-3">Découvrez le confort dans cet appartement de {{$get->note}} étoiles pour <b>{{$get->prix_nuit}} la nuit</b> ou <b>{{$get->prix_jour}} le jour</b>. Vous pouvez voir plus de détails en cliquant sur le bouton</p>
                                    <div class="d-flex justify-content-between">
                                        <form action="display_details", method="post">
                                            @csrf
                                            <input type="text" value="{{$get->id}}" style="display: none" name="id_appart">
                                            <button class="btn btn-sm btn-primary rounded py-2 px-4">Voir les détails</button>
                                        </form>
                                        @if( auth()->user() != null )
                                            
                                           <a class="btn btn-sm btn-dark rounded py-2 px-4" href="add_cart">Ajouter au panier</a>
                                        
                                        @else
                                        
                                          <a class="btn btn-sm btn-dark rounded py-2 px-4" href="customer_login">Ajouter au panier</a>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
        <!-- Room End -->

         <!-- Service Start -->
         
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Nos Services</h6>
                    <h1 class="mb-5">Prenez connaissance de nos <span class="text-primary text-uppercase">Services</span></h1>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-hotel fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Chambres & Appartments</h5>
                            <p class="text-body mb-0">Offrent des espaces confortables et modernes, alliant design élégant et fonctionnalité pour répondre aux besoins de chaque résident. Que ce soit pour un séjour court ou long terme, ils garantissent un cadre de vie agréable et bien équipé.</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-utensils fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Nouriture & Restaurant</h5>
                            <p class="text-body mb-0">Propose une expérience culinaire unique, avec des plats savoureux préparés à partir d'ingrédients frais et de saison. Que ce soit pour un repas gastronomique ou un dîner décontracté, chaque visite promet un voyage gustatif inoubliable dans une ambiance accueillante.</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-spa fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Spa & Fitness</h5>
                            <p class="text-body mb-0">Offre un havre de détente et de bien-être, combinant soins revitalisants et installations de remise en forme de pointe. Profitez d'une expérience revitalisante pour le corps et l'esprit dans un cadre serein et luxueux.</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-swimmer fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Sports & Gaming</h5>
                            <p class="text-body mb-0">Propose une combinaison dynamique d'activités sportives et de divertissements immersifs, conçus pour stimuler l'énergie et l'esprit compétitif. Avec des installations de pointe et des jeux passionnants, c'est l'endroit idéal pour se divertir et se défier entre amis.</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-glass-cheers fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Evènements & Fêtes</h5>
                            <p class="text-body mb-0">Transforment chaque occasion en une célébration mémorable, avec des décors captivants et une ambiance festive. Que ce soit pour un mariage, un anniversaire ou une soirée à thème, chaque détail est soigneusement orchestré pour créer des souvenirs inoubliables.</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-dumbbell fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">GYM & Yoga</h5>
                            <p class="text-body mb-0">Offre un équilibre parfait entre force et sérénité, avec des séances d'entraînement énergisantes et des pratiques de yoga apaisantes. Profitez d'un espace accueillant pour renforcer votre corps, améliorer votre flexibilité, et cultiver votre bien-être mental.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->
@endsection


        
      

 