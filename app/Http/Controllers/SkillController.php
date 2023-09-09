<?php
namespace App\Http\Controllers;

use Inertia\Inertia;

class SkillController extends Controller
{
    public function list() {
        return Inertia::render('Skills/List');
    }

    public function store() {
        return Inertia::render('Skills/Store');
    }

    public function update() {
        return Inertia::render('Skills/Update');
    }

    public function destroy() {
        return Inertia::render('Skills/Delete');
    }
}
