<?php namespace App\Exceptions;

use ErrorException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;
use Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException'
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        if (env('APP_ENV', 'production') === 'production') {
            Log::error($e);
        }
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($this->isHttpException($e)) {
            if ($e instanceof NotFoundHttpException) {
                Flash::error('We Didn\'t find this url on our routes, error code(NotFoundHttpException)');

            } else {
                Flash::error('an HHTP error Occurred , Our engineers got notified and will be working on it. error code(HTTPException)');
            }
            if (env('APP_ENV', 'production') === 'production') {
                return Redirect::back();

            }

            return $this->renderHttpException($e);
        } else {
            if ($e instanceof ErrorException) {

                Flash::error('Server error. CarTow.ie technical support have been notified and are working to resolve the issue. Error code (ErrorException)');

            } else {
                Flash::error('An error has occurred , Our engineers got notified and will be working on it.');
            }
            if (env('APP_ENV', 'production') === 'production') {
                return Redirect::to('dashboard');

            }

            return parent::render($request, $e);
        }
    }

}
