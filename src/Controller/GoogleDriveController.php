<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Google_Client;

class GoogleDriveController extends AbstractController
{

    #[Route('/cms-sheets/authorize', name: 'cms-sheets_authorize')]
    public function oauth(Google_Client $googleClient): RedirectResponse
    {
        $authUrl = $googleClient->createAuthUrl();

        return $this->redirect($authUrl);
    }

    // This should be the URL on your server that will process the OAuth 2.0 response.
    #[Route('/cms-sheets/authorized', name: 'cms-sheets_authorized')]
    public function oauthCallback(Request $request, Google_Client $googleClient)
    {
        $code = $request->query->get('code');

        if (isset($code)) {
            $accessToken = $googleClient->fetchAccessTokenWithAuthCode($code);
            $googleClient->setAccessToken($accessToken);

            file_put_contents($this->getParameter('kernel.project_dir') . '/tokens/google-drive-access-token.json', json_encode($accessToken));

            return $this->redirectToRoute('cms-sheets_authorized-success');
        }

        return $this->redirectToRoute('cms-sheets_authorized-error');
    }

    // #[Route('/cms-sheets/authorized-success', name: 'cms-sheets_authorized-success')]
    // public function authorizedSuccess(): Response
    // {
    //     return new Response('authorized-success');
    // }

    // #[Route('/cms-sheets/authorized-error', name: 'cms-sheets_authorized-error')]
    // public function authorizedError(): Response
    // {
    //     return new Response('authorized-error');
    // }
}