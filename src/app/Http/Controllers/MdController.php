<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class MdController extends Controller
{
    public function top()
    {
        $posts = $this->getPosts();

        return view('index', compact('posts'));
    }

    public function show(string $id)
    {
        $file = collect($this->getPosts())->first(fn($x) => $x['id'] === $id);

        if ($file === null) {
            abort(404);
        }

        $converter = new GithubFlavoredMarkdownConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $html = $converter->convert(File::get($file['filepath']))->getContent();

        $article = [...$file, 'html' => $html];

        return view('md', $article);
    }

    private function getPosts() : array
    {
        $posts = [];

        $files = File::glob(resource_path('markdown/*.md'));

        foreach ($files as $file) {
            $filename = basename($file);

            $posts[] = [
                'id' => md5($filename),
                'filepath' => $file,
                'filename' => $filename,
                'title' => preg_replace('/\.(claude\.)?md$/', '', $filename),
                'updated_at' => filemtime($file),
            ];
        }

        usort($posts, function($a, $b) {
            return $b['updated_at'] <=> $a['updated_at'];
        });

        return $posts;
    }
}
