<?php
class Dvelum_Sitemap
{
    protected $adapters = [];
    protected $url = '/sitemap.xml';

    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Add sitemap generator
     * @param $code
     * @param Dvelum_Sitemap_Adapter $adapter
     */
    public function addAdapter($code, Dvelum_Sitemap_Adapter $adapter)
    {
        $this->adapters[$code] = $adapter;
    }

    /**
     * Get Sitemap Index XML
     */
    public function getIndexXml()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml.= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml.= '</sitemapindex>';
        return $xml;
    }

    /**
     * Get sitemap XML
     * @param $code - adapter code
     * @return string
     */
    public function getMapXml($code)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml.= $this->getItems();
        $xml.= '</urlset>';
    }
}