Nom et prénom : ZRIBI Cyrine

Titre du projet : Gestion des Collections de Montres

Thème de l'application : L'application permet de gérer des collections de montres en utilisant Symfony. On peut consulter une liste de collections de montres, accéder aux détails de chaque collection, et visualiser les montres associées. Chaque montre dispose de ses informations spécifiques (marque, modèle, prix, description, image).

Modèle de données : Le projet repose sur deux principales entités :

- WatchBox (équivalent à l'[inventaire]) :

id : identifiant unique de la collection
name : nom de la collection
description : description de la collection

Relations : Une collection peut contenir plusieurs montres (relation 1-N).

- Watch (équivalent à [objet]) :

id : identifiant unique de la montre
brand : marque de la montre
model : modèle de la montre
price : prix de la montre
description : description de la montre
image : chemin de l'image de la montre

Relations : Une montre appartient à une seule collection (relation N-1 avec WatchBox).


- La liste des WatchBoxes est accessible à l'URI `/watchbox`.
