<?php
use Jaggy\Watcher\Monitor;

/**
 * MonitorTest
 *
 * @author      Jaggy Gauran <jaggygauran@gmail.com>
 * @version     Release: 0.1.0
 * @link        https://github.com/
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
        $monitor = new Monitor();

        $this->assertInstanceOf('Jaggy\Watcher\Monitor', $monitor);
    }
}
