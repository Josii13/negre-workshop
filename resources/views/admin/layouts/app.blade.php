<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin') - {{ config('app.name', 'Negre Shop') }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Protection contre les styles publics -->
    <style>
        /* Réinitialiser TOUS les styles publics qui pourraient affecter l'admin */
        body#page-top {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
            padding-top: 0 !important;
            background-color: #f8f9fc !important;
            margin: 0 !important;
        }
        
        /* S'assurer que les styles publics n'affectent pas l'admin */
        #wrapper,
        #wrapper * {
            font-family: 'Nunito', sans-serif !important;
        }
        
        /* EXCEPTION : Préserver les icônes FontAwesome */
        #wrapper .fa,
        #wrapper .fas,
        #wrapper .far,
        #wrapper .fal,
        #wrapper .fab {
            font-family: "Font Awesome 5 Free" !important;
        }
        
        #wrapper .fab {
            font-family: "Font Awesome 5 Brands" !important;
        }
        
        /* Protéger la navigation admin */
        #wrapper .navbar,
        body#page-top .navbar {
            position: static !important;
            padding: 1rem !important;
            border-bottom: 1px solid #e3e6f0 !important;
        }
        
        /* Reset des marges/paddings pour l'admin */
        #wrapper * {
            box-sizing: border-box;
        }
        
        /* S'assurer que les cards admin ne sont pas affectées */
        #wrapper .card {
            position: relative !important;
            display: flex !important;
            flex-direction: column !important;
            min-width: 0 !important;
            word-wrap: break-word !important;
            background-color: #fff !important;
            background-clip: border-box !important;
            border: 1px solid #e3e6f0 !important;
            border-radius: .35rem !important;
        }
    </style>
    
    @yield('styles')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.layouts.partials.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.layouts.partials.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('admin.layouts.partials.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Prêt à partir ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à terminer votre session actuelle.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script pour le centre de messages -->
    <script>
        function showContactModal(id, name, email, phone, message, date) {
            Swal.fire({
                title: '<i class="fas fa-envelope"></i> Message de Contact',
                html: `
                    <div style="text-align: left; padding: 20px;">
                        <div style="margin-bottom: 15px; padding: 10px; background-color: #f8f9fc; border-radius: 5px;">
                            <strong><i class="fas fa-user text-primary"></i> Nom :</strong> ${name}
                        </div>
                        <div style="margin-bottom: 15px; padding: 10px; background-color: #f8f9fc; border-radius: 5px;">
                            <strong><i class="fas fa-envelope text-primary"></i> Email :</strong> 
                            <a href="mailto:${email}" style="color: #4e73df;">${email}</a>
                        </div>
                        <div style="margin-bottom: 15px; padding: 10px; background-color: #f8f9fc; border-radius: 5px;">
                            <strong><i class="fas fa-phone text-primary"></i> Téléphone :</strong> ${phone}
                        </div>
                        <div style="margin-bottom: 15px; padding: 10px; background-color: #f8f9fc; border-radius: 5px;">
                            <strong><i class="fas fa-clock text-primary"></i> Date :</strong> ${date}
                        </div>
                        <div style="padding: 15px; background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 5px;">
                            <strong><i class="fas fa-comment-dots text-warning"></i> Message :</strong>
                            <p style="margin-top: 10px; white-space: pre-wrap; color: #333;">${message}</p>
                        </div>
                    </div>
                `,
                width: '700px',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-reply"></i> Répondre par email',
                cancelButtonText: 'Fermer',
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#858796',
                customClass: {
                    container: 'contact-modal-container'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Ouvrir le client email par défaut
                    window.location.href = `mailto:${email}?subject=Re: Votre message de contact&body=Bonjour ${name},%0D%0A%0D%0A`;
                }
            });
        }
    </script>

    @yield('scripts')

</body>

</html>

