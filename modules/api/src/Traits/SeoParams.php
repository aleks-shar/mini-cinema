<?php

declare(strict_types=1);

namespace App\Api\Traits;

use App\Admin\Seo\Models\MetaTag;
use App\Api\Models\Seo;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait SeoParams
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getSeoHostSettings(MetaTag|Seo|null $tag = null): array
    {
        if ($tag) {
            return ['pattern' => $tag, 'page' => null];
        }

        return ['pattern' => $this->getPattern(), 'page' => $this->getPage()];
    }
    public function getPattern(): ?Seo
    {
        $controller = Str::lower(
            Str::replace('Controller', '', class_basename(request()->route()->getControllerClass()))
        );

        $action = request()->route()->getActionMethod();

        if ($controller == 'page') {
            $action = request()->route()->parameter('page')->slug;
        }

        return Seo::whereController($controller)->whereAction($action)->first();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPage()
    {
        return request()->get('page');
    }
}
