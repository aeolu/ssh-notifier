<?php
namespace Jaggy\Watcher;

use Jaggy\Watcher\Monitor;
use Jaggy\Watcher\Session;
use AdamBrett\ShellWrapper\Runners\ShellExec;
use AdamBrett\ShellWrapper\Command\Builder as CommandBuilder;

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
 * @link        https://github.com/jaggyspaghetti/ssh-watcher
 * @license     http://www.wtfpl.net/ Do What The Fuck You Want To Public License
 * @since       Class available since Release 1.1.0
 */
class StartDaemonCommand extends EndlessCommand
{
    protected $monitor;


    /**
     * Initialize
     *
     * @access public
     */
    public function __construct($name = null)
    {
        $shell   = new ShellExec;
        $builder = new CommandBuilder('w');
        $session = new Session($shell, $builder);

        $this->monitor = new Monitor($session);
        $this->monitor->check();

        parent::__construct($name);
    }


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
        $root = dirname(dirname(dirname(__DIR__)));
        $icon = $root . '/assets/link.png';

        if (! $sessions = $this->monitor->check()) {
            return;
        }


        foreach ($sessions as $session) {
            $command = "terminal-notifier -title 'SSH Session Started' -message '{$session['user']}@{$session['tty']} has connected' -appIcon {$icon}";

            shell_exec($command);
        }
    }
}
