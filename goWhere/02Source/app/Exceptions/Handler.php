<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\ExceptionHandler as SymfonyDisplayer;
use Psr\Log\LoggerInterface;

class Handler extends ExceptionHandler
{
    protected $pathPrefix;

    public function __construct(LoggerInterface $log)
    {
        parent::__construct($log);
        $this->pathPrefix = \Config::get('app.isBackend') === true ? 'admin.' : '';
    }

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $e            
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request            
     * @param \Exception $e            
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }
        return parent::render($request, $e);
    }

    /**
     * 前后台HttpException使用不同路径的错误页
     * @param HttpException $e
     * @return type
     */
    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();
        if (view()->exists($this->pathPrefix . "errors.{$status}")) {
            return response()->view($this->pathPrefix . "errors.{$status}", ['exception' => $e], $status);
        } else {
            return $this->convertExceptionToResponse($e);
        }
    }

    /**
     * 其他Exception在未开启debug的情况下使用$this->pathPrefix.errors.error视图输出
     * @param Exception $e
     * @return type
     */
    protected function convertExceptionToResponse(Exception $e)
    {
        if (config('app.debug') || !view()->exists($this->pathPrefix . "errors.error")) {
            return (new SymfonyDisplayer(config('app.debug')))->createResponse($e);
        }
        return response()->view($this->pathPrefix . "errors.error", ['exception' => $e]);
    }

}
