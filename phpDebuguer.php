<?php if (DEBUG) { ?>
    <div style="width:100%; border: 5px solid red; padding: 1em; background-color: white;">
        <H1 style="text-align: center; margin-bottom: 1em;">DEBUGUER PHP 2.1.2</H1>
        <p style="color: blue;">SUPERGLOBAL</p>
        <p style="color: red;">Object</p>
        <P style="margin-bottom: 2em;">Variable</P>
        <?php
        // Obtenir toutes les variables en mémoire
        $pile = debug_backtrace();
        $const = get_defined_constants();
        $variables = get_defined_vars();
        $display = [
            'pile' => ['Pile d execution' => $pile],
            'session' => [],
            'other' => [],
            'object' => [],
            'superglobal' => [],
            'const' => ['Constantes' => $const]
        ];

        // Organisation des variables
        foreach ($variables as $key => $value) {
            $letters = substr($key, 0, 1);
            if ($key === '_SESSION') {
                $display['session'][$key] = $value;
            } elseif ($letters === '_' && $key !== '_SESSION') {
                $display['superglobal'][$key] = $value;
            } elseif (is_object($value)) {
                $display['object'][$key] = $value;
            } elseif ($key !== '_SESSION' && $key !== 'pile') {
                $display['other'][$key] = $value;
            }
        }

        $h2 = '';
        $color = '';
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
                } elseif ($key !== '_SESSION' && $key !== 'Pile d execution' && $key !== 'Constantes') {
                    $h2 = 'Variables :';
                    $color = '';
                } 
                if ($h2 !== $h2c) { ?>
                <h2 style="color: <?= $color ?>; margin-bottom: 1em;"><?= $h2 ?></h2> <?php } $h2c = $h2;?>
                <div style='margin-bottom: 2em; border: 3px solid red; width: 80%; padding: 1em; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); border-radius: 1em; position: relative;'>
                    <?php
                    $color = ($key[0] === '_') ? 'blue' : (is_object($value) ? 'red' : ($key === 'Pile d execution' ? 'green' : ''));
                    ?>
                    <button onclick='toggleContent("<?php echo $key; ?>-content")' style='position: absolute; top: 2px; right: 10px; border-radius: 1em; font-size: 2em; padding: 8px 20px; cursor: pointer;'>+</button>
                    <h2 style='color: <?php echo $color; ?>'><?php echo "$key : " . (empty($variables[$key]) && $key !== 'Pile d execution' && $key !== 'Constantes' ? 'empty' : ''); ?></h2>
                    <div id='<?php echo "$key-content"; ?>' style='display: none;'>
                        <pre style="overflow: auto;">
                            <?php print_r($value); ?>
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
<?php } ?>