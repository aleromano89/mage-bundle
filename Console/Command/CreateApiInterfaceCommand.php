<?php
declare(strict_types=1);

namespace Ctasca\MageBundle\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ctasca\MageBundle\Api\MakerApiInterfaceInterface;

class CreateApiInterfaceCommand extends Command
{
    private MakerApiInterfaceInterface $maker;

    /**
     * @param MakerApiInterfaceInterface $maker
     */
    public function __construct(
        MakerApiInterfaceInterface $maker
    ) {
        $this->maker = $maker;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('magebundle:api-interface:create')
            ->setDescription('Creates an API interface in specified Company/Module');

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->maker->make($input, $output);
    }
}
