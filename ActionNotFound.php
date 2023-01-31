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

use Arikaim\Core\Actions\Action;

/**
 * Action not found
 */
class ActionNotFound extends Action
{
    /**
     * Run action
     *
     * @param mixed $params
     * @return mixed
     */
    public function run(...$params)
    {
        $this->error('Action ' . $this->getOption('name') . ' not found');
    }
}
