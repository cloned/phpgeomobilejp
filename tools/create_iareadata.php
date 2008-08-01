<?php
$iareadir = @$argv[1];
$outfile = 'iareadata.php';

if ($argc != 2 || !is_dir($iareadir)) {
    echo "Usage: php create_iareadata.php iarea-directory\n";
    exit;
} elseif (file_exists($outfile)) {
    printf("%s is exists.\n", $outfile);
    exit;
}

if (substr($iareadir, -1, 1) != '/') {
    $iareadir .= '/';
}

$list = scandir($iareadir);
$data = array();

foreach ($list as $name) {
    if (preg_match('/\.txt$/i', $name)) {
        $contents = trim(file_get_contents($iareadir . $name));        
        if ($contents) {
            $data[] = mb_convert_encoding($contents, 'UTF-8', 'SJIS');
        }
    }
}

$phpdata = '<?php' . "\n" . '$data = ' . var_export($data, true) . ';';
file_put_contents($outfile, $phpdata);
