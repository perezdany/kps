<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\AppartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepensesController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//ROUTE DU SITE POUR LES VISITEURS
Route::view('/', 'welcome')->name('home');

Route::view('/welcome', 'welcome')->name('home');

//CONNEXION A L'ESPACE CLIENT 
Route::view('customer_login', 'customer/customer_login')->name('login');


//a propos
Route::view('about', 'about');

//contact
Route::view('contact', 'contact');

//route pour contact
Route::get('contact', function () {
    return view('contact');
});

Route::post('contact', [UserController::class, 'ContactUs']);


//services
Route::get('services', function () {
    return view('services');
});

//appartements
Route::get('appartements', function () {
    return view('appartements');
});

//newsletter 
Route::post('newsletter', [UserController::class, 'Newsletter']);
Route::get('/unsuscribe/{id}/{mail}', [UserController::class, 'Unsuscribe']);

//VALIDATION DU COMPTE
Route::get('/confirm/{id_client}/{token}', [UserController::class, 'confirm']);


/*---------*/

//ESPACE CLIENT

/*---------*/
Route::middleware(['guest:web'])->group(function(){

   //CONNEXION A L'ESPACE CLIENT 

   Route::view('customer_login', 'customer/customer_login')->name('login');
   Route::post('customerLogin', [AuthController::class, 'UserLogin']);

    Route::get('customer_register', function () {
        return view('customer/customer_register');
    });

    //route::get('/user', [UserController::class, 'index']);

    Route::post('customer_register', [UserController::class, 'CustomerRegister']);

    //Route::get('my_space', [UserController::class, 'my_space'])->name('myspace');

    //DECONNEXION DE L'UTILSATEUR
    Route::get('/logout', [AuthController::class, 'logoutUser']);

    /*Route::get('my_space', function(){
        
        
    });*/

    
    
    /*@component('mail::message')
    # {{ $data['subject'] }}
        
    {{ $data['message'] }}

    @endcomponent

    Cordialement,<br>
    {{ $data['email'] }}
    @endcomponent*/

    // Route ajouter au panier
    Route::post('add_cart', [CartController::class, 'store']);

    //Vider le panier
    Route::get('viderpanier/{rowid}', [CartController::class, 'empty']);

    //mon panier
    Route::get('my_cart', [CartController::class, 'index']);

    //supprimer un élément du panier
    Route::get('my_cart/deleteItem/{rowid}', [CartController::class, 'destroy']);

    //formulaire de réservation
    Route::post('reservation_form', function () {
        return view('customer/reservation_form');
    });

    //les traitements des réservation
    Route::get('reservation_form', function () {
        return view('customer/reservation_form');
    });

    //FORMULAIRE DE RESERVATION
    Route::post('submit/reservation_form', [ReservationController::class, 'AddReservation']);

    //SUPPRIMER UNE RESERVATION
    Route::get('delete/reservation/{id_reservation}', [ReservationController::class, 'DeleteMyReservation']);

    //FORMULAIRE DE MODIFICATION
    Route::get('edit_reservation', function () {
        return view('customer/edit_reservation');
    });

    //MODIFIER MA RESERVATION
    Route::post('edit_reservation/edit', [ReservationController::class, 'editMyReservation']);


    //Test
    Route::get('test', function () {
        return view('customer/test');
    });

});

