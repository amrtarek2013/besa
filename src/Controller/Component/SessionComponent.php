<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Session;
/**
 * Csv component
 */

class SessionComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    

    
	protected $_session;
	public $cacheKey;
    protected $_defaultConfig = [];

	public function initialize(array $config): void
    {
    	$this->_session = $this->getSession();
    }

        protected function getSession(): Session
    {
        return $this->getController()->getRequest()->getSession();
    }

    // You can read values from the session using Hash::extract() compatible syntax:
    public function read($key = null)
    {
    	return $this->_session->read($key);
    }
    // $key should be the dot separated path you wish to write $value to:
    public function write($key,$value)
    {
    	return $this->_session->write($key,$value);
    }
    // see if data exists in the session
    public function check($key)
    {
    	return $this->_session->check($key);
    }
    // delete data from the session
    public function delete($key)
    {
    	return $this->_session->delete($key);
    }
 	// read and delete data from the session
    public function consume($key)
    {
    	return $this->_session->consume($key);
    }

    //  destroy a session
    public function destroy()
    {
    	return $this->_session->destroy();
    }

}
