<?php
//Restrict Direct access to script
namespace App\Controller;

if(empty($_SERVER['HTTP_REFERER'])) {die("Unauthorized Access.");}

require_once('vendor/autoload.php');
require_once('StringCompare.php');

use App\Entity\StringCompare;
use Statickidz\GoogleTranslate;

class Translate {

    public $sl = "en";
    public $tl = "fr";

    public function __construct($sl = null, $tl = null) {
        if (!empty($sl)) {$this->sl = $sl;}
        if (!empty($tl)) {$this->tl = $tl;}
    }

    public function toArray($a = null) {
        if (empty($a))
            return false;

        if (!preg_match("[.]", $a)) {
            $b = trim($a);
        } else {
            $b = explode(".", trim($a));
        }

        $i = 0;

        while ( !empty($b[$i]) ) {

            if (preg_match("[,]", $b[$i])) {

                $c = explode(",", trim($b[$i]));

                for ($j = 0; $j < count($c); $j++) {

                    $d[] = $this->textAndAccuracy(trim($c[$j]));
                }

                $final[] = $d;

                //empty $d for another sentence
                unset($d);
            } else {

                $final[] = $this->textAndAccuracy(trim($b[$i]));
            }
            $i++;
        }

        if (empty($final)) {
            return false;
        }

        return $final;
    }

    public function toString($a = array()) {
        if (empty($a))
            return false;

        foreach ($a as $aa) {
            if (!empty($aa['translated'])) {
                $sentences[] = "<span style='color:hsl(" . $aa['accuracy'] . ", 50%, 50%);'>" . $aa['translated'] . "</span>";
            } else {
                foreach ($aa as $aaa) {
                    if (!empty($aaa['translated'])) {
                        $phrase = "<span style='color:hsl(" . $aaa['accuracy'] . ", 50%, 50%);'>" . $aaa['translated'] . "</span>";
                        $phrases[] = $phrase;
                    }
                }
                $sentences[] = implode(", ", $phrases);
            }
        }
        return implode(". ", $sentences) . ".";
    }

    public function textAndAccuracy($text = null) {
        if(empty($text))
            return false;

        $sl = $this->sl;
        $tl = $this->tl;
        $trans = new GoogleTranslate();
        $forward = $trans->translate($sl, $tl, $text);
        $backward = $trans->translate($tl, $sl, $forward);

        $similarText = new StringCompare($text, $backward, array(
            'remove_html_tags' => false,
            'remove_extra_spaces' => true,
            'remove_punctuation' => true,
            'punctuation_symbols' => Array('.', ',')
        ));
        $return['translated'] = $forward;
        $return['accuracy'] = (int) $similarText->getSimilarityPercentage();

        return $return;
    }
}

$text = $_POST['st'];
$target_lang = $_POST['tl'];
$source_lang = $_POST['sl'];

$trans = new Translate($source_lang, $target_lang);

echo $returnString = $trans->toString($trans->toArray($text));