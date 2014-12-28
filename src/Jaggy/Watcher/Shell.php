<?php
namespace Jaggy\Watcher;

use AdamBrett\ShellWrapper\Runners\ShellExec;
use AdamBrett\ShellWrapper\Command\Builder as CommandBuilder;

/**
 * Handles all the shell commands.
 *
 * @property    \AdamBrett\ShellWrapper\Command\Builder    builder
 * @property    \AdamBrett\ShellWrapper\Runners\ShellExec  shell
 *
 * @uses        \AdamBrett\ShellWrapper\Command\Builder
 * @uses        \AdamBrett\ShellWrapper\Runners\ShellExec
 *
 * @package     Jaggy\Watcher
 * @author      Jaggy Gauran <jaggygauran@gmail.com>
 * @version     Release: 0.1.2
 * @link        https://github.com/
 * @license     http://www.wtfpl.net/ Do What The Fuck You Want To Public License
 * @since       Class available since Release 1.1.0
 */
class Shell
{

    /**
     * @access protected
     * @var    \AdamBrett\ShellWrapper\Command\Builder
     */
    protected $builder;

    /**
     * @access protected
     * @var    \AdamBrett\ShellWrapper\Runners\ShellExec
     */
    protected $shell;


    /**
     * Inject dependencies
     *
     * @param  \AdamBrett\ShellWrapper\Runners\ShellExec $shell
     * @param  \AdamBrett\ShellWrapper\Command\Builder   $builder
     *
     * @access public
     */
    public function __construct(ShellExec $shell, CommandBuilder $builder)
    {
        $this->shell   = $shell;
        $this->builder = $builder;
    }
}
