<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YoutubeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    // Search video relevan
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return back()->with('error', 'Masukkan judul lagu!');
        }

        $safeQuery = escapeshellarg('ytsearch10:' . $query);
        $command = "yt-dlp --dump-json --flat-playlist --no-warnings --js-runtimes node {$safeQuery} 2>&1";

        exec($command, $outputLines);

        $results = [];
        foreach ($outputLines as $line) {
            $data = json_decode($line, true);
            if ($data && isset($data['id'])) {
                $results[] = [
                    'id'       => $data['id'],
                    'title'    => $data['title'] ?? 'Unknown',
                    'duration' => isset($data['duration']) ? gmdate("i:s", $data['duration']) : '?',
                    'url'      => 'https://www.youtube.com/watch?v=' . $data['id'],
                    'thumb'    => 'https://img.youtube.com/vi/' . $data['id'] . '/mqdefault.jpg',
                ];
            }
        }

        return view('index', compact('results', 'query'));
    }

   public function download(Request $request)
{
    $request->validate([
        'url'     => 'required|url',
        'quality' => 'required|in:128,192,320',
    ]);

    $url     = $request->input('url');
    $quality = $request->input('quality');

    if (!str_contains($url, 'youtube.com') && !str_contains($url, 'youtu.be')) {
        return back()->with('error', 'URL harus dari YouTube!');
    }

    // ✅ PATH sesuai Windows kamu
    $ytDlpPath  = '"C:\Program Files (x86)\yt-dlp\yt-dlp.exe"';
    $ffmpegPath = '"C:\Program Files (x86)\ffmpeg\bin"';

    // ✅ FOLDER DOWNLOAD
    $outputDir = storage_path('app/public/downloads');
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0777, true); // recursive
    }

    // ✅ AUTO RENAME JUDUL
    $outputTemplate = $outputDir . DIRECTORY_SEPARATOR . '%(title)s.%(ext)s';

    $safeUrl = escapeshellarg($url);
   $outputTemplate = $outputDir . DIRECTORY_SEPARATOR . '%(title)s.%(ext)s';

    // ✅ COMMAND FINAL
  $command = "{$ytDlpPath} --no-playlist -x --audio-format mp3 --audio-quality {$quality}K --ffmpeg-location {$ffmpegPath} --js-runtimes node --extractor-args \"youtube:player_client=web\" --sleep-interval 3 --max-sleep-interval 6 --user-agent \"Mozilla/5.0 (Windows NT 10.0; Win64; x64)\" -o \"{$outputTemplate}\" {$safeUrl} 2>&1";

    exec($command, $outputLines, $returnCode);
    \Log::info('DOWNLOAD LOG:', $outputLines);

    if ($returnCode !== 0) {
        return back()->with('error', implode("\n", $outputLines));
    }

    // ✅ AMBIL FILE TERBARU
    $files = glob($outputDir . DIRECTORY_SEPARATOR . '*.mp3');
    if (!$files) {
        return back()->with('error', 'File tidak ditemukan!');
    }

    usort($files, fn($a, $b) => filemtime($b) - filemtime($a));
    $latestFile = $files[0];

    return response()->download($latestFile)->deleteFileAfterSend(true);
}}