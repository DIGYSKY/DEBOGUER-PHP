<?php if (DEBUG) { ?>
    <div style="width:100%; border: 5px solid red; padding: 1em; background-color: white;">
        <H1 style="text-align: center; margin-bottom: 1em;">DEBOGUER PHP 2.0.0</H1>
        <p style="color: blue;">SUPERGLOBAL</p>
        <p style="color: red;">Object</p>
        <P style="margin-bottom: 2em;">Variable</P>
        <?php
        // Obtenir toutes les variables en mémoire
        $variables = get_defined_vars();
        $display = [
            'session' => [],
            'other' => [],
            'object' => [],
            'superglobal' => []
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
            } elseif ($key !== '_SESSION') {
                $display['other'][$key] = $value;
            }
        }

        // Parcourir les variables
        foreach ($display as $var) {
            foreach ($var as $key => $value) { ?>
                <div style='margin-bottom: 2em; border: 3px solid red; width: 80%; padding: 1em; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); border-radius: 1em; position: relative;'>
                    <?php
                    $color = ($key[0] === '_') ? 'blue' : (is_object($value) ? 'red' : '');
                    ?>
                    <button class='button' onclick='toggleContent("<?php echo $key; ?>-content")' style='position: absolute; top: 2px; right: 10px; border-radius: 1em; font-size: 2em; padding: 8px 20px; cursor: pointer;'>+</button>
                    <h2 style='color: <?php echo $color; ?>'><?php echo "$key : " . (empty($variables[$key]) ? 'empty' : ''); ?></h2>
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
