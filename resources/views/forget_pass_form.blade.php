@extends('layouts/base')

@section('title')
	Mon Espace
@endsection

@section('content')
	 <!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url(../img/carousel-1.jpg);">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center pb-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Espace Clients</h1>
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
                    <h6 class="section-title text-center text-primary text-uppercase">Compte utilisateur</h6>
                    <h1 class="mb-5"><span class="text-primary text-uppercase">Mot de passe oublié</span></h1>
                </div>
                <div class="row g-4">
					<div class="col-md-3"></div>
                    
                    <div class="col-md-6">
                        <div class="wow fadeInUp" data-wow-delay="0.2s">
                            <form method="post" action="get_email">
                            	@csrf
                                <div class="row g-3">
                                    <div class="col-3">
                                       
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control"  name="email"  required>
                                            <label >Entrez votre émail pour vérification</label>
                                        </div>
                                    </div>
                                    
									<div class="col-3">
                                       
                                    </div>
                                    <div class="col-4">
                                       
                                    </div>
									<div class="col-4">
                                        <button class="btn btn-primary w-100 py-3" type="submit">Valider</button>
                                    </div>
									<div class="col-4">
                                        
                                    </div>
                                  
                                    
                                </div>
                            </form>
                            
                        </div>
						<hr>
						<br>
						
                    </div>
					
					<div class="col-md-3"></div>
                </div>
            </div>
        </div>
        <!-- Contact End -->

@endsection