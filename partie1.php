<?php
class Personne {
    //  Attributs publics 
    public string $nom;
    public string $prenom;

    //  Attributs privés
    private string $dateNaissance;  // format "AAAA-MM-JJ"
    private string $villeNaissance; 
    private string $cin; 

    // Constructeur 
    public function __construct(
        string $nom, 
        string $prenom, 
        string $dateNaissance, 
        string $villeNaissance, 
        string $cin
    ) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->villeNaissance = $villeNaissance;
        $this->cin = $cin;
    }

    // Méthode publique 
    public function getName(): string {
        return $this->prenom . " " . $this->nom;
    }

    //Méthode privée 
    private function getAge(): int {
        $naissance = new DateTime($this->dateNaissance);
        $aujourdhui = new DateTime();
        return $naissance->diff($aujourdhui)->y;
    }
}

// Programme de test
$p = new Personne("Hachimi", "Sara", "2000-05-14", "Marrakech", "EE123456");
echo $p->getName() . PHP_EOL;   // Affiche : Sara Hachimi
echo $p->nom . PHP_EOL;         // Affiche : Hachimi