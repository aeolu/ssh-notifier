<?php
namespace Jaggy\Watcher;

/**
 * Monitors the sessions to see if a new user connects.
 *
 * @property    \Jaggy\Watcher\Session session
 *
 * @uses        \Jaggy\Watcher\Session
 *
 * @package     Jaggy\Watcher
 * @author      Jaggy Gauran <jaggygauran@gmail.com>
 * @version     Release: 0.1.0
 * @link        https://github.com/jaggyspaghetti/ssh-watcher
 * @license     http://www.wtfpl.net/ Do What The Fuck You Want To Public License
 * @since       Class available since Release 1.1.0
 */
class Monitor
{


    /**
     * Inject the session to monitor.
     *
     * @param  \Jaggy\Watcher\Session $session
     *
     * @access public
     */
    public function __construct(Session $session)
    {

    }
}
