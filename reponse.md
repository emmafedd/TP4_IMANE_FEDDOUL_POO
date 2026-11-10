# Réponses aux questions du TP 4 – Programmation Orientée Objet en PHP

## Partie 0 – La première classe

### 0.3 $v1 et $v2 partagent-ils la même valeur de $marque ? Pourquoi ?
__Non. Chaque fois que l'on utilise le mot-clé `new Voiture()`, PHP crée un nouvel objet en mémoire distinct. Les attributs (`$marque`, `$couleur`) sont propres à chaque instance (objet). Modifier `$v2` n'a donc aucun impact sur `$v1`.

---

## Partie 1 – Visibilité et encapsulation : la classe `Personne`

### 1.1 Que remarquez-vous ? Quelle ligne provoque quelle erreur ?
- `echo $p->cin;` -> Erreur fatale : Impossible d'accéder à une propriété privée (`private`).
- `echo $p->dateNaissance;` -> Erreur fatale : Même raison, l'attribut est encapsulé.
- `echo $p->getAge();` -> Erreur fatale : Appel interdit d'une méthode privée depuis l'extérieur de la classe.

### 1.2 Pourquoi serait-il dangereux de laisser `cin` en `public` ?
Le CIN est une donnée sensible et unique. N'importe quel code externe pourrait la modifier accidentellement ou malveillamment.

### 1.3 `getAge()` est privée : est-elle donc inutile ?
Non, elle n'est pas inutile. Elle est conçue pour être appelée à l'intérieur de la classe par d'autres méthodes.

### 1.4 Changez la visibilité de `cin` en `protected`. Le comportement change-t-il ?
Depuis l'extérieur, oui et non : on obtient toujours une erreur si on essaie de l'afficher directement (`$p->cin`), mais la visibilité `protected` permet aux classes filles (en cas d'héritage) d'y accéder, contrairement à `private`.

---

## Partie 2 – Constructeurs et destructeur

### 2.1.a Que se passe-t-il avec `new Voiture("Noire")` et `new Voiture(120)` ?
- `new Voiture("Noire")` -> Fonctionne : `"Noire"` est assigné à `$couleur`, et `$vitesse` prend sa valeur par défaut (`0`).
- `new Voiture(120)` -> Erreur de type (`TypeError`) en PHP 8 car le premier paramètre attend une `string` (`"Noire"`), mais on lui transmet un `int` (`120`).

### 2.2.a Que remarquez-vous à l'exécution ?
PHP génère une erreur fatale car il n'autorise pas la surcharge de méthodes (méthodes portant le même nom avec des signatures différentes) pour le constructeur `__construct()`.

### 2.3 Le destructeur
#### 2.3.a Ordre d'affichage :
1. `Voiture Blanche créée.`
2. `Voiture Blanche détruite.` (provoqué par `unset($maVoiture);`)
3. `Fin du script.`

#### 2.3.b Suppression de `unset` :
Le message de destruction s'affichera tout à la fin du script, juste après "Fin du script." (ou lors du nettoyage de fin d'exécution de PHP).

#### 2.3.c Deux objets `$a` et `$b` sans `unset` :
Ils sont détruits dans l'ordre inverse de leur création (principe du LIFO - Last In, First Out). Si `$a` est créé en premier puis `$b`, `$b` est détruit en premier, suivi de `$a`.

---

## Partie 3 – Surcharge de propriétés : `__get`, `__set`, `__isset`, `__unset`

### 3.2 Sans `__set`, que se passerait-il ?
Une erreur fatale de type `Cannot access private property` serait levée si l'on essayait d'assigner une valeur à un attribut privé de l'extérieur. Avec `__set`, l'interception permet de gérer l'écriture proprement.

### 3.3 `__set` peut-il casser l'encapsulation ?
Oui, s'il est mal écrit (par exemple s'il assigne aveuglément toute valeur sans filtre). C'est pourquoi on y ajoute des contrôles de validation (comme exigé en 3.4).

---

## Partie 4 – Représentation textuelle : `__toString`

### 4.1 `getAge()` est `private`, pourtant elle fonctionne ici. Pourquoi ?
Parce que `__toString()` fait partie de la même classe (`Personne`). En PHP, la visibilité `private` restreint l'accès à la classe elle-même, peu importe que l'on manipule l'objet depuis l'intérieur d'une méthode de cette même classe.

### 4.2 Que se passe-t-il si `__toString()` retourne un entier ?
PHP déclenchera une erreur fatale (`Recoverable fatal error` ou `TypeError` selon la version) car `__toString()` doit impérativement retourner une chaîne de caractères (`string`).

### 4.3 Intérêt de `__toString()` :
Il permet d'utiliser directement l'objet dans un contexte textuel (comme `echo $obj` ou une concaténation `echo "Utilisateur : " . $obj`) sans avoir à appeler explicitement une méthode dédiée (comme `$obj->getName()`).

---

## Partie 5 – Sérialisation : `__serialize` et `__unserialize`

### 5.1 Le mot de passe figure-t-il dans la chaîne sérialisée ?
Non, car la méthode `__serialize()` filtre explicitement les clés retournées et omet volontairement `$motDePasse`.

### 5.2 Que constate-t-on si on commente `__serialize()` ?
Le mot de passe en clair (ainsi que son nom de propriété privé) apparaît dans la chaîne sérialisée. C'est un risque critique de sécurité si cette chaîne est stockée dans un fichier de logs, une session non chiffrée ou transmise.

### 5.3 Valeur de `$motDePasse` après `unserialize` ?
Elle est réinitialisée à une chaîne vide `""` grâce au code défini dans `__unserialize()`.

### 5.4 Réflexion sécurité (PHP Object Injection) :
N'appelez jamais `unserialize()` sur des données non fiables provenant d'utilisateurs (cookies, formulaires, requêtes HTTP), car un attaquant pourrait injecter une chaîne sérialisée malveillante exploitant des méthodes magiques (comme `__destruct`) pour exécuter du code arbitraire sur le serveur. Préférez toujours des formats d'échange de données standards et sûrs comme `json_encode` / `json_decode`.

---

## Partie 6 – Héritage : la classe `Etudiant`

### 6.2.a Suppression de `parent::__construct` :
Les attributs de la classe mère (`Personne`) ne seront pas initialisés, ce qui provoquera des erreurs ou des variables non définies lors de l'appel des méthodes parentes.

### 6.2.b Pourquoi `$nom` est `protected` et non `private` ?
Pour qu'il soit directement accessible par les classes filles (`Etudiant`), tout en restant protégé des accès extérieurs.

### 6.3.a Erreurs de `final` et `readonly` :
- Redéfinir une méthode `final` génère une erreur fatale (`Cannot override final method`).
- Étendre une classe `final` génère une erreur fatale (`Class X may not inherit from final class`).
- Modifier une propriété `readonly` après son initialisation génère une erreur fatale (`Cannot modify readonly property`).

### 6.4.a Appel de `$this->getAge()` dans `Etudiant` :
Si `getAge()` est `private` dans `Personne`, elle est strictement invisible pour la classe fille `Etudiant`. Pour qu'une classe fille puisse l'utiliser, sa visibilité doit être modifiée en `protected`.

### 6.4.b Accès à `$this->dateNaissance` depuis `Etudiant` :
C'est impossible si l'attribut est déclaré en `private` dans la classe mère, car l'encapsulation `private` n'est pas partagée avec aucune autre classe, pas même les classes filles.

---

## Partie 7 – Mise en pratique : le compte bancaire

### 7.1 Erreur de syntaxe :
L'expression `$this->montant 1` présente un espace inattendu au milieu, et il manquait un opérateur arithmétique.

### 7.2 Formule mathématique correcte :
Pour ajouter un taux d'intérêt annuel $t$ %, la formule correcte après un an est :
$$\text{montant} = \text{montant} + \text{montant} \times \left(\frac{t}{100}\right)$$

### 7.3 Ordre des paramètres :
L'énoncé demandait « un montant initial et un intérêt », alors que le code initial proposait `__construct($interet, $montantInitial)`. Inverser l'ordre garantit la cohérence et évite toute confusion lors de l'instanciation.

---

## Questions de synthèse

1. **Quelle est la différence entre une classe et un objet ?**
   - Une classe est un modèle abstrait (un plan de construction).
   - Un objet est une instance concrète de cette classe, créée en mémoire à l'aide du mot-clé `new`.

2. **Citez trois avantages de la POO par rapport à la programmation procédurale :**
   - L'encapsulation (protection des données contre les accès non autorisés).
   - La réutilisabilité grâce à l'héritage et la composition.
   - La maintenabilité et l'extensibilité du code (organisation modulaire claire).

3. **Pourquoi est-il recommandé de déclarer les attributs en `private` ou `protected` ?**
   Pour respecter le principe d'encapsulation, empêcher les modifications directes et incontrôlées depuis l'extérieur, et passer obligatoirement par des méthodes de contrôle (getters/setters).

4. **Quelle différence entre `private` et `protected` en cas d'héritage ?**
   - `private` : accessible uniquement dans la classe où l'attribut est défini (invisible pour les classes filles).
   - `protected` : accessible dans la classe d'origine et dans toutes ses classes filles.

5. **Une méthode magique doit-elle être déclarée `public` ? Quelles exceptions ?**
   Oui, toutes les méthodes magiques de PHP (comme `__construct`, `__get`, `__set`, `__toString`, etc.) doivent obligatoirement être déclarées en `public`. La seule exception notable est `__construct` qui peut parfois être déclaré en `private` dans le cadre du design pattern *Singleton*.