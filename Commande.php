<?php
namespace hangarapp\model;

class Commande extends \Illuminate\Database\Eloquent\Model{
    protected $table      = 'commande';  /* le nom de la table */
    protected $primaryKey = 'Id';     /* le nom de la clé primaire */
    public    $timestamps = false;
    
    public function afficheCommande(){
        $html = "<ul>";
        $requete = Commande::select();
        $lignes = $requete->get();
        foreach ($lignes as $c){  
            $html.= "<li>Identifiant = $c->Id, Nom = $c->Nom_client, Mail= $c->Mail_client, Montant = $c->Montant, Tel = $c->Tel_client, Etat = $c->Etat</li>\n" ;
        }
      echo $html;
    }

    public function ajouterCommande($nom, $mail, $montant, $tel)
  {
    $c = new Commande();
    $c->Nom_client = $nom;
    $c->Mail_Client = $mail;
    $c->Montant = $montant;
    $c->Tel_client = $tel;
    $c->Etat = 1;
    $c->save();
  }
    public function modifMailClient($id, $mail){
        $requete = Commande::where('Id' ,'=', $id)->update(['Mail_client'=>$mail]);
    }

    public function modifTelClient($id, $tel){
        $requete = Commande::where('Id' ,'=', $id)->update(['Tel_client'=>$tel]);
    }

    public function modifEtat($id, $etat){
        $requete = Commande::where('Id' ,'=', $id)->update(['Etat'=>$etat]);
    }

    public function supprimerCommande($id)
    {
     $requete = Commande::where('Id','=', $id)->delete();
    }
}