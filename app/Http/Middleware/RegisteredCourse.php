<?php

namespace App\Http\Middleware;

use App\Trait\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisteredCourse
{
    use HttpResponses;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->route()->course) {
            $course = $request->route()->course->id;
            $courses = $request->user()->load('courses:id')->courses->pluck('id')->toArray(); 

            if(in_array($course, $courses))
            {
                return $next($request);
            }

            return $this->error(['errors' => __('generic.not_registered')], 401);
        }

        return $this->error(['errors' => __('generic.not_found')], 404); 
    }
}
