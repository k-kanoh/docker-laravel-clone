<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Traits\GetArticles;

class SitemapController extends Controller
{
    use GetArticles;

    public function index()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $xml .= '<url>';
        $xml .= '<loc>' . url('/') . '</loc>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>1.0</priority>';
        $xml .= '</url>';

        $xml .= '<url>';
        $xml .= '<loc>' . url('/thssren.html') . '</loc>';
        $xml .= '<changefreq>yearly</changefreq>';
        $xml .= '<priority>0.6</priority>';
        $xml .= '</url>';

        $xml .= '<url>';
        $xml .= '<loc>' . url('/barcode') . '</loc>';
        $xml .= '<changefreq>yearly</changefreq>';
        $xml .= '<priority>0.6</priority>';
        $xml .= '</url>';

        $xml .= '<url>';
        $xml .= '<loc>' . url('/a5m2reverse.html') . '</loc>';
        $xml .= '<changefreq>yearly</changefreq>';
        $xml .= '<priority>0.6</priority>';
        $xml .= '</url>';

        $articles = $this->getArticles(false);

        foreach ($articles as $article) {
            $xml .= '<url>';
            $xml .= '<loc>' . route('md.show', $article['id']) . '</loc>';
            $xml .= '<lastmod>' . date('c', $article['updated_at']) . '</lastmod>';
            $xml .= '<changefreq>monthly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
