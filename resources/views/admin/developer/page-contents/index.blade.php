@extends('admin.layouts.app')

@section('title', 'Contenus des Pages')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Contenus des Pages</h1>
</div>

<!-- Content Row -->
<div class="row">
    @foreach($pages as $slug => $name)
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="font-weight-bold text-primary text-uppercase mb-1">
                            {{ $name }}
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            Modifier le contenu
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.developer.page-contents.edit', $slug) }}" class="btn btn-primary btn-sm btn-block">
                        <i class="fas fa-edit"></i> Éditer
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Info Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Information</h6>
    </div>
    <div class="card-body">
        <p class="mb-2">
            <i class="fas fa-info-circle text-info"></i>
            Les modifications apportées ici seront immédiatement visibles sur le site public.
        </p>
        <p class="mb-0">
            <i class="fas fa-lock text-warning"></i>
            Seuls les super administrateurs peuvent modifier ces contenus.
        </p>
    </div>
</div>
@endsection

