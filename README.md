# DEBOGUER PHP 2.0.0
---
Il s'agit d'un mini déboguer pour PHP qui affiche les différentes variables setter.
---
## installation :
Dans un premier temps il faut définir la constante qui permet d'activer "DEBOGUER PHP" comme suit :
```php
define('DEBUG', true);// true : enable, false : disable
```
Cette définition se fait généralement dans le fichier de configuration de votre site web (parameters.conf.php) !

Enfin il suffit de requier le fichier à la fin de votre site web, généralement dans le footer comme suit :
```php
< ?php require_once './cheminVersLeFichier/phpDebuguer.php' ?>
```

### En vous souhaitant bon code !! !
N'hésitez pas à faire un Fork avec vos idées, vos modifications ou avec des fonctions supplémentaires !

### GNU GENERAL PUBLIC LICENSE

Use php 8.2

Copyright (C) 2007 Free Software Foundation, Inc. <https://fsf.org/> 
Everyone is permitted to copy and distribute verbatim copies 
of this license document, but changing it is not allowed.

See the LICENSE file
