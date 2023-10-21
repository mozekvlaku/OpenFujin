<?php
/**
 * Copyright 2023 Ing. Tomas Kracik (Vespotok)
 * 
 * Licensed under the Apache License, Version 2.0 (the 'License');
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an 'AS IS' BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * 
 * Out-Of-Fujin Context OpenFujin-compatible Autoloader (Modlib)
 */

spl_autoload_register(function ($class) {
    $context = [
        [
            'namespace' => 'Fujin\\DevTools',
            'path' => '/',
            'exts' => ['.model', '.fdo']
        ],
        [
            'namespace' => 'Fujin',
            'path' => '/',
            'exts' => ['.model', '.fdo']
        ]
    ];
    foreach ($context as $item) {
        $namespace = $item['namespace'];
        $path = $item['path'];
        $exts = $item['exts'];
        if (strpos($class, $namespace) === 0) {
            $full_path = __DIR__ . $path . str_replace('\\', DIRECTORY_SEPARATOR, ltrim($class, $namespace));
            foreach ($exts as $ext) {
                $file = strtolower($full_path . $ext);
                if (file_exists($file)) {
                    require $file;
                    return true;
                }
            }
        }
    }
    return false;
});