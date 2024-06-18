@extends('layouts/base')

@section('title')
	KPS IMMOBILIER-Services
@endsection

@section('content')
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
                            <h5 class="mb-3">Chambres & Appartments(Hôtelerie)</h5>
                            <p class="text-body mb-0">Votre prochain havre de paix est ici. N'hésitez pas à nous contacter pour réserver.</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-hotel fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Vente et location de maison</h5>
                            <p class="text-body mb-0">Une équipe de professionnels du marché immobilier à votre service<br>Une large gamme d’appartements de qualité<br>Un interlocuteur unique à votre disposition<br>
Un accompagnement sur-mesure</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-globe fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Vente de terrain </h5>
                            <p class="text-body mb-0">Achetezvos terrains chez nous. Nous accompagnons dans toutes les démarches. <br>Vous pouvez nous faire confiance</p>
                        </a>
                    </div>
                   
                </div>
            </div>
        </div>
       
    
        <!-- Service End -->
@endsection