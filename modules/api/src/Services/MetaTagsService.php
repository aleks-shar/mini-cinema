<?php

declare(strict_types=1);

namespace App\Api\Services;

use App\Admin\Setting\Models\DomainSettings;
use App\Api\Models\Seo;

final class MetaTagsService
{
    private array $default = [
        'title' => '',
        'keywords' => '',
        'description' => '',
        'h1' => '',
    ];

    /** @var array|string[] $data */
    private array $data = [];

    /** @var array|string[] $tags */
    protected array $tags = [];

    /** @var array|string[]  $seoMass */
    protected array $seoMass = [];

    /** @var string|mixed|null  $alias */
    private string|null $alias;

    /** @var mixed  $pattern */
    private mixed $pattern;

    public function __construct(mixed $pattern, mixed $page, string $alias = null)
    {
        $this->alias = $alias;
        $this->page = $page;
        $this->data = $this->getSeoSettings();
        $this->pattern = $pattern;
    }

    /**
     * @return array<string, string>
     */
    private function getSeoSettings(): array
    {
        $SeoHost = DomainSettings::query()->where(['key' => 'SeoHost'])->first();
        $OgSiteName = DomainSettings::query()->where(['key' => 'OgSiteName'])->first();

        return [
            '%seo_host%' => $SeoHost->value ?? 'ZonaFilm.ru',
            '%og_site_name%' => $OgSiteName->value ?? 'ZonaFilm.ru',
        ];
    }

    /**
     * @param array|String[] $data
     * @return array|String[]
     */
    public static function getSeoData(array $hostSettings, array $data): array
    {
        $seo = new self(...$hostSettings);
        $seo->setData($data);

        return $seo->getData();
    }

    public static function getSeoDataByAlias(
        mixed $pattern,
        mixed $page,
        string $alias,
        array $data
    ): array {
        $seo = new self($pattern, $page, $alias);
        $seo->setData($data);

        return $seo->getData();
    }

    /**
     * @param array|String[] $data
     */
    public function setData(array $data = []): void
    {
        $this->data = array_merge($this->data, $data);
    }

    public function getPattern(): array
    {
        $pattern = [];

        if ($this->alias) {
            $pattern = Seo::query()->where(['alias' => $this->alias])->first();
        } elseif ($this->pattern) {
            $pattern = $this->pattern;
        }

        return ! $pattern ? [] : [
            'h1' => $pattern->h1,
            'title' => $pattern->title,
            'keywords' => $pattern->keywords,
            'description' => $pattern->description,
        ];
    }

    public function apply(): void
    {
        $pattern = $this->getPattern();

        $keys = array_keys($this->data);
        $values = array_values($this->data);

        foreach ($pattern as $key => &$value) {
            if (empty($value)) {
                unset($pattern[$key]);

                continue;
            }

            $value = str_replace($keys, $values, $value);
        }

        $tags = self::merge($this->default, $pattern);

        $tags['title'] = preg_replace('/(\s){2,}/u', ' ', trim($tags['title']));
        $tags['description'] = preg_replace('/(\s){2,}/u', ' ', trim($tags['description']));

        $seo_mass = [
            'title' => $tags['title'],
            'keywords' => $tags['keywords'],
            'description' => $tags['description'],
        ];

        $seo_mass['h1'] = $tags['h1'];
        $this->seoMass = $seo_mass;
    }

    /**
     * @return array|String[]
     */
    public function getData(): array
    {
        if (empty($this->seoMass)) {
            $this->apply();
        }

        return $this->seoMass;
    }

    public static function merge(array $array1, array $array2): array
    {
        if (self::isAssoc($array2)) {
            foreach ($array2 as $key => $value) {
                if (
                    is_array($value)
                    and isset($array1[$key])
                    and is_array($array1[$key])
                ) {
                    $array1[$key] = self::merge($array1[$key], $value);
                } else {
                    $array1[$key] = $value;
                }
            }
        } else {
            foreach ($array2 as $value) {
                if (! in_array($value, $array1, true)) {
                    $array1[] = $value;
                }
            }
        }

        if (func_num_args() > 2) {
            foreach (array_slice(func_get_args(), 2) as $array2) {
                if (self::isAssoc($array2)) {
                    foreach ($array2 as $key => $value) {
                        if (
                            is_array($value)
                            and isset($array1[$key])
                            and is_array($array1[$key])
                        ) {
                            $array1[$key] = self::merge($array1[$key], $value);
                        } else {
                            $array1[$key] = $value;
                        }
                    }
                } else {
                    foreach ($array2 as $value) {
                        if (! in_array($value, $array1, true)) {
                            $array1[] = $value;
                        }
                    }
                }
            }
        }

        return $array1;
    }

    /**
     * @param array|string[] $array array to check
     */
    public static function isAssoc(array $array): bool
    {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }

    /**
     * @return array<string, string>|string|null
     */
    public static function clear(string $str): array|string|null
    {
        $str = preg_replace("/[^\w\sёйäöüß]|_/ui", ' ', $str);

        return preg_replace("/\s{2,}/u", ' ', $str);
    }
}
