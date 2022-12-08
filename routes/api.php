<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LotController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\InventaireController;
use App\Http\Controllers\MedicamentController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\DetailsVenteController;
use App\Http\Controllers\DetailsFactureController;
use App\Http\Controllers\DetailsCommandeController;
use App\Http\Controllers\DetailsInventaireController;
use App\Http\Controllers\ParametrageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//_______________________ Routes publiques ___________________________

Route::post('user/login', [AuthController::class, 'login']); //connexion
//_______________________ FIN Routes publiques ___________________________


//_______________________ Routes protégées ___________________________

//route protégée
Route::group(['middleware' => ['auth:sanctum']], function () {

    //_________________________ PROFIL _________________________________________

    Route::get('profil/liste', [ProfilController::class, 'getAllProfils']); //liste profils

    Route::get('profil/{id}', [ProfilController::class, 'getProfilById']); //view d'un profil

    Route::post('profil/ajout', [ProfilController::class, 'addProfil']); //ajout profil

    Route::put('profil/modifier/{id}', [ProfilController::class, 'updateProfil']); //modifier profil

    Route::delete('profil/supprimer/{id}', [ProfilController::class, 'deleteProfil']); //supprimer profil

    Route::get('profil/rechercher/{nomProfil}', [ProfilController::class, 'searchProfil']); //rechercher profil

    //_________________________ FIN PROFIL _____________________________________

    //_________________________ USER _________________________________________

    Route::get('user/liste', [UserController::class, 'getAllUsers']); //liste users

    Route::get('user/{id}', [UserController::class, 'getUserById']); //view d'un user

    Route::post('user/ajout', [AuthController::class, 'register']); //ajout user

    Route::put('user/modifier/{id}', [UserController::class, 'updateUser']); //modifier user

    Route::delete('user/supprimer/{id}', [UserController::class, 'deleteUser']); //supprimer user

    Route::get('user/rechercher/{name}', [UserController::class, 'searchUser']); //rechercher user

    Route::post('user/logout', [AuthController::class, 'logout']); //deconnexion

    Route::get('user', [AuthController::class, 'getUser']); //getUserConnect

    Route::get('vendeurs', [UserController::class, 'getUserVendeur']); //Liste des user avec profil vendeur

    Route::post('crypterMdp', [AuthController::class, 'crypterPassword']); //cryper les mdp

    Route::get('existenceEmail/{email}', [UserController::class, 'verifierExistenceEmail']);

    Route::get('usercount', [UserController::class, 'getCountUser']);

    //_________________________ FIN USER _____________________________________

    //_________________________ Fournisseur _____________________________________

    Route::get('fournisseurs/liste', [FournisseurController::class, 'getAllFournisseurs']); //liste Fournisseur

    Route::get('fournisseur/{id}', [FournisseurController::class, 'getFournisseurById']); //view d'un Fournisseur

    Route::post('fournisseur/ajout', [FournisseurController::class, 'addFournisseur']); //ajout Fournisseur

    Route::put('fournisseur/modifier/{id}', [FournisseurController::class, 'updateFournisseur']); //modifier Fournisseur

    Route::delete('fournisseur/supprimer/{id}', [FournisseurController::class, 'deleteFournisseur']); //supprimer Fournisseur

    Route::get('fournisseur/rechercher/{nomfournisseur}', [FournisseurController::class, 'searchFournisseur']); //rechercher Fournisseur

    Route::get('verifierExistenceFournisseur/{nom}', [FournisseurController::class, 'verifierExistence']);

    Route::get('fournisseurcount', [FournisseurController::class, 'getCountFournisseur']);

    //_________________________ Fin Fournisseur__________________________________

    //_________________________ FACTURE _________________________________________

    Route::get('facture/liste', [FactureController::class, 'getAllFactures']); //liste facture

    Route::get('facture/{id}', [FactureController::class, 'getFactureById']); //view d'une facture

    Route::post('facture/ajout', [FactureController::class, 'addFacture']); //ajout facture

    Route::put('facture/modifier/{id}', [FactureController::class, 'updateFacture']); //modifier facture

    Route::delete('facture/supprimer/{id}', [FactureController::class, 'deleteFacture']); //supprimer facture

    Route::get('facture/rechercher/{numFacture}', [FactureController::class, 'searchFacture']); //rechercher facture

    Route::get('facture/numero', [FactureController::class, 'searchFacture']); //rechercher facture

    //_________________________ FIN FACTURE _____________________________________

    //_________________________ COMMANDE _________________________________________

    Route::get('commande/liste', [CommandeController::class, 'getAllCommandes']); //liste commande

    Route::get('commande/{id}', [CommandeController::class, 'getCommandeById']); //view d'une commande

    Route::post('commande/ajout', [CommandeController::class, 'addCommande']); //ajout commande

    Route::put('commande/modifier/{id}', [CommandeController::class, 'updateCommande']); //modifier commande

    Route::delete('commande/supprimer/{id}', [CommandeController::class, 'deleteCommande']); //supprimer commande

    Route::get('commande/rechercher/{numCommande}', [CommandeController::class, 'searchCommande']); //rechercher commande

    Route::post('filtrer/commande', [CommandeController::class, 'getFilterCommande']);

    //_________________________ FIN COMMANDE _____________________________________

    //_________________________ INVENTAIRE _________________________________________

    Route::get('inventaire/liste', [InventaireController::class, 'getAllInventaires']); //liste inventaire

    Route::get('inventaire/{id}', [InventaireController::class, 'getInventaireById']); //view d'un inventaire

    Route::post('inventaire/ajout', [InventaireController::class, 'addInventaire']); //ajout inventaire

    Route::put('inventaire/modifier/{id}', [InventaireController::class, 'updateInventaire']); //modifier inventaire

    Route::delete('inventaire/supprimer/{id}', [InventaireController::class, 'deleteInventaire']); //supprimer inventaire

    Route::get('inventaire/rechercher/{numInventaire}', [InventaireController::class, 'searchInventaire']); //rechercher inventaire

    Route::post('inventaire', [InventaireController::class, 'getDataInventaire']);

    //_________________________ FIN INVENTAIRE _____________________________________

    //_________________________ PARAMETRAGE _________________________________________

    Route::get('numeroLot', [ParametrageController::class, 'getNumLot']);

    Route::get('numeroFacture', [ParametrageController::class, 'getNumfacture']);

    Route::get('numeroCommande', [ParametrageController::class, 'getNumCommande']);

    Route::get('numeroVente', [ParametrageController::class, 'getNumVente']);

    Route::get('numeroInventaire', [ParametrageController::class, 'getNumInventaire']);

    Route::get('numeroMedicament', [ParametrageController::class, 'getNumMedicament']);

    //_________________________ FIN PARAMETRAGE _____________________________________

    //_________________________ VENTE _________________________________________

    Route::get('vente/liste', [VenteController::class, 'getAllVentes']); //liste ventes

    Route::get('vente/{id}', [VenteController::class, 'getVenteById']); //view d'une vente

    Route::post('vente/ajout', [VenteController::class, 'addVente']); //ajout vente

    Route::put('vente/modifier/{id}', [VenteController::class, 'updateVente']); //modifier vente

    Route::delete('vente/supprimer/{id}', [VenteController::class, 'deleteVente']); //supprimer vente

    Route::get('commande/rechercher/{numVente}', [VenteController::class, 'searchVente']); //rechercher vente

    Route::post('filtrer/vente', [VenteController::class, 'getFilterDateVente']);

    Route::get('ventedujour', [VenteController::class, 'getVenteToDate']);

    //_________________________ FIN VENTE _____________________________________

    //_________________________ MEDICAMENT _________________________________________

    Route::get('medicament/liste', [MedicamentController::class, 'getAllMedicaments']); //liste medicament

    Route::get('medicament/{id}', [MedicamentController::class, 'getMedicamentById']); //view d'un medicament

    Route::get('existenceMedicament/{nomMedi}', [MedicamentController::class, 'verifierExistence']);

    Route::post('medicament/ajout', [MedicamentController::class, 'addMedicament']); //ajout medicament

    Route::put('medicament/modifier/{id}', [MedicamentController::class, 'updateMedicament']); //modifier medicament

    Route::delete('medicament/supprimer/{id}', [MedicamentController::class, 'deleteMedicament']); //supprimer medicament

    Route::get('medicament/forme/{forme}', [MedicamentController::class, 'searchMedicamentForme']); //rechercher medicament

    Route::get('medicament/famille/{famille}', [MedicamentController::class, 'searchMedicamentFamille']); //rechercher medicament

    Route::get('medicamentcount', [MedicamentController::class, 'getCountMedicament']);

    //_________________________ FIN MEDICAMENT _____________________________________

    //_________________________ DETAILS COMMANDE _________________________________________

    Route::get('details_commande/liste', [DetailsCommandeController::class, 'getAllDetailsCommandes']); //liste details_commande

    Route::get('details_commande/{id}', [DetailsCommandeController::class, 'getDetailsCommandeById']); //view d'un details_commande

    Route::post('details_commande/ajout', [DetailsCommandeController::class, 'addDetailsCommande']); //ajout details_commande

    Route::put('details_commande/modifier/{id}', [DetailsCommandeController::class, 'updateDetailsCommande']); //modifier details_commande

    Route::delete('details_commande/supprimer/{id}', [DetailsCommandeController::class, 'deleteDetailsCommande']); //supprimer details_commande

    Route::get('lastCommande', [DetailsCommandeController::class, 'getLastCommande']);
    //_________________________ FIN DETAILS COMMANDE _____________________________________

    //_________________________ LOTS _________________________________________

    Route::get('lot/liste', [LotController::class, 'getAllLots']); //liste lot

    Route::get('lot/{id}', [LotController::class, 'getLotById']); //view d'un lot

    Route::post('lot/ajout', [LotController::class, 'addLot']); //ajout lot

    Route::put('lot/modifier/{id}', [LotController::class, 'updateLot']); //modifier lot

    Route::delete('lot/supprimer/{id}', [LotController::class, 'deleteLot']); //supprimer lot

    Route::get('lot/rechercher/{prixUnitaire}', [LotController::class, 'searchLot']); //rechercher lot

    Route::get('lotValide', [LotController::class, 'getLotNonPeremption']);

    Route::get('lotInvalide', [LotController::class, 'getLotPeremption']);

    Route::get('lotcount', [LotController::class, 'getCountLot']);

    //_________________________ FIN LOTS _____________________________________

    //_________________________ DETAILS FACTURE _________________________________________

    Route::get('details_facture/liste', [DetailsFactureController::class, 'getAllDetailsFactures']); //liste details_facture

    Route::get('details_facture/{id}', [DetailsFactureController::class, 'getDetailsFactureById']); //view d'un details_facture

    Route::post('details_facture/ajout', [DetailsFactureController::class, 'addDetailsFacture']); //ajout details_facture

    Route::put('details_facture/modifier/{id}', [DetailsFactureController::class, 'updateDetailsFacture']); //modifier details_facture

    Route::delete('details_facture/supprimer/{id}', [DetailsFactureController::class, 'deleteDetailsFacture']); //supprimer details_facture

    //_________________________ FIN DETAILS FACTURE _____________________________________

    //_________________________ DETAILS INVENTAIRE _________________________________________

    Route::get('details_inventaire/liste', [DetailsInventaireController::class, 'getAllDetailsInventaires']); //liste details_inventaire

    Route::get('details_inventaire/{id}', [DetailsInventaireController::class, 'getDetailsInventaireById']); //view d'un details_inventaire

    Route::post('details_inventaire/ajout', [DetailsInventaireController::class, 'addDetailsInventaire']); //ajout details_inventaire

    Route::put('details_inventaire/modifier/{id}', [DetailsInventaireController::class, 'updateDetailsInventaire']); //modifier details_inventaire

    Route::delete('details_inventaire/supprimer/{id}', [DetailsInventaireController::class, 'deleteDetailsInventaire']); //supprimer details_inventaire

    //_________________________ FIN DETAILS INVENTAIRE _____________________________________

    //_________________________ DETAILS VENTE _________________________________________

    Route::get('details_vente/liste', [DetailsVenteController::class, 'getAllDetailsVentes']); //liste details_vente

    Route::get('details_vente/{id}', [DetailsVenteController::class, 'getDetailsVenteById']); //view d'un details_vente

    Route::post('details_vente/ajout', [DetailsVenteController::class, 'addDetailsVente']); //ajout details_vente

    Route::put('details_vente/modifier/{id}', [DetailsVenteController::class, 'updateDetailsVente']); //modifier details_vente

    Route::delete('details_vente/supprimer/{id}', [DetailsVenteController::class, 'deleteDetailsVente']); //supprimer details_vente

    Route::get('lastVente', [DetailsVenteController::class, 'getLastVente']);

    //_________________________ FIN DETAILS VENTE _____________________________________


});

//_______________________ End Routes protégées ___________________________