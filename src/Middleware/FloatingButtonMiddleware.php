<?php

namespace TianSchutte\ServiceDeskJira\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

/**
 * Class FloatingButtonMiddleware
 * @author Tian Schutte
 * @description Checks if the response is successful, then retrieves response, renders 'floating_button'
 *              and appends content of this to response's content string before </body> tag.
 * @package TianSchutte\ServiceDeskJira
 */
class FloatingButtonMiddleware
{

    /**
     * @param $request
     * @param Closure $next
     * @return Response|mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->is('service-desk-jira*')) {
            return $next($request);
        }

        $isSuccessful = $response instanceof Response && $response->getStatusCode() == 200;

        if ($isSuccessful) {
            $floatingButton = View::make('service-desk-jira::floating_button');
            $content = $response->getContent();
            $post = strripos($content, '</body>');

            if ($post !== false) {
                $content = substr($content, 0, $post) . $floatingButton->render() . substr($content, $post);
                $response->setContent($content);
            }
        }

        return $response;
    }
}
