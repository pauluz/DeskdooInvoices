<?php
/**
 * Project: Deskdoo
 * Author: pZ
 * Date: 12.05.2015
 */

class DeskdooUtils
{
    /* deskdoo ....... */


    /**
     * pZ: getUsernameFromEmail
     * separate function to prepare important string: username
     *
     * @param $email
     *
     * @return string
     */
    public static function getUsernameFromEmail($email)
    {
        return substr($email, 0, strpos($email, '@'));
    }

    /**
     * pZ: slownie
     *
     * @param string $kwota
     *
     * @return string
     */
    public static function slownie($kwota, $currency = null)
    {
        $t_a = array('','sto','dwieście','trzysta','czterysta','pięćset','sześćset','siedemset','osiemset','dziewięćset');
        $t_b = array('','dziesięć','dwadzieścia','trzydzieści','czterdzieści','pięćdziesiąt','sześćdziesiąt','siedemdziesiąt','osiemdziesiąt','dziewięćdziesiąt');
        $t_c = array('','jeden','dwa','trzy','cztery','pięć','sześć','siedem','osiem','dziewięć');
        $t_d = array('dziesięć','jedenaście','dwanaście','trzynaście','czternaście','piętnaście','szesnaście','siedemnaście','osiemnaście','dziewiętnaście');

        // pZ: zmienna $paczki niżej jest ograniczana do 4 - uważać przy powiększaniu tych zmiennych $mnoznik_5
        $mnoznik_4 = array('miliard','miliardy','miliardów');
        $mnoznik_3 = array('milion','miliony','milionów');
        $mnoznik_2 = array('tysiąc','tysiące','tysięcy');
        $mnoznik_1 = array('złoty','złote','złotych');

        if (!is_null($currency) && is_array($currency) && (count($currency) == 3)) {
            // pZ: przykład: $currency = array('PLN', 'PLN', 'PLN'); $currency = array('', '', '');
            $mnoznik_1 = $currency;
        }

        // $kw = '1001';

        $text = '';

        if ($kwota === 0 || $kwota === '0') {
            $text .= 'zero ' . $mnoznik_1[2];

        } elseif ($kwota != '') {

            $ln = strlen($kwota);

            // ścinam do 4 i zaokrąglam do góry
            $paczki = min(ceil($ln/3), 4); // po 3 znaki
            // var_dump($paczki); die();

            // tworze kwote która ma znaków: 3,6,9,.... i zera na początku, np.: '001234'
            $kwota_paczki = str_pad($kwota, $paczki * 3, '0', STR_PAD_LEFT);

            for($i = $paczki; $i > 0; $i--) {

                $mnoznik = ('mnoznik_' . $i);

                $paczka = substr($kwota_paczki, 0, 3);
                $kwota_paczki = substr($kwota_paczki, 3); // odrzucam tą paczkę

                // sprawdzam czy wstawiać 'dziesięć','jedenaście','dwanaście',.... czy normalną liczbę
                $text .= ($paczka{1} == 1)
                    ? $t_a[$paczka{0}].' '.$t_d[$paczka{2}]
                    : $t_a[$paczka{0}].' '.$t_b[$paczka{1}].' '.$t_c[$paczka{2}];

                // pomijam całkiem zerową paczkę (np. tysiące w 5.000.000) ale zostawiam końcówkę
                if (($paczka{0} == 0) && ($paczka{1} == 0) && ($paczka{2} == 0) && ($i != 1) ) {
                    continue;
                } elseif (($paczka{0} == 0) && ($paczka{1} == 0) && ($paczka{2} == 1) ) {
                    $ka = ${$mnoznik}[0];
                } elseif (($paczka{1} != 1) && ($paczka{2} > 1) && ($paczka{2} < 5)) {
                    $ka = ${$mnoznik}[1];
                } else {
                    $ka = ${$mnoznik}[2];
                }

                $text .= ' ' . $ka . ' ';
            }
        }
        $text = trim($text);
        // pZ: zamieniam wiele spacji obok siebie w jedną spację - testuj: "phpunit -c app/ --group StdSlownie"
        $text = preg_replace('!\s+!', ' ', $text);

        return $text;
    }
}
