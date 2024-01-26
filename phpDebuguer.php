<?php if (DEBUG) { 
    // ini_set('max_execution_time', 0);
    // ini_set('memory_limit', '-1');
    // ini_set('xdebug.max_nesting_level', 500);
    $color = 'black';?>
    <div style="width:100%; border: 5px solid red; padding: 1em; background-color: white;">
        <H1 style="text-align: center; margin-bottom: 1em; color: black;">DEBOGUER PHP 2.2.0</H1>
        <p style="font-size: 1.25em; margin-bottom: 1em; color: black;">Version de PHP : <?= PHP_VERSION ?></p>
        <p style="font-size: 1.25em; margin-bottom: 1em; color: black;">OS du serveur : <?= PHP_OS_FAMILY ?></p>
        <p style="font-size: 1.25em; margin-bottom: 2em; color: black;">Temps d'éxecution : <?= round(microtime(true) - TIME_EXE, 3) ?>s</p>
        <?php
        // Obtenir toutes les variables en mémoire
        $pile = debug_backtrace();
        $const = get_defined_constants();
        $variables = get_defined_vars();
        $display = [
            'pile' => ['Pile d execution' => $pile],
            'session' => [],
            'post' => [],
            'other' => [],
            'object' => [],
            'superglobal' => [],
            'const' => ['Constantes' => $const]
            // 'phpinfo' => ['PHP info' => '']
        ];

        // Organisation des variables
        foreach ($variables as $key => $value) {
            $letters = substr($key, 0, 1);
            if ($key === '_SESSION') {
                $display['session'][$key] = $value;
            } elseif ($key === '_POST') {
                $display['post'][$key] = $value;
            } elseif ($letters === '_' && $key !== '_SESSION' && $key !== '_POST') {
                $display['superglobal'][$key] = $value;
            } elseif (is_object($value)) {
                $display['object'][$key] = $value;
            } elseif ($key !== '_SESSION' && $key !== 'pile' && $key !== 'const' && $key !== 'color') {
                $display['other'][$key] = $value;
            }
        }

        $h2 = '';
        $h2c = '';

        // Parcourir les variables
        foreach ($display as $var) { 
            foreach ($var as $key => $value) {
                $letters = substr($key, 0, 1);
                if ($letters === '_') {
                    $h2 = 'Superglobales :';
                    $color = 'blue';
                } elseif (is_object($value)) {
                    $h2 = 'Objects :';
                    $color = 'red';
                } elseif ($key !== '_SESSION' && $key !== 'Pile d execution' && $key !== 'Constantes' && $key !== 'PHP info') {
                    $h2 = 'Variables :';
                    $color = 'black';
                } 
                if ($h2 !== $h2c) { ?>
                <h2 style="color: <?= $color ?>; margin-bottom: 1em;"><?= $h2 ?></h2> <?php } $h2c = $h2;?>
                <div style='margin-bottom: 2em; border: 3px solid red; width: 80%; padding: 1em; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); border-radius: 1em; position: relative;'>
                    <?php
                    $color = ($key[0] === '_') ? 'blue' : (is_object($value) ? 'red' : ($key === 'Pile d execution' ? 'green' : 'black'));
                    ?>
                    <button onclick='toggleContent("<?php echo $key; ?>-content")' style='position: absolute; top: 2px; right: 10px; border-radius: 1em; font-size: 2em; padding: 8px 20px; cursor: pointer;'>+</button>
                    <h2 style='color: <?php echo $color; ?>'><?php echo "$key : " . (empty($variables[$key]) && $key !== 'Pile d execution' && $key !== 'Constantes' && $key !== 'PHP info' ? 'empty' : ''); ?></h2>
                    <div id='<?php echo "$key-content"; ?>' style='display: none;'>
                        <pre style="overflow: auto;">
                            <?= $key === 'Constantes' ? print_r($value) : ($key === 'PHP info' ? phpinfo() : var_dump($value))?>
                        </pre>
                    </div>
                </div>

            <?php }
        }
        ?>
    </div>

    <script>
        function toggleContent(elementId) {
            let x = document.getElementById(elementId);
            if (x.style.display === 'block') {
                x.style.display = 'none';
            } else {
                x.style.display = 'block';
            }
        }
    </script>
    <!-- <style>
        body {background-color: white;}
    </style> -->
<?php } ?>