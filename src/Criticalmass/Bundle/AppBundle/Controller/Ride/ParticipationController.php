<?php

namespace Criticalmass\Bundle\AppBundle\Controller\Ride;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Criticalmass\Bundle\AppBundle\Controller\AbstractController;
use Criticalmass\Bundle\AppBundle\Entity\Participation;
use Criticalmass\Bundle\AppBundle\Entity\Ride;
use Symfony\Component\HttpFoundation\Response;

class ParticipationController extends AbstractController
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("ride", class="AppBundle:Ride")
     */
    public function rideparticipationAction(Ride $ride, string $status): Response
    {
        $participation = $this->getParticipationRepository()->findParticipationForUserAndRide($this->getUser(), $ride);

        if (!$participation) {
            $participation = new Participation();
            $participation->setRide($ride);
            $participation->setUser($this->getUser());
        }

        $participation->setGoingYes($status === 'yes');
        $participation->setGoingMaybe($status === 'maybe');
        $participation->setGoingNo($status === 'no');

        $em = $this->getDoctrine()->getManager();
        $em->merge($participation);
        $em->flush();

        $this->recalculateRideParticipations($ride);

        return $this->redirectToObject($ride);
    }

    protected function recalculateRideParticipations(Ride $ride): void
    {
        $ride->setParticipationsNumberYes($this->getParticipationRepository()->countParticipationsForRide($ride,
            'yes'));
        $ride->setParticipationsNumberMaybe($this->getParticipationRepository()->countParticipationsForRide($ride,
            'maybe'));
        $ride->setParticipationsNumberNo($this->getParticipationRepository()->countParticipationsForRide($ride, 'no'));

        $em = $this->getDoctrine()->getManager();
        $em->merge($ride);
        $em->flush();
    }
}
