<?php declare(strict_types=1);

namespace App\Controller\CityCycle;

use App\Controller\AbstractController;
use App\Criticalmass\RideGenerator\ExecuteGenerator\DateTimeListGenerator;
use App\Criticalmass\RideGenerator\RideGenerator\CityRideGeneratorInterface;
use App\Criticalmass\Util\DateTimeUtil;
use App\Entity\CityCycle;
use App\Entity\Ride;
use App\Form\Type\ExecuteCityCycleType;
use App\Model\RideGenerator\CycleExecutable;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CityCycleExecuteController extends AbstractController
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("cityCycle", class="App:CityCycle", options={"id" = "cycleId"})
     */
    public function executeAction(Request $request, CityCycle $cityCycle, SerializerInterface $serializer): Response
    {
        $dateTime = new Carbon();
        $sixMonthInterval = new CarbonInterval('P6M');

        $executeable = new CycleExecutable();
        $executeable
            ->setCityCycle($cityCycle)
            ->setFromDate($dateTime->startOfMonth())
            ->setUntilDate((clone $dateTime)->add($sixMonthInterval)->endOfMonth());

        $form = $this->createForm(ExecuteCityCycleType::class, $executeable);
        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = new Client(['verify' => false]);

            $result = $client->post('https://127.0.0.1:8001/api/preview', ['content-type' => 'text/json', 'body' => $serializer->serialize($executeable, 'json'),]);

            $rideList = $serializer->deserialize($result->getBody()->getContents(), 'array<App\Entity\Ride>', 'json');

            return $this->render('CityCycle/execute_preview.html.twig', [
                'cityCycle' => $cityCycle,
                'executeable' => $executeable,
                'dateTimeList' => [],
                'form' => $form->createView(),
                'rideList' => $rideList,
            ]);
        }

        return $this->render('CityCycle/execute_datetime.html.twig', [
            'cityCycle' => $cityCycle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("cityCycle", class="App:CityCycle", options={"id" = "cycleId"})
     */
    public function executePersistAction(Request $request, CityCycle $cityCycle, CityRideGeneratorInterface $generator, SessionInterface $session, ManagerRegistry $registry): Response
    {
        if (Request::METHOD_POST === $request->getMethod() && $request->request->getInt('fromDate') && $request->request->get('untilDate')) {
            $executeable = new CycleExecutable();
            $executeable
                ->setFromDate(new \DateTime(sprintf('@%d', $request->request->getInt('fromDate'))))
                ->setUntilDate(new \DateTime(sprintf('@%d', $request->request->getInt('untilDate'))));

            $dateTimeList = DateTimeListGenerator::generateDateTimeList($executeable);

            $generator->addCity($cityCycle->getCity())
                ->setDateTimeList($dateTimeList)
                ->execute();

            $rideList = $generator->getRideList();

            $em = $registry->getManager();

            /** @var Ride $ride */
            foreach ($rideList as $ride) {
                $em->persist($ride);
            }

            $em->flush();

            $flashMessage = sprintf('Es wurden <strong>%d Touren</strong> automatisch angelegt.', count($rideList));

            $session->getFlashBag()->add('success', $flashMessage);

            return $this->redirectToRoute('caldera_criticalmass_city_listrides', [
                'citySlug' => $cityCycle->getCity()->getMainSlug()->getSlug(),
                'cityCycleId' => $cityCycle->getId(),
            ]);
        }

        return $this->redirectToRoute('caldera_criticalmass_citycycle_execute', [
            'citySlug' => $cityCycle->getCity()->getMainSlug()->getSlug(),
            'cityCycleId' => $cityCycle->getId(),
        ]);
    }
}
