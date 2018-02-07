<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/02/2018
 * Time: 00:45
 */

namespace MyApp\UserBundle\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;


class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $authorizationChecker;

    public function __construct(Router $router, AuthorizationChecker $authorizationChecker) {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {

        $response = null;

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('Admin'));
        } else if ($this->authorizationChecker->isGranted('ROLE_USER')) {
            $response = new RedirectResponse($this->router->generate('my_app_user_homepage'));
        }

        return $response;
    }

}