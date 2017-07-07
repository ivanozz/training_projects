<?php
$ROOT = __DIR__;
$projects = scandir($ROOT);

echo '<ul>';
foreach($projects as $projectUrl) {
    $projectPath = $ROOT.'/'.$projectUrl;
    $projectReadmePath = $ROOT.'/'.$projectUrl.'/README.txt';
    if(is_dir($projectPath) && $projectUrl != '..' && $projectUrl != '.') {
        if(is_file($projectReadmePath)) {
            $projectReadme = fopen($projectReadmePath, "r");
            $projectName = fgets($projectReadme);
            $projectDesc = fgets($projectReadme);
            if($projectName) {
                echo '<li><a href="/' . $projectUrl . '/index.php">';
                echo $projectName;

                if($projectDesc)
                    echo '(<i>'.$projectDesc.'</i>)';

                echo '</a></li>';
            }
        }
    }
}
echo '</ul>';