<?php
namespace hangarapp\model;

class Panier extends \Illuminate\Database\Eloquent\Model
{

  protected $table      = 'panier';
  protected $primaryKey = 'id';
  public    $incrementing = false;
  public    $timestamps = false;

  public function ajoutPanier($produit,$qte)//Produit = id_Produit, Commande = Id_Commande, qte = Quantite.
  {//Fonction pour ajouter au panier.
    $idcommande = Commande::select('Id')->orderBy('Id','desc');
    $idcommande = $idcommande->first();
    $p = new Panier();
    $p->id_produit = $produit;
    $p->id_Commande = $idcommande->Id;
    $p->Quantite = $qte;
    $p->save();
  }

  public function supprimePanier($produit,$commande)//Produit = Id_Produit, Commande = Id_Commande.
  {//Supprime un produit du panier.
   $requete = Panier::where('id_Commande','=', $commande)->where('id_Produit','=', $produit)->delete();
  }

  public function modifiePanier($produit,$commande,$qte)//Produit = id_Produit, Commande = Id_Commande, qte = Quantite.
  {//Modifie la quantité d'un produit.
    $requete = Panier::where('id_Commande' ,'=', $commande)->where('id_Produit' ,'=', $produit)->update(['Quantite'=>$qte]);
  }

  public function viderPanier($commande)//Commande correspond à l'Id_Commande.
  {//Vide le panier.
    $requete = Panier::where('id_Commande','=', $commande)->delete();
  }

  public function affichage($user) //user correspond à l'id_Commande.
  {//Fonction pour afficher le nom du produit, le tarif à l'unité ainsi que la quantité commandée.
    $resultat = "<ul>";
    $requete = Panier::select('produit.Nom', 'panier.Quantite', 'produit.Tarif_Unitaire')->leftJoin('produit','produit.Id','=','panier.Id_produit')->leftJoin('commande','panier.Id_Commande','=','commande.Id')->where('commande.Etat','=',1)->where('Id_commande','=',$user);
    $lignes = $requete->get();
    $total = 0;
    foreach ($lignes as $p)
    {
      $prix = ($p->Tarif_Unitaire * $p->Quantite);
      $qte = $p->Quantite;
      $resultat .= "<li>Produit : $p->Nom  / Prix unitaire : $p->Tarif_Unitaire €   <input type =number id =commande value=$qte></input> Total : $prix €</li>";
      $total+= $prix;
    }
    echo $resultat.="</ul>";
    echo "Total : ".$total."€";
  }
}