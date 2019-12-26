<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 2019-12-20
 * Time: 17:57
 */

namespace Project\Utils\Core\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class CreateHelperCommand extends Command
{


    //TODO test aşamasında

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ...
    }

}
