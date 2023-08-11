<?php

namespace Inmanturbo\PathRouter\Handlers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class WildcardHandler
{
    public function __invoke(string $viewPath, string $routeKey): array
    {
        if (View::exists($viewPath)) {
            $contents = View::make($viewPath);
            $response = Response::make($contents, 200);
            foreach (config('path-router.routes.'.$routeKey.'.headers') as $key => $value) {
                if (Str::contains($viewPath, $key)) {
                    $response->withHeaders($value);
                }
            }

            return [true, $response];
        }

        foreach (config('view.paths') as $path) {
            $matchingPath = $this->findMatchingPath($path, $viewPath);
            if ($matchingPath['matches']) {
                $contents = View::make($matchingPath['viewPath'], $matchingPath['data']);
                $response = Response::make($contents, 200);
                foreach (config('path-router.routes.'.$routeKey.'.headers') as $key => $value) {
                    if (Str::contains($viewPath, $key)) {
                        $response->withHeaders($value);
                    }
                }

                return [true, $response];
            }
        }

        return [false, false];
    }

    protected function findMatchingPath(string $directory, string $path): array
    {
        $dirIterator = new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new \RecursiveIteratorIterator($dirIterator, \RecursiveIteratorIterator::SELF_FIRST);

        $return = ['matches' => false, 'data' => [], 'match' => ''];

        // dd($directory, $path);

        foreach ($iterator as $item) {
            $relativePath = substr($item->getPathname(), strlen($directory));

            // Convert directory entry to regex pattern
            $patternSegments = [];
            $bracketSegmentIndices = [];
            $isSpreadOperator = false;
            $fileExtensionPattern = '';

            foreach (explode('/', $relativePath) as $index => $segment) {
                if (strpos($segment, '[...') !== false && strpos($segment, ']') !== false) {
                    $patternSegments[] = '(.+)';
                    $bracketSegmentIndices[] = $index;
                    $isSpreadOperator = true;
                    break;
                } elseif (strpos($segment, '[') !== false && strpos($segment, ']') !== false) {
                    $patternSegments[] = '([^/]+)';
                    $bracketSegmentIndices[] = $index;
                } else {
                    if (strpos($segment, '.') !== false) {
                        $fileExtensionPattern = '(\.'.preg_quote(explode('.', $segment)[1], '#').')?';
                        $segmentWithoutExtension = explode('.', $segment)[0];
                        $patternSegments[] = preg_quote($segmentWithoutExtension, '#');
                    } else {
                        $patternSegments[] = preg_quote($segment, '#');
                    }
                }
            }

            $pattern = '#^'.implode('/', $patternSegments).$fileExtensionPattern.'$#';

            if (preg_match($pattern, $path, $matchedSegments)) {
                $keyValues = [];

                if ($isSpreadOperator) {
                    preg_match('/\[...([^]]+)\]/', explode('/', $relativePath)[$bracketSegmentIndices[0]], $keyMatches);
                    $key = $keyMatches[1];
                    $value = explode('/', $matchedSegments[1]);
                    $keyValues[$key] = $value;
                } else {
                    foreach ($bracketSegmentIndices as $i => $segmentIndex) {
                        preg_match('/\[([^]]+)\]/', explode('/', $relativePath)[$segmentIndex], $keyMatches);
                        $key = $keyMatches[1];
                        $value = $matchedSegments[$i + 1];
                        $keyValues[$key] = $value;
                    }
                }

                $return['matches'] = true;
                $return['data'] = $keyValues;
                $return['match'] = $relativePath;
                $return['viewPath'] = str_replace(['.php', '.html', '.md', '.blade.php', '.js', '.vue', '.svelte'], '', $relativePath);
            }
        }

        return $return;
    }
}
