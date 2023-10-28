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
use Arikaim\Core\Actions\ActionNotFound;
use Arikaim\Core\Utils\Factory;
use Arikaim\Core\Utils\Path;

/**
 * Factory class for actions
 */
class Actions 
{
    /**
     * Action
     *
     * @var ActionInterface
     */
    private $action;

    /**
     * Constructor
     * 
     * @param ActionInterface $action
    */
    public function __construct(ActionInterface $action)
    {
        $this->action = $action;       
    }

    /**
     * Get action
     *
     * @return ActionInterface
     */
    public function getAction(): ActionInterface
    {
        return $this->action;
    }

    /**
     * Run action
     *
     * @param mixed ...$params
     * @return ActionInterface
     */
    public function run(...$params): ActionInterface
    {
        $this->action->run(...$params);

        return $this->action;
    }

    /**
     * Set action option
     *
     * @param string $name
     * @param mixed $value
     * @return Self
     */
    public function option(string $name, $value): Self
    {
        $this->action->option($name,$value);

        return $this;
    }

    /**
     * Set action options
     *
     * @param array $options
     * @return Self
     */
    public function options(array $options): Self
    {
        $this->action->setOptions($options);

        return $this;
    }

    /**
     * Create action located in storage file
     *
     * @param string      $storagePath (relative)
     * @param string|null $className
     * @return Self
     */
    public static function createFromStorage(string $storagePath, ?string $className = null): Self
    {
        $fileName = (empty($className) == false) ? $className . '.php' : '';
        $path = Path::STORAGE_PATH . $storagePath . $fileName;

        $instance = (\file_exists($path) == true) ? require($path) : null;
        $instance = ($instance instanceof ActionInterface) ? $instance : Self::createActionInstance($className);   
        
        return new Self($instance);
    }

    /**
     * Create action from extension
     *
     * @param string $className
     * @param string $extensionName
     * @return Self
     */
    public static function createFromExtension(string $className, string $extensionName): Self
    {
        $actionClass = Factory::getExtensionNamespace($extensionName) . '\\Actions\\' . $className;

        return new Self(Self::createActionInstance($actionClass));       
    }

    /**
     * Create action form module
     *
     * @param string $className
     * @param string $moduleName
     * @return Self
     */
    public static function createFromModule(string $className, string $moduleName): Self
    {
        $actionClass = Factory::getModuleNamespace($moduleName) . '\\Actions\\' . $className;

        return new Self(Self::createActionInstance($actionClass));        
    }

    /**
     * Create action instance
     *
     * @param string $class
     * @return ActionInterface
     */
    public static function createActionInstance(string $class): ActionInterface
    {
        if (\class_exists($class) == false) {
            return (new ActionNotFound())->option('name',$class);
        }

        $instance = new $class();

        return ($instance instanceof ActionInterface) ? $instance : (new ActionNotFound())->option('name',$class); 
    }
}
