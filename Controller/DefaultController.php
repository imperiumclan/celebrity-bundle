<?php

namespace ICS\CelebrityBundle\Controller;

use ICS\CelebrityBundle\Entity\Celebrity;
use ICS\CelebrityBundle\Form\Type\CelebrityType;
use ICS\CelebrityBundle\Service\CelebrityService;
use ICS\MediaBundle\Entity\MediaImage;
use ICS\MediaBundle\Service\MediaClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/" , name="ics_celebrity_homepage")
     */
    public function index(Request $request)
    {
        $celebrities = $this->getDoctrine()->getRepository(Celebrity::class)->findBy([], ['fullname' => 'ASC']);

        return $this->render('@Celebrity/index.html.twig', [
            'celebrities' => $celebrities,
        ]);
    }
    /**
     * @Route("/add" , name="ics_celebrity_add")
     * @Route("/edit/{id}" , name="ics_celebrity_edit")
     */
    public function add(Request $request, $id = null)
    {
        $celebrity = new Celebrity();

        if ($id != null) {
            $celebrity = $this->getDoctrine()->getRepository(Celebrity::class)->find($id);
        }


        $form = $this->createForm(CelebrityType::class, $celebrity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $celebrity = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($celebrity);
            $em->flush();

            return $this->redirectToRoute('ics_celebrity_show', [
                'id' => $celebrity->getId()
            ]);
        }

        return $this->render('@Celebrity/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/show/{id}" , name="ics_celebrity_show")
     */
    public function show(CelebrityService $client, $id)
    {
        $celebrity = $this->getDoctrine()->getRepository(Celebrity::class)->find($id);

        $search = $celebrity->getFullname();
        $images = [];

        if ($search != "") {

            $images = $client->search($search);
        }
        return $this->render('@Celebrity/show.html.twig', [
            'celebrity' => $celebrity,
            'images' => $images,
        ]);
    }
    /**
     * @Route("/search/celebrityninja", options={"expose"=true}, name="ics_celebrity_cn_search")
     */
    public function search_cn(Request $request, CelebrityService $client)
    {
        $search = $request->get('search');

        $infos = $client->getInfosFromCN($search);

        return $this->render('@Celebrity/cnResults.html.twig', [
            'infos' => $infos
        ]);
    }

    /**
     * @Route("/download/{id}", options={"expose"=true}, name="ics_celebrity_download")
     */
    public function download(Request $request, MediaClient $media, int $id)
    {
        $celebrity = $this->getDoctrine()->getRepository(Celebrity::class)->find($id);
        $url = $request->get('mediaUrl', null);
        if ($celebrity == null || $url == null) {
            return $this->createNotFoundException('This celebrity do not exist');
        }
        $path = $this->getParameter('kernel.project_dir') . '/public/medias/celebrities/' . str_replace(' ', '_', $celebrity->getFullname());

        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }

        $files = scandir($path);
        $image = $media->DownloadImage('https:' . $url, $path . '/' . (count($files) - 2) . '.jpeg');
        $celebrity->getGallery()->add($image);

        $em = $this->getDoctrine()->getManager();
        $em->persist($celebrity);
        $em->flush();

        return new Response('ok');
    }
}
