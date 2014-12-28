<?php
namespace Jaggy\Watcher;

use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Command\Builder as CommandBuilder;

/**
 * Handles all the shell commands.
 *
 * @property    \AdamBrett\ShellWrapper\Runners\Exec     shell
 * @property    \AdamBrett\ShellWrapper\Command\Builder  builder
 *
 * @uses        \AdamBrett\ShellWrapper\Runners\Exec
 * @uses        \AdamBrett\ShellWrapper\Command\Builder
 *
 * @package     Jaggy\Watcher
 * @author      Jaggy Gauran <jaggygauran@gmail.com>
 * @version     Release: 0.1.1
 * @link        https://github.com/
 * @license     http://www.wtfpl.net/ Do What The Fuck You Want To Public License
 * @since       Class available since Release 1.1.0
 */
class Shell
{

    /**
     * Inject dependencies
     *
     * @param  \AdamBrett\ShellWrapper\Runners\Exec    $shell
     * @param  \AdamBrett\ShellWrapper\Command\Builder $builder
     *
     * @access public
     */
    public function __construct(Exec $shell, CommandBuilder $builder)
    {
    }
}
