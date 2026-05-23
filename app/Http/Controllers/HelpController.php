<?php

namespace App\Http\Controllers;

use App\Models\DocWorkflow;
use Illuminate\Http\Request;

/**
 * Public help/tutorial viewer (in-app documentation).
 * URL: /help (landing), /help/{kode} (detail)
 */
class HelpController extends Controller
{
    /**
     * Landing — list semua doc aktif, grouped by modul + kategori, dengan search.
     */
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $query = DocWorkflow::where('active', true);

        if ($q !== '') {
            $query->where(function ($w) use ($q) {
                $w->where('judul', 'like', "%{$q}%")
                  ->orWhere('ringkasan', 'like', "%{$q}%")
                  ->orWhere('kode', 'like', "%{$q}%")
                  ->orWhere('konten', 'like', "%{$q}%");
            });
        }

        $docs = $query->orderBy('modul')
                      ->orderBy('kategori')
                      ->orderBy('urutan')
                      ->orderBy('judul')
                      ->get();

        // Group by modul
        $grouped = $docs->groupBy('modul');

        return view('help.index', compact('grouped', 'q'));
    }

    /**
     * Detail viewer — render markdown ke HTML.
     */
    public function show(string $kode)
    {
        $doc = DocWorkflow::where('kode', $kode)
            ->where('active', true)
            ->firstOrFail();

        // Related docs: same modul, exclude current, top 5
        $related = DocWorkflow::where('active', true)
            ->where('modul', $doc->modul)
            ->where('id', '!=', $doc->id)
            ->orderBy('urutan')->orderBy('judul')
            ->limit(5)
            ->get();

        // Convert markdown → HTML (simple converter, no extra package)
        $html = $this->markdownToHtml($doc->konten);

        return view('help.show', compact('doc', 'html', 'related'));
    }

    /**
     * Minimal markdown → HTML converter (no external package).
     * Support: # headings, **bold**, *italic*, `code`, ```fenced```, lists, links.
     */
    protected function markdownToHtml(string $md): string
    {
        // Escape HTML first
        $h = htmlspecialchars($md, ENT_QUOTES, 'UTF-8');

        // Fenced code blocks ```...```
        $h = preg_replace_callback('/```(\w*)\n(.*?)\n```/s', function ($m) {
            return '<pre class="bg-light p-3 rounded"><code>' . $m[2] . '</code></pre>';
        }, $h);

        // Inline code `...`
        $h = preg_replace('/`([^`\n]+)`/', '<code class="bg-light px-1 rounded">$1</code>', $h);

        // Headings (## , ### , #)
        $h = preg_replace('/^### (.*)$/m', '<h5 class="mt-3">$1</h5>', $h);
        $h = preg_replace('/^## (.*)$/m', '<h4 class="mt-4">$1</h4>', $h);
        $h = preg_replace('/^# (.*)$/m', '<h3 class="mt-4">$1</h3>', $h);

        // Bold + italic
        $h = preg_replace('/\*\*([^\*]+)\*\*/', '<strong>$1</strong>', $h);
        $h = preg_replace('/(?<!\*)\*([^\*\n]+)\*(?!\*)/', '<em>$1</em>', $h);

        // Links [text](url)
        $h = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="$2">$1</a>', $h);

        // Unordered list (- item)
        $h = preg_replace_callback('/(?:^- .+(?:\n|$))+/m', function ($m) {
            $items = preg_replace('/^- (.+)$/m', '<li>$1</li>', trim($m[0]));
            return "<ul>{$items}</ul>";
        }, $h);

        // Ordered list (1. item)
        $h = preg_replace_callback('/(?:^\d+\. .+(?:\n|$))+/m', function ($m) {
            $items = preg_replace('/^\d+\. (.+)$/m', '<li>$1</li>', trim($m[0]));
            return "<ol>{$items}</ol>";
        }, $h);

        // Paragraphs — wrap remaining lines yang bukan tag block
        $lines = explode("\n", $h);
        $out = [];
        $buffer = [];
        foreach ($lines as $line) {
            $trim = trim($line);
            if ($trim === '') {
                if (!empty($buffer)) {
                    $out[] = '<p>' . implode(' ', $buffer) . '</p>';
                    $buffer = [];
                }
            } elseif (preg_match('/^<(h[1-6]|ul|ol|li|pre|code|blockquote|hr|p|div)/i', $trim)) {
                if (!empty($buffer)) {
                    $out[] = '<p>' . implode(' ', $buffer) . '</p>';
                    $buffer = [];
                }
                $out[] = $line;
            } else {
                $buffer[] = $trim;
            }
        }
        if (!empty($buffer)) {
            $out[] = '<p>' . implode(' ', $buffer) . '</p>';
        }

        return implode("\n", $out);
    }
}
