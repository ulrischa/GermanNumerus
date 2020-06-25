# GermanNumerus
Inflect plural and singular of nouns in German Language.

PHP Port of pluralize and singularize part from https://github.com/clips/pattern/blob/master/pattern/text/de/inflect.py
## Usage
See example.php
### Include
require_once('GermanNumerus.php');

use \ulrischa\GermanNumerus;
### Generate plural for German word
echo GermanNumerus::pluralize("Kopf");
### Generate singular for german word
echo  GermanNumerus::singularize("Bodenverunreinigungen");

### Accuracy
ca. 72% for pluralize()
ca. 84% for singularize()

