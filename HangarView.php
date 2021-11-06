<?php
namespace hangarapp\view;

use mf\router\Router as Router;
use hangarapp\model\Categorie as Categorie;
use hangarapp\model\Commande as Commande;
use hangarapp\model\Gerant as Gerant;
use hangarapp\model\Panier as Panier;
use hangarapp\model\Producteur as Producteur;
use hangarapp\model\Produit as Produit;
use hangarapp\view\HangarView as HangarView;
use mf\view\AbstractView as AbstractView ;

class HangarView extends AbstractView
{


    public function __construct( $data )
    {
        parent::__construct($data);
    }


    private function renderHeader()
    {
        return "<div class=\"main_container\"><h1>Le Hangar</h1>%%NAV%%";
    }


    private function renderFooter()
    {
        return "</div>";
    }


    private function renderNav()
    {
        $route = new Router();
        $link_panier =$route->urlFor('panier');
        $link_login =$route->urlFor('home');
        $link_register =$route->urlFor('home');

        $link_form =$route->urlFor('home');

        $nav = "<div class=\"nav_bar\">
    <div id=\"btn_panier\">
        <a href=".$link_panier.">🛒</a>
    </div>
    <div id=\"btn_connexion\">
        <a href=".$link_form.">👤</a>
    </div></div>";
        return $nav;
    }
///---------------- CODE À COPIER --------------------------------------------------------------------------------------------
    private function renderCommande()
    {
      $displayTweets = "<div class= 'commande'> ".
                        "<div id = 'commande'>".
                            "<form action='/laouer/Atelier1/main.php/finalisation/' method='post'>".
                              "<label id='lb' for = 'nom'> Nom : </label>".
                              "<input type = 'text' id = 'entree' name = 'nom' required minlenght ='1' placeholder = 'Dupont'>".

                              "<br>".

                              "<label id='lb' for = 'mail'> Mail : </label>".
                              "<input type = 'text' id = 'entree' name = 'mail' required minlenght ='1' placeholder = 'djean52@mail.fr'>".

                              "<br>".

                              "<label id='lb' for = 'num'> Numéro de téléphone : </label>".
                              "<input type = 'text' id = 'entree' name = 'num' required minlenght =10 maxlenght =10 placeholder = '0641875963'>".

                              "<br>".
                              "<div id = 'bouton'>".
                                "<input type = 'checkbox' name='check' required> Je confirme que je me rendrais sur le lieu de livraison et que je remettrais la somme due dans le but d'obtenir mes produits.".

                                "<br>".

                                "<input type='submit' name = 'btncommand' value = 'valider'>".
                              "</div>".
                            "</form>".
                         "</div>".
                        "</div>";
      return $displayTweets;
    }

    private  function renderFinalisation()
    {
      $displayTweets = "<div class= 'commande'> ".
                          "<div id = 'valid'>".
                              "Votre commande a bien été enregistrée!".
                              "</br>".
                              "<a href= '/laouer/Atelier1/main.php/home'>Retourner au menu</a>".
                           "</div>".
                        "</div>";

      return $displayTweets;
    }
///-------------------------------------------------------------------------------------------
    /* Méthode renderHome
     *
     *
     *
     */

    private function renderTest()
    {



    }



    /* Méthode renderViewTweet
     *
     * Réalise la vue de la fonctionnalité affichage d'un tweet
     *
     */

    private function renderHome()
    {
      $produits = $this->data["produit"];
              $categories = $this->data["categorie"];
              $displayProduits= "";
              $displayProduits .= "<form action=\"/laouer/Atelier1/main.php/home/\" method=\"POST\"><div class=\"container_produit\">";

              foreach ($categories as $categorie)
              {
                  $displayProduits .= "<div class=\"container_categorie\">";
                  $displayProduits .= "<h1>$categorie->Nom</h1>";

              foreach ($produits as $produit)
              {
                  if ($produit->Id_Categorie == $categorie->Id)
                  {

                  $displayProduits .= "<div class=\"list_produit\">
                  $produit->Nom
              <div class=\"info_produit\">
                  <div class=\"cell_produit\">
                          <img class=\"photo_produit\" src=\"/localhost/laouer/Atelier1/html/img/$produit->Photo\" alt=\"Image of $produit->Nom\">
                      </div>
                      <div class=\"cell_produit\">
                          <ul>
                              <li>Info: $produit->Description</li>
                              <li>Prix/Unité : $produit->Tarif_Unitaire</li>
                              <li><input style=\"display:none\" type=\"text\" value=\"$produit->Id\" name=\"valueOf$produit->Id\"></li>
                              <li><input style=\"display:none\" type=\"text\" value=\"$produit->Tarif_Unitaire\" name=\"PriceOf$produit->Id\"></li>
                              <li><input type=\"number\" value=\"0\" name=\"$produit->Id\"></li>
                              <li><input type=\"submit\"value=\"ADD\"></li>
                          </ul>
                      </div>
              </div>
          </div>\n";

                  }
              }
              $displayProduits .= "</div>";
              }
              $displayProduits .= "</div>";

              return $displayProduits;
    }






    /* Méthode renderBody
     *
     * Retourne la framgment HTML de la balise <body> elle est appelée
     * par la méthode héritée render.
     *
     */

    public function renderBody($selector)
    {

        /*
         * voire la classe AbstractView
         */

        $header = $this->renderHeader();
        $navBar = "";
        $center = "";
        $footer = $this->renderFooter();

        // variable $$ au lieu du case ??
        switch ($selector) {
            case 'renderHome':
                $navBar = $this->renderNav();
                $center = $this->renderHome();
                break;

            case 'renderTest':
                $navBar = $this->renderNav();
                $center = $this->renderTest();
                break;
//-----------CODE À COPIER -----------------------------------------------------------
            case 'renderCommande':
                $center = $this->renderCommande();
                $navBar = $this->renderNav();
                break;

            case 'renderFinalisation':
                $center = $this->renderFinalisation();
                $navBar = $this->renderNav();
                break;
//----------------------------------------------------------------------------------
            default:
                $center = "Pas de fonction view correspondante";
                break;
        }


$body = <<<EOT
${header}
${center}
${footer}
EOT;

        return str_replace("%%NAV%%", $navBar, $body);

    }

}
