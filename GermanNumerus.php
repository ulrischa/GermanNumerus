<?php
namespace ulrischa;

// Multibyte-Encoding
mb_internal_encoding("UTF-8");

 if (!function_exists('mb_ucfirst')) {
     /**
      * ucfirst with Multibyte
      *
      * @param string $string
      * @return string
      */
     function mb_ucfirst($string)
     {
         return mb_strtoupper(mb_substr($string, 0, 1)).mb_strtolower(mb_substr($string, 1));
     }
 }


class Helper
{
    
   /**
    * Checks if String starts with another String
    *
    * @param string $haystack
    * @param string $needle
    * @return bool
    */
    public static function start_with($haystack, $needle)
    {
        $length = mb_strlen($needle);
        return (mb_substr($haystack, 0, $length) === $needle);
    }

    /**
     * Checks if String ends with another String
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function ends_with($haystack, $needle)
    {
        $length = mb_strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (mb_substr($haystack, -$length) === $needle);
    }
}


/**
* Inflect plural and singular of nouns in German Language
*
* Port from https://www.clips.uantwerpen.be/pages/pattern
* Copyright (c) 2011-2013 University of Antwerp, Belgium
* All rights reserved.
*
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the following conditions are met:
*
*   * Redistributions of source code must retain the above copyright
*     notice, this list of conditions and the following disclaimer.
*   * Redistributions in binary form must reproduce the above copyright
*     notice, this list of conditions and the following disclaimer in
*     the documentation and/or other materials provided with the
*     distribution.
*   * Neither the name of Pattern nor the names of its
*     contributors may be used to endorse or promote products
*     derived from this software without specific prior written
*     permission.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
* "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
* LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
* FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
* COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
* INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
* BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
* LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
* CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
* LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
* ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
* POSSIBILITY OF SUCH DAMAGE.
* 
* Accuracy (measured on CELEX German morphology word forms):
* 75% for gender()
* 72% for pluralize()
* 84% for singularize() (for nominative)
*
* @author ulrischa <uli@ulrischa.de>
*
*/
class GermanNumerus
{
    protected static $plural_inflections = array(
        "aal" => "äle", "aat"=>"aaten",  "abe"=>"aben" , "ach" => "ächer", "ade"=>"aden"  ,
        "age"=>"agen"  , "ahn"=>"ahnen",  "ahr"=>"ahre" , "akt"=>"akte" , "ale"=>"alen"  ,
        "ame"=>"amen"  , "amt" => "ämter",  "ane"=>"anen" , "ang"=> "änge" , "ank"=> "änke"  ,
        "ann"=> "änner" , "ant"=>"anten",  "aph"=>"aphen", "are"=>"aren" , "arn"=>"arne"  ,
        "ase"=>"asen"  , "ate"=>"aten" ,  "att"=> "ätter", "atz"=> "ätze" , "aum"=>"äume"  ,
        "aus"=> "äuser" , "bad"=> "bäder",  "bel"=>"bel"  , "ben"=>"ben"  , "ber"=>"ber"   ,
        "bot"=>"bote"  , "che"=>"chen" ,  "chs"=>"chse" , "cke"=>"cken" , "del"=>"del"   ,
        "den"=>"den"   , "der"=>"der"  ,  "ebe"=>"ebe"  , "ede"=>"eden" , "ehl"=>"ehle"  ,
        "ehr"=>"ehr"   , "eil"=>"eile" ,  "eim"=>"eime" , "eis"=>"eise" , "eit"=>"eit"   ,
        "ekt"=>"ekte"  , "eld"=>"elder",  "ell"=>"elle" , "ene"=>"enen" , "enz"=>"enzen" ,
        "erd"=>"erde"  , "ere"=>"eren" ,  "erk"=>"erke" , "ern"=>"erne" , "ert"=>"erte"  ,
        "ese"=>"esen"  , "ess"=>"esse" ,  "est"=>"este" , "etz"=>"etze" , "eug"=>"euge"  ,
        "eur"=>"eure"  , "fel"=>"fel"  ,  "fen"=>"fen"  , "fer"=>"fer"  , "ffe"=>"ffen"  ,
        "gel"=>"gel"   , "gen"=>"gen"  ,  "ger"=>"ger"  , "gie"=>"gie"  , "hen"=>"hen"   ,
        "her"=>"her"   , "hie"=>"hien" ,  "hle"=>"hlen" , "hme"=>"hmen" , "hne"=>"hnen"  ,
        "hof"=> "höfe"  , "hre"=>"hren" ,  "hrt"=>"hrten", "hse"=>"hsen" , "hte"=>"hten"  ,
        "ich"=>"iche"  , "ick"=>"icke" ,  "ide"=>"iden" , "ieb"=>"iebe" , "ief"=>"iefe"  ,
        "ieg"=>"iege"  , "iel"=>"iele" ,  "ien"=>"ium"  , "iet"=>"iete" , "ife"=>"ifen"  ,
        "iff"=>"iffe"  , "ift"=>"iften",  "ige"=>"igen" , "ika"=>"ikum" , "ild"=>"ilder" ,
        "ilm"=>"ilme"  , "ine"=>"inen" ,  "ing"=>"inge" , "ion"=>"ionen", "ise"=>"isen"  ,
        "iss"=>"isse"  , "ist"=>"isten",  "ite"=>"iten" , "itt"=>"itte" , "itz"=>"itze"  ,
        "ium"=>"ium"   , "kel"=>"kel"  ,  "ken"=>"ken"  , "ker"=>"ker"  , "lag"=> "läge"  ,
        "lan"=> "läne"  , "lar"=>"lare" ,  "lei"=>"leien", "len"=>"len"  , "ler"=>"ler"   ,
        "lge"=>"lgen"  , "lie"=>"lien" ,  "lle"=>"llen" , "mel"=>"mel"  , "mer"=>"mer"   ,
        "mme"=>"mmen"  , "mpe"=>"mpen" ,  "mpf"=>"mpfe" , "mus"=>"mus"  , "mut"=>"mut"   ,
        "nat"=>"nate"  , "nde"=>"nden" ,  "nen"=>"nen"  , "ner"=>"ner"  , "nge"=>"ngen"  ,
        "nie"=>"nien"  , "nis"=>"nisse",  "nke"=>"nken" , "nkt"=>"nkte" , "nne"=>"nnen"  ,
        "nst"=>"nste"  , "nte"=>"nten" ,  "nze"=>"nzen" , "ock"=> "öcke" , "ode"=>"oden"  ,
        "off"=>"offe"  , "oge"=>"ogen" ,  "ohn"=> "öhne" , "ohr"=>"ohre" , "olz"=> "ölzer" ,
        "one"=>"onen"  , "oot"=>"oote" ,  "opf"=> "öpfe" , "ord"=>"orde" , "orm"=>"ormen" ,
        "orn"=> "örner" , "ose"=>"osen" ,  "ote"=>"oten" , "pel"=>"pel"  , "pen"=>"pen"   ,
        "per"=>"per"   , "pie"=>"pien" ,  "ppe"=>"ppen" , "rag"=> "räge" , "rau"=> "raün"  ,
        "rbe"=>"rben"  , "rde"=>"rden" ,  "rei"=>"reien", "rer"=>"rer"  , "rie"=>"rien"  ,
        "rin"=>"rinnen", "rke"=>"rken" ,  "rot"=>"rote" , "rre"=>"rren" , "rte"=>"rten"  ,
        "ruf"=>"rufe"  , "rzt"=>"rzte" ,  "sel"=>"sel"  , "sen"=>"sen"  , "ser"=>"ser"   ,
        "sie"=>"sien"  , "sik"=>"sik"  ,  "sse"=>"ssen" , "ste"=>"sten" , "tag"=>"tage"  ,
        "tel"=>"tel"   , "ten"=>"ten"  ,  "ter"=>"ter"  , "tie"=>"tien" , "tin"=>"tinnen",
        "tiv"=>"tive"  , "tor"=>"toren",  "tte"=>"tten" , "tum"=>"tum"  , "tur"=>"turen" ,
        "tze"=>"tzen"  , "ube"=>"uben" ,  "ude"=>"uden" , "ufe"=>"ufen" , "uge"=>"ugen"  ,
        "uhr"=>"uhren" , "ule"=>"ulen" ,  "ume"=>"umen" , "ung"=>"ungen", "use"=>"usen"  ,
        "uss"=> "üsse"  , "ute"=>"uten" ,  "utz"=>"utz"  , "ver"=>"ver"  , "weg"=>"wege"  ,
        "zer"=>"zer"   , "zug"=> "züge" , "ück"=> "ücke");
        
