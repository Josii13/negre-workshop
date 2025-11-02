<?php

namespace App\Http\View\Composers;

use App\Models\ModalContent;
use Illuminate\View\View;

class ModalContentComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('modalContent', ModalContent::first());
    }
}

