<?php

/*
  // Global function:
  $component->on($eventName, 'functionName');

  // Model and method names:
  $component->on($eventName, ['Modelname', 'functionName']);

  // Object and method name:
  $component->on($eventName, [$obj, 'functionName']);

  // Anonymous function:
  $component->on($eventName, function ($event) {
  // Use $event.
  });
 * and open the template in the editor.
 */

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use \common\models\User;

class Util extends Component {

    public $beforeBody;
    public $afterBody;
    public $member;
    public $tab = 1;

    const PUBLISH = 1;
    const UNPUBLISH = 0;

    public function publish() {
        return ['Unpublish', 'Publish'];
    }

    public function publishLabel($int) {
        $array = $this->publish();
        if ($int == 1)
            $class = 'success';
        else
            $class = 'default';

        return '<div class="label label-' . $class . '">' . $array[$int] . '</div>';
    }

    public function say() {
        return 'haiii';
    }

    public function randomString($length = 10, $chars = '', $type = array()) {
        $alphaSmall = 'abcdefghijklmnopqrstuvwxyz';
        $alphaBig = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '0123456789';
        $othr = '`~!@#$%^&*()/*-+_=[{}]|;:",<>.\/?' . "'";
        $characters = "";
        $string = '';
        isset($type['alphaSmall']) ? $type['alphaSmall'] : $type['alphaSmall'] = true;
        isset($type['alphaBig']) ? $type['alphaBig'] : $type['alphaBig'] = true;
        isset($type['num']) ? $type['num'] : $type['num'] = true;
        isset($type['othr']) ? $type['othr'] : $type['othr'] = false;
        isset($type['duplicate']) ? $type['duplicate'] : $type['duplicate'] = true;
        if (strlen(trim($chars)) == 0) {
            $type['alphaSmall'] ? $characters.=$alphaSmall : $characters = $characters;
            $type['alphaBig'] ? $characters.=$alphaBig : $characters = $characters;
            $type['num'] ? $characters.=$num : $characters = $characters;
            $type['othr'] ? $characters.=$othr : $characters = $characters;
        } else
            $characters = str_replace(' ', '', $chars);
        if ($type['duplicate'])
            for (; $length > 0 && strlen($characters) > 0; $length--) {
                $ctr = mt_rand(0, (strlen($characters)) - 1);
                $string.=$characters[$ctr];
            } else
            $string = substr(str_shuffle($characters), 0, $length);
        return $string;
    }

    public function randomCode() {
        $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $return .= $tokens[rand(0, 35)];
            }
            if ($i < 2) {
                $return .= '';
            }
        }
        return $return;
    }

    public static function curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function dom() {
        $url = 'http://www.gandhool.com';
        $result = self::curl($url);
        $dom = new DomDocument();
        $dom->load($result);
        $classname = 'moviefilm';
        $finder = new DomXPath($dom);
        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
        $tmp_dom = new DOMDocument();
        foreach ($nodes as $node) {
            $tmp_dom->appendChild($tmp_dom->importNode($node, true));
        }
        $innerHTML.=trim($tmp_dom->saveHTML());
        return $innerHTML;
    }

    public function crawler($url) {
        $return = [];
        $last = 50;
        $html = DOM::file_get_html($url);
        foreach ($html->find('div[class=moviefilm]') as $element) {
            $return[] = $element->children(1)->children(0)->getAttribute('href');
        }
        for ($i = 2; $i <= $last; $i++) {
            $urlx = $url . '/page/' . $i;
            $html = DOM::file_get_html($urlx);
            foreach ($html->find('div[class=moviefilm]') as $element) {
                $return[] = $element->children(1)->children(0)->getAttribute('href');
            }
        }

        return $return;
    }

    public static function selectCurrency($id = NULL) {
        $return = 'USD';

        switch ($id) {
            case 1: $return = 'USD';
                break;
            case 2: $return = 'EUR';
                break;
            default : $return = 'USD';
        }
        return $return;
    }

}
