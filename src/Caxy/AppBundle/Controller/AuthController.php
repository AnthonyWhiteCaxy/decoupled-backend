<?php

namespace Caxy\AppBundle\Controller;

use Doctrine\Common\Persistence\ObjectRepository;
use OAuth2\OAuth2;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class AuthController extends Controller
{
    /**
     * Return JWT Token
     *
     * @param  Request $request
     * @return mixed
     */
    public function providerAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Client');
        $data = json_decode($request->getContent(), true);

        $client = $repo->find($data['clientId']);

        $params = array(
            'code' => $data['code'],
            'client_id' => $data['clientId'],
            'redirect_uri' => $data['redirectUri'],
            'grant_type' => OAuth2::GRANT_TYPE_AUTH_CODE,
            'client_secret' => $client->getSecret(),
        );

        // Step 1. Exchange authorization code for access token.
        $subrequest = new Request($params, array(), array('_controller' => 'fos_oauth_server.controller.token:tokenAction'));
        $subresponse = $this->get('http_kernel')->handle($subrequest, HttpKernelInterface::SUB_REQUEST);

        /** @var ObjectRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:AccessToken');
        $data = json_decode($subresponse->getContent(), true);
        $authCode = $repo->findOneBy(['token' => $data['access_token']]);

        $jwtManager = $this->get('lexik_jwt_authentication.jwt_manager');
        return JsonResponse::create(array('token' => $jwtManager->create($authCode->getUser())));
    }
}
