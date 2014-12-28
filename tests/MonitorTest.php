<?php
use Jaggy\Watcher\Monitor;

/**
 * MonitorTest
 *
 * @author      Jaggy Gauran <jaggygauran@gmail.com>
 * @version     Release: 0.1.1
 * @link        https://github.com/jaggyspaghetti/ssh-watcher
 * @license     http://www.wtfpl.net/ Do What The Fuck You Want To Public License
 * @since       Class available since Release 1.1.0
 */
class MonitorTest extends PHPUnit_Framework_TestCase
{

    /**
     * Session data provider.
     *
     * @access public
     * @return array
     */
    public function sessionDataProvider()
    {
        return [
            'New s004' => [
                [
                    [
                        'user'     => 'jaggyspaghetti',
                        'tty'      => 's004',
                        'from'     => 'localhost',
                        'login_at' => '10:07',
                        'idle'     => '29',
                        'action'   => 'ssh 127.0.0.1'
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
                ],

                [
                    [
                        'user'     => 'jaggyspaghetti',
                        'tty'      => 's004',
                        'from'     => 'localhost',
                        'login_at' => '10:07',
                        'idle'     => '29',
                        'action'   => 'ssh 127.0.0.1'
                    ],
                ]
            ],


            'New s003' => [
                [
                    [
                        'user'     => 'jaggyspaghetti',
                        'tty'      => 's003',
                        'from'     => 'localhost',
                        'login_at' => '10:07',
                        'idle'     => '29',
                        'action'   => 'ssh 127.0.0.1'
                    ]
                ],

                [
                ],

                [
                    [
                        'user'     => 'jaggyspaghetti',
                        'tty'      => 's003',
                        'from'     => 'localhost',
                        'login_at' => '10:07',
                        'idle'     => '29',
                        'action'   => 'ssh 127.0.0.1'
                    ],
                ]
            ]
        ];
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
        $session = Mockery::mock('Jaggy\Watcher\Session');
        $monitor = new Monitor($session);

        $this->assertInstanceOf('Jaggy\Watcher\Monitor', $monitor);
    }


    /**
     * it returns the difference of the old and the new session
     *
     * @test
     * @dataProvider sessionDataProvider
     *
     * @param  array $expected
     * @param  array $old
     * @param  array $new
     *
     * @access public
     * @return void
     */
    public function it_returns_the_difference_of_the_old_and_the_new_session($expected, $old, $new)
    {
        $session = Mockery::mock('Jaggy\Watcher\Session');
        $session->shouldReceive('get')->andReturnValues([$old, $new]);

        $monitor = new Monitor($session);

        // initialize
        $monitor->check();
        $actual = $monitor->check();

        $this->assertEquals($expected, $actual);
    }
}
