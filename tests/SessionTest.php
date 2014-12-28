<?php
use Jaggy\Watcher\Session;
use Illuminate\Support\ClassLoader;

/**
 * ConsoleTest
 *
 * @uses        \Jaggy\Watcher\Console
 * @uses        \Illumiate\Support\ClassLoader
 *
 * @author      Jaggy Gauran <jaggygauran@gmail.com>
 * @version     Release: 0.1.3
 * @link        https://github.com/
 * @license     http://www.wtfpl.net/ Do What The Fuck You Want To Public License
 * @since       Class available since Release 0.1.0
 */
class SessionTest extends PHPUnit_Framework_TestCase
{

    /**
     * Initialize configuration.
     *
     * @access public
     * @return void
     */
    public function setUp()
    {
        ClassLoader::register();
    }


    /**
     * it is initializable
     *
     * @test
     * @access public
     * @return void
     */
    public function it_is_initializable()
    {
        $exec    = Mockery::mock('AdamBrett\ShellWrapper\Runners\ShellExec');
        $builder = Mockery::mock('AdamBrett\ShellWrapper\Command\Builder');

        $session = new Session($exec, $builder);

        $this->assertInstanceOf('Jaggy\Watcher\Session', $session);
    }


    /**
     * it fetches all the logged users
     *
     * @test
     * @access public
     * @return void
     */
    public function it_fetches_all_the_logged_users()
    {
        $expected = [
            [
                'user'     => 'jaggyspaghetti',
                'tty'      => 'session',
                'from'     => '-',
                'login_at' => '0:42',
                'idle'     => '9:54',
                'action'   => '-'
            ],
            [
                'user'     => 'jaggyspaghetti',
                'tty'      => 's004',
                'from'     => 'localhost',
                'login_at' => '10:07',
                'idle'     => '29',
                'action'   => 'ssh 127.0.0.1'
            ],
            [
                'user'     => 'jaggyspaghetti',
                'tty'      => 's005',
                'from'     => 'localhost',
                'login_at' => '10:07',
                'idle'     => '2',
                'action'   => '-zsh'
            ],
            [
                'user'     => 'jaggyspaghetti',
                'tty'      => 's006',
                'from'     => 'localhost',
                'login_at' => '10:06',
                'idle'     => '-',
                'action'   => 'w'
            ],
        ];

        $exec    = Mockery::mock('AdamBrett\ShellWrapper\Runners\ShellExec');
        $builder = Mockery::mock('AdamBrett\ShellWrapper\Command\Builder');

        $exec->shouldReceive('run')->andReturn('10:36  up 2 days, 13:21, 4 users, load averages: 2.07 2.08 2.12
USER     TTY      FROM              LOGIN@  IDLE WHAT
jaggyspaghetti session  -                 0:42    9:54 -
jaggyspaghetti s004     localhost        10:07      29 ssh 127.0.0.1
jaggyspaghetti s005     localhost        10:07       2 -zsh
jaggyspaghetti s006     localhost        10:06       - w');

        $session = new Session($exec, $builder);
        $actual  = $session->get();

        $this->assertEquals($expected, $actual);
    }
}
