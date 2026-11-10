<?php
class Voiture {
    public $marque;
    public $couleur; // 0.2- on Ajout de la propriété couleur

    public function setMarque($m) {
        $this->marque = $m;
    }

    public function setCouleur($c) { // 0.2 - on  Ajout de la méthode setCouleur
        $this->couleur = $c;
    }

    public function afficher() {
        echo "Marque : " . $this->marque . " | Couleur : " . ($this->couleur ?? 'Non définie') . PHP_EOL;
    }
}

// 0.1 : Premier objet $v1
$v1 = new Voiture();
$v1->setMarque("Toyota");
$v1->setCouleur("Grise");
$v1->afficher();

// 0.1 : Second objet $v2 de marque "Renault"
$v2 = new Voiture();
$v2->setMarque("Renault");
$v2->setCouleur("Bleue");
$v2->afficher();