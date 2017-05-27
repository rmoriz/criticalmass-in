<?php

namespace AppBundle\Command;

use AppBundle\Entity\Photo;
use AppBundle\Entity\Ride;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Liip\ImagineBundle\Controller\ImagineController;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class PrepareImagesCommand extends ContainerAwareCommand
{
    /** @var Registry $doctrine */
    protected $doctrine = null;

    /** @var UploaderHelper $uploaderHelper*/
    protected $uploaderHelper = null;

    /** @var ImagineController $imagineController */
    protected $imagineController = null;

    protected function configure(): void
    {
        $this
            ->setName('criticalmass:images:prepare')
            ->setDescription('Create thumbnails for images')
            ->addArgument(
                'citySlug',
                InputArgument::REQUIRED,
                'Slug of the city'
            )
            ->addArgument(
                'rideDate',
                InputArgument::REQUIRED,
                'Date of the ride'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->doctrine = $this->getContainer()->get('doctrine');
        $this->uploaderHelper = $this->getContainer()->get('vich_uploader.templating.helper.uploader_helper');
        $this->imagineController = $this->getContainer()->get('liip_imagine.controller');

        /** @var Ride $ride */
        $ride = $this->doctrine->getRepository('AppBundle:Ride')->findByCitySlugAndRideDate($input->getArgument('citySlug'), $input->getArgument('rideDate'));

        $photos = $this->doctrine->getRepository('AppBundle:Photo')->findPhotosByRide($ride);

        /** @var Photo $photo */
        foreach ($photos as $photo) {
            foreach ($this->getFilterList() as $filter) {
                $this->applyFilter($photo, $filter);

                $output->writeln(sprintf(
                    'Applied filter <comment>%s</comment> to photo <info>#%d</info>',
                    $filter,
                        $photo->getId()
                ));
            }
        }
    }

    protected function applyFilter(Photo $photo, string $filter): void
    {
        $filename = $this->uploaderHelper->asset($photo, 'imageFile');

        $this->imagineController
            ->filterAction(
                new Request(),
                $filename,
                $filter
            )
        ;
    }

    protected function getFilterList(): array
    {
        return [
            'gallery_photo_thumb',
            'gallery_photo_standard',
            'gallery_photo_large',
        ];
    }
}