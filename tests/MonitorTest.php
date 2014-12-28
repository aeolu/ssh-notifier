<?php
use Jaggy\Watcher\Monitor;

/**
 * MonitorTest
 *
 * @author      Jaggy Gauran <jaggygauran@gmail.com>
 * @version     Release: 0.1.0
 * @link        https://github.com/jaggyspaghetti/ssh-watcher
 * @license     http://www.wtfpl.net/ Do What The Fuck You Want To Public License
 * @since       Class available since Release 1.1.0
 */
class MonitorTest extends PHPUnit_Framework_TestCase
{

    /**
     * it is initializable
     *
     * @test
     * @access public
     * @return void
     */
    public function it_is_initializable()
    {
        $session = Mockery::mock('Jaggy\Watcher\Session');
        $monitor = new Monitor($session);

        $this->assertInstanceOf('Jaggy\Watcher\Monitor', $monitor);
    }


    /**
     * it returns the difference of the old and the new session
     *
     * @test
     * @access public
     * @return void
     */
    public function it_returns_the_difference_of_the_old_and_the_new_session()
    {
        $expected = [
            [
                'user'     => 'jaggyspaghetti',
                'tty'      => 's004',
                'from'     => 'localhost',
                'login_at' => '10:07',
                'idle'     => '29',
                'action'   => 'ssh 127.0.0.1'
            ],
        ];

        $session = Mockery::mock('Jaggy\Watcher\Session');

        $session->shouldReceive('get')->andReturnValues([
            [
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
                    'tty'      => 's005',
                    'from'     => 'localhost',
                    'login_at' => '10:07',
                    'idle'     => '2',
                    'action'   => '-zsh'
                ]
            ],
            [
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
                ]
            ]
        ]);

        $monitor = new Monitor($session);

        // initialize
        $monitor->check();
        $actual = $monitor->check();

        $this->assertEquals($expected, $actual);
    }
}
