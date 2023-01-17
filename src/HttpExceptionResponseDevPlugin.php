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

namespace Micro\Plugin\Http;

use Micro\Component\DependencyInjection\Container;
use Micro\Framework\Kernel\Plugin\ConfigurableInterface;
use Micro\Framework\Kernel\Plugin\DependencyProviderInterface;
use Micro\Framework\Kernel\Plugin\PluginConfigurationTrait;
use Micro\Framework\Kernel\Plugin\PluginDependedInterface;
use Micro\Plugin\Http\Business\Exception\Renderer\RendererFactory;
use Micro\Plugin\Http\Business\Exception\Renderer\RendererFactoryInterface;
use Micro\Plugin\Http\Business\Executor\HttpExceptionPageExecutorDecoratorFactory;
use Micro\Plugin\Http\Business\Executor\RouteExecutorFactoryInterface;
use Micro\Plugin\Http\Configuration\HttpExceptionResponseDevPluginConfigurationInterface;
use Micro\Plugin\Http\Decorator\HttpFacadeExceptionDevDecorator;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 *
 * @method HttpExceptionResponseDevPluginConfigurationInterface configuration()
 */
class HttpExceptionResponseDevPlugin implements ConfigurableInterface, DependencyProviderInterface, PluginDependedInterface
{
    use PluginConfigurationTrait;

    private HttpFacadeInterface $httpFacade;

    public function provideDependencies(Container $container): void
    {
        $container->decorate(HttpFacadeInterface::class, function (
            HttpFacadeInterface $httpFacade
        ) {
            $this->httpFacade = $httpFacade;

            return $this->createDecorator();
        });
    }

    protected function createDecorator(): HttpFacadeInterface
    {
        return new HttpFacadeExceptionDevDecorator(
            $this->httpFacade,
            $this->createRouteExecutorFactory()
        );
    }

    protected function createRouteExecutorFactory(): RouteExecutorFactoryInterface
    {
        return new HttpExceptionPageExecutorDecoratorFactory(
            $this->httpFacade,
            $this->createExceptionRendererFactory(),
            $this->configuration()
        );
    }

    protected function createExceptionRendererFactory(): RendererFactoryInterface
    {
        return new RendererFactory($this->configuration());
    }

    public function getDependedPlugins(): iterable
    {
        return [
            HttpCorePlugin::class,
        ];
    }
}
