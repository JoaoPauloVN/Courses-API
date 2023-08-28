<?php
namespace App\Http\Controllers;

use Inertia\Inertia;

class LessonController extends Controller
{
    public function list() {
        return Inertia::render('Lessons/List');
    }

    public function details() {
        return Inertia::render('Lessons/Details');
    }

    public function store() {
        return Inertia::render('Lessons/Store');
    }

    public function update() {
        return Inertia::render('Lessons/Update');
    }

    public function destroy() {
        return Inertia::render('Lessons/Delete');
    }
}
