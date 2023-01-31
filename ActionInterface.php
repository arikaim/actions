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

/**
 * Action interface
 */
interface ActionInterface
{   
    /**
     * Run action
     *
     * @param mixed ...$params
     * @return mixed
     */
    public function run(...$params);

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array;
}
