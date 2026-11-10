<?php
class Utilisateur {
    public string $nom;
    public int $age;
    private string $motDePasse;

    public function __construct(string $nom, int $age, string $motDePasse) {
        $this->nom = $nom;
        $this->age = $age;
        $this->motDePasse = $motDePasse;
    }

    // Choisit les données sérialisées
    public function __serialize(): array {
        return [
            'nom' => $this->nom,
            'age' => $this->age,
            // $motDePasse est volontairement exclu pour des raisons de sécurité
        ];
    }

    // Reconstruit l'objet à partir des données sérialisées
    public function __unserialize(array $data): void {
        $this->nom = $data['nom'];
        $this->age = $data['age'];
        $this->motDePasse = "";   // à réinitialiser
    }
}

// Test de la Partie 5
$u = new Utilisateur("Alice", 25, "secret123");
$serialise = serialize($u);
echo "Sérialisé : $serialise" . PHP_EOL;

$restaure = unserialize($serialise);
var_dump($restaure);

// 5.4 : alternative sûre pour échanger des données (JSON)
$json = json_encode(['nom' => $u->nom, 'age' => $u->age]);
echo "JSON : $json" . PHP_EOL;
var_dump(json_decode($json, true));