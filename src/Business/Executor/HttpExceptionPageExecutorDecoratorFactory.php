<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Business\Executor;

use Micro\Plugin\Http\Business\Exception\Renderer\RendererFactoryInterface;
use Micro\Plugin\Http\Configuration\HttpExceptionResponseDevPluginConfigurationInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class HttpExceptionPageExecutorDecoratorFactory implements RouteExecutorFactoryInterface
{
    public function __construct(
        private RouteExecutorInterface $decorated,
        private RendererFactoryInterface $rendererFactory,
        private HttpExceptionResponseDevPluginConfigurationInterface $pluginConfiguration
    ) {
    }

    public function create(): RouteExecutorInterface
    {
        return new HttpExceptionPageExecutorDecorator(
            $this->decorated,
            $this->rendererFactory,
            $this->pluginConfiguration
        );
    }
}
