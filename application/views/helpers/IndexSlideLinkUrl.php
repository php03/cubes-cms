<?php

class Zend_View_Helper_IndexSlideLinkUrl extends Zend_View_Helper_Abstract
{
    public function indexSlideLinkUrl($indexSlide) {
        
        switch ($indexSlide['link_type']) {
            
            case 'SitemapPage':
                //pozivanje helpera u helper
                return $this->view->sitemapPageUrl($indexSlide['sitemap_page_id']);

            
            case 'InternalLink':
                return $this->view->baseUrl($indexSlide['internal_link_url']);

            
            case 'ExternalLink':
                return $indexSlide['external_link_url'];

            
            default:
                return '';
        }
        
    }
}

