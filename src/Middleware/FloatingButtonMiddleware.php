<?php

namespace TianSchutte\ServiceDeskJira\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use TianSchutte\ServiceDeskJira\Services\ServiceDeskService;

/**
 * Class FloatingButtonMiddleware
 * @author Tian Schutte
 * @description Checks if the response is successful, then retrieves response, renders 'floating_button'
 *              and appends content of this to response's content string before </body> tag. Al so firstly checks
 *              if the request is a request from the service-desk-jira package, if so, it will not append the floating button.
 * @package TianSchutte\ServiceDeskJira
 */
class FloatingButtonMiddleware
{
    /**
     * @var ServiceDeskService
     */
    private $serviceDeskService;

    /**
     * FloatingButtonMiddleware constructor.
     */
    public function __construct(ServiceDeskService $serviceDeskService)
    {
        $this->serviceDeskService = $serviceDeskService;
    }

    /**
     * @param $request
     * @param Closure $next
     * @return Response|mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->is('service-desk-jira*')) {
            return $response;
        }

        if(!auth()->check()) {
            return $response;
        }

        if (session('service_desk_customer_checked') === false) {
            return $response;
        }

        if (session('service_desk_customer_checked') === true) {
            $this->addFloatingButton($response);
            return $response;
        }

        if (!$this->serviceDeskService->isServiceDeskCustomer()) {
            session(['service_desk_customer_checked' => false]);

            return $response;
        }

        $this->addFloatingButton($response);

        return $response;
    }

    private function addFloatingButton($response)
    {
        $isSuccessful = $response instanceof Response && $response->getStatusCode() == 200;

        if ($isSuccessful) {
            $floatingButton = View::make('service-desk-jira::floating_button');
            $content = $response->getContent();
            $post = strripos($content, '</body>');

            if ($post !== false) {
                $content = substr($content, 0, $post) . $floatingButton->render() . substr($content, $post);
                $response->setContent($content);

                session(['service_desk_customer_checked' => true]);
            }
        }
    }
}
