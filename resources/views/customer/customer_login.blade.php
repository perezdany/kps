@extends('layouts/base')

@section('title')
	Mon Espace
@endsection


@section('content')
	
	 <!-- Contact Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Connectez-vous</h6>
                    <h1 class="mb-5"><span class="text-primary text-uppercase">Votre Espace</span></h1>
                </div>
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
                <div class="row g-4">
					<div class="col-md-3"></div>
                    
                    <div class="col-md-6">
                        <div class="wow fadeInUp" data-wow-delay="0.2s">
                            <form method="post" action="customerLogin">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control"  name="login" onkeyup="this.value=this.value.toLowerCase()" >
                                            <label>Email/Numéro de téléphone</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" class="form-control"  name="password" >
                                            <label>Mot de passe</label>
                                        </div>
                                    </div>
									<div class="col-3">
                                       
                                    </div>
									<div class="col-6">
                                        <button class="btn btn-primary w-100 py-3" type="submit">Connexion</button>
                                    </div>
									<div class="col-3">
                                        
                                    </div>
                                   
                                </div>
                            </form>
                        </div>
						<hr>
						<br>
						<p>
							<span>Si vous n'avez pas de Compte,</span><a href="customer_register">Cliquez-ici pour créer un compte</a>
						</p>
                    </div>
					
					<div class="col-md-3"></div>
                </div>
            </div>
        </div>
        <!-- Contact End -->
@endsection