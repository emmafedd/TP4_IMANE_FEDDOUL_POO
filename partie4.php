<?php
class Personne {
    private string $nom;
    private string $prenom;
    private string $dateNaissance;

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

// Tests de la Partie 4
$p = new Personne("Hachimi", "Sara", "2000-05-14");
echo $p . PHP_EOL; // Utilise directement l'objet avec echo grâce à __toString()