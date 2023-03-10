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

namespace Micro\Plugin\Http\Business\Exception\Renderer;

use Micro\Plugin\Http\Exception\FlattenException;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class JsonRenderer implements RendererInterface
{
    public function render(\Throwable $throwable): string
    {
        $flatten = FlattenException::createFromThrowable($throwable);

        return (string) json_encode($flatten->toArray());
    }
}
