<?php
class Compte {
    private float $montant;
    private float $interet;   // en pourcentage

    // 7.3 : ordre des paramètres conforme à l'énoncé (montant initial, puis intérêt)
    public function __construct(float $montantInitial, float $interet) {
        $this->montant = $montantInitial;
        $this->interet = $interet;
    }

    // 7.1 et 7.2 : syntaxe et formule corrigées
    public function unAn(): void {
        $this->montant += $this->montant * ($this->interet / 100);
    }

    public function getMontant(): float {
        return $this->montant;
    }
}

// Création des deux comptes
$c1 = new Compte(400.0, 10.0);
$c2 = new Compte(2500.0, 5.0);

// Boucle sur 10 ans
for ($i = 1; $i <= 10; $i++) {
    $c1->unAn();
    $c2->unAn();
}

// 7.4 : affichage formaté
echo 'Valeur du compte 1 = ' . number_format($c1->getMontant(), 2, ',', ' ') . ' dirhams' . PHP_EOL;
echo 'Valeur du compte 2 = ' . number_format($c2->getMontant(), 2, ',', ' ') . ' dirhams' . PHP_EOL;