# WatchBox Showcase Project

## Sujet du Projet
Ce projet est une application web permettant de gérer un inventaire de montres (`WatchBox`), des galeries publiques ou privées (`Showcase`), et les informations des membres (`Member`). L'objectif est de fournir un espace où les utilisateurs peuvent gérer leurs collections de montres et partager certaines informations avec d'autres membres.

---

## Nomenclature
- **Inventaire** : `WatchBox` – Représente la boîte contenant les montres d'un utilisateur.
- **Galerie** : `Showcase` – Permet d'exposer des montres de manière publique ou privée.
- **Objet** : `Watch` – Chaque montre est un objet contenu dans une `WatchBox` ou présenté dans une `Showcase`.

---

## Fonctionnalités
1. **Gestion des WatchBoxes** :
   - Les utilisateurs ne peuvent pas accéder aux `WatchBoxes` des autres membres. Un message flash s'affiche en cas de tentative non autorisée.
   - L'administrateur peut consulter les `WatchBoxes` de tous les utilisateurs.

2. **Showcases** :
   - Les membres peuvent créer des `Showcases` pour afficher leurs montres.
   - Les `Showcases` peuvent être publiques ou privées.
   - L'accès aux `Showcases` privées d'autres membres est interdit.
   - Les membres peuvent uniquement modifier leurs propres `Showcases`.

3. **Gestion des Membres** :
   - Les membres peuvent consulter leur profil.
   - Il est interdit d'accéder au profil de l'administrateur (message flash).
   - Une liste des membres est disponible pour consultation.

4. **Authentification** :
   - Système de rôles : Utilisateur (ROLE_USER) et Administrateur (ROLE_ADMIN).
   - Accès aux différentes sections de l'application selon les permissions.

---

## Routes Principales
- **Authentification** :
  - Login : [http://localhost:8000/login](http://localhost:8000/login)

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

## Accédez à l'application :

URL par défaut : http://localhost:8000/login
