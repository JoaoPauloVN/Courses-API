<?php
namespace App\Http\Controllers;

use Inertia\Inertia;

class ModuleController extends Controller
{
    public function list() {
        return Inertia::render('Modules/List');
    }

    public function store() {
        return Inertia::render('Modules/Store');
    }

    public function update() {
        return Inertia::render('Modules/Update');
    }

    public function destroy() {
        return Inertia::render('Modules/Delete');
    }
}
