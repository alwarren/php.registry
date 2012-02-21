<?php
/**
 * 
 * LICENSE
 * 
 * Copyright (c) 2012 Al Warren
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 * 
 * - Redistributions of source code must retain the above copyright notice, this 
 *   list of conditions and the following disclaimer.
 * 
 * - Redistributions in binary form must reproduce the above copyright notice, 
 *   this list of conditions and the following disclaimer in the documentation 
 *   and/or other materials provided with the distribution.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF S
 * UBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
 * POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * Registry Class
 * 
 * @package registry
 * @author Al Warren
 * @copyright 2012 Al Warren
 */
class registry  extends ArrayObject
{
    /**
     * Registry storage container.
     * 
     * @access    private
     * @staticvar registry object
     */
    private static $_registry = null;
    
    /**
     * Class constructor.
     * 
     * @access private
     * @param  array
     * @param  int
     */
    public function __construct($array = array(), $flags = parent::ARRAY_AS_PROPS)
    {
        parent::__construct($array, $flags);
    }
    
    /**
     * Old style class constructor.
     * - Creates an instance of itself
     * 
     * @return object registry
     */
    public function registry()
    {
        return self::getInstance();
    }
    
    /**
     * Registry Singleton
     * - initializes registry if not already initialized.
     * 
     * @return object registry
     */
    public static function getInstance()
    {
        if (self::$_registry === null) {
            self::$_registry = new registry;
        }
        return self::$_registry;
    }
    /**
     * Retrieve an item from the registry.
     * - returns default if not found
     * - renders an error message if $showerror is true
     * 
     * @param type string
     * @param type mixed
     * @param type boolean
     * @return type mixed
     */
    public static function get($key, $default = null, $showerror=false)
    {
        $key = trim($key);
        try {
            if (empty($key))
                throw new Exception("Registry access requires a key");
        } catch (Exception $e) {
            $message = $e->getMessage()
                     . ' on line ' . $e->getLine()
                     . ' of ' . $e->getFile();
            show_error($message);
            return $default;
        }
        $_registry = self::getInstance();
        try {
            if (!$_registry->offsetExists($key)) {
                if (true === $showerror)
                    throw new Exception("Nothing found in registry for key '$key'");
                else
                    return $default;
            }
        } catch (Exception $e) {
            $message = $e->getMessage()
                     . ' on line ' . $e->getLine()
                     . ' of ' . $e->getFile();
            show_error($message);
            return null;
        }
        return $_registry->offsetGet($key);
    }
    /**
     * Adds an entry to the registry with an index of $key.
     * 
     * @param string
     * @param mixed
     * @return object registry
     */
    public static function set($key, $value)
    {
        $_registry = self::getInstance();
        $_registry->offsetSet($key, $value);
        return $_registry;
    }
    /**
     * Checks to see if container contains an item with an index of $key.
     * 
     * @param string
     * @param type mixed
     * @return boolean
     */
    public static function contains($key)
    {
        if (self::$_registry === null) {
            return false;
        }
        return self::$_registry->offsetExists($key);
    }
    /**
     * Workaround for php bug.
     * @link http://bugs.php.net/bug.php?id=40442 (ZF-960).
     * 
     * @param string
     * @return boolean
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this);
    }
}

if(!function_exists('show_error'))
{
    /**
     * Simple error display.
     * 
     * @param string
     */
    function show_error($error=null)
    {
        echo "<p>Error: $error</p>";
    }
}
