<?php
ini_set('memory_limit', '-1');
Class Pusher
{
  
    public function __construct()
    {
        // Load config
        

        // Get config variables
        $app_id     = '1223620';
        $app_key    = '9bf859a0e9328e34498a';
        $app_secret = '5308ddba5c44457772c4';
        $options    = array('cluster' => 'us2',
        'useTLS' => true);

        // Create Pusher object only if we don't already have one
        if (!isset($this->pusher))
        {
            // Create new Pusher object
            $this->pusher = new Pusher($app_key, $app_secret, $app_id, $options);
            log_message('debug', 'CI Pusher library loaded');

            // Set logger if debug is set to true
            if ($this->config->item('pusher_debug') === TRUE )
            {
                $this->pusher->set_logger(new Ci_pusher_logger());
                log_message('debug', 'CI Pusher library debug ON');
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Get Pusher object
     *
     * @return  Object
     */
    public function get_pusher()
    {
        return $this->pusher;
    }

  
    // --------------------------------------------------------------------

    /**
    * Enables the use of CI super-global without having to define an extra variable.
    * I can't remember where I first saw this, so thank you if you are the original author.
    *
    * Copied from the Ion Auth library
    *
    * @access  public
    * @param   $var
    * @return  mixed
    */
    public function __get($var)
    {
        return get_instance()->$var;
    }

}

