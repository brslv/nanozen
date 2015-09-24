<?php

namespace Nanozen\Providers\Dispatching;

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
                $bindingModel = new $bindingModel('Ivan', 23); // TODO: unhardcode those bitches.
            } else {
                throw new \Exception("The provided binding model does not exist: {$bindingModel}");
            }
        }

        $this->controller->binding = $bindingModel;
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