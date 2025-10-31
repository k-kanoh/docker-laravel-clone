<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Traits\GetArticles;
use Illuminate\Support\Facades\File;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class MdController extends Controller
{
    use GetArticles;

    public function top()
    {
        $articles = $this->getArticles(auth()->check());

        return view('top', compact('articles'));
    }

    public function show(string $id)
    {
        $file = collect($this->getArticles(auth()->check()))->first(fn($x) => $x['id'] === $id);

        if ($file === null) {
            abort(404);
        }

        $converter = new GithubFlavoredMarkdownConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $html = $converter->convert(File::get($file['filepath']))->getContent();

        $article = [
            ...$file,
            'html' => $html,
        ];

        return view('md', $article);
    }
}
