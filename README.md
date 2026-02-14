[![PHP Version](https://img.shields.io/badge/PHP-8.4-blue.svg)](https://www.php.net/releases/8.4/)
[![Symfony Version](https://img.shields.io/badge/Symfony-8.0-purple.svg)](https://symfony.com/releases/8.0)
[![PHPStan](https://img.shields.io/badge/PHPStan-Level%207-brightgreen)](https://phpstan.org/)
[![Tests Coverage](https://img.shields.io/badge/Coverage-65%25-red.svg)](#)
[![License](https://img.shields.io/badge/License-Proprietary-red.svg)](LICENSE)
# 🏋️ Les Titans

Les Titans est une application web développée avec Symfony permettant la
gestion des adhérents et de la communication interne d'une association
sportive communale.

## 🚀 Aperçu du projet

-   Gestion complète des adhérents
-   Communication interne via publications
-   Suivi administratif (badge, caution, certificat, cotisation)
-   Dashboard dirigeants
-   Automatisation des notifications
-   Application mobile-first responsive

## 🎯 Problématique initiale

-   gestion des membres sur papier et fichiers Excel
-   communication via groupe Facebook privé
-   manque de suivi administratif
-   adhérents parfois non informés
-   charge administrative importante

## 👥 Rôles utilisateurs

ROLE_ADMIN --- accès complet\
ROLE_PRESIDENT --- gestion complète\
ROLE_VICE_PRESIDENT --- gestion complète sans suppression\
ROLE_TREASURER --- gestion complète sans suppression\
ROLE_SECRETARY --- gestion complète sans suppression\
ROLE_MEMBER --- consultation, publications, commentaires, profil

## 🧩 Fonctionnalités

### Partie publique

-   Page d'accueil
-   Demande d'adhésion
-   Formulaire de contact
-   Informations pratiques
-   Pages légales

### Gestion des membres

-   CRUD adhérents
-   Validation adhésion
-   Gestion badges et cautions
-   Paiement annuel hors ligne
-   Suivi certificat médical

### Communication interne

-   Publications
-   Commentaires
-   Profils modifiables

### Dashboard dirigeants

-   Gestion membres
-   Validation adhésions
-   Gestion messages (avec workflow interne)

## 🧱 Architecture

-   DDD
-   Architecture hexagonale
-   DTO
-   Symfony Forms

## ⚙️ Stack technique

-   PHP 8.4
-   Symfony 8.0
-   Doctrine ORM 3.5
-   MySQL
-   Twig
-   Docker
-   Nginx

## 🔐 Sécurité

-   Hash password Symfony
-   Protection CSRF
-   Gestion des rôles

## 🧪 Qualité

-   Tests fonctionnels en cours
-   Tests unitaires prévus
-   PHPStan en cours
-   PHP-CS-Fixer en cours

## 🐳 Environnement

-   Docker
-   WSL2
-   Makefile
-   Fixtures

## 🚀 Installation

``` bash
git clone https://github.com/ThibDel8/Les_Titans.git
cd Les_Titans
make up
make install
```

## 📈 Roadmap

-   Export Excel
-   Module coaching

## 👨‍💻 Auteur

Thibault Delattre\
GitHub : https://github.com/ThibDel8 \
LinkedIn : https://www.linkedin.com/in/thibault-delattre8/
