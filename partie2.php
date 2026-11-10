<?php

// 2.1.b Promotion de propriétés (PHP 8) :
class Voiture {
    public function __construct(
        public string $couleur = "Blanche",
        public int $vitesse = 0
    ) {}

    public function afficher(): void {
        echo "Couleur : {$this->couleur} | Vitesse : {$this->vitesse} km/h" . PHP_EOL;
    }
}


// Exemple pour la classe Personne (2.2.b, 2.2.c et 2.3.d) :
class Personne {
    public string $nom;
    public string $prenom;

    // 2.2.b Solution avec un seul constructeur : 
    public function __construct(string $nom = "", string $prenom = "") {
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    // 2.2.c Bonus (Named constructor / Méthode statique de fabrique) :
    public static function depuisTableau(array $data): self {
        return new self($data['nom'] ?? '', $data['prenom'] ?? '');
    }

    // 2.3.d Destructeur dans Personne : 
    public function __destruct() {
        echo "Détruire " . __CLASS__ . PHP_EOL;
    }
}

// Petit test .
$v = new Voiture("Rouge", 60);
$v->afficher();

$p = Personne::depuisTableau(['nom' => 'Hachimi', 'prenom' => 'Sara']);
echo "Personne créée : {$p->prenom} {$p->nom}" . PHP_EOL;