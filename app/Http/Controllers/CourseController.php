<?php
namespace App\Http\Controllers;

use Inertia\Inertia;

class CourseController extends Controller
{
    public function list() {
        return Inertia::render('Courses/List');
    }

    public function details() {
        return Inertia::render('Courses/Details');
    }

    public function store() {
        return Inertia::render('Courses/Store');
    }

    public function update() {
        return Inertia::render('Courses/Update');
    }

    public function destroy() {
        return Inertia::render('Courses/Delete');
    }

    public function students() {
        return Inertia::render('Courses/Students');
    }

    public function review() {
        return Inertia::render('Courses/Review');
    }

    public function subscribe() {
        return Inertia::render('Courses/Subscribe');
    }

    public function unsubscribe() {
        return Inertia::render('Courses/Unsubscribe');
    }
}
