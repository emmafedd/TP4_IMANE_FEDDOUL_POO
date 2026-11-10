<?php
class Personne {
    private string $nom = "";
    private string $prenom = "";
    private string $dateNaissance = "";

    public function __set(string $name, mixed $value): void {
        if (!property_exists($this, $name)) {
            echo "Propriété '$name' inexistante !" . PHP_EOL;
            return;
        }

        // 3.4 : le nom ne doit pas être vide et doit contenir au moins 2 caractères
        if ($name === 'nom') {
            if (empty($value) || strlen($value) < 2) {
                throw new InvalidArgumentException("Le nom doit contenir au moins 2 caractères.");
            }
        }

        $this->$name = $value;
    }

    public function __get(string $name): mixed {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }

    public function __isset(string $name): bool {
        // Corrigé : une chaîne vide compte comme "non définie"
        return property_exists($this, $name) && $this->$name !== "";
    }

    public function __unset(string $name): void {
        if (property_exists($this, $name)) {
            $this->$name = "";
        }
    }
}

// Tests de la Partie 3
$p = new Personne();
$p->nom = "Hachimi";                // Appelle __set
echo "Nom : " . $p->nom . PHP_EOL;  // Appelle __get

var_dump(isset($p->nom));           // Appelle __isset (true)
unset($p->nom);                     // Appelle __unset
var_dump(isset($p->nom));           // Appelle __isset (false, car vidé)

$p->telephone = "0600000000";       // Propriété inexistante : message d'alerte

// Test de la validation 3.4 (décommentez pour voir l'exception)
// $p->nom = "A";