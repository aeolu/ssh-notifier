<?php
namespace Jaggy\Watcher;

/**
 * Monitors the sessions to see if a new user connects.
 *
 * @property    boolean                running
 * @property    array                  current
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
     * @access protected
     * @var    \Jaggy\Watcher\Session
     */
    protected $session;

    /**
     * The current session collection.
     *
     * @access protected
     * @var    array
     */
    protected $current;

    /**
     * Fail safe for empty arrays
     *
     * @access protected
     * @var    boolean
     */
    protected $running = false;


    /**
     * Inject the session to monitor.
     *
     * @param  \Jaggy\Watcher\Session $session
     *
     * @access public
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }


    /**
     * Compare the current session to the new session and set the
     * new session.
     *
     * @access public
     * @return array
     */
    public function check()
    {
        $difference = [];

        // initialize the monitor
        if (! $this->running) {
            $this->running = true;
            $this->current = $this->session->get();

            return $difference;
        }


        $sessions = $this->session->get();

        $current = array_pluck($this->current, 'tty');
        $new     = array_pluck($sessions, 'tty');
        $ttys    = array_diff($new, $current);

        foreach ($sessions as $session) {
            if (! in_array($session['tty'], $ttys)) {
                continue;
            }

            $difference[] = $session;
        }

        $this->current = $sessions;
        return $difference;
    }
}
