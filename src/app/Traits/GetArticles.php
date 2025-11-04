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
        $colors = [];
        $i = 1;

        foreach ($files as $file) {
            $filename = basename($file);
            $withoutExt = preg_replace('/\.md$/', '', $filename);

            preg_match('/\.([a-c])(?:\.|$)/', $withoutExt, $matches);
            $theme = $matches[1] ?? null;

            $title = preg_replace('/\.([a-c]|claude|gpt)(?=\.|$)/i', '', $withoutExt);

            $group = str_replace(resource_path('markdown'), '', dirname($file));
            $group = trim($group, '/') ?: null;

            if ($group && !array_key_exists($group, $colors)) {
                $colors[$group] = $i++;
            }

            $articles[] = [
                'id' => md5($title),
                'filepath' => $file,
                'filename' => $filename,
                'title' => $title,
                'updated_at' => filemtime($file),
                'theme' => $theme,
                'group' => $group,
                'color' => $group ? $colors[$group] : null,
            ];
        }

        usort($articles, function($a, $b) {
            return $b['updated_at'] <=> $a['updated_at'];
        });

        return $articles;
    }
}
