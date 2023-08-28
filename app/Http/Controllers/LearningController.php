<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class LearningController extends Controller
{
    public function store() {
        return Inertia::render('Learinigs/Store');
    }

    public function update() {
        return Inertia::render('Learinigs/Update');
    }

    public function destroy() {
        return Inertia::render('Learinigs/Delete');
    }
}
