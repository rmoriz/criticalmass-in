<?php declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Photo;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends BaseController
{
    /**
     * This is a pretty useless endpoint which is not ready for usage now.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Does bullshit",
     *  section="Photo"
     * )
     */
    public function galleryAction(RegistryInterface $registry): Response
    {
        $photoRides = $registry->getRepository(Photo::class)->findRidesForGallery();

        $view = View::create();
        $view
            ->setData($photoRides)
            ->setFormat('json')
            ->setStatusCode(200);

        return $this->handleView($view);
    }
}
