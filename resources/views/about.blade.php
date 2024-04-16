@php
    Use App\Http\Controllers\Calculator;
@endphp
@extends('layouts/base')

@section('title')
    KPS IMMOBILIER-A propos
@endsection
@section('content')

	
        <!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center pb-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">A Propos de nous</h1>
                    
                </div>
            </div>
        </div>
        <!-- Page Header End -->

		
        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <h6 class="section-title text-start text-primary text-uppercase">Présentation</h6>
                        <h1 class="mb-4">Bienvenue à notre <span class="text-primary text-uppercase">Espace Hotelier!</span></h1>
                        <p class="mb-4">KPS Immobilier est une entreprise ou une agence spécialisée dans l'achat, la vente, la location et la gestion de biens immobiliers. Fondée sur les valeurs d'expertise, de professionnalisme et de service à la clientèle, KPS Immobilier s'engage à fournir des solutions personnalisées et efficaces pour répondre aux besoins diversifiés de ses clients dans le domaine de l'immobilier. KPS Immobilier pourrait également se spécialiser dans différents secteurs de l'immobilier, tels que la résidentielle, commerciale, industrielle ou encore dans des services spécifiques comme la gestion locative, l'investissement immobilier ou le développement de projets.
KPS Immobilier serait une structure immobilière engagée à fournir des services de qualité supérieure, basés sur l'expertise, la confiance et la satisfaction du client.
</p>
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
@endsection