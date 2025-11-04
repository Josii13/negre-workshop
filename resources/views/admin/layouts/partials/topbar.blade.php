<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Rechercher..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                            placeholder="Rechercher..." aria-label="Search"
                            aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts (Commandes en attente) -->
        @php
            $pendingOrders = \App\Models\Order::where('status', 'pending')->latest()->take(5)->get();
            $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();

            // Calculer le nombre de notifications non lues
            $unreadOrdersCount = $pendingOrdersCount;
            if(isset($_COOKIE['read_orders'])) {
                $readOrders = json_decode($_COOKIE['read_orders'], true) ?? [];
                $unreadOrdersCount = $pendingOrdersCount - count($readOrders);
            }
        @endphp
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                @if($unreadOrdersCount > 0)
                    <span class="badge badge-danger badge-counter" id="ordersBadge">{{ $unreadOrdersCount > 9 ? '9+' : $unreadOrdersCount }}</span>
                @endif
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Centre d'alertes
                </h6>
                @forelse($pendingOrders as $order)
                    @php
                        $isRead = isset($_COOKIE['read_orders']) && in_array($order->id, json_decode($_COOKIE['read_orders'], true) ?? []);
                    @endphp
                    <a class="dropdown-item d-flex align-items-center order-notification {{ $isRead ? 'read-notification' : '' }}"
                       href="{{ route('admin.orders.index') }}"
                       data-order-id="{{ $order->id }}"
                       style="{{ $isRead ? 'opacity: 0.6;' : '' }}">
                        <div class="mr-3">
                            <div class="icon-circle bg-warning">
                                <i class="fas fa-shopping-cart text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{ $order->created_at->diffForHumans() }}</div>
                            <span class="font-weight-bold">Nouvelle commande de {{ $order->customer_name }}</span>
                            <div class="small text-truncate">{{ $order->product_name }} - {{ number_format($order->product_price, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </a>
                @empty
                    <div class="dropdown-item text-center text-gray-500 py-3">
                        <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                        <p class="mb-0">Aucune commande en attente</p>
                    </div>
                @endforelse
                @if($pendingOrdersCount > 0)
                    <a class="dropdown-item text-center small text-gray-500" href="{{ route('admin.orders.index') }}">Voir toutes les commandes</a>
                @endif
            </div>
        </li>

        <!-- Nav Item - Messages (Requêtes de contact) -->
        @php
            $recentContacts = \App\Models\Contact::latest()->take(5)->get();
            $contactsCount = \App\Models\Contact::count();

            // Calculer le nombre de messages non lus
            $unreadContactsCount = $contactsCount;
            if(isset($_COOKIE['read_contacts'])) {
                $readContacts = json_decode($_COOKIE['read_contacts'], true) ?? [];
                $unreadContactsCount = $contactsCount - count($readContacts);
            }
        @endphp
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                @if($unreadContactsCount > 0)
                    <span class="badge badge-danger badge-counter" id="contactsBadge">{{ $unreadContactsCount > 9 ? '9+' : $unreadContactsCount }}</span>
                @endif
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Centre de messages
                </h6>
                @forelse($recentContacts as $contact)
                    @php
                        $isRead = isset($_COOKIE['read_contacts']) && in_array($contact->id, json_decode($_COOKIE['read_contacts'], true) ?? []);
                    @endphp
                    <a class="dropdown-item d-flex align-items-center contact-notification {{ $isRead ? 'read-notification' : '' }}"
                       href="#"
                       onclick="event.preventDefault(); showContactModal('{{ $contact->id }}', '{{ addslashes($contact->name) }}', '{{ addslashes($contact->email) }}', '{{ addslashes($contact->phone ?? 'N/A') }}', '{{ addslashes($contact->message) }}', '{{ $contact->created_at->format('d/m/Y à H:i') }}');"
                       data-contact-id="{{ $contact->id }}"
                       style="{{ $isRead ? 'opacity: 0.6;' : '' }}">
                        <div class="dropdown-list-image mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-user text-white"></i>
                            </div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">{{ Str::limit($contact->message, 60) }}</div>
                            <div class="small text-gray-500">{{ $contact->name }} · {{ $contact->created_at->diffForHumans() }}</div>
                        </div>
                    </a>
                @empty
                    <div class="dropdown-item text-center text-gray-500 py-3">
                        <i class="fas fa-inbox fa-2x mb-2 text-muted"></i>
                        <p class="mb-0">Aucun message</p>
                    </div>
                @endforelse
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name ?? 'Administrateur' }}</span>
                <img class="img-profile rounded-circle" src="{{ asset('admin/img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('admin.profile.change-password') }}">
                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                    Modifier mon mot de passe
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Déconnexion
                </a>
            </div>
        </li>

    </ul>

</nav>

<script>
// Fonction pour mettre à jour un cookie
function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = name + '=' + JSON.stringify(value) + ';expires=' + expires.toUTCString() + ';path=/';
}

// Fonction pour récupérer un cookie
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return JSON.parse(c.substring(nameEQ.length, c.length));
    }
    return null;
}

document.addEventListener('DOMContentLoaded', function() {
    // Gestion des notifications de commandes
    const orderNotifications = document.querySelectorAll('.order-notification');
    const ordersBadge = document.getElementById('ordersBadge');

    orderNotifications.forEach(notification => {
        notification.addEventListener('click', function(e) {
            const orderId = this.getAttribute('data-order-id');

            // Récupérer les commandes lues
            let readOrders = getCookie('read_orders') || [];
            if (!readOrders.includes(orderId)) {
                readOrders.push(orderId);
                setCookie('read_orders', readOrders, 1); // Expire dans 1 jour
            }

            // Mettre à jour l'interface
            if (ordersBadge) {
                let currentCount = parseInt(ordersBadge.textContent);
                if (currentCount > 1) {
                    ordersBadge.textContent = currentCount - 1;
                } else {
                    ordersBadge.remove();
                }
            }

            // Marquer comme lu
            this.style.opacity = '0.6';
            this.classList.add('read-notification');
        });
    });

    // Gestion des notifications de contacts
    const contactNotifications = document.querySelectorAll('.contact-notification');
    const contactsBadge = document.getElementById('contactsBadge');

    contactNotifications.forEach(notification => {
        notification.addEventListener('click', function(e) {
            const contactId = this.getAttribute('data-contact-id');

            // Récupérer les contacts lus
            let readContacts = getCookie('read_contacts') || [];
            if (!readContacts.includes(contactId)) {
                readContacts.push(contactId);
                setCookie('read_contacts', readContacts, 1); // Expire dans 1 jour
            }

            // Mettre à jour l'interface
            if (contactsBadge) {
                let currentCount = parseInt(contactsBadge.textContent);
                if (currentCount > 1) {
                    contactsBadge.textContent = currentCount - 1;
                } else {
                    contactsBadge.remove();
                }
            }

            // Marquer comme lu
            this.style.opacity = '0.6';
            this.classList.add('read-notification');
        });
    });

    // Fonction pour réinitialiser toutes les notifications
    window.resetAllNotifications = function() {
        setCookie('read_orders', [], 1);
        setCookie('read_contacts', [], 1);
        location.reload();
    };
});
</script>
