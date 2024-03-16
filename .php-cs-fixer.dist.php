<?php declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(array_map(fn($x) => __DIR__ . '/src' . $x, [
        '/app',
        '/config',
        '/database/factories',
        '/database/seeders',
        '/routes',
        '/tests',
    ]));

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules([
        // 基本ルールセット
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,

        // <?php declare(strict_types=1); を付与
        'blank_line_after_opening_tag' => false,
        'linebreak_after_opening_tag' => false,
        'declare_strict_types' => true,

        // phpdocの「@param string|null $bar」をnullが最後にくるようにする
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'none',
        ],

        // phpdocのタグを消したがるのをやめさせる
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => false,
            'remove_inheritdoc' => false,
        ],

        // グローバルなクラスはインポートして使う
        'global_namespace_import' => [
            'import_classes' => true,
        ],

        // グローバルな関数、定数の絶対参照「\」を省略する
        'native_constant_invocation' => false,
        'native_function_invocation' => false,

        // テストケースで静的メソッドは「this->」を使う
        'php_unit_test_case_static_method_calls' => [
            'call_type' => 'this',
        ],

        // 結合演算子「.」を使うときはスペースを挟む
        'concat_space' => ['spacing' => 'one'],

        // 名前空間付きクラスをそのままにする
        'fully_qualified_strict_types' => false,

        // キャストの型の後にスペースを挟まない
        'cast_spaces' => [
            'space' => 'none',
        ],

        // fnと()にスペースを挟まない
        'function_declaration' => [
            'closure_fn_spacing' => 'none',
            'closure_function_spacing' => 'none',
        ],

        // 行末のセミコロンの前に空白があれば取り除く
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line',
        ],

        // phpdocの見出しに勝手に「.」を付けるのをやめる
        'phpdoc_summary' => false,

        // 戻り値の型宣言の「:」の前後にスペースを挟む
        'return_type_declaration' => [
            'space_before' => 'one',
        ],

        // コメント始まりのスペース自動挿入は不要
        'single_line_comment_spacing' => false,

        // 匿名関数にstaticを付けたがるのをやめさせる
        'static_lambda' => false,

        // ヨーダスタイルを拒否
        'yoda_style' => false,
    ])
    ->setFinder($finder);
