<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    protected $table = 'system_config';

    public function getWebsiteSeo()
    {
        $default_seo = $this->getDefaultSeo();
        $seo_v = $default_seo ? $default_seo->toArray() : [];
        return [
            'globle' => $this->getSeoValue($seo_v, 'seo_default_globle'),
            'keywords' => $this->getSeoValue($seo_v, 'seo_default_keywords'),
            'title' => $this->getSeoValue($seo_v, 'seo_default_title'),
            'description' => $this->getSeoValue($seo_v, 'seo_default_description'),
        ];
    }

    public function getDefaultSeo()
    {
        return SystemConfig::whereIn('identifier', ['seo_default_keywords', 'seo_default_title', 'seo_default_description', 'seo_default_globle'])->get()->pluck('value', 'identifier');
    }

    public function seoConstants()
    {
        return [
            'seo_default_keywords' => SEO_DEFAULT_KEYWORDS,
            'seo_default_title' => SEO_DEFAULT_TITLE,
            'seo_default_description' => SEO_DEFAULT_DESCRIPTION,
            'seo_default_globle' => SEO_DEFAULT_GLOBLE
        ];
    }

    public function getSeoValue($seo_v, $key)
    {
        $seo_constants = $this->seoConstants();
        return array_key_exists($key, $seo_v) ? $seo_v[$key] : $seo_constants[$key];
    }

    public function updateSeo($data)
    {
        $res = [];
        foreach ($data as $k => $v) {
            if (SystemConfig::where('identifier', $k)->first()) {
                $res[$k] = SystemConfig::where('identifier', $k)->update(['value' => $v]);
            } else {
                $res[$k] = SystemConfig::insert(['identifier' => $k, 'value' => $v]);
            }
        }
        return $res;
    }

}
