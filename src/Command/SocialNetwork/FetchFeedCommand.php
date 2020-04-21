<?php

namespace App\Command\SocialNetwork;

use App\Criticalmass\SocialNetwork\FeedFetcher\FeedFetcher;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchFeedCommand extends Command
{
    /** @var FeedFetcher $feedFetcher */
    protected $feedFetcher;

    /** @var ManagerRegistry $doctrine */
    protected $doctrine;

    public function __construct(ManagerRegistry $doctrine, FeedFetcher $feedFetcher)
    {
        $this->doctrine = $doctrine;
        $this->feedFetcher = $feedFetcher;

        parent::__construct(null);

    }

    protected function configure(): void
    {
        $this
            ->setName('criticalmass:social-network:fetch-feed')
            ->setDescription('Fetch feeds');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->feedFetcher->fetch()->persist();
    }
}
