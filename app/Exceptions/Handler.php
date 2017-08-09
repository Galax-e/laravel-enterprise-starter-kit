<?php
namespace App\Exceptions;
use App\Libraries\Utils;
use Auth;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Input;
use LERN;
use Request;
use Setting;
use View;
class Handler extends ExceptionHandler
{
   /**
    * A list of the exception types that should not be reported.
    *
    * @var array
    */
   protected $dontReport = [
       \Symfony\Component\HttpKernel\Exception\HttpException::class,
   ];
   /**
    * Report or log an exception.
    *
    * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
    *
    * @param  \Exception  $e
    * @return void
    */
   public function report(Exception $e)
   {
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
     
   }
   private function setLERNNotificationFormat()
   {
       
   }
}