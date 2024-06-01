<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Menu;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Contracts\Cache\CacheInterface;

class MenuUpdateFromSheetController extends AbstractController
{

    #[Route('/cms-sheets/menu-update', name:'cms-sheets_menu-update')]
    public function menuUpdateFromSheet(Request $request, EntityManagerInterface $entityManager, MenuRepository $menuRepository, CacheInterface $menuCache): Response
    {
        $headerToken = $request->headers->get('Authorization');
        $expectedToken = 'Bearer ' . $_ENV["APP_GOOGLE_APP_SCRIPTS_TOKEN"];
    
        if ($headerToken !== $expectedToken) {
            return new Response('Unauthorized', Response::HTTP_UNAUTHORIZED);
        } else {
            $data = json_decode($request->getContent(), true);

            $sheetRowData = $data['sheetRowData'];

            $id_cms = $sheetRowData['id'];
            $name = $sheetRowData['name'];
            $url = $sheetRowData['url'];
            $type = $sheetRowData['type'];

            $existsMenu = $menuRepository->findMenu($id_cms);

            if ($existsMenu) {
                $menu = $existsMenu;
            } else {
                $menu = new Menu();
                $menu->setIdCms($id_cms);
            }

            $menu->setName($name);
            $menu->setUrl($url);
            $menu->setType($type);

            $entityManager->persist($menu);
            $entityManager->flush();

            $cacheKey = 'menu';
            $menuCache->delete($cacheKey);

            return new Response('success', Response::HTTP_OK);
        }
    }
}