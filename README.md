Projet de Migration vers l'Approche Orientée Objet (OOP) et Implémentation du Design Pattern MVC

Ce projet vise à migrer l'architecture actuelle, basée sur une approche procédurale, vers une approche orientée objet (OOP) pour améliorer la modularité, l'extensibilité et la maintenabilité. En bonus, une implémentation du design pattern MVC (Modèle-Vue-Contrôleur) est envisagée pour une structuration claire du code.
Migration vers l'OOP
Zones d'Application de l'OOP

    Gestion des équipes
    Gestion des membres de l'équipe
    Gestion des projets

Conversion des Éléments Clés en Classes et Objets

    Création de classes pour chaque entité (Equipe, Membre, Projet, etc.).
    Utilisation d'encapsulation, d'héritage et de polymorphisme pour améliorer la structure du code.

Implémentation du Design Pattern MVC
Trois Composants Distincts

    Modèle : Représente les données et la logique métier.
    Vue : Responsable de l'affichage des données.
    Contrôleur : Gère les entrées utilisateur et coordonne les interactions entre Modèle et Vue.

Organisation des Répertoires

    app/Model : Classes du Modèle
    app/View : Fichiers de Vue
    app/Controller : Classes du Contrôleur
    public : Fichiers accessibles publiquement (CSS, JS, images, etc.)

Comment Exécuter le Projet

    Assurez-vous d'avoir PHP installé sur votre machine.
    Configurez un serveur web local (Apache, Nginx, etc.) pour pointer vers le répertoire public.
    Configurez votre base de données dans les classes du Modèle.