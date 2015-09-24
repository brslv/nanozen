<?php

namespace Nanozen\App;

/**
 * Class Injector
 *
 * @author brslv
 * @package Nanozen\App
 */
class Injector
{

    private static $container;
    
    const INJECTOR_PROPERTY = 'dependsOn';
    
    /**
     * Prepare objects for injecting.
     * 
     * @param \InjectorTypes $type
     * @param string $alias
     * @param mixed $value
     * @param array $arguments
     */
    public static function prepare($type, $alias, $value, $arguments = null)
    {
    	if ($type == InjectorTypes::TYPE_VALUE) {
    		self::prepareValue($alias, $value);
    	}
    	
    	if ($type == InjectorTypes::TYPE_CLASS) {    		
    		self::prepareClass($alias, $value, $arguments);
    	}
    	
    	if ($type == InjectorTypes::TYPE_SINGLETON) {
    		self::prepareSingleton($alias, $value, $arguments);
    	}
    }

    /**
     * Invoke a class.
     *
     * @param string $class The full class name.
     * @param array $arguments Array of arguments, needed for instantiating the specified class.
     * @return object
     * @throws \Exception
     */
    public static function call($class, $arguments = null) 
    {
		if ( ! class_exists($class)) {
			throw new \Exception("Class {$class} cannot be resolved.");
		}
		
		$reflector = new \ReflectionClass($class);
		
		// Create an object from the class.
		if ($arguments === null || count($arguments) == 0) {
			$object = new $class;
		} else {
			if ( ! is_array($arguments)) {
				$arguments = [$arguments];
			}
				
			$object = $reflector->newInstanceArgs($arguments);
		}
		
		if (property_exists($class, Injector::INJECTOR_PROPERTY)) {
			$injectorProperty = self::INJECTOR_PROPERTY;
			$classesToBeInjected = $object->$injectorProperty;
			
			foreach ($classesToBeInjected as $classAlias) {
				if (array_key_exists($classAlias, self::$container)) {
                    self::injectDependencies($classAlias, $object);
                }
			}
		}
		
		return $object;
    }

    /**
     * @param $classAlias
     * @param $object
     * @throws \Exception
     */
    private static function injectDependencies($classAlias, $object)
    {
        switch (self::$container[$classAlias]['type']) {

            case InjectorTypes::TYPE_VALUE :
                $object->$classAlias = self::$container[$classAlias]['value'];
                break;

            case InjectorTypes::TYPE_CLASS :
                $object->$classAlias = self::call(
                    self::$container[$classAlias]['value'],
                    self::$container[$classAlias]['arguments']
                );
                break;

            case InjectorTypes::TYPE_SINGLETON :
                if (self::$container[$classAlias]['instance'] === null) {
                    self::$container[$classAlias]['instance'] = self::call(
                        self::$container[$classAlias]['value'],
                        self::$container[$classAlias]['arguments']
                    );

                    $object->$classAlias = self::$container[$classAlias]['instance'];
                } else {
                    $object->$classAlias = self::$container[$classAlias]['instance'];
                }
                break;
        }
    }
    
    /**
     * Prepares a simple value.
     * 
     * @param string $alias
     * @param mixed $value
     */
    private static function prepareValue($alias, $value)
    {
    	self::put($alias, [
    		'value' => $value,
    		'type' => InjectorTypes::TYPE_VALUE,
    	]);
    }
    
    /**
     * Prepares a class.
     * 
     * @param string $alias
     * @param string $value The full class path.
     * @param array $arguments Array of arguments, needed for instantiating the specified class.
     */
    private static function prepareClass($alias, $value, $arguments = null) 
    {
    	self::put($alias, [
    		'value' => $value,
    		'type' => InjectorTypes::TYPE_CLASS,
    		'arguments' => $arguments,
    	]);
    }
    
    private static function prepareSingleton($alias, $value, $arguments = null)
    {
    	self::put($alias, [
    		'value' => $value,
    		'type' => InjectorTypes::TYPE_SINGLETON,
    		'instance' => null,
    		'arguments' => $arguments,
    	]);
    }
    
    /**
     * Put a value in the container.
     * 
     * @param string $alias
     * @param mixed $value
     */
    private static function put($alias, $value)
    {
    	if (is_null(self::$container)) {
    		self::$container = [];
    	}
    	
    	self::$container[$alias] = $value;
    }

}