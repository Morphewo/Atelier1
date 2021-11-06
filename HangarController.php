<?php

namespace hangarapp\control;

use mf\utils\HttpRequest as HttpRequest;
use mf\router\Router as Router;
use hangarapp\model\Categorie as Categorie;
use hangarapp\model\Commande as Commande;
use hangarapp\model\Gerant as Gerant;
use hangarapp\model\Panier as Panier;
use hangarapp\model\Producteur as Producteur;
use hangarapp\model\Produit as Produit;
use hangarapp\view\HangarView as HangarView;

/* Classe HangarController :
 *
 * Réalise les algorithmes des fonctionnalités suivantes:
 *
 *  - afficher la liste des Tweets
 *  - afficher un Tweet
 *  - afficher les tweet d'un utilisateur
 *  - afficher la le formulaire pour poster un Tweet
 *  - afficher la liste des utilisateurs suivis
 *  - évaluer un Tweet
 *  - suivre un utilisateur
 *
 */

class HangarController extends \mf\control\AbstractController {


    /* Constructeur :
     *
     * Appelle le constructeur parent
     *
     * c.f. la classe \mf\control\AbstractController
     *
     */

    public function __construct()
    {
        parent::__construct();
    }


    /* Méthode viewHome :
     *
     * Réalise la fonctionnalité : afficher la liste de Tweet
     *
     */

     public function viewHome(){

       if (isset($_POST))
     {
     $info = array();
     $info_cookie = array();
     $a="";
     $b="";
     $c="";
     $tic = 0;
     foreach ($_POST as $data)
     {
         $c = $b;
         $b = $a;
         $a = $data;
         if (($a != 0) && ($tic == 2))
         {
             var_dump("coucou");
             $info_cookie[] = array("id"=>$c,"qte"=>$b, "prix"=>$a);
         }
         $tic += 1;
         if ($tic >= 3)
         {
             $tic = 0;
         }
     }
     if (isset($_COOKIE["Panier"]))
     {
          setcookie("Panier", substr($_COOKIE["Panier"], 0, -1).(ltrim(json_encode($info_cookie), '[')),"",'/');
     }
     else
     {
     setcookie("Panier", json_encode($info_cookie),"",'/');
     }
     }
     $info["produit"] = Produit::select('*')->orderBy('Id_Categorie')->orderBy('nom')->get();
     $info["categorie"] = Categorie::select('*')->orderBy('nom')->get();
     $vueProduit = new HangarView($info);
     echo $vueProduit->render('renderHome');
     }

     public function viewTest(){

     }

///------------ CODE À COPIER--------------------------------------------------------------------------
     public function viewCommande(){

         $produit = Produit::all();
         $vueProduit = new HangarView($produit);
         // echo $vueTweets->renderHome();
         echo $vueProduit->render('renderCommande');

     }

     public function viewValid(){

         $produit = Produit::all();
         $montant = 0;
         $panier = json_decode($_COOKIE['Panier']);

         foreach($panier as $prod)
         {
           echo $panier['prix'];
           $montant += $prod['prix'] * $prod['qte'];
         }

         $c = new Commande();//ajout de la commande
         $c->Nom_client = isset($_POST['nom']) && !empty($_POST['nom']) ? $_POST['nom'] : null;
         $c->Mail_client = isset($_POST['mail']) && !empty($_POST['mail']) ? $_POST['mail'] : null;
         $c->Montant = $montant;
         $c->Tel_client = isset($_POST['num']) && !empty($_POST['num']) ? $_POST['num'] : null;
         $c->Etat = 1;
         $c->save();


         $idcommande = Commande::select('MAX(Id)');

         foreach($panier as $paniers)
         {
           $p = new Panier();
           $p->Id_Produit = isset($paniers['id']) && !empty($paniers['id']) ? $paniers['id'] : null;
           $p->Id_Commande = $idcommande;
           $p->Quantite =isset($paniers['qte']) && !empty($paniers['qte']) ? $paniers['qte'] : null;
           $p->save();
         }

         $vueProduit = new HangarView($produit);
         echo $vueProduit->render('renderFinalisation');

     }
///--------------------------------------------------------------------------------------------------
}