Route::middleware(['auth:web'])->group(function(){

    //CONNEXION A L'ESPACE CLIENT
    //Route::post('customerLogin', [AuthController::class, 'UserLogin']);

    //Route::get('customer_login', [UserController::class, 'loginclient'])->name('connexion'); //route sur le formulaire de connexion

    Route::get('my_space', [UserController::class, 'my_space'])->name('myspace');

    //DECONNEXION DE L'UTILISATEUR
    Route::get('/logout', [AuthController::class, 'logoutUser']);

    /*Route::get('my_space', function(){
        
        
    });*/

    
    /*@component('mail::message')
    # {{ $data['subject'] }}
        
    {{ $data['message'] }}

    @endcomponent

    Cordialement,<br>
    {{ $data['email'] }}
    @endcomponent*/

    // Route ajouter au panier
    Route::post('add_cart', [CartController::class, 'store']);

    //Vider le panier
    Route::get('viderpanier/{rowid}', [CartController::class, 'empty']);

    //mon panier
    Route::get('my_cart', [CartController::class, 'index']);

    //supprimer un élément du panier
    Route::get('my_cart/deleteItem/{rowid}/{email}', [CartController::class, 'destroy']);

   //formulaire de réservation
    Route::post('reservation_form', function () {
        return view('customer/reservation_form');
    });
    
    //les traitements des réservation
    Route::get('reservation_form', function () {
        return view('customer/reservation_form');
    });

    //FORMULAIRE DE RESERVATION
    Route::post('submit/reservation_form', [ReservationController::class, 'AddReservation']);

    //SUPPRIMER UNE RESERVATION
    Route::get('delete/reservation/{id_reservation}', [ReservationController::class, 'DeleteMyReservation']);

    //FORMULAIRE DE MODIFICATION
    Route::get('edit_reservation', function () {
        return view('customer/edit_reservation');
    });

    //MODIFIER MA RESERVATION
    Route::post('edit_reservation/edit', [ReservationController::class, 'editMyReservation']);


    //Test
    Route::get('test', function () {
        return view('customer/test');
    });

});


/*-------*/

//ADMINISTRATION ROUTES

/*--------*/

Route::middleware(['auth:admin'])->group(function(){

    //TABLEAU DE BORD
    Route::get('dashboard', [UserController::class, 'myDash'])->name('mydash');

    //ENNREGISTRER UN UTILISATEUR
    Route::get('register_user', function () {
        return view('admin/register_user');
    });

    Route::post('register_user', [UserController::class, 'RegisterUser']);

   
    //LES RESERVATIONS
    Route::get('reservations', function () {
        return view('admin/reservations');
    });

    //RESERVATION EN COURS
    Route::get('pool_reserv', function () {
        return view('admin/in_progress_reservation');
    });

    //GESTION DES APPARTEMENTS
    Route::get('appartements_gest', function () {
        return view('admin/appartements_gest');
    });

    //LES CLIENTS
    Route::get('customers', function () {
        return view('admin/customers');
    });

    //LES UTILISATEURS ADMIN
    Route::get('users', function () {
        return view('admin/users');
    });

    //MODIFICATION D'UTILISATEUR ADMIN
    Route::post('edit_admin_form', [UserController::class, 'EditAdminForm']);
    Route::post('edit_admin', [UserController::class, 'EditAdmin']);
    //MODIFIER SON MOT DE PASSE£
    Route::post('edit_admin_pass', [UserController::class, 'EditAdminPassword']);

    //LES DEPARTEMENTS
    Route::get('departements', function () {
        return view('admin/departements');
    });

    Route::get('add_departement', function () {
        return view('admin/add_departement');
    });

    Route::post('add_departement', [DepartementController::class, 'AddDepartement']);
    
    //AJOUT D'UN CLIENT
    Route::get('add_customer', function () {
        return view('admin/add_customer');
    });

    //MODIFICATION D'UN COMPTE CLIENT
    Route::post('edit_customer_form', [UserController::class, 'EditCustomerForm']);

    Route::post('add_customer', [UserController::class, 'AddCustomer']);

    Route::post('edit_customer', [UserController::class, 'EditCustomerAccount']);

    //MODIFIER SON MOT DE PASSE
    Route::post('edit_customer_pass', [UserController::class, 'EditCustomerPass']);

    //AJOUT D'UNE RESERVATION
    Route::get('save_reservation', function () {
        return view('admin/save_reservation');
    });

    //FORMULAIRE DE RESERVATION A MODIFIER ET MODIFICATION
    Route::post('edit_reserv_form', [ReservationController::class, 'EditReservationForm']);
    Route::post('edit_the_reservation', [ReservationController::class, 'AdminEditReservation']);

    Route::post('save_reservation', [ReservationController::class, 'SaveReservation']);

    //AJOUT D'UN APPARTEMENT
    Route::get('add_appart', function () {
        return view('admin/add_appart');
    });

    //MODIFIER UN APPARTEMENT
    Route::post('edit_appart_form', [AppartController::class, 'EditAppartForm']);
    Route::post('edit_appart', [AppartController::class, 'EditAppart']);

    Route::post('add_appart', [AppartController::class, 'AddAppart']);

    //Deconnexion de l'administrateur
    Route::get('logoutAdmin', [AuthController::class, 'logoutAdmin']);

    //valider la réservation

    Route::post('validate', [ReservationController::class, 'ValidateReservation']);

    //supprimer la reservation

    Route::post('deleteReservation', [ReservationController::class, 'ReservationCancel']);

    //supprimer l'appartement

    Route::post('deleteappart', [AppartController::class, 'DeleteAppart']);

    //supprimer un client 
    Route::post('deleteCustomer', [UserController::class, 'DeleteCustomer']);

    //supprimer un utilisateur
    Route::post('deleteuser', [UserController::class, 'DeleteUser']);

    //supprimer un département
    Route::post('deletedepartement', [DepartementController::class, 'DeleteDepartement']);

    //modifier le département
    Route::post('edit_departements', function () {
        return view('admin/edit_departements');
    });

    Route::post('update_departement', [DepartementController::class, 'UpdateDepartement']);

    //LES DEPENSES
    Route::get('depenses', function(){
        return view('admin/depenses');
    });

    //AJOUTER DES DEPENSES
    Route::get('add_depense_form', function(){
        return view('admin/add_depense_form');
    });
    
    Route::post('add_depense', [DepensesController::class, 'SaveDepense']);

    //SUPPRIMER LA DEPENSE
    Route::post('deletedepense', [DepensesController::class, 'DeleteDepense']);

    //MODIFIER UNE DEPENSE
    Route::post('edit_depense_form', [DepensesController::class, 'edit_depense_form']);
    Route::post('edit_depense', [DepensesController::class, 'editDepense']);

    //LES INFOS D'UN APPARTEMENT
    Route::post('about_appart', [AppartController::class, 'DetailsAppartView']);


});

