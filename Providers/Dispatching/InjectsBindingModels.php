<?php

namespace Nanozen\Providers\Dispatching;

use Nanozen\Utilities\Csrf;
/**
 * Trait InjectsBindingModels
 *
 * @author brslv
 * @package Nanozen\Providers\Dispatching 
 */
trait InjectsBindingModels 
{
	
	private $bindingRegex = '/(?:@bind )(.*)/';

    private function injectBindingModelIfAny()
    {
        $bindingModel = $this->getBindingModelIfAny();

        if ($bindingModel) {
            if (class_exists($bindingModel)) {
            	if (isset($_POST['_token']) && Csrf::validate($_POST['_token'])) {
	                unset($_POST['_token']);
            		$bindingModel = new $bindingModel();
	                
	                $reflector = new \ReflectionClass($bindingModel);
	                $classProperties = $reflector->getProperties();
	                
	                if ( ! $this->isPassedDataValid($classProperties)) {
	                	throw new \Exception("Binding model cannot be processed with the data you passed.");
	                }
	                
	                foreach ($classProperties as $property) {
	                	$propertyName = $property->getName();
	                	
	                	$bindingModel->{$propertyName} = $_POST[$propertyName];
	                }
            	}
            } else {
                throw new \Exception("The provided binding model does not exist: {$bindingModel}");
            }
        }

        $this->controller->binding = $bindingModel;
    }
    
    private function isPassedDataValid($classProperties)
    {
    	$propertyNamesList = [];
    	$matched = [];
    	
    	foreach ($classProperties as $property) {
    		$propertyNamesList[] = $property->getName();
    	}
    	
    	foreach ($propertyNamesList as $property) {
    		foreach ($_POST as $post => $value) {
    			if ($property == $post) {
    				$matched[] = $property;
    			}
    		}
    	}
    	
    	if (count($propertyNamesList) == count($matched)) {
    		return true;
    	}
    	
    	return false;
    }

    private function getBindingModelIfAny()
    {
        // parses dockblock
        // and checks for binding model
        $reflector = new \ReflectionMethod($this->controller, $this->action);
        $doc = $reflector->getDocComment();
        if ( ! $doc) {
            return false;
        }

        preg_match($this->bindingRegex, $doc, $match);
        $bindingModelClass = isset($match[1]) ? $match[1] : false;

        if ( ! $bindingModelClass) {
            return null;
        }

        return $bindingModelClass;
    }

}