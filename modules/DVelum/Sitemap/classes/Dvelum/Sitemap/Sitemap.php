<?php
abstract class Dvelum_Sitemap_Adapter
{
    protected $host;
    protected $scheme = 'http://';

    public function __construct()
    {
        $this->host = Request::server('HTTP_HOST', 'string', '');
        if(Request::isHttps()){
            $scheme = 'https://';
        }
    }

    /**
     * Get item xml
     * @param $url
     * @param $lastMod
     * @param string $modTime
     * @param float $priority
     * @return string
     */
    protected function getItem($url , $lastMod , $modTime='weekly', $priority = 0.8)
    {
        return '<url><loc>' . $this->scheme . $this->serverName . $url . '</loc><lastmod>' . $lastMod . '</lastmod><changefreq>'.$modTime.'</changefreq><priority>'.$priority.'</priority></url>';
    }

    abstract protected function getData();

    public function __toXml()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml.= $this->getItems();
        $xml.= '</urlset>';
    }

    /**
     * Get Sitemap urlset items
     * @return string
     */
    abstract protected function getItems();
}