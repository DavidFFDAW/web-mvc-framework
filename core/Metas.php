<?php

class Metas
{
    private $title = '';
    private $description = '';
    private $robots = 'index, follow';
    private $keywords = '';
    private $canonical;
    private $ogTitle = '';
    private $ogDescription = '';
    private $ogImage = '';
    private $ogUrl = '';
    private $ogType = 'website';
    private $ogSiteName = '';
    private $ogLocale = 'es_ES';
    private $twitterCard = 'summary_large_image';
    private $twitterSite = '';
    private $twitterCreator = '';
    private $twitterTitle = '';
    private $twitterDescription = '';
    private $twitterImage = '';
    private $twitterImageAlt = '';



    public function __construct($metas = array())
    {
        $https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        $this->title = $metas['title'] ?? 'Mandarinos SAD';
        $this->description = $metas['description'] ?? 'Página web del nuevo equipo de fútbol Mandarinos SAD';
        $this->canonical = ($https ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    public function set($key, $value)
    {
        $this->$key = $value;

        return $this;
    }

    public function get($key = null)
    {
        if ($key) {
            return $this[$key];
        }

        return array(
            'title' => $this->title,
            'description' => $this->description,
            'robots' => $this->robots,
            'keywords' => $this->keywords,
            'canonical' => $this->canonical,
            'ogTitle' => $this->ogTitle,
            'ogDescription' => $this->ogDescription,
            'ogImage' => $this->ogImage,
            'ogUrl' => $this->ogUrl,
            'ogType' => $this->ogType,
            'ogSiteName' => $this->ogSiteName,
            'ogLocale' => $this->ogLocale,
            'twitterCard' => $this->twitterCard,
            'twitterSite' => $this->twitterSite,
            'twitterCreator' => $this->twitterCreator,
            'twitterTitle' => $this->twitterTitle,
            'twitterDescription' => $this->twitterDescription,
            'twitterImage' => $this->twitterImage,
            'twitterImageAlt' => $this->twitterImageAlt,
        );
    }
}
