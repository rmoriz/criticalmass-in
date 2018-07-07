<?php declare(strict_types=1);

namespace AppBundle\Criticalmass\Statistic\RideEstimateHandler;

use AppBundle\Criticalmass\Statistic\RideEstimateCalculator\RideEstimateCalculatorInterface;
use AppBundle\Entity\Ride;
use AppBundle\Entity\RideEstimate;
use AppBundle\Entity\Track;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

/** @deprecated  */
class RideEstimateService
{
    /** @var Doctrine $doctrine */
    protected $doctrine;

    /** @var RideEstimateCalculatorInterface $calculator */
    protected $calculator;

    public function __construct(Doctrine $doctrine, RideEstimateCalculatorInterface $calculator)
    {
        $this->doctrine = $doctrine;

        $this->calculator = $calculator;
    }

    /** @deprecated  */
    public function flushEstimates(Ride $ride, bool $flush = true): RideEstimateService
    {
        $ride
            ->setEstimatedDistance(0.0)
            ->setEstimatedDuration(0.0)
            ->setEstimatedParticipants(0);

        if ($flush) {
            $this->doctrine->getManager()->flush();
        }

        return $this;
    }

    /** @deprecated  */
    public function calculateEstimates(Ride $ride, bool $flush = true): RideEstimateService
    {
        $estimates = $this->doctrine->getRepository(RideEstimate::class)->findByRide($ride);

        $this->calculator
            ->setRide($ride)
            ->setEstimates($estimates)
            ->calculate();

        if ($flush) {
            $this->doctrine->getManager()->flush();
        }

        return $this;
    }

    /** @deprecated  */
    public function addEstimateFromTrack(Track $track, bool $flush = true): RideEstimateService
    {
        $re = new RideEstimate();
        $re
            ->setRide($track->getRide())
            ->setUser($track->getUser())
            ->setTrack($track)
            ->setEstimatedDistance($track->getDistance())
            ->setEstimatedDuration($this->calculateDurationInHours($track));

        $track->setRideEstimate($re);

        $this->doctrine->getManager()->persist($re);

        if ($flush) {
            $this->doctrine->getManager()->flush();
        }

        return $this;
    }

    /** @deprecated  */
    protected function calculateDurationInSeconds(Track $track): int
    {
        if ($track->getStartDateTime() && $track->getEndDateTime()) {
            return $track->getEndDateTime()->getTimestamp() - $track->getStartDate()->getTimestamp();
        }

        return 0;
    }

    /** @deprecated  */
    protected function calculateDurationInHours(Track $track): float
    {
        if ($durationInSeconds = $this->calculateDurationInSeconds($track)) {
            return $durationInSeconds / 3600.0;
        }

        return 0;
    }
}
