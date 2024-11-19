# Plan des Tâches du Projet Symfony

## Liste des Tâches

| N° étape | Tâche à faire                                                                 | Obligatoire / Optionnel | Séance de début prévisionnel | État |
|----------|------------------------------------------------------------------------------|--------------------------|------------------------------|------|
| 1        | Prise de connaissance du cahier des charges                                  | **OBLIGATOIRE**          | TP 3                         |  Done    |
| 2        | Initialisation du projet Symfony                                             | **OBLIGATOIRE**          | TP 3                         |  Done    |
| 3        | Gestion du code source avec Git                                              | **RECOMMANDÉ**           |                              |  Done    |
| 4        | Ajout au modèle des données des entités liées [inventaire] et [objet] minimales | **OBLIGATOIRE**          | TP 3                         |  Done    |
| 4.1      | - Entité [inventaire]                                                       | ''                       | ''                           |  Done    |
| 4.2      | - Entité [objet]                                                            | ''                       | ''                           |  Done    |
| 4.3      | - Association 1-N entre [inventaire] et [objet]                             | ''                       | ''                           |  Done    |
| 4.4      | - Propriétés non-essentielles des [objets] (optionnel)                      | **OPTIONNEL**            | En 2ème moitié de projet     |  Done    |
| 5        | Ajout de données de tests chargeables avec les fixtures                     | **OBLIGATOIRE**          | TP 3                         |  Done    |
|          | - Pour [inventaire]                                                        |                          |                              |  Done    |
|          | - Pour [objet]                                                             |                          |                              |  Done    |
| 6        | Création des pages du "front-office" de consultation des [inventaires]      |                          |                              |  Done    |
|          | - Consultation de la liste de tous les inventaires (dans un premier temps)  | **OBLIGATOIRE**          | TP 4                         |  Done    |
|          | - Consultation d'une fiche d'[inventaire] à partir de la liste             | **OBLIGATOIRE**          | TP 4                         |  Done    |
| 7        | Utilisation de gabarits pour les pages de consultation du front-office      | **OBLIGATOIRE**          | TP 5                         |  Done    |
|          | - Consultation d'un [objet]                                                |                          |                              |  Done    |
|          | - Consultation de la liste des [objets] d'un [inventaire]                  |                          |                              |  Done    |
|          | - Navigation d'un [inventaire] vers la consultation de ses [objets]        |                          |                              |  Done    |
| 8        | Intégration d'une mise en forme CSS avec Bootstrap dans les gabarits Twig   | **OBLIGATOIRE**          | TP 6                         |  Done    |
| 9        | Ajout de l'entité membre et du lien membre - [inventaire]                   | **OBLIGATOIRE**          | TP 3/4                       |  Done    |
|          | - Ajout de membre au modèle des données                                    |                          |                              |  Done    |
|          | - Ajout de l'association 1-1 entre membre et son inventaire                |                          |                              |  Done    |
| 10       | Intégration de menus de navigation                                          | **OBLIGATOIRE**          |                              |  Done    |
| 11       | Ajout de l'entité [galerie] au modèle des données et de l'association M-N avec [objet] | **OBLIGATOIRE**          |                              |  Done    |
| 12       | Ajout d'un contrôleur CRUD pour [galerie]                                   | **OBLIGATOIRE**          | TP 7                         |  Done    |
| 13       | Ajout de fonctions CRUD pour [objet]                                        | **OBLIGATOIRE**          |                              |  Done    |
| 14       | Ajout de la consultation des [objets] depuis les [galeries] publiques       | **OBLIGATOIRE**          |                              |  Done    |
| 15       | Consultation de la liste des seuls inventaires d'un membre dans le front-office | **OBLIGATOIRE**          |                              |  Done    |
| 16       | Contextualisation de la création d'un [objet] en fonction de l'[inventaire] | **OBLIGATOIRE**          |                              |  Done    |
| 17       | Ajout de la gestion de la mise en ligne d'images pour des photos dans les [objet] | **OBLIGATOIRE**          | TP 8                         |  Done    |
| 18       | Ajout de l'authentification                                                | **OBLIGATOIRE**          | TP 8                         |  Done    |
| 19       | Affichage des seules galeries publiques                                     | **OBLIGATOIRE**          |                              |  Done    |
| 20       | Contextualisation de la création d'une [galerie] en fonction du membre      | **OPTIONNEL**            |                              |  Done    |
| 21       | Contextualisation de l'ajout d'un [objet] à une [galerie]                  | **OPTIONNEL**            |                              |  Done    |
| 22       | Utilisation des messages flash pour les CRUDs                               | **OPTIONNEL**            |                              |  Done    |
| 23       | Ajout d'une gestion de marque-pages/panier dans le front-office            | **OPTIONNEL**            | TP 8                         |     |
| 24       | Protection de l'accès aux données à leurs seuls propriétaires              | **OPTIONNEL**            | TP 8                         |  Done    |
| 25       | Contextualisation du chargement des données en fonction de l'utilisateur connecté | **OPTIONNEL**            |                              |  Done    |

---