Route::middleware(['guest:admin'])->group(function(){
    
    //ESPACE DE CONNEXION ADMIN
    Route::get('login_admin', [UserController::class, 'loginAdminView'])->name('loginAdmin');

    //CONNEXION A L'ESPACE ADMIN
    Route::post('login_admin', [AuthController::class, 'AdminLogin']);

    //TABLEAU DE BORD
    //Route::get('dashboard', [UserController::class, 'myDash'])->name('mydash');
   /*
    Route::get('register_user', function () {
        return view('admin/register_user');
    });

    Route::post('register_user', [UserController::class, 'RegisterUser']);
 

    Route::get('reservations', function () {
        return view('admin/reservations');
    });

    Route::get('pool_reserv', function () {
        return view('admin/in_progress_reservation');
    });

    Route::get('appartements_gest', function () {
        return view('admin/appartements_gest');
    });

    Route::get('customers', function () {
        return view('admin/customers');
    });

    Route::get('users', function () {
        return view('admin/users');
    });

    Route::get('departements', function () {
        return view('admin/departements');
    });

    Route::get('add_departement', function () {
        return view('admin/add_departement');
    });

    Route::post('add_departement', [DepartementController::class, 'AddDepartement']);

    Route::get('add_customer', function () {
        return view('admin/add_customer');
    });

    Route::post('add_customer', [UserController::class, 'AddCustomer']);

    Route::get('save_reservation', function () {
        return view('admin/save_reservation');
    });

    Route::post('save_reservation', [ReservationController::class, 'SaveReservation']);

    Route::get('add_appart', function () {
        return view('admin/add_appart');
    });

    Route::post('add_appart', [AppartController::class, 'AddAppart']);

    //Deconnexion de l'administrateur
    //Route::get('logoutAdmin', [AuthController::class, 'logoutAdmin']);

    //valider la réservation

    Route::post('validate', [ReservationController::class, 'ValidateReservation']);

    //supprimer la reservation

    Route::post('deleteReservation', [ReservationController::class, 'ReservationCancel']);

    //supprimer l'appartement

    Route::post('deleteappart', [AppartController::class, 'DeleteAppart']);

    //supprimer un client 
    Route::post('deleteCustomer', [UserController::class, 'DeleteCustomer']);

    //supprimer un utilisateur
    Route::post('deleteuser', [UserController::class, 'DeleteUser']);

    //supprimer un département
    Route::post('deletedepartement', [DepartementController::class, 'DeleteDepartement']);

    //modifier le département
    Route::post('edit_departements', function () {
        return view('admin/edit_departements');
    });

    Route::post('update_departement', [DepartementController::class, 'UpdateDepartement']);
    */
});

?>
