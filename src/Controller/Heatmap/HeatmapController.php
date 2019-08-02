<?php declare(strict_types=1);

namespace App\Controller\Heatmap;

use App\Controller\AbstractController;
use App\Entity\City;
use App\Entity\Ride;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class HeatmapController extends AbstractController
{
    /**
     * @ParamConverter("city", class="App:City")
     */
    public function cityAction(City $city): Response
    {
        return $this->render('Heatmap/city.html.twig', [
            'city' => $city,
        ]);
    }

    /**
     * @ParamConverter("ride", class="App:Ride")
     */
    public function rideAction(Ride $ride): Response
    {
        return $this->render('Heatmap/ride.html.twig', [
            'ride' => $ride,
        ]);
    }

    /**
     * @ParamConverter("user", class="App:User")
     */
    public function userAction(User $user): Response
    {
        return $this->render('Heatmap/user.html.twig');
    }
}
