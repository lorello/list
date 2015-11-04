<?php

/*
 *  root
 *    / aaa
 *    / bbb
 *
 *
 *
 *
 *
 */

function scan($path, $root='')
{
    if (empty($root)) {
        # looking on the root path
        $root = $path;
        $output = './docs/index.md';
    } else {
        $relPathname = str_replace($root, '', $path);
        $docsDir = 'docs'.$relPathname;
        if (!is_dir($docsDir))
            mkdir($docsDir, '775', true);
        $output = "./docs/$relPathname/index.md";
    }
    if (is_file($output))
        unlink($output);

    $dir = new DirectoryIterator($path);
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot()) {
            $name = $fileinfo->getBasename();
            if ($fileinfo->isDir())
            {
                scan($fileinfo->getPathname(), $root);
                $data = "* [$name]($name)\n";
            }
            else {
                $data = "* $name\n";
            }
            file_put_contents($output, $data, FILE_APPEND);
        }
    }
}

scan('../Video');
