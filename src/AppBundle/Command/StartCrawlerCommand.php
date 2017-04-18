<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\EventDispatcher\GenericEvent;

class StartCrawlerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('crawler:start')
            ->setDescription('Start a crawler')
            ->setHelp('-')
            ->addArgument('id', InputArgument::REQUIRED, 'ID of a vehicle model.')
            ->addArgument('start_page', InputArgument::REQUIRED, 'From which page to parse')
            ->addArgument('end_page', InputArgument::REQUIRED, 'Till which page to parse');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $crawlerManager = $this->getContainer()->get('app.web_crawler');
        $id = $input->getArgument('id');
        $startPage = $input->getArgument('start_page');
        $endPage = $input->getArgument('end_page');

        $crawlerManager->startCrawler($id, $startPage, $endPage);

        $dispatcher = $this->getContainer()->get('event_dispatcher');
        $dispatcher->addListener(
            'test',
            function (GenericEvent $event) use ($output) {
                $output->writeLn('sadad');
            }
        );


//        $output->writeln('test');
    }
}