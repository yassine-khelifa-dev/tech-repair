# Repair Flow

> Système de gestion des réparations pour ateliers de réparation.

Repair Flow permet aux clients de soumettre des demandes de réparation en ligne, et aux techniciens/administrateurs de gérer l'ensemble du processus via un tableau de bord d'administration.

---

## Table des matières

- [Architecture](#architecture)
- [Fonctionnalités principales](#fonctionnalités-principales)
- [Catalogue d'appareils](#catalogue-dappareils)
- [Système de spécifications](#système-de-spécifications)
- [Workflow de réparation](#workflow-de-réparation)
- [Notifications](#notifications)
- [API](#api)
- [Frontend](#frontend)
- [Tests](#tests)

---

## Architecture

| Couche | Technologies |
|--------|-------------|
| **Backend** | Laravel · Service Layer · API Resources · Form Requests · Jobs · Notifications · Feature Tests |
| **Frontend** | React · TypeScript · React Router · React Hook Form · Zod · Axios · Tailwind CSS |

---

## Fonctionnalités principales

- Soumission de demandes de réparation sans création de compte
- Catalogue hiérarchique d'appareils (type → marque → modèle)
- Spécifications dynamiques par modèle d'appareil
- Suivi du statut de réparation en temps réel
- Notifications asynchrones via Laravel Jobs

---

## Catalogue d'appareils

Le catalogue est organisé en trois niveaux hiérarchiques.

### Type d'appareil

Représente une catégorie d'appareils.

Exemples : `Smartphone` · `Tablette` · `Laptop`

### Marque

Représente le fabricant.

Exemples : `Apple` · `Samsung` · `Xiaomi`

### Modèle d'appareil

Représente un appareil spécifique.

Exemples : `iPhone 17 Pro Max` · `Galaxy S24 Ultra`

Chaque modèle appartient à **une marque** et **un type d'appareil**.

---

## Système de spécifications

Le système de spécifications est dynamique, basé sur des **Attributs** et des **Options**.

### Attribut

Décrit une caractéristique d'un appareil.

| Attribut | Options disponibles |
|----------|-------------------|
| Couleur | Noir · Blanc · Bleu · Vert · Titane |
| Stockage | 128 Go · 256 Go · 512 Go · 1 To |
| RAM | 8 Go · 12 Go · 16 Go |

### Options autorisées

Chaque modèle d'appareil définit ses propres options autorisées.

**Exemple :** L'application peut contenir 100 couleurs différentes, mais l'iPhone 17 Pro Max ne sera disponible qu'en Noir, Blanc, Bleu, Titane et Vert. Le frontend n'affichera que ces options pour ce modèle.

### Relations

```
DeviceModel
  ├── belongs to → Brand
  ├── belongs to → DeviceType
  └── has many  → SpecificationOptions (allowed)

SpecificationAttribute
  └── has many → SpecificationOptions

SpecificationOption
  ├── belongs to → SpecificationAttribute
  └── can be assigned to many → DeviceModels
```

---

## Workflow de réparation

### 1. Demande client

Le client suit ces étapes sans avoir à créer de compte :

1. Sélectionne un **type d'appareil**
2. Sélectionne une **marque**
3. Sélectionne un **modèle d'appareil**
4. Sélectionne les **spécifications** disponibles
5. Uploade des **photos** (optionnel)
6. Décrit le **problème**
7. Soumet la demande

La demande est enregistrée avec le statut `pending`.

### 2. Revue technicien

L'administrateur peut :

- Consulter les demandes
- Approuver ou rejeter une demande
- Créer un ticket de réparation
- Ajouter des notes technicien
- Uploader des photos de réparation
- Ajouter des logs de réparation

### 3. Ticket de réparation

Un ticket contient :

| Champ | Description |
|-------|-------------|
| Informations client | Nom, contact, etc. |
| Informations appareil | Modèle, spécifications sélectionnées |
| Statut | État courant de la réparation |
| Notes technicien | Observations internes |
| Tarification | Prix estimé / final |
| Historique | Logs de toutes les actions effectuées |

---

## Notifications

Les notifications sont traitées de manière **asynchrone** via des Laravel Jobs.

### Notifications client

| Événement | Notification envoyée |
|-----------|---------------------|
| Demande approuvée | ✅ |
| Demande rejetée | ✅ |
| Log de réparation visible ajouté | ✅ |
| Ticket créé manuellement par un admin | ✅ |

### Notifications administrateur

| Événement | Notification envoyée |
|-----------|---------------------|
| Nouvelle demande de réparation soumise | ✅ |

---

## API

Base URL : `/api`

### Catalogue

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| `GET` | `/device-types` | Liste tous les types d'appareils |
| `GET` | `/brands` | Liste tous les fabricants |
| `GET` | `/device-models` | Liste les modèles filtrés par `brand_id` et `device_type_id` |
| `GET` | `/device-models/{device_model}/attributes` | Attributs et options autorisés pour un modèle |

### Réparations

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| `POST` | `/repair-request/create` | Crée une nouvelle demande de réparation |

#### Corps de la requête — `POST /repair-request/create`

```json
{
  "customer": { ... },
  "device": {
    "device_model_id": 1,
    "selected_options": [10, 23, 47]
  },
  "issue_description": "L'écran est fissuré.",
  "images": ["<base64>", "..."]
}
```

---

## Frontend

### Pages principales

| Page | Description |
|------|-------------|
| **Home** | Landing page présentant les services |
| **Repair Request** | Formulaire dynamique connecté à l'API |
| **Success** | Confirmation après soumission réussie |

### Formulaire de demande

Le formulaire charge dynamiquement :
- Types d'appareils
- Marques
- Modèles d'appareils
- Spécifications disponibles

via des appels API successifs selon les sélections de l'utilisateur.

---

## Tests

Le backend inclut des **Feature Tests** couvrant :

- ✅ Demandes de réparation
- ✅ Tickets de réparation
- ✅ Logs de réparation
- ✅ Notifications
- ✅ Règles métier

Les tests valident le workflow complet de réparation ainsi que le comportement des endpoints API.
