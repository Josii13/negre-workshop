# Configuration EmailJS - Guide d'installation

## 📧 Variables d'environnement requises

Ajoutez ces variables à votre fichier `.env` :

```env
# Configuration EmailJS pour l'envoi sécurisé d'emails
EMAILJS_PUBLIC_KEY=your_public_key_here
EMAILJS_SERVICE_ID=service_xxxxxxx
EMAILJS_TEMPLATE_ID=template_client_xxxxx
EMAILJS_TEMPLATE_ADMIN_ID=template_admin_xxxxx

# Coordonnées administrateur
ADMIN_EMAIL=admin@example.com
ADMIN_NAME="Administrateur NÈGRE Shop"

# Numéro WhatsApp (format international sans +)
WHATSAPP_NUMBER=2250769465904
```

## 🔐 Sécurité

- Les valeurs ci-dessus sont accessibles via l'API `/api/email-config`
- Elles sont publiques et ne contiennent AUCUNE clé secrète
- Les clés privées EmailJS (si elles existent) ne doivent JAMAIS être exposées côté client

## 🚀 Comment ça fonctionne

### 1. Backend (Laravel)

**Route API** : `GET /api/email-config`
- Contrôleur : `App\Http\Controllers\Api\EmailConfigController`
- Retourne la configuration EmailJS publique en JSON

### 2. Frontend (JavaScript)

**Fichier** : `public/js/order-email-handler.js`
- Charge automatiquement la configuration depuis l'API
- Initialise EmailJS avec la clé publique
- Gère l'envoi double (client + admin)
- Gère la redirection WhatsApp

### 3. Utilisation dans les pages

```javascript
// Le système se charge automatiquement au chargement de la page
// Accessible via : window.OrderEmailHandler

// Envoyer un email double (client + admin)
await window.OrderEmailHandler.sendDualEmails(form, {
    product_name: 'Nom du produit',
    product_price: '50000 FCFA'
});

// Ouvrir WhatsApp avec message pré-rempli
const url = window.OrderEmailHandler.openWhatsAppWithMessage('Message');
```

## 📝 Templates EmailJS requis

### Template Client (EMAILJS_TEMPLATE_ID)

Variables disponibles :
- `{{to_email}}` - Email du client
- `{{to_name}}` - Nom du client
- `{{product_name}}` - Nom du produit
- `{{product_price}}` - Prix du produit
- `{{customer_phone}}` - Téléphone du client
- `{{message}}` - Message de la commande

### Template Admin (EMAILJS_TEMPLATE_ADMIN_ID)

Variables disponibles :
- `{{to_email}}` - Email admin (ADMIN_EMAIL)
- `{{to_name}}` - Nom admin (ADMIN_NAME)
- `{{customer_name}}` - Nom du client
- `{{customer_email}}` - Email du client
- `{{customer_phone}}` - Téléphone du client
- `{{product_name}}` - Nom du produit
- `{{product_price}}` - Prix du produit
- `{{message}}` - Message de la commande
- `{{order_date}}` - Date de la commande

## ✅ Test de configuration

1. Ouvrir la console navigateur sur une page avec formulaire de commande
2. Taper : `window.OrderEmailHandler.isReady()`
3. Doit retourner `true` si tout est configuré correctement

## 🔍 Debug

Si les emails ne partent pas :

1. **Vérifier la console** : `console.log(window.OrderEmailHandler.getConfig())`
2. **Vérifier l'initialisation** : `window.OrderEmailHandler.isReady()`
3. **Vérifier l'API** : Aller sur `/api/email-config` dans le navigateur
4. **Vérifier EmailJS** : Quota restant sur votre compte EmailJS

