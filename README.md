# GermanNumerus
Inflect plural and singular of nouns in German Language.

PHP Port from Python: https://www.clips.uantwerpen.be/pages/pattern
## Usage
See example.php
### Include
require_once('GermanNumerus.php');

use \ulrischa\GermanNumerus;
### Generate plural for German word
echo GermanNumerus::pluralize("Kopf");
### Generate singular for german word
echo  GermanNumerus::singularize("Bodenverunreinigungen");
