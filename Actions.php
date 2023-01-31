<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Core\Actions;

use Arikaim\Core\Actions\ActionInterface;
use Arikaim\Core\Utils\Factory;
use Arikaim\Core\Utils\Path;

/**
 * Factory class for actions
 */
class Actions 
{
    /**
     * Create action located in storage file
     *
     * @param string      $storagePath (relative)
     * @param string|null $className
     * @return ActionInterface|null
     */
    public static function createFromStorage(string $storagePath, ?string $className = null): ?ActionInterface
    {
        $fileName = Path::STORAGE_PATH . $storagePath . (empty($className) == false) ? $className . '.php' : '';
        if (\file_exists($fileName) == false) {
            return null;
        }
        
        $instance = require($fileName);

        return ($instance instanceof ActionInterface) ? $instance : Self::createActionInstance($className);                       
    }

    /**
     * Create action from extension
     *
     * @param string $className
     * @param string $extensionName
     * @return ActionInterface|null
     */
    public function createFromExtension(string $className, string $extensionName): ?ActionInterface
    {
        $actionClass = Factory::getExtensionNamespace($extensionName) . '\\Actions\\' . $className;

        return  Self::createActionInstance($actionClass);       
    }

    /**
     * Create action form module
     *
     * @param string $className
     * @param string $moduleName
     * @return ActionInterface|null
     */
    public function createFromModule(string $className, string $moduleName): ?ActionInterface
    {
        $actionClass = Factory::getModuleNamespace($moduleName) . '\\Actions\\' . $className;

        return  Self::createActionInstance($actionClass);       
    }

    /**
     * Create action instance
     *
     * @param string $class
     * @return ActionInterface|null
     */
    public function createActionInstance(string $class): ?ActionInterface
    {
        if (\class_exists($class) == false) {
            return null;
        }

        $instance = new $class();

        return ($instance instanceof ActionInterface) ? $instance : null; 
    }
}
