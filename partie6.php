<?php
class Personne {
    protected string $nom;
    protected string $prenom;
    protected string $dateNaissance;

    public function __construct(string $nom, string $prenom, string $dateNaissance) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
    }

    protected function getAge(): int {
        $naissance = new DateTime($this->dateNaissance);
        $aujourdhui = new DateTime();
        return $naissance->diff($aujourdhui)->y;
    }

    public function __toString(): string {
        return $this->prenom . " " . $this->nom . " (" . $this->getAge() . " ans)";
    }
}

class Etudiant extends Personne {
    private string $cne;

    public function __construct(string $nom, string $prenom, string $dateNaissance, string $cne) {
        parent::__construct($nom, $prenom, $dateNaissance);
        $this->cne = $cne;
    }

    public function getCne(): string {
        return $this->cne;
    }

    public function __toString(): string {
        return parent::__toString() . " - CNE: " . $this->cne;
    }
}

// Tests de la Partie 6 (Tableau de 5 étudiants)
$etudiants = [
    new Etudiant("Alami", "Youssef", "2001-02-10", "S130012345"),
    new Etudiant("Benjelloun", "Fatima", "2002-06-22", "S140067890"),
    new Etudiant("Tazi", "Omar", "2000-11-15", "S130098765"),
    new Etudiant("Chraibi", "Salma", "2003-01-05", "S150011223"),
    new Etudiant("Idrissi", "Mehdi", "2001-09-30", "S130044556")
];

foreach ($etudiants as $e) {
    echo $e . PHP_EOL;
}
// i have to do each part test each class test organized. 