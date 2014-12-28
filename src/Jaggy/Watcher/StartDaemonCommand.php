<?php
namespace Jaggy\Watcher;

use Wrep\Daemonizable\Command\EndlessCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Starts the watcher daemon.
 *
 * @uses        \Wrep\Daemonizable\Command\EndlessCommand
 * @uses        \Symfony\Component\Console\Input\InputInterface
 * @uses        \Symfony\Component\Console\Output\OutputInterface
 *
 * @package     Jaggy\Watcher
 * @author      Jaggy Gauran <jaggygauran@gmail.com>
 * @version     Release: 0.1.3
 * @link        https://github.com/
 * @license     http://www.wtfpl.net/ Do What The Fuck You Want To Public License
 * @since       Class available since Release 1.1.0
 */
class StartDaemonCommand extends EndlessCommand
{

    /**
     * Configure the command
     *
     * @access public
     * @return void
     */
    public function configure()
    {
        $this->setName('start')
             ->setDescription('Start the watcher daemon');
    }


    /**
     * Execute the command
     *
     * @param  \Symfony\Component\Console\Input\InputInterface $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @access public
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->count);
    }
}
