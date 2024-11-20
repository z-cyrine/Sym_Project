# WatchBox Project
# Nom et Prénom : Cyrine ZRIBI

## Sujet du Projet
Ce projet est une application web permettant de gérer un inventaire de montres (`WatchBox`), des galeries publiques ou privées (`Showcase`), et les informations des membres (`Member`). L'objectif est de fournir un espace où les utilisateurs peuvent gérer leurs collections de montres et partager certaines informations avec d'autres membres.

---

## Nomenclature
- **Inventaire** : `WatchBox` – Représente la boîte contenant les montres d'un utilisateur.
- **Galerie** : `Showcase` – Permet d'exposer des montres de manière publique ou privée.
- **Objet** : `Watch` – Chaque montre est un objet contenu dans une `WatchBox` ou présenté dans une `Showcase`.

---

## Plan des Tâches
Veuillez trouver la liste des tâches dans le lien suivant : https://github.com/z-cyrine/Sym_Project/blob/main/TODO.md

## Fonctionnalités
1. **Gestion des WatchBoxes** :
   - Les utilisateurs ne peuvent pas accéder aux `WatchBoxes` des autres membres. Un message flash s'affiche en cas de tentative non autorisée.
   - L'administrateur peut consulter les `WatchBoxes` de tous les utilisateurs.

2. **Gestion des montres** :
   - Seul l'administrateur peut accéder à la liste de toutes les montres. Un message flash s'affiche aux autres membres les empéchant d'accéder à cette route.

3. **Showcases** :
   - Les membres peuvent créer des `Showcases` pour afficher leurs montres.
   - Les `Showcases` peuvent être publiques ou privées.
   - L'accès aux `Showcases` privées d'autres membres est interdit.
   - Les membres peuvent uniquement modifier leurs propres `Showcases`.

4. **Gestion des Membres** :
   - Les membres peuvent consulter leur profil.
   - Il est interdit d'accéder au profil de l'administrateur (message flash).
   - Une liste des membres est disponible pour consultation.

5. **Authentification** :
   - Système de rôles : Utilisateur (ROLE_USER) et Administrateur (ROLE_ADMIN).
   - Accès aux différentes sections de l'application selon les permissions.

---

## Accédez à l'application :
URL par défaut : http://localhost:8000/

## Routes Principales
- **Authentification** :
  - Login : [http://localhost:8000/](http://localhost:8000/)

- **Affichage des showcases publiques** :
  - Showcases publiques accessibles à tout le monde : [http://localhost:8000/showcase/public-showcases](http://localhost:8000/showcase/public-showcases)

- **Gestion des montres** :
  - Liste de toutes les montres : [http://localhost:8000/watch/list](http://localhost:8000/watch/list)

- **Gestion des WatchBoxes** :
  - Détails d'une WatchBox : [http://localhost:8000/watchbox/{id}](http://localhost:8000/watchbox/{id})

- **Gestion des Showcases** :
  - Détails d'une montre dans une Showcase : [http://localhost:8000/showcase/watch/{id}](http://localhost:8000/showcase/watch/{id})
  - Détails d'une Showcase : [http://localhost:8000/showcase/{id}](http://localhost:8000/showcase/{id})

- **Gestion des Membres** :
  - Profil d'un membre : [http://localhost:8000/member/{id}](http://localhost:8000/member/{id})
  - Liste des membres : [http://localhost:8000/members](http://localhost:8000/members)

---

## Credentials des Membres
Utilisez les identifiants suivants pour tester les fonctionnalités de l'application :

| Email              | Mot de passe | Rôle          |
|--------------------|--------------|---------------|
| cyrine@localhost   | 123456       | ROLE_USER     |
| olivier@localhost  | 123456       | ROLE_USER     |
| admin@localhost    | admin123     | ROLE_ADMIN    |

---

## Commandes pour Lancer l'Application
1. Après avoir extrait l'archive ZIP :
  rm -fr composer.lock symfony.lock vendor/ var/cache/ .project
  symfony composer install
  symfony server:start

2. Commandes pour initialiser la base de données :
  php bin/console doctrine:database:drop --force
  php bin/console doctrine:database:create
  php bin/console doctrine:schema:create
  php bin/console doctrine:fixtures:load

Toutes les tâches obligatoires et optionnelles ont été réalisées.

