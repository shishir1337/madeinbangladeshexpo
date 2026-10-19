<?php

namespace App\Support\Content;

use Illuminate\Support\Str;

/**
 * Editor-written Markdown rendered to HTML, with an id on every `##` heading so sections can be linked and
 * listed as a table of contents. Raw HTML in the source is escaped.
 */
class MarkdownDocument
{
    private ?string $html = null;

    /**
     * @var list<array{id: string, title: string}>
     */
    private array $sections = [];

    public function __construct(private string $markdown) {}

    public function html(): string
    {
        if ($this->html === null) {
            $this->render();
        }

        return $this->html;
    }

    /**
     * The document's `##` headings, in order.
     *
     * @return list<array{id: string, title: string}>
     */
    public function sections(): array
    {
        if ($this->html === null) {
            $this->render();
        }

        return $this->sections;
    }

    private function render(): void
    {
        $html = Str::markdown($this->markdown, ['html_input' => 'escape', 'allow_unsafe_links' => false]);
        $used = [];

        $this->html = preg_replace_callback('#<h2>(.*?)</h2>#s', function (array $match) use (&$used): string {
            $title = html_entity_decode(strip_tags($match[1]), ENT_QUOTES | ENT_HTML5);
            $id = Str::slug($title) ?: 'section-'.(count($used) + 1);

            while (in_array($id, $used, true)) {
                $id .= '-'.(count($used) + 1);
            }

            $used[] = $id;
            $this->sections[] = ['id' => $id, 'title' => $title];

            return "<h2 id=\"{$id}\">{$match[1]}</h2>";
        }, $html);
    }
}
