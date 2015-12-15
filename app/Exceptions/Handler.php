<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Mail;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * @override
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		if ($this->shouldReport($e)) {
			$this->log->error($e);

			// send exception report to admin
			if (app()->environment() == 'production' && !env('APP_DEBUG'))
			{
				$data = [
						'exception_message'	=> $e->getMessage(),
						'code'		=> $e->getCode(),
						'file'		=> $e->getFile(),
						'trace'		=> $e->getTraceAsString()
				];

				Mail::queue('emails.exception-report', $data, function($message) {
					$message->to('kingdido999@gmail.com');
					$message->subject('Stuvi Exception Report');
				});
			}
		}
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		return parent::render($request, $e);
	}

}
