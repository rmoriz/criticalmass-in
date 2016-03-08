<?php

namespace Caldera\Bundle\CriticalmassSiteBundle\Controller;

use Caldera\Bundle\CriticalmassCoreBundle\Image\ExifReader\DateTimeExifReader;
use Caldera\Bundle\CriticalmassCoreBundle\Image\PhotoGps\PhotoGps;
use Caldera\Bundle\CriticalmassModelBundle\Entity\Event;
use Caldera\Bundle\CriticalmassModelBundle\Entity\Photo;
use Caldera\Bundle\CriticalmassModelBundle\Entity\Ride;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PhotoController extends AbstractController
{
    public function uploadAction(Request $request, $citySlug, $rideDate)
    {
        $ride = $this->getCheckedCitySlugRideDateRide($citySlug, $rideDate);

        if ($request->getMethod() == 'POST') {
            return $this->uploadPostAction($request, $ride);
        } else {
            return $this->render('CalderaCriticalmassSiteBundle:Photo:upload.html.twig', [
                'ride' => $ride
            ]);
        }
    }

    protected function uploadGetAction(Request $request, Ride $ride = null, Event $event = null)
    {
        return $this->render('CalderaCriticalmassSiteBundle:PhotoUpload:upload.html.twig', [
            'ride' => $ride,
            'event' => $event
        ]);
    }

    protected function uploadPostAction(Request $request, Ride $ride = null, Event $event = null)
    {
        $em = $this->getDoctrine()->getManager();

        $photo = new Photo();

        $photo->setImageFile($request->files->get('file'));
        $photo->setUser($this->getUser());
        $photo->setRide($ride);
        $photo->setCity($ride->getCity());

        if ($ride) {
            $photo->setRide($ride);
            $photo->setCity($ride->getCity());
        }

        if ($event) {
            $photo->setEvent($event);
            $photo->setCity($event->getCity());
        }

        $em->persist($photo);
        $em->flush();

        /**
         * @var DateTimeExifReader $dter
         */
        $dter = $this->get('caldera.criticalmass.image.exifreader.datetime');

        $dateTime = $dter
            ->setPhoto($photo)
            ->execute()
            ->getDateTime();

        $photo->setDateTime($dateTime);

        $em->persist($photo);
        $em->flush();

        $track = $this->getTrackRepository()->findByUserAndRide($ride, $this->getUser());

        if ($ride) {
            $track = $this->getTrackRepository()->findByUserAndRide($ride, $this->getUser());
        }

        if ($ride and $track) {
            /**
             * @var PhotoGps $pgps
             */
            $pgps = $this->get('caldera.criticalmass.image.photogps');

            $pgps
                ->setPhoto($photo)
                ->setTrack($track)
                ->execute();

            $em->merge($photo);
            $em->flush();
        }

        return new Response('foo');
    }
}
