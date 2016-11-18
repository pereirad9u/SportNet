<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
use App\Models\Users;


$app->add(function ($request, $response, $next) {
    $this->view->offsetSet('flash', $this->flash);
    return $next($request, $response);
});

$middleware_user_co = function ($request, $response, $next) {
    if (isset($_SESSION['uniqid']) && isset($_SESSION['type']) && $_SESSION['type']=='user'){
        return $response = $next($request, $response);
    }else{
        $uri = $request->getUri()->withPath($this->router->pathFor('homepage'));
        return $response = $response->withRedirect($uri, 302);
    }
};

$middleware_org_co = function ($request, $response, $next) {
    if (isset($_SESSION['uniqid']) && isset($_SESSION['type']) && $_SESSION['type']=='org'){
        return $response = $next($request, $response);
    }else{
        $uri = $request->getUri()->withPath($this->router->pathFor('homepage'));
        return $response = $response->withRedirect($uri, 302);
    }
};


$app->add(function ($request, $response, $next) {
    if (!(starts_with($request->getUri()->getPath(),'/ajax'))){
        if (isset($_SESSION['uniqid']) && isset($_SESSION['type'])){
            if ($_SESSION['type'] == 'org'){
                $o = \App\Models\Organisers::find($_SESSION['uniqid']);
                $this->view->render($response,'header.twig',['org'=>$o]);
            }else{
                $u = Users::find($_SESSION['uniqid']);
                $this->view->render($response,'header.twig',['user'=>$u, 'nb_panier'=>sizeof($_SESSION['panier'])]);
            }

        }else{
            $this->view->render($response,'header.twig');
        }
        $response = $next($request, $response);
        $this->view->render($response,'footer.twig');

        return $response;
    }else{
        $response = $next($request, $response);
        return $response;
    }
});