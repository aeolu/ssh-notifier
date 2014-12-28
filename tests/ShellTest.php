<?php
use Jaggy\Watcher\Shell;

/**
 * ShellTest
 *
 * @uses        \Jaggy\Watcher\Shell
 *
 * @author      Jaggy Gauran <jaggygauran@gmail.com>
 * @version     Release: 0.1.1
 * @link        https://github.com/
 * @license     http://www.wtfpl.net/ Do What The Fuck You Want To Public License
 * @since       Class available since Release 0.1.0
 */
class ShellTest extends PHPUnit_Framework_TestCase
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
        $exec    = Mockery::mock('AdamBrett\ShellWrapper\Runners\ShellExec');
        $builder = Mockery::mock('AdamBrett\ShellWrapper\Command\Builder');

        $shell = new Shell($exec, $builder);

        $this->assertInstanceOf('Jaggy\Watcher\Shell', $shell);
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
    }
}
