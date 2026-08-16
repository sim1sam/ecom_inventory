<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use App\Models\MaintainanceText;
class MaintainaceMode
{
    public function handle(Request $request, Closure $next)
    {
        // Get maintenance mode status from database
        $maintainance = MaintainanceText::first();
        
        // Check if maintenance mode is active
        if ($maintainance && $maintainance->status == 1) {
            // Allow admin routes to pass through
            if ($request->is('admin/*') || $request->is('admin')) {
                return $next($request);
            }
            
            // Redirect to maintenance page for all other routes
            return response()->view('maintenance', compact('maintainance'), 503);
        }
        
        return $next($request);
    }
}

