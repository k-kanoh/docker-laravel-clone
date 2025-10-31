<?php declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait GetArticles
{
    private function getArticles(bool $withSubDir) : array
    {
        if ($withSubDir) {
            $files = collect(File::allFiles(resource_path('markdown')))
                ->filter(fn($x) => $x->getExtension() === 'md')
                ->map(fn($x) => $x->getPathname())
                ->toArray();
        } else {
            $files = File::glob(resource_path('markdown/*.md'));
        }

        $articles = [];

        foreach ($files as $file) {
            $filename = basename($file);

            $articles[] = [
                'id' => md5($filename),
                'filepath' => $file,
                'filename' => $filename,
                'title' => preg_replace('/\.(claude\.)?md$/', '', $filename),
                'updated_at' => filemtime($file),
            ];
        }

        usort($articles, function($a, $b) {
            return $b['updated_at'] <=> $a['updated_at'];
        });

        return $articles;
    }
}
