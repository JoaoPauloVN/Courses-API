<?php
namespace App\Http\Controllers;

use Inertia\Inertia;

class CategoryController extends Controller
{
    public function list() {
        return Inertia::render('Categories/List');
    }

    public function store() {
        return Inertia::render('Categories/Store');
    }

    public function update() {
        return Inertia::render('Categories/Update');
    }

    public function destroy() {
        return Inertia::render('Categories/Delete');
    }
}
