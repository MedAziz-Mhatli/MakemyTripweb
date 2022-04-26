<?php
/*
 * This file is part of the Eko\GoogleTranslateBundle Symfony bundle.
 *
 * (c) Vincent Composieux <vincent.composieux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eko\GoogleTranslateBundle\Translate;

/**
 * Class MethodManager.
 *
 * This is the class that manage available methods
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class MethodManager
{
    /**
     * @var array Methods available
     */
    protected $methods = [];

    /**
     * Constructor.
     *
     * @param array $methods
     */
    public function __construct(array $methods)
    {
        foreach ($methods as $method) {
            if ($method instanceof MethodInterface) {
                $this->methods[$method->getName()] = $method;
            }
        }
    }

    /**
     * Returns all methods available.
     *
     * @return array
     */
    public function all()
    {
        return $this->methods;
    }
}
