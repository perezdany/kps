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
                    <h6 class="section-title text-center text-primary text-uppercase">Connectez-vous</h6>
                    <h1 class="mb-5"><span class="text-primary text-uppercase">Votre Espace</span></h1>
                </div>
                <div class="row g-4">
					<div class="col-md-3"></div>
                    
                    <div class="col-md-6">
                        <div class="wow fadeInUp" data-wow-delay="0.2s">
                            <form method="post" action="customer_register">
                            	@csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name"  name="name" onkeyup="this.value=this.value.toUpperCase()" required>
                                            <label >Nom & Prénom(s)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="email"  name="email" required onkeyup="this.value=this.value.toLowerCase()">
                                            <label>Email</label>
                                        </div>
                                    </div>
									<div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id=""  name="tel" required>
                                            <label for="">Téléphone: ex 0102030405</label>
                                        </div>
                                    </div>
									<div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="" name="adresse" required>
                                            <label for="">Adresse: ex Abidjan cocody Riviera 2</label>
                                        </div>
                                    </div>
									<div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="pwd1"  name="password" required>
                                            <label for="">Mot de passe</label>
                                        </div>
                                    </div>
									<div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="pwd2" name="confirm_pass" required onkeyup="verifyPassword()">
                                            <label for="">Confirmer le mot de passe</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="match">
                                    	
                                    	
                                    </div>
                                    <script type="text/javascript">
						                
						                /*UN SCRIPT QUI VA VERFIER SI LES DEUX PASSWORDS MATCHENT*/
						                function verifyPassword()
						                {
						                  var msg; 
						                  var str = document.getElementById("pwd1").value; 

						                  /*if (str.match( /[0-9]/g) && 
						                      str.match( /[A-Z]/g) && 
						                      str.match(/[a-z]/g) && 
						                      str.match( /[^a-zA-Z\d]/g) &&
						                      str.length >= 10) 
						                    msg = "<p style='color:green'>Mot de passe fort.</p>"; 
						                  else 
						                    msg = "<p style='color:red'>Mot de passe faible.</p>"; 
						                  document.getElementById("msg").innerHTML= msg; */
						                  //var _ = require('underscore');
						                  var text1 = document.getElementById('pwd1').value;
						                  var text2 = document.getElementById('pwd2').value;
						                  
						                  if((text1 == text2))
						                  {
						                    var theText = "<p style='color:green'>Correspond.</p>"; ;
						                    document.getElementById("match").innerHTML= theText; 
						                  }
						                  else
						                  {
						                    var theText = "<p style='color:red'>Ne correspond pas.</p>";
						                    document.getElementById("match").innerHTML= theText; 
						                  }
						                }
							                
						            </script>
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
							<span>Si vous avez déjà un Compte,</span><a href="customer_login">Cliquez-ici pour vous connecter</a>
						</p>
                    </div>
					
					<div class="col-md-3"></div>
                </div>
            </div>
        </div>
        <!-- Contact End -->

@endsection