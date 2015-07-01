<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->auth->guest())
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('login');
			}
		}

        // check if the current route is 'user/activate'
//        var_dump($request->route());
//        return 'asdf';
        if ($request->is('user/activate') || $request->is('user/activate/*'))
        {
            return $next($request);
        }

        // for those users who are not activated yet.
        if (!$this->auth->user()->isActivated())
        {
            return redirect('user/activate');
        }

		return $next($request);
	}

}
