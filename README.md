# Intranet M2L

Application web intranet de gestion des collaborateurs de l'entreprise M2L.
Développée en PHP / MySQL avec Tailwind CSS.

---

## MCD — Modèle Conceptuel de Données

```
+------------------+          +------------------+
|  collaborateurs  |          |     avatars      |
+------------------+          +------------------+
| PK id            |◄────────►| PK id            |
|    civilite      |  1    0,1 |    photo         |
|    prenom        |          | FK collaborateur_id
|    nom           |          +------------------+
|    email         |
|    motdepasse    |
|    telephone     |
|    date_naissance|
|    pays          |
|    ville         |
|    profession    |
|    role          |  ENUM : admin | client
+------------------+
```

### Relations

| Relation | Cardinalité | Description |
|---|---|---|
| collaborateur → avatar | 1,1 — 0,1 | Un collaborateur peut avoir une photo de profil |

---

## Stack technique

- **Back-end** : PHP 8 (PDO, sessions, password_hash)
- **Base de données** : MySQL — base `intranet`
- **Front-end** : Tailwind CSS, Alpine.js, Font Awesome
- **Sécurité** : CSRF token, sessions sécurisées, guards auth/admin

---

## Architecture du projet

Le projet suit une architecture **"Pages + Logique séparée"** : les pages sont les points d'entrée HTTP, toute la logique métier et les accès BDD sont isolés dans `src/`.

```
ProjetM2L/
│
├── index.php                        # Page d'inscription (point d'entrée public)
│
├── pages/                           # Points d'entrée HTTP (vues principales)
│   ├── acceuil.php                  # Tableau de bord connecté
│   ├── listes.php                   # Annuaire des collaborateurs (pagination, filtres, CRUD admin)
│   ├── profil.php                   # Profil utilisateur
│   ├── form_connexion.php           # Formulaire de connexion
│   ├── form_add_collaborateur.php   # Formulaire ajout collaborateur (admin)
│   └── form_edit_collaborateur.php  # Formulaire modification collaborateur (admin)
│
├── src/                             # Logique métier
│   ├── auth/                        # Authentification et sécurité
│   │   ├── connexion.php            # Traitement du login (POST)
│   │   ├── inscription.php          # Traitement de l'inscription (POST)
│   │   ├── deconnexion.php          # Destruction de session
│   │   ├── auth_check.php           # Guard : redirige si non connecté
│   │   └── admin_check.php          # Guard : redirige si non admin
│   │
│   ├── db/                          # Connexion base de données (non versionné)
│   │
│   ├── collaborateurs/              # Requêtes de lecture des collaborateurs
│   │   ├── collaborateur.php        # Récupère 1 collaborateur aléatoire (accueil)
│   │   ├── filtre_collaborateurs.php# Requête filtrée + paginée (listes)
│   │   └── all_collaborators.php    # Récupère tous les collaborateurs
│   │
│   └── crud/
│       └── crud_collab/             # Traitement CRUD collaborateurs (admin)
│           ├── add_collaborateur.php        # Traitement ajout (POST)
│           ├── edit_collaborateur.php       # Traitement modification (POST)
│           ├── delete_collaborateur.php     # Traitement suppression (POST)
│           └── modifier_profil.php          # Modification profil connecté (POST)
│
├── includes/                        # Composants HTML réutilisables
│   ├── header_public.php            # Header pages publiques
│   ├── header_connected.php         # Header + nav pages connectées
│   └── footer.php
│
└── asset/                           # Images, icônes, ressources statiques
```

### Principes appliqués

- **`__DIR__`** sur tous les `require_once` des fichiers inclus — évite les erreurs de chemin selon l'appelant
- **Chemins absolus** (`/ProjetM2L/...`) sur tous les `header('Location:')` des guards et scripts POST — évite les redirections cassées selon la profondeur d'inclusion
- **Guards** (`auth_check.php`, `admin_check.php`) inclus en tête de chaque page protégée
- **CSRF token** sur tous les formulaires POST

---

## Fonctionnalités

- Inscription / Connexion avec authentification sécurisée
- Annuaire des collaborateurs avec filtres de recherche et pagination (6 par page)
- CRUD collaborateurs complet réservé aux administrateurs (ajout, modification, suppression)
- Gestion de profil (modification des informations personnelles)
- Déconnexion complète (destruction de session)
