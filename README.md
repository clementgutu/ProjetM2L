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

## Fonctionnalités

- Inscription / Connexion avec authentification sécurisée
- Annuaire des collaborateurs avec filtres de recherche
- Gestion de profil (modification des informations + photo)
- Gestion des catégories (réservée aux administrateurs)
- Déconnexion complète (destruction de session)
