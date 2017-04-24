<?php
namespace AppBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\EventDispatcher\GenericEvent;

class StartCrawlerCommand extends Command
{
    private $adsProviders;
    private $em;

    public function __construct(array $adsProviders, EntityManager $em)
    {
        parent::__construct();

        $this->adsProviders = $adsProviders;
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setName('crawler:start')
            ->setDescription('Start a crawler');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->adsProviders as $adsProvider) {
            $crawlerManager = new $adsProvider($this->em);
            $data = $crawlerManager->getNewAds();
            echo $data;
        }
    }
}