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

/**
 * Base class for all actions
 */
abstract class Action implements ActionInterface
{
    /**
     * Action name
     *
     * @var string|null
     */
    protected $name = null;

    /**
     * Action title
     *
     * @var string|null
     */
    protected $title = null;

    /**
     * Action description
     *
     * @var string|null
     */
    protected $description = null;

    /**
     * Execution error
     *
     * @var mixed|null
    */
    protected $error = null;

    /**
     * Action options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Job code
     *
     * @param mixed $params
     * @return mixed
     */
    abstract public function run(...$params);

    /**
     * Undocumented function
     */
    public function __construct()
    {
        $this->error = null;
        $this->init();
    }

    /**
     * Run action
     *
     * @param mixed ...$params
     * @return void
     */
    public function __invoke(...$params)
    {
        $this->run($params);
    }

    /**
     * Set option
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function option(string $name, $value): void
    {
        $this->options[$name] = $value;
    } 

    /**
     * Get option value
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getOption(string $name, $default = null)
    {
        return $this->options[$name] ?? $default;
    } 

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    } 

    /**
     * Init action
     *
     * @return void
     */
    public function init(): void
    {        
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name'          => $this->getName(),
            'error'         => $this->getError(),
            'handler_class' => \get_class(),
            'title'         => $this->getTitle(),
            'description'   => $this->getDescription(),
            'options'       => $this->getOptions(),
        ];
    }

    /**
     * Get execution error
     *
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set error
     *
     * @param mixed $error
     * @return void
     */
    public function error($error): void
    {
        $this->error = $error;
    }

    /**
     * Return true if action is executed successful
     *
     * @return boolean
     */
    public function hasError(): bool
    {
        return ($this->error !== null);
    }

    /**
     * Set
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, $value): void
    {
        $this->$name = $value;
    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return void
     */
    public function name(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return void
     */
    public function title(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Set description
     *
     * @param string $title
     * @return void
     */
    public function description(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