    protected static $singular_inflections = array(
        "innen"=>"in" , "täten"=>"tät",  "ahnen"=>"ahn",  "enten"=>"ent", "räser"=>"ras",
        "hrten"=>"hrt", "ücher"=>"uch", "örner"=>"orn", "änder"=>"and", "ürmer"=>"urm",
        "ahlen"=>"ahl",  "uhren"=>"uhr", "ätter"=>"att",  "suren"=>"sur",  "chten"=>"cht",
        "kuren"=>"kur",  "erzen"=>"erz", "güter"=>"gut",  "soren"=>"sor", "änner"=>"ann",
        "äuser"=>"aus",  "taten"=>"tat",  "isten"=>"ist", "bäder"=>"bad", "ämter"=>"amt",
        "eiten"=>"eit",  "raten"=>"rat",  "ormen"=>"orm",  "ionen"=>"ion",  "nisse"=>"nis",
        "ölzer"=>"olz",  "ungen"=>"ung", "läser"=>"las", "ächer"=>"ach",  "urten"=>"urt",
        "enzen"=>"enz",  "aaten"=>"aat",  "aphen"=>"aph", "öcher"=>"och", "türen"=>"tür",
        "sonen"=>"son", "ühren"=>"ühr", "ühner"=>"uhn",  "toren"=>"tor", "örter"=>"ort",
        "anten"=>"ant", "räder"=>"rad",  "turen"=>"tur", "äuler"=>"aul",  "änze"=>"anz",
        "tten"=>"tte",   "mben"=>"mbe",  "ädte"=>"adt",   "llen"=>"lle",   "ysen"=>"yse",
        "rben"=>"rbe",   "hsen"=> "hse",  "raün"=>"ra",   "rven"=>"rve",   "rken"=>"rke",
        "ünge"=>"ung",  "üten"=>"üte",   "usen"=>"use",   "tien"=>"tie",  "läne"=>"lan",
        "iben"=>"ibe",   "ifen"=>"ife",   "ssen"=>"sse",   "gien"=>"gie",   "eten"=>"ete",
        "rden"=>"rde",  "öhne"=>"ohn",  "ärte"=>"art",   "ncen"=>"nce",  "ünde"=>"und",
        "uben"=>"ube",   "lben"=>"lbe",  "üsse"=>"uss",   "agen"=>"age",  "räge"=>"rag",
        "ogen"=>"oge",   "anen"=>"ane",   "sken"=>"ske",   "eden"=>"ede",  "össe"=>"oss",
        "ürme"=>"urm",   "ggen"=>"gge",  "üren"=>"üre",   "nten"=>"nte",  "ühle"=>"ühl",
        "änge"=>"ang",   "mmen"=>"mme",   "igen"=>"ige",   "nken"=>"nke",  "äcke"=>"ack",
        "oden"=>"ode",   "oben"=>"obe",  "ähne"=>"ahn",  "änke"=>"ank",   "inen"=>"ine",
        "seen"=>"see",  "äfte"=>"aft",   "ulen"=>"ule",  "äste"=>"ast",   "hren"=>"hre",
        "öcke"=>"ock",   "aben"=>"abe",  "öpfe"=>"opf",   "ugen"=>"uge",   "lien"=>"lie",
        "ände"=>"and",  "ücke"=>"ück",   "asen"=>"ase",   "aden"=>"ade",   "dien"=>"die",
        "aren"=>"are",   "tzen"=>"tze",  "züge"=>"zug",  "üfte"=>"uft",   "hien"=>"hie",
        "nden"=>"nde",  "älle"=>"all",   "hmen"=>"hme",   "ffen"=>"ffe",   "rmen"=>"rma",
        "olen"=>"ole",   "sten"=>"ste",   "amen"=>"ame",  "höfe"=>"hof",  "üste"=>"ust",
        "hnen"=>"hne",  "ähte"=>"aht",   "umen"=>"ume",   "nnen"=>"nne",   "alen"=>"ale",
        "mpen"=>"mpe",   "mien"=>"mie",   "rten"=>"rte",   "rien"=>"rie",  "äute"=>"aut",
        "uden"=>"ude",   "lgen"=>"lge",   "ngen"=>"nge",   "iden"=>"ide",  "ässe"=>"ass",
        "osen"=>"ose",   "lken"=>"lke",   "eren"=>"ere",  "üche"=>"uch",  "lüge"=>"lug",
        "hlen"=>"hle",   "isen"=>"ise",  "ären"=>"äre",  "töne"=>"ton",   "onen"=>"one",
        "rnen"=>"rne",  "üsen"=>"üse",  "haün"=>"ha",   "pien"=>"pie",   "ihen"=>"ihe",
        "ürfe"=>"urf",   "esen"=>"ese",  "ätze"=>"atz",   "sien"=>"sie",  "läge"=>"lag",
        "iven"=>"ive",  "ämme"=>"amm",  "äufe"=>"auf",   "ppen"=>"ppe",   "enen"=>"ene",
        "lfen"=>"lfe",  "äume"=>"aum",   "nien"=>"nie",   "unen"=>"une",   "cken"=>"cke",
        "oten"=>"ote",    "mie"=>"mie",    "rie"=>"rie",    "sis"=>"sen",    "rin"=>"rin",
        "ein"=>"ein",    "age"=> "age",    "ern"=>"ern",    "ber"=>"ber",    "ion"=>"ion",
        "inn"=>"inn",    "ben"=> "ben",   "äse"=>"äse",    "eis"=>"eis",    "hme"=> "hme",
        "iss"=>"iss",    "hen"=> "hen",    "fer"=> "fer",    "gie"=>"gie",    "fen"=> "fen",
        "her"=>"her",    "ker"=> "ker",    "nie"=> "nie",    "mer"=>"mer",    "ler"=> "ler",
        "men"=>"men",    "ass"=> "ass",    "ner"=> "ner",    "per"=>"per",    "rer"=> "rer",
        "mus"=>"mus",    "abe"=> "abe",    "ter"=> "ter",    "ser"=>"ser",   "äle"=>  "aal",
        "hie"=>"hie",    "ger"=> "ger",    "tus"=> "tus",    "gen"=>"gen",    "ier"=> "ier",
        "ver"=>"ver",    "zer"=> "zer");
        
    protected static $irregular_plural = array(
        "bus" => "busse", "visum" => "visa", "atlas" => "atlanten", "embryo" => "embryonen",
        "globus" => "globen", "kaktus" => "kakteen", "komma" => "kommas", "lexikon" => "lexika",
        "luftballon" => "luftballons", "monitor" => "monitore", "museum" => "museen",
        "pizza" => "pizzen", "radius" => "radien", "rhythmus" => "rhythmen", "studie" => "studien",
        "tunnel" => "tunnel", "verhalten" => "verhaltensweisen", "virus" => "viren", "zirkus" => "zirkusse"
    );
    
    /**
     * Inflect plural from given noun
     *
     * @param string $noun
     * @return string
     */
    public static function pluralize($noun)
    {
        $w = mb_strtolower($noun);
        
        // Iregular?
        foreach (self::$irregular_plural as $s => $p) {
            if ($w == $s) {
                return mb_ucfirst($p);
            }
        }

        foreach (self::$plural_inflections as $s => $p) {
            if (Helper::ends_with($w, $s) === true) {
                return mb_ucfirst(preg_replace('/'.$s.'$/u', '', $w).$p);
            }
        }

        // Default rules (baseline = 69%).
        if (Helper::ends_with($w, "ge") === true) {
            return mb_ucfirst($w);
        }
        if (Helper::ends_with($w, "gie") === true) {
            return mb_ucfirst($w);
        }
        if (Helper::ends_with($w, "e") === true) {
            return mb_ucfirst($w)."n";
        }
        if (Helper::ends_with($w, "ien") === true) {
            return preg_replace('/ien$/u', '', $w)."um";
        }
        if (Helper::ends_with($w, "au") === true || Helper::ends_with($w, "sein") === true || Helper::ends_with($w, "eit") === true || Helper::ends_with($w, "er") === true || Helper::ends_with($w, "en") === true || Helper::ends_with($w, "el") === true || Helper::ends_with($w, "chen") === true || Helper::ends_with($w, "mus") === true || Helper::ends_with($w, "tät") === true || Helper::ends_with($w, "tik") === true || Helper::ends_with($w, "tum") === true || Helper::ends_with($w, "u") === true) {
            return mb_ucfirst($w);
        }
        if (Helper::ends_with($w, "ant") === true || Helper::ends_with($w, "ei") === true || Helper::ends_with($w, "enz") === true || Helper::ends_with($w, "ion") === true || Helper::ends_with($w, "ist") === true || Helper::ends_with($w, "or") === true || Helper::ends_with($w, "schaft") === true || Helper::ends_with($w, "tur") === true || Helper::ends_with($w, "ung") === true) {
            return mb_ucfirst($w)."en";
        }
        if (Helper::ends_with($w, "ein") === true) {
            return mb_ucfirst($w)."e";
        }
        if (Helper::ends_with($w, "in") === true) {
            return mb_ucfirst($w)."nen";
        }
        if (Helper::ends_with($w, "nis") === true) {
            return mb_ucfirst($w)."se";
        }
        if (Helper::ends_with($w, "eld") === true || Helper::ends_with($w, "ild") === true || Helper::ends_with($w, "ind") === true) {
            return mb_ucfirst($w)."er";
        }
        if (Helper::ends_with($w, "o") === true) {
            return mb_ucfirst($w)."s";
        }
        if (Helper::ends_with($w, "a") === true) {
            return mb_ucfirst(preg_replace('/a$/u', '', $w)."en");
        }
        # Inflect common umlaut vowels: Kopf => Köpfe.
        if (Helper::ends_with($w, "all") === true || Helper::ends_with($w, "and") === true || Helper::ends_with($w, "ang") === true || Helper::ends_with($w, "ank") === true || Helper::ends_with($w, "atz") === true || Helper::ends_with($w, "auf") === true || Helper::ends_with($w, "ock") === true || Helper::ends_with($w, "opf") === true || Helper::ends_with($w, "uch") === true || Helper::ends_with($w, "uss") === true) {
            $umlaut = mb_substr($w, -3, 1);
            $umlaut = str_replace("a", "ä", $umlaut);
            $umlaut = str_replace("o", "ö", $umlaut);
            $umlaut = str_replace("u", "ü", $umlaut);
            return mb_ucfirst(mb_substr($w, 0, -3).$umlaut.mb_substr($w, -2)."e");
        }
        foreach (array("ag" => "äge", "ann" => "änner", "aum" => "äume", "aus" => "äuser", "zug" => "züge") as $s => $p) {
            if (Helper::ends_with($w, $s) === true) {
                return mb_ucfirst(preg_replace('/'.$s.'$/u', '', $w).$p);
            }
        }

        return mb_ucfirst($w."e");
    }
    
    /**
     * Inflect singular from given noun
     *
     * @param string $noun
     * @return string
     */
    public static function singularize($noun)
    {
        $w = mb_strtolower($noun);
        
        //Iregular?
        foreach (self::$irregular_plural as $s => $p) {
            if ($w == $p) {
                return mb_ucfirst($s);
            }
        }
        
        foreach (self::$singular_inflections as $p => $s) {
            if (Helper::ends_with($w, $p) === true) {
                return mb_ucfirst(preg_replace('/'.$p.'$/u', '', $w).$s);
            }
        }
        
        foreach (array("nen", "en", "n", "e", "er", "s") as $suffix) {
            if (Helper::ends_with($w, $suffix) === true) {
                $w = preg_replace('/'.$suffix.'$/u', '', $w);
                break;
            }
        }
        if (Helper::ends_with($w, "rr") === true || Helper::ends_with($w, "rv") === true || Helper::ends_with($w, "nz") === true) {
            return mb_ucfirst($w."e");
        }
        return mb_ucfirst($w);
    }
    
    /**
     * Check if given noun is singular
     *
     * @param string $noun
     * @return boolean
     */
    public static function is_singular($noun)
    {
        if (self::singularize($noun) === $noun) return true;
        return false;
    
    }
    
    /**
     * Check if given noun is plural
     *
     * @param string $noun
     * @return boolean
     */
    public static function is_plural($noun)
    {
        if (self::pluralize(self::singularize($noun)) === $noun) return true;
        return false;
    
    }
    
}
