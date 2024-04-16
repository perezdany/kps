@extends('layouts/base')

@section('title')
	KPS IMMOBILIER-contact
@endsection

@section('content')
	<!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center pb-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Contactez-nous</h1>
                   
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
                    <h6 class="section-title text-center text-primary text-uppercase">Contact</h6>
                    <h1 class="mb-5"><span class="text-primary text-uppercase">Formulaire</span> Pour toute quesiton</h1>
                </div>
                <div class="row g-4">
                   
                    <div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
                        <iframe class="position-relative rounded w-100 h-100"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.345470495619!2d-3.995221225466381!3d5.36415803554995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfc1eb5ea181fe97%3A0x5a9d7c8a725a0509!2s9274%2BJXF%202%20plateaux%20Vallons%2C%20J%2075%2C%20Abidjan!5e0!3m2!1sfr!2sci!4v1712751212601!5m2!1sfr!2sci"
                            frameborder="0" style="min-height: 350px; border:0;" allowfullscreen="" aria-hidden="false"
                            tabindex="0"></iframe>
                            
                    </div>
                    <div class="col-md-6">
                        <div class="wow fadeInUp" data-wow-delay="0.2s">
                            <form action="contact" method="post">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" placeholder="Your Name" onkeyup="this.value=this.value.toUpperCase()" name="name" required>
                                            <label for="name">Votre Nom</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" placeholder="Your Email" name="email" onkeyup="this.value=this.value.toLowerCase()" required>
                                            <label for="email">Votre Email</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="subject" placeholder="Subject" name="subject" required>
                                            <label for="subject">Subjet</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a message here" id="message" style="height: 150px" name="msg" required></textarea>
                                            <label for="message">Message</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit">Envoyer</button>
                                    </div>
                                    <p>
                                       
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->
@endsection