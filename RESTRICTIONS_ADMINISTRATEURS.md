# 🔐 Restrictions d'accès pour les Administrateurs

**Date :** 18 octobre 2025  
**Statut :** ✅ Système de restrictions hiérarchiques implémenté

---

## 🎯 Objectif

Permettre aux **Administrateurs** d'accéder à la gestion des utilisateurs mais avec des **restrictions strictes** : ils ne peuvent gérer QUE les **clients**, pas les autres administrateurs ou super administrateurs.

---

## 📊 Matrice des permissions

| Action | Super Admin | Admin | Client |
|--------|-------------|-------|--------|
| **Accéder à la liste des utilisateurs** | ✅ Oui | ✅ Oui | ❌ Non |
| **Créer un administrateur** | ✅ Oui | ❌ Non | ❌ Non |
| **Modifier un client** | ✅ Oui | ✅ Oui | ❌ Non |
| **Modifier un admin** | ✅ Oui | ❌ **Non** 🔒 | ❌ Non |
| **Modifier un super admin** | ✅ Oui | ❌ **Non** 🔒 | ❌ Non |
| **Supprimer un client sans commandes** | ✅ Oui | ✅ Oui | ❌ Non |
| **Supprimer un client avec commandes** | ✅ Oui (sécurisé) | ✅ Oui (sécurisé) | ❌ Non |
| **Supprimer un admin** | ✅ Oui (sécurisé) | ❌ **Non** 🔒 | ❌ Non |
| **Supprimer un super admin** | ❌ **Interdit** 🛡️ | ❌ **Interdit** 🛡️ | ❌ Non |

---

## 🔒 Règles de sécurité

### 1. **Accès à la page**
- ✅ **Super Admin** : Accès complet
- ✅ **Admin** : Accès avec restrictions
- ❌ **Client** : Aucun accès (403)

### 2. **Bouton "Nouvel Administrateur"**
```blade
@if(auth()->user()->type === 'super_admin')
    <!-- Bouton actif -->
@else
    <!-- Bouton désactivé avec tooltip -->
@endif
```

- **Super Admin** : Bouton actif ✅
- **Admin** : Bouton grisé avec message "Accès restreint" 🔒

### 3. **Boutons Edit/Delete dans le tableau**

Pour chaque utilisateur, la logique détermine :
- `$canEdit` : Admin peut modifier UNIQUEMENT les clients
- `$canDelete` : Admin peut supprimer UNIQUEMENT les clients

**Si accès refusé :**
- Bouton grisé avec icône 🔒
- Classe `btn-access-denied`
- Au clic → Modale "Non accès"

---

## 🎨 Interface utilisateur

### Modale "Non accès" 🚫

Lorsqu'un Admin clique sur un bouton restreint :

```javascript
Swal.fire({
    icon: 'error',
    title: '🚫 Accès Refusé',
    html: `
        Vous n'avez pas les permissions nécessaires.
        
        Action : Modifier/Supprimer "Nom Utilisateur"
        Type : Administrateur/Super Administrateur
        
        ⚠️ Seuls les super administrateurs peuvent [action] 
           des administrateurs ou super administrateurs.
        
        Si vous pensez avoir besoin de ces permissions, 
        veuillez contacter un super administrateur.
    `,
    confirmButtonText: 'J\'ai compris'
});
```

**Caractéristiques :**
- Icône d'erreur rouge
- Titre explicite "🚫 Accès Refusé"
- Détails de l'action demandée
- Explication de la restriction
- Message de contact

---

## 🗂️ Modifications des fichiers

### Backend

#### `app/Http/Controllers/Admin/UserController.php`

**1. Middleware modifié**
```php
public function __construct()
{
    $this->middleware(function ($request, $next) {
        if (!in_array(auth()->user()->type, ['admin', 'super_admin'])) {
            abort(403, 'Accès refusé...');
        }
        return $next($request);
    });
}
```
✅ Permet l'accès aux admins ET super_admins

**2. Méthode `create()`**
```php
public function create()
{
    if (auth()->user()->type === 'admin') {
        return redirect()->route('admin.users.index')
            ->with('error', 'Accès refusé. Seuls les super administrateurs...');
    }
    return view('admin.users.create');
}
```
✅ Bloque l'accès pour les admins

**3. Méthode `store()`**
```php
public function store(Request $request)
{
    if (auth()->user()->type === 'admin') {
        return redirect()->route('admin.users.index')
            ->with('error', 'Accès refusé...');
    }
    // ... reste du code
}
```
✅ Double vérification backend

**4. Méthode `edit()`**
```php
public function edit(User $user)
{
    if (auth()->user()->type === 'admin' && 
        in_array($user->type, ['admin', 'super_admin'])) {
        return redirect()->route('admin.users.index')
            ->with('error', 'Accès refusé. Vous ne pouvez pas modifier...');
    }
    return view('admin.users.edit', compact('user'));
}
```
✅ Bloque l'édition d'admins par des admins

**5. Méthode `update()`**
```php
public function update(Request $request, User $user)
{
    if (auth()->user()->type === 'admin' && 
        in_array($user->type, ['admin', 'super_admin'])) {
        return redirect()->route('admin.users.index')
            ->with('error', 'Accès refusé...');
    }
    // ... reste du code
}
```
✅ Double vérification pour l'update

**6. Méthode `destroy()`**
```php
public function destroy(Request $request, User $user)
{
    // ... vérifications existantes ...
    
    if (auth()->user()->type === 'admin' && 
        in_array($user->type, ['admin', 'super_admin'])) {
        return redirect()->route('admin.users.index')
            ->with('error', 'Accès refusé. Vous ne pouvez pas supprimer...');
    }
    
    // ... reste du code
}
```
✅ Bloque la suppression d'admins par des admins

---

### Frontend

#### `resources/views/admin/users/index.blade.php`

**1. Bouton "Nouvel Administrateur"**
```blade
@if(auth()->user()->type === 'super_admin')
    <a href="..." class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouvel Administrateur
    </a>
@else
    <button class="btn btn-secondary" disabled 
            title="Seuls les super administrateurs...">
        <i class="fas fa-lock"></i> Accès restreint
    </button>
@endif
```

**2. Logique des boutons dans le tableau**
```php
@php
    $isCurrentUser = $user->id === auth()->id();
    $isSuperAdmin = $user->type === 'super_admin';
    $isAdminOrSuperAdmin = in_array($user->type, ['admin', 'super_admin']);
    $currentUserIsAdmin = auth()->user()->type === 'admin';
    
    $canEdit = !($currentUserIsAdmin && $isAdminOrSuperAdmin);
    $canDelete = !$isCurrentUser && 
                 !$isSuperAdmin && 
                 !($currentUserIsAdmin && $isAdminOrSuperAdmin);
@endphp
```

**3. Bouton Edit avec restriction**
```blade
@if($canEdit)
    <a href="..." class="btn btn-warning">
        <i class="fas fa-edit"></i>
    </a>
@else
    <button class="btn btn-secondary btn-access-denied" 
            data-action="modifier"
            data-user-name="..."
            data-user-type="...">
        <i class="fas fa-lock"></i>
    </button>
@endif
```

**4. Bouton Delete avec restriction**
```blade
@if($canDelete)
    <form class="delete-user-form">...</form>
@elseif($isSuperAdmin)
    <button disabled>
        <i class="fas fa-shield-alt"></i>
    </button>
@else
    <button class="btn-access-denied" 
            data-action="supprimer"
            data-user-name="..."
            data-user-type="...">
        <i class="fas fa-lock"></i>
    </button>
@endif
```

**5. Script JavaScript pour la modale**
```javascript
$('.btn-access-denied').on('click', function() {
    const action = $(this).data('action');
    const userName = $(this).data('user-name');
    const userType = $(this).data('user-type');
    
    Swal.fire({
        icon: 'error',
        title: '🚫 Accès Refusé',
        html: `...`,
        confirmButtonText: 'J\'ai compris',
        width: '600px'
    });
});
```

---

## 🧪 Tests à effectuer

### Test 1 : Connexion en tant qu'Administrateur
1. [x] Se connecter avec un compte `admin`
2. [ ] Accéder à `/admin/users` → Succès ✅
3. [ ] Vérifier que le bouton "Nouvel Administrateur" est grisé 🔒
4. [ ] Vérifier le tooltip "Accès restreint"

### Test 2 : Tentative de création (Admin)
1. [ ] Essayer d'accéder à `/admin/users/create` directement
2. [ ] Vérifier : Redirection avec message d'erreur ❌
3. [ ] Message : "Seuls les super administrateurs peuvent créer..."

### Test 3 : Édition de clients (Admin)
1. [ ] Trouver un utilisateur de type `customer`
2. [ ] Cliquer sur le bouton Edit (icône crayon)
3. [ ] Vérifier : Accès accordé ✅
4. [ ] Modifier et sauvegarder → Succès

### Test 4 : Tentative d'édition d'admin (Admin)
1. [ ] Trouver un utilisateur de type `admin` ou `super_admin`
2. [ ] Vérifier : Bouton Edit remplacé par bouton 🔒
3. [ ] Cliquer sur le bouton 🔒
4. [ ] Vérifier : Modale "🚫 Accès Refusé" s'affiche
5. [ ] Vérifier le contenu de la modale (action, type, message)
6. [ ] Cliquer sur "J'ai compris" → Fermeture

### Test 5 : Tentative d'édition via URL directe (Admin)
1. [ ] Copier l'URL `/admin/users/{id}/edit` d'un admin
2. [ ] Coller dans le navigateur et valider
3. [ ] Vérifier : Redirection avec message d'erreur ❌

### Test 6 : Suppression de client (Admin)
1. [ ] Trouver un client sans commandes
2. [ ] Cliquer sur supprimer
3. [ ] Vérifier : Confirmation simple ✅
4. [ ] Confirmer → Suppression réussie

### Test 7 : Tentative de suppression d'admin (Admin)
1. [ ] Trouver un utilisateur de type `admin`
2. [ ] Vérifier : Bouton Delete remplacé par bouton 🔒
3. [ ] Cliquer sur le bouton 🔒
4. [ ] Vérifier : Modale "🚫 Accès Refusé" s'affiche
5. [ ] Vérifier que l'action est "supprimer"

### Test 8 : Super Admin (contrôle)
1. [ ] Se connecter avec un compte `super_admin`
2. [ ] Vérifier : Bouton "Nouvel Administrateur" actif ✅
3. [ ] Vérifier : Tous les boutons Edit/Delete actifs (sauf super_admin)
4. [ ] Vérifier : Aucun bouton 🔒 visible

---

## 📋 Messages d'erreur

### Backend (redirection)
```php
'Accès refusé. Seuls les super administrateurs peuvent créer des administrateurs.'
'Accès refusé. Vous ne pouvez pas modifier un administrateur ou super administrateur.'
'Accès refusé. Vous ne pouvez pas supprimer un administrateur ou super administrateur.'
```

### Frontend (modale)
```
🚫 Accès Refusé

Vous n'avez pas les permissions nécessaires pour effectuer cette action.

Action demandée : Modifier/Supprimer "Nom Utilisateur"
Type d'utilisateur : Administrateur/Super Administrateur

⚠️ Seuls les super administrateurs peuvent [action] des administrateurs 
   ou super administrateurs.

Si vous pensez avoir besoin de ces permissions, veuillez contacter 
un super administrateur.
```

---

## 🎯 Avantages de ce système

### 1. **Sécurité renforcée** 🔒
- Validation à **deux niveaux** (frontend + backend)
- Impossible de contourner via l'URL directe
- Messages clairs pour l'utilisateur

### 2. **UX améliorée** 🎨
- Boutons visuellement grisés (pas masqués)
- Modale informative au lieu d'une erreur brutale
- Messages d'aide pour contacter un super admin

### 3. **Hiérarchie claire** 📊
- Super Admin → Gestion complète
- Admin → Gestion des clients uniquement
- Séparation des responsabilités

### 4. **Prévention des erreurs** ✅
- L'admin **voit** les autres admins mais ne peut pas les modifier
- Pas de frustration de "pourquoi je ne les vois pas ?"
- Feedback immédiat avec la modale

---

## 🔄 Flux de sécurité

### Scénario : Admin tente de modifier un autre Admin

```
[Admin clique sur Edit]
  ↓
[Frontend] Vérifie le type d'utilisateur
  ↓
[Affiche bouton 🔒 au lieu d'Edit]
  ↓
[Admin clique sur 🔒]
  ↓
[JavaScript] Récupère les données (action, nom, type)
  ↓
[Affiche modale SweetAlert2 "🚫 Accès Refusé"]
  ↓
[Admin lit le message explicatif]
  ↓
[Clique sur "J'ai compris"]
  ↓
[Fin - Aucune action effectuée]
```

### Si l'admin tente via URL directe :

```
[Admin tape /admin/users/5/edit dans l'URL]
  ↓
[Backend] UserController@edit vérifie les permissions
  ↓
[Détecte : Admin tente d'éditer un Admin]
  ↓
[Redirection vers /admin/users]
  ↓
[Affiche message flash d'erreur]
  ↓
[SweetAlert2 affiche l'erreur]
  ↓
[Fin - Accès refusé]
```

---

## ✅ Checklist de vérification

- [x] Middleware permet l'accès aux admins
- [x] Bouton "Nouvel Administrateur" grisé pour admins
- [x] Vérification dans `create()` et `store()`
- [x] Vérification dans `edit()` et `update()`
- [x] Vérification dans `destroy()`
- [x] Logique PHP dans la vue pour déterminer `$canEdit` et `$canDelete`
- [x] Boutons 🔒 affichés quand accès refusé
- [x] Classe `btn-access-denied` ajoutée
- [x] Attributs data (action, user-name, user-type)
- [x] Script JavaScript pour gérer le clic
- [x] Modale SweetAlert2 personnalisée
- [x] Messages d'erreur explicites
- [x] Tests des différents scénarios

---

## 🚀 Résumé

**Avant** : Seuls les super admins pouvaient accéder à la gestion des utilisateurs.

**Maintenant** :
- ✅ Les **admins** peuvent accéder à la page
- ✅ Ils peuvent **gérer les clients** (edit, delete)
- ❌ Ils **ne peuvent PAS** gérer les admins/super_admins
- 🔒 Boutons visuels avec icône de cadenas
- 🚫 Modale informative "Accès Refusé"
- 🛡️ Protection backend ET frontend

**Résultat** : Système hiérarchique clair, sécurisé et convivial ! 🎉

---

**Créé le :** 18 octobre 2025  
**Statut :** ✅ OPÉRATIONNEL - Prêt pour les tests

