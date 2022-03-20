# THYP_TP2_Upload
 
Projet d'upload de fichiers vers le répertoire du projet.

Création d'une page permettant d'upload un fichier avec la possibilité de le renommer. Une vérification du type de fichier est faites afin de limiter les documents autorisés (pdf, jpg png uniquement par exemple).

En parallèle de l'upload du fichier, des informations sont enregistrés dans une table qui correspondent au nouveau nom du fichier, à l'extension ainsi que le chemin du fichier. Cependant, si le nom de l'image est déjà présente, affiche un message pour le notifier à l'utilisateur.

Plusieurs type de messages sont affichés:
- Message de succes lorsque les informations d'une image sont bien sauvegardés dans la BDD.
- Message d'un problème concernant le type de fichier qui n'est pas prit en charge.
- Message d'erreur lorsqu'une image portant le même nom est déjà présente dans la BDD.
- Message d'erreur lorsque le fichier à upload rencontre un problème.

Des vérifications sont faites afin de permettre seulement l'affichage des pages contenants des informations.

©Adam MKHININI
