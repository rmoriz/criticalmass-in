<?php

namespace Caldera\Bundle\CriticalmassSiteBundle\Controller;

use Caldera\Bundle\CriticalmassCoreBundle\Board\Builder\BoardBuilder;
use Symfony\Component\HttpFoundation\Request;

class BoardController extends AbstractController
{
    public function overviewAction(Request $request)
    {
        /**
         * @var BoardBuilder $boardBuilder
         */
        $boardBuilder = $this->get('caldera.criticalmass.board.builder.boardbuilder');

        $boardBuilder->buildOverview();

        $tree = $boardBuilder->getList();

        return $this->render(
            'CalderaCriticalmassSiteBundle:Board:overview.html.twig',
            [
                'boardTree' => $tree
            ]
        );
    }

    public function viewcityboardAction(Request $request, $citySlug)
    {
        $city = $this->getCheckedCity($citySlug);

        /**
         * @var BoardBuilder $boardBuilder
         */
        $boardBuilder = $this->get('caldera.criticalmass.board.builder.boardbuilder');

        $boardBuilder->buildCityThreadBoard($city);

        return $this->render(
            'CalderaCriticalmassSiteBundle:Board:viewCityThreadBoard.html.twig',
            [
                'city' => $city,
                'threads' => $boardBuilder->getList()
            ]
        );
    }

    public function viewcitythreadAction(Request $request, $citySlug, $threadId)
    {

    }

    public function viewrideboardAction(Request $request, $citySlug)
    {
        $city = $this->getCheckedCity($citySlug);

        /**
         * @var BoardBuilder $boardBuilder
         */
        $boardBuilder = $this->get('caldera.criticalmass.board.builder.boardbuilder');

        $boardBuilder->buildRideBoard($city);

        return $this->render(
            'CalderaCriticalmassSiteBundle:Board:viewRideBoard.html.twig',
            [
                'city' => $city,
                'threads' => $boardBuilder->getList()
            ]
        );
    }

    public function viewridethreadAction(Request $request, $citySlug, $rideDate)
    {
        $ride = $this->getCheckedCitySlugRideDateRide($citySlug, $rideDate);

        /**
         * @var BoardBuilder $boardBuilder
         */
        $boardBuilder = $this->get('caldera.criticalmass.board.builder.boardbuilder');

        $boardBuilder->buildRideThread($ride);

        return $this->render(
            'CalderaCriticalmassSiteBundle:Board:viewRideThread.html.twig',
            [
                'posts' => $boardBuilder->getList()
            ]
        );
    }
}
