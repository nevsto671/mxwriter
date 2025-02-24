<?php

/**
 * Developed by Sohel Rana
 * https://github.com/sohelrn
 */

use PHPMailer\PHPMailer\PHPMailer;

class Helper
{
    // check SSL/https connection
    public static function isHTTPS()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    }

    // check Ajax request
    public static function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    // build base url
    public static function baseUrl($dir = true)
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://';
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        $path =  $dir === false ? null : rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
        return $protocol . $host . $path;
    }

    // Slug URL
    public static function slug($string, $limit = null, $delimiter = '-')
    {
        if (empty($string)) return null;
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        //if (function_exists('mb_convert_encoding')) $string = mb_convert_encoding($string, 'UTF-8', mb_list_encodings());
        //$string = preg_replace('~[^-\w]+~', '', $string); // remove unwanted characters
        //$string = preg_replace('/[^\p{L}\p{N}\s]/u', $delimiter, $string); // Remove symbols
        $string = strip_tags($string); // Remove HTML and PHP tags
        if ($limit && function_exists('mb_substr')) $string = mb_substr($string, 0, $limit, 'UTF-8'); // Truncate slug to max. characters
        if (function_exists('mb_strtolower')) $string = mb_strtolower($string, 'UTF-8'); // Make lowercase
        $string = preg_replace('/[\\/\\\"\'`~^*$:,;?#!|.({<%>})\[\]]+/', '', $string); // Remove some charactersss
        $string = preg_replace('!\s+!', $delimiter, $string); // Remove multiple spaces with delimiter
        $string = preg_replace('/[\\/\\\"&|=_-]+/', $delimiter, $string); // Replace some charactersss with delimiter
        $string = trim($string, $delimiter); // Remove delimiter from start and ends
        return $string;
    }

    // Send mail
    public static function sendMail($to, $subject, $body, $from, $replyto = null, $attachment = null)
    {
        // get smtp information
        $results = DB::select('settings', 'name, description', ['status' => 2]);
        $setting = [];
        foreach ($results as $val) {
            $setting[$val['name']] = $val['description'];
        }
        $mail = new PHPMailer(true);
        try {
            if (isset($setting['smtp_connection']) && $setting['smtp_connection'] == 1) {
                $mail->isSMTP();
                $mail->SMTPDebug = 0;
                $mail->SMTPAuth = true;
                $mail->Host = $setting['smtp_hostname'];
                $mail->Username = $setting['smtp_username'];
                $mail->Password = $setting['smtp_password'];
                $mail->Port = $setting['smtp_port'];
                if ($setting['smtp_encryption'] == 'SSL') {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                } else if ($setting['smtp_encryption'] == 'TLS') {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                }
            }
            if (is_array($from)) {
                foreach ($from as $email => $name) {
                    $mail->setFrom($email, $name);
                }
            } else {
                $mail->setFrom($from);
            }
            if (is_array($to)) {
                foreach ($to as $email => $name) {
                    $mail->addAddress($email, $name);
                }
            } else {
                $mail->addAddress($to);
            }
            if (!is_null($replyto)) {
                if (is_array($replyto)) {
                    foreach ($replyto as $email => $name) {
                        $mail->addReplyTo($email, $name);
                    }
                } else {
                    $mail->addReplyTo($replyto);
                }
            }
            if (!is_null($attachment)) {
                if (is_array($attachment)) {
                    foreach ($attachment as $file => $name) {
                        $mail->addAttachment($file, $name);
                    }
                } else {
                    $mail->addAttachment($attachment);
                }
            }
            if (is_array($body)) {
                $mail->msgHTML($body['html']);
            } else {
                $mail->Body = $body;
            }
            $mail->Subject = $subject;
            $mail->XMailer = ' ';
            $mail->send();
            return true;
        } catch (\Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    // encrypt and decrypt text
    public static function crypto($string, $secret_key, $encrypt_decrypt)
    {
        $output = false;
        $secret_iv = '@%|$!';
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $key = hash('sha256', $secret_key);
        if ($encrypt_decrypt) {
            $output = base64_encode(openssl_encrypt($string, "AES-256-CBC", $key, 0, $iv));
        } else {
            $output = openssl_decrypt(base64_decode($string), "AES-256-CBC", $key, 0, $iv);
        }
        return $output;
    }

    // Check for script tags exists
    public static function isScript($str)
    {
        $scripting = '/(%3C|<|&lt;|&#60;)\s*(script|\?)/iU';
        $asciiChars = '/%(0|1)(\d|[a-f])/i';
        // input is an array
        if (is_array($str)) {
            foreach ($str as $val) {
                if (!self::isScript($val)) return false;
            }
            return true;
        } else {
            // decoding input once is ok
            $decoded = rawurldecode($str);
            // check for any script tags or any remaining URL encoded characters
            if (preg_match($scripting, $decoded) || preg_match($asciiChars, $decoded)) {
                return false;
            }
            return true;
        }
    }

    // Detect search engine bots
    public static function isBot()
    {
        $botRegex = '/BotLink|bingbot|AhrefsBot|ahoy|AlkalineBOT|anthill|appie|arale|araneo|AraybOt|ariadne|arks|ATN_Worldwide|Atomz|bbot|Bjaaland|Ukonline|borg\-bot\/0\.9|boxseabot|bspider|calif|christcrawler|CMC\/0\.01|combine|confuzzledbot|CoolBot|cosmos|Internet Cruiser Robot|cusco|cyberspyder|cydralspider|desertrealm, desert realm|digger|DIIbot|grabber|downloadexpress|DragonBot|dwcp|ecollector|ebiness|elfinbot|esculapio|esther|fastcrawler|FDSE|FELIX IDE|ESI|fido|H�m�h�kki|KIT\-Fireball|fouineur|Freecrawl|gammaSpider|gazz|gcreep|golem|googlebot|griffon|Gromit|gulliver|gulper|hambot|havIndex|hotwired|htdig|iajabot|INGRID\/0\.1|Informant|InfoSpiders|inspectorwww|irobot|Iron33|JBot|jcrawler|Teoma|Jeeves|jobo|image\.kapsi\.net|KDD\-Explorer|ko_yappo_robot|label\-grabber|larbin|legs|Linkidator|linkwalker|Lockon|logo_gif_crawler|marvin|mattie|mediafox|MerzScope|NEC\-MeshExplorer|MindCrawler|udmsearch|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|sharp\-info\-agent|WebMechanic|NetScoop|newscan\-online|ObjectsSearch|Occam|Orbsearch\/1\.0|packrat|pageboy|ParaSite|patric|pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|Getterrobo\-Plus|Raven|RHCS|RixBot|roadrunner|Robbie|robi|RoboCrawl|robofox|Scooter|Search\-AU|searchprocess|Senrigan|Shagseeker|sift|SimBot|Site Valet|skymob|SLCrawler\/2\.0|slurp|ESI|snooper|solbot|speedy|spider_monkey|SpiderBot\/1\.0|spiderline|nil|suke|http:\/\/www\.sygol\.com|tach_bw|TechBOT|templeton|titin|topiclink|UdmSearch|urlck|Valkyrie libwww\-perl|verticrawl|Victoria|void\-bot|Voyager|VWbot_K|crawlpaper|wapspider|WebBandit\/1\.0|webcatcher|T\-H\-U\-N\-D\-E\-R\-S\-T\-O\-N\-E|WebMoose|webquest|webreaper|webs|webspider|WebWalker|wget|winona|whowhere|wlm|WOLP|WWWC|none|XGET|Nederland\.zoek|AISearchBot|woriobot|NetSeer|Nutch|YandexBot|YandexMobileBot|SemrushBot|FatBot|MJ12bot|DotBot|PetalBot|AddThis|baiduspider|SeznamBot|mod_pagespeed|CCBot|openstat.ru\/Bot|m2e/i';
        $userAgent = empty($_SERVER['HTTP_USER_AGENT']) ? FALSE : $_SERVER['HTTP_USER_AGENT'];
        $isBot = !$userAgent || preg_match($botRegex, $userAgent);
        return $isBot;
    }

    // Clean and safe text
    public static function input($str)
    {
        if (!$str) return null;
        if (!is_string($str)) return null;
        $str = strip_tags($str); // remove HTML and PHP tags
        $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); // replace html characters
        //$trans = ["<" => "&lt;", ">" => "&gt;"];
        //$str = strtr($str, $trans); // replace chars
        //$str = preg_replace('!\s+!', ' ', $str); // remove whitespace from string
        return $str ? trim($str) : null;
    }

    // Clean output text
    public static function output($str)
    {
        if (!$str) return null;
        $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
        return $str;
    }

    // Split full name
    public static function splitName($fullname, $short = false)
    {
        $fullname = ucwords(trim($fullname));
        if (strpos($fullname, ' ') === false) {
            if ($short) $fullname = mb_substr($fullname, 0, 1);
            return ['firstname' => $fullname, 'lastname' => ''];
        }
        $parts = explode(' ', $fullname);
        $lastname = array_pop($parts);
        $firstname = implode(' ', $parts);
        if ($short) {
            $firstname = mb_substr($firstname, 0, 1);
            $lastname = mb_substr($lastname, 0, 1);
        }
        return ['firstname' => $firstname, 'lastname' => $lastname];
    }

    // Hash tag to link
    public static function hashTag($string, $link = 'hashtag')
    {
        if (!$link) {
            preg_match_all('/(?<!w)#w+/', $string, $hashtag);
            return $hashtag[0];
        }
        return preg_replace('/#(\w+)/', '<a href="' . $link . '/$1" alt="$1">$0</a>', $string);
    }

    // Break new line
    public static function br2nl($str)
    {
        return preg_replace("/\<br\s*\/?\>/i", "\n", $str);
    }

    // Shortens a number and attaches K, M, B, etc. accordingly
    public static function shortenNumber($number, $precision = 1)
    {
        if ($number < 1000) $precision = 0;
        $divisors = [
            pow(1000, 0) => '', // 1000^0 == 1
            pow(1000, 1) => 'K', // Thousand
            pow(1000, 2) => 'M', // Million
            pow(1000, 3) => 'B', // Billion
            pow(1000, 4) => 'T', // Trillion
            pow(1000, 5) => 'Qa', // Quadrillion
            pow(1000, 6) => 'Qi', // Quintillion
        ];
        foreach ($divisors as $divisor => $shorthand) {
            if (abs($number) < ($divisor * 1000)) break;
        }
        return number_format($number / $divisor, $precision) . $shorthand;
    }

    // csv to array
    public static function csvToArray($csv_file)
    {
        $array = array_map('str_getcsv', file($csv_file));
        array_walk($array, function (&$a) use ($array) {
            if (count($array[0]) != count($a)) return null;
            $a = array_combine($array[0], $a);
        });
        array_shift($array);
        return $array;
    }

    // set cron job
    public static function setCronJob($command)
    {
        if (is_callable('shell_exec')) {
            $crontab = shell_exec('crontab -l');
            if (strpos($crontab, $command) === false) {
                $cron = !empty($crontab) ? ($crontab .  PHP_EOL . $command) : $command;
                shell_exec('echo "' . $cron . '" | crontab -');
                $crontab = shell_exec('crontab -l');
                if (strpos($crontab, $command) !== false) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
        return false;
    }

    // add mailchimp contact
    public static function mailchimp($data)
    {
        // get mailchimp information
        $mailchimp_apikey = DB::select('settings', 'description', ['name' => 'mailchimp_apikey'], 'LIMIT 1');
        $mailchimp_audienceid = DB::select('settings', 'description', ['name' => 'mailchimp_audienceid'], 'LIMIT 1');
        $api_key = isset($mailchimp_apikey[0]['description']) ? $mailchimp_apikey[0]['description'] : null;
        $audience_id = isset($mailchimp_audienceid[0]['description']) ? $mailchimp_audienceid[0]['description'] : null;
        if (empty($api_key)) return false;
        $parts = explode('-', $api_key);
        $server = count($parts) === 2 ? $parts[1] : null;
        $api_url = "https://$server.api.mailchimp.com/3.0/lists/$audience_id/members";
        $json_data = json_encode($data);
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_USERPWD, 'apikey:' . $api_key);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $http_code == 200 ? true : false;
    }
}
