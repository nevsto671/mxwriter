<?php

namespace Controller\Admin;

use DB;
use Helper;
use Gateway;
use Uploader;
use Controller\AdminController;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Settings extends AdminController
{
    public function index()
    {
        switch (isset($_GET['tab']) ? strtolower($_GET['tab']) : null) {
            default:
            case ("general"):
                $tab = "general";
                $image_writeable = is_writeable(DIR . '/images') ? true : false;
                $date_format = ['d/m/Y', 'd-m-Y', 'd.m.Y', 'Y/m/d', 'Y-m-d', 'Y.m.d', 'm/d/Y', 'm-d-Y', 'm.d.Y', 'Y/d/m', 'Y-d-m', 'Y.d.m', 'M d, Y', 'd M, Y', 'F d, Y', 'd F, Y'];
                $time_format = ['g:i a', 'g:i A', 'H:i'];
                $time_zone = ['Pacific/Midway' => '(GMT-11:00) Midway Island, Samoa', 'America/Adak' => '(GMT-10:00) Hawaii-Aleutian', 'Etc/GMT+10' => '(GMT-10:00) Hawaii', 'Pacific/Marquesas' => '(GMT-09:30) Marquesas Islands', 'Pacific/Gambier' => '(GMT-09:00) Gambier Islands', 'America/Anchorage' => '(GMT-09:00) Alaska', 'America/Ensenada' => '(GMT-08:00) Tijuana, Baja California', 'Etc/GMT+8' => '(GMT-08:00) Pitcairn Islands', 'America/Los_Angeles' => '(GMT-08:00) Pacific Time (US & Canada)', 'America/Denver' => '(GMT-07:00) Mountain Time (US & Canada)', 'America/Chihuahua' => '(GMT-07:00) Chihuahua, La Paz, Mazatlan', 'America/Dawson_Creek' => '(GMT-07:00) Arizona', 'America/Belize' => '(GMT-06:00) Saskatchewan, Central America', 'America/Cancun' => '(GMT-06:00) Guadalajara, Mexico City, Monterrey', 'Chile/EasterIsland' => '(GMT-06:00) Easter Island', 'America/Chicago' => '(GMT-06:00) Central Time (US & Canada)', 'America/New_York' => '(GMT-05:00) Eastern Time (US & Canada)', 'America/Havana' => '(GMT-05:00) Cuba', 'America/Bogota' => '(GMT-05:00) Bogota, Lima, Quito, Rio Branco', 'America/Caracas' => '(GMT-04:30) Caracas', 'America/Santiago' => '(GMT-04:00) Santiago', 'America/La_Paz' => '(GMT-04:00) La Paz', 'Atlantic/Stanley' => '(GMT-04:00) Faukland Islands', 'America/Campo_Grande' => '(GMT-04:00) Brazil', 'America/Goose_Bay' => '(GMT-04:00) Atlantic Time (Goose Bay)', 'America/Glace_Bay' => '(GMT-04:00) Atlantic Time (Canada)', 'America/St_Johns' => '(GMT-03:30) Newfoundland', 'America/Araguaina' => '(GMT-03:00) UTC-3', 'America/Montevideo' => '(GMT-03:00) Montevideo', 'America/Miquelon' => '(GMT-03:00) Miquelon, St. Pierre', 'America/Godthab' => '(GMT-03:00) Greenland', 'America/Argentina/Buenos_Aires' => '(GMT-03:00) Buenos Aires', 'America/Sao_Paulo' => '(GMT-03:00) Brasilia', 'America/Noronha' => '(GMT-02:00) Mid-Atlantic', 'Atlantic/Cape_Verde' => '(GMT-01:00) Cape Verde Is.', 'Atlantic/Azores' => '(GMT-01:00) Azores', 'Europe/Belfast' => '(GMT) Greenwich Mean Time : Belfast', 'Europe/Dublin' => '(GMT) Greenwich Mean Time : Dublin', 'Europe/Lisbon' => '(GMT) Greenwich Mean Time : Lisbon', 'Europe/London' => '(GMT) Greenwich Mean Time : London', 'Africa/Abidjan' => '(GMT) Monrovia, Reykjavik', 'Europe/Amsterdam' => '(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Vienna', 'Europe/Belgrade' => '(GMT+01:00) Belgrade, Bratislava, Budapest, Prague', 'Europe/Brussels' => '(GMT+01:00) Brussels, Copenhagen, Madrid, Paris', 'Africa/Algiers' => '(GMT+01:00) West Central Africa', 'Africa/Windhoek' => '(GMT+01:00) Windhoek', 'Asia/Beirut' => '(GMT+02:00) Beirut', 'Africa/Cairo' => '(GMT+02:00) Cairo', 'Asia/Gaza' => '(GMT+02:00) Gaza', 'Africa/Blantyre' => '(GMT+02:00) Harare, Pretoria', 'Asia/Jerusalem' => '(GMT+02:00) Jerusalem', 'Europe/Helsinki' => '(GMT+02:00) Helsinki', 'Europe/Athens' => '(GMT+02:00) Athens', 'Asia/Damascus' => '(GMT+02:00) Syria', 'Europe/Moscow' => '(GMT+03:00) Moscow, St. Petersburg, Volgograd', 'Africa/Addis_Ababa' => '(GMT+03:00) Nairobi', 'Asia/Tehran' => '(GMT+03:30) Tehran', 'Asia/Dubai' => '(GMT+04:00) Abu Dhabi, Muscat', 'Asia/Yerevan' => '(GMT+04:00) Yerevan', 'Asia/Kabul' => '(GMT+04:30) Kabul', 'Asia/Yekaterinburg' => '(GMT+05:00) Ekaterinburg', 'Asia/Tashkent' => '(GMT+05:00) Tashkent', 'Asia/Kolkata' => '(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi', 'Asia/Katmandu' => '(GMT+05:45) Kathmandu', 'Asia/Dhaka' => '(GMT+06:00) Astana, Dhaka', 'Asia/Novosibirsk' => '(GMT+06:00) Novosibirsk', 'Asia/Rangoon' => '(GMT+06:30) Yangon (Rangoon)', 'Asia/Bangkok' => '(GMT+07:00) Bangkok, Hanoi, Jakarta', 'Asia/Krasnoyarsk' => '(GMT+07:00) Krasnoyarsk', 'Asia/Hong_Kong' => '(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi', 'Asia/Irkutsk' => '(GMT+08:00) Irkutsk, Ulaan Bataar', 'Australia/Perth' => '(GMT+08:00) Perth', 'Australia/Eucla' => '(GMT+08:45) Eucla', 'Asia/Tokyo' => '(GMT+09:00) Osaka, Sapporo, Tokyo', 'Asia/Seoul' => '(GMT+09:00) Seoul', 'Asia/Yakutsk' => '(GMT+09:00) Yakutsk', 'Australia/Adelaide' => '(GMT+09:30) Adelaide', 'Australia/Darwin' => '(GMT+09:30) Darwin', 'Australia/Brisbane' => '(GMT+10:00) Brisbane', 'Australia/Hobart' => '(GMT+10:00) Hobart', 'Asia/Vladivostok' => '(GMT+10:00) Vladivostok', 'Australia/Lord_Howe' => '(GMT+10:30) Lord Howe Island', 'Etc/GMT-11' => '(GMT+11:00) Solomon Is., New Caledonia', 'Asia/Magadan' => '(GMT+11:00) Magadan', 'Pacific/Norfolk' => '(GMT+11:30) Norfolk Island', 'Asia/Anadyr' => '(GMT+12:00) Anadyr, Kamchatka', 'Pacific/Auckland' => '(GMT+12:00) Auckland, Wellington', 'Etc/GMT-12' => '(GMT+12:00) Fiji, Kamchatka, Marshall Is.', 'Pacific/Chatham' => '(GMT+12:45) Chatham Islands', 'Pacific/Tongatapu' => '(GMT+13:00) Nukuʻalofa', 'Pacific/Kiritimati' => '(GMT+14:00) Kiritimati'];
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $data['site_name'] = !empty($_POST['site_name']) ? $_POST['site_name'] : null;
                    $data['site_title'] = !empty($_POST['site_title']) ? $_POST['site_title'] : null;
                    $data['site_description'] = !empty($_POST['site_description']) ? $_POST['site_description'] : null;
                    $data['language'] = isset($_POST['language']) ? $_POST['language'] : 'English';
                    $data['direction'] = isset($_POST['direction']) ? $_POST['direction'] : 'ltr';
                    $data['theme_style'] = isset($_POST['theme_style']) ? $_POST['theme_style'] : 'light';
                    $data['phone_code'] = !empty($_POST['phone_code']) ? $_POST['phone_code'] : '1';
                    $data['date_format'] = !empty($_POST['date_format']) && in_array($_POST['date_format'], $date_format) ? $_POST['date_format'] : 'd/m/y';
                    $data['time_format'] = !empty($_POST['time_format']) && in_array($_POST['time_format'], $time_format) ? $_POST['time_format'] : 'g:i a';
                    $data['time_zone'] = !empty($_POST['time_zone']) && array_key_exists($_POST['time_zone'], $time_zone) ? $_POST['time_zone'] : 'UTC';
                    $data['copyright'] = !empty($_POST['copyright']) ? $_POST['copyright'] : null;
                    $data['footer_text'] = !empty($_POST['footer_text']) ? $_POST['footer_text'] : null;
                    $data['site_address'] = !empty($_POST['site_address']) ? $_POST['site_address'] : null;
                    if (strlen($data['site_name']) < 3) $this->redirect("admin/settings?tab=$tab", "Something went wrong, try again.", "error");
                    if (!$this->license()) $this->redirect("admin/settings");
                    foreach ($data as $key => $val) {
                        DB::update('settings', ['description' => $val], ['name' => $key], 'LIMIT 1');
                    }
                    $this->redirect("admin/settings?tab=$tab", "Your details were changed successfully.");
                }
                break;
            case ("finance"):
                $tab = "finance";
                $currency = ['AED' => ['title' => 'United Arab Emirates Dirham', 'name' => 'dirham', 'code' => 'AED', 'symbol' => 'د.إ', 'entity' => '&#1583;.&#1573;', 'discern' => '', 'ltr' => 'false',], 'AFN' => ['title' => 'Afghan Afghani', 'name' => 'afghani', 'code' => 'AFN', 'symbol' => '؋', 'entity' => '&#x60B;', 'discern' => '', 'ltr' => 'false',], 'ALL' => ['title' => 'Lek', 'name' => 'lek', 'code' => 'ALL', 'symbol' => 'L', 'entity' => '&#x4C;', 'discern' => '', 'ltr' => 'true',], 'AMD' => ['title' => 'Armenian Dram', 'name' => 'dram', 'code' => 'AMD', 'symbol' => '֏', 'entity' => '&#x58F;', 'discern' => '', 'ltr' => 'true',], 'ANG' => ['title' => 'Netherlands Antillean Guilder', 'name' => 'guilder', 'code' => 'ANG', 'symbol' => 'ƒ', 'entity' => '&#x192;', 'discern' => '', 'ltr' => 'true',], 'AOA' => ['title' => 'Angolan Kwanza', 'name' => 'kwanza', 'code' => 'AOA', 'symbol' => 'Kz', 'entity' => '&#x4B;&#x7A;', 'discern' => '', 'ltr' => 'true',], 'ARS' => ['title' => 'Argentine Peso', 'name' => 'peso', 'code' => 'ARS', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => '', 'ltr' => 'true',], 'AUD' => ['title' => 'Australian Dollar', 'name' => 'dollar', 'code' => 'AUD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'AU$', 'ltr' => 'true',], 'AWG' => ['title' => 'Aruban Florin', 'name' => 'florin', 'code' => 'AWG', 'symbol' => 'ƒ', 'entity' => '&#x192;', 'discern' => 'Afl.', 'ltr' => 'true',], 'AZN' => ['title' => 'Azerbaijani Manat', 'name' => 'manat', 'code' => 'AZN', 'symbol' => '₼', 'entity' => '&#x20BC;', 'discern' => '', 'ltr' => 'true',], 'BAM' => ['title' => 'Bosnia and Herzegovina Convertible Mark', 'name' => 'convertible mark', 'code' => 'BAM', 'symbol' => 'КМ', 'entity' => '&#x41A;&#x41C;', 'discern' => '', 'ltr' => 'true',], 'BBD' => ['title' => 'Barbadian Dollar', 'name' => 'dollar', 'code' => 'BBD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'Bds$', 'ltr' => 'true',], 'BDT' => ['title' => 'Bangladeshi Taka', 'name' => 'taka', 'code' => 'BDT', 'symbol' => '৳', 'entity' => '&#x9F3;', 'discern' => 'Tk ', 'ltr' => 'true',], 'BGN' => ['title' => 'Bulgarian Lev', 'name' => 'lev', 'code' => 'BGN', 'symbol' => 'лв.', 'entity' => '&#x43B;&#x432;&#x2E;', 'discern' => '', 'ltr' => 'true',], 'BHD' => ['title' => 'Bahraini Dinar', 'name' => 'dinar', 'code' => 'BHD', 'symbol' => '.د.ب', 'entity' => '&#x2E;&#x62F;&#x2E;&#x628;', 'discern' => 'BD', 'ltr' => 'true',], 'BIF' => ['title' => 'Burundian Franc', 'name' => 'franc', 'code' => 'BIF', 'symbol' => 'FBu', 'entity' => '&#x46;&#x42;&#x75;', 'discern' => '', 'ltr' => 'true',], 'BMD' => ['title' => 'Bermudian Dollar', 'name' => 'dollar', 'code' => 'BMD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'BD$', 'ltr' => 'true',], 'BND' => ['title' => 'Brunei Dollar', 'name' => 'dollar', 'code' => 'BND', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'B$', 'ltr' => 'true',], 'BOB' => ['title' => 'Bolivian Boliviano', 'name' => 'boliviano', 'code' => 'BOB', 'symbol' => 'Bs', 'entity' => '&#x42;&#x73;', 'discern' => 'B$', 'ltr' => 'true',], 'BOV' => ['title' => 'Mvdol', 'name' => 'mvdol', 'code' => 'BOV', 'symbol' => '-', 'entity' => '&#x2D;', 'discern' => '', 'ltr' => 'true',], 'BRL' => ['title' => 'Brazilian Real', 'name' => 'real', 'code' => 'BRL', 'symbol' => 'R$', 'entity' => '&#x52;&#x24;', 'discern' => '', 'ltr' => 'true',], 'BSD' => ['title' => 'Bahamian Dollar', 'name' => 'dollar', 'code' => 'BSD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'B$', 'ltr' => 'true',], 'BTN' => ['title' => 'Ngultrum', 'name' => 'ngultrum', 'code' => 'BTN', 'symbol' => 'Nu.', 'entity' => '&#x4E;&#x75;&#x2E;', 'discern' => '', 'ltr' => 'true',], 'BWP' => ['title' => 'Pula', 'name' => 'pula', 'code' => 'BWP', 'symbol' => 'P', 'entity' => '&#x50;', 'discern' => '', 'ltr' => 'true',], 'BYN' => ['title' => 'Belarusian Ruble', 'name' => 'ruble', 'code' => 'BYN', 'symbol' => 'Br', 'entity' => '&#x42;&#x72;', 'discern' => '', 'ltr' => 'true',], 'BZD' => ['title' => 'Belize Dollar', 'name' => 'dollar', 'code' => 'BZD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'BZ$', 'ltr' => 'true',], 'CAD' => ['title' => 'Canadian Dollar', 'name' => 'dollar', 'code' => 'CAD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'CA$', 'ltr' => 'true',], 'CDF' => ['title' => 'Congolese Franc', 'name' => 'franc', 'code' => 'CDF', 'symbol' => 'FC', 'entity' => '&#x46;&#x43;', 'discern' => 'CF', 'ltr' => 'true',], 'CHF' => ['title' => 'Swiss Franc', 'name' => 'franc', 'code' => 'CHF', 'symbol' => 'Fr', 'entity' => '&#x46;&#x72;', 'discern' => 'SFr', 'ltr' => 'true',], 'CLF' => ['title' => 'Unidad de Fomento', 'name' => 'Unidad de Fomento', 'code' => 'CLF', 'symbol' => 'UF', 'entity' => '&#x55;&#x46;', 'discern' => '', 'ltr' => 'true',], 'CLP' => ['title' => 'Chilean Peso', 'name' => 'peso', 'code' => 'CLP', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'CLP$', 'ltr' => 'true',], 'CNY' => ['title' => 'Yuan Renminbi', 'name' => 'yuan', 'code' => 'CNY', 'symbol' => '¥', 'entity' => '&#xA5;', 'discern' => '', 'ltr' => 'true',], 'COP' => ['title' => 'Colombian Peso', 'name' => 'peso', 'code' => 'COP', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'COP$', 'ltr' => 'true',], 'CRC' => ['title' => 'Costa Rican Colon', 'name' => 'colon', 'code' => 'CRC', 'symbol' => '₡', 'entity' => '&#x20A1;', 'discern' => '', 'ltr' => 'true',], 'CUC' => ['title' => 'Peso Convertible', 'name' => 'peso', 'code' => 'CUC', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'CUC$', 'ltr' => 'true',], 'CUP' => ['title' => 'Cuban Peso', 'name' => 'peso', 'code' => 'CUP', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => '$MN', 'ltr' => 'true',], 'CVE' => ['title' => 'Cabo Verde Escudo', 'name' => 'escudo', 'code' => 'CVE', 'symbol' => 'Esc', 'entity' => '&#x45;&#x73;&#x63;', 'discern' => '', 'ltr' => 'true',], 'CZK' => ['title' => 'Czech Koruna', 'name' => 'koruna', 'code' => 'CZK', 'symbol' => 'Kč', 'entity' => '&#x4B;&#x10D;', 'discern' => '', 'ltr' => 'true',], 'DJF' => ['title' => 'Djibouti Franc', 'name' => 'franc', 'code' => 'DJF', 'symbol' => 'Fdj', 'entity' => '&#x46;&#x64;&#x6A;', 'discern' => '', 'ltr' => 'true',], 'DKK' => ['title' => 'Danish Krone', 'name' => 'krone', 'code' => 'DKK', 'symbol' => 'kr', 'entity' => '&#x6B;&#x72;', 'discern' => 'DKK', 'ltr' => 'true',], 'DOP' => ['title' => 'Dominican Peso', 'name' => 'peso', 'code' => 'DOP', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'RD$', 'ltr' => 'true',], 'DZD' => ['title' => 'Algerian Dinar', 'name' => 'dinar', 'code' => 'DZD', 'symbol' => 'دج', 'entity' => '&#x62F;&#x62C;', 'discern' => 'DA', 'ltr' => 'false',], 'EGP' => ['title' => 'Egyptian Pound', 'name' => 'pound', 'code' => 'EGP', 'symbol' => '£', 'entity' => '&#xA3;', 'discern' => '£E', 'ltr' => 'true',], 'ETB' => ['title' => 'Ethiopian Birr', 'name' => 'birr', 'code' => 'ETB', 'symbol' => 'ብር', 'entity' => '&#x1265;&#x122D;', 'discern' => 'Br', 'ltr' => 'true',], 'ERN' => ['title' => 'Nakfa', 'name' => 'nakfa', 'code' => 'ERN', 'symbol' => 'Nkf', 'entity' => '&#x4E;&#x6B;&#x66;', 'discern' => '', 'ltr' => 'true',], 'EUR' => ['title' => 'Euro', 'name' => 'euro', 'code' => 'EUR', 'symbol' => '€', 'entity' => '&#x20AC;', 'discern' => '', 'ltr' => 'true',], 'FJD' => ['title' => 'Fiji Dollar', 'name' => 'dollar', 'code' => 'FJD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'FJ$', 'ltr' => 'true',], 'FKP' => ['title' => 'Falkland Islands Pound', 'name' => 'pound', 'code' => 'FKP', 'symbol' => '£', 'entity' => '&#xA3;', 'discern' => 'FK£', 'ltr' => 'true',], 'GBP' => ['title' => 'Pound sterling', 'name' => 'pound', 'code' => 'GBP', 'symbol' => '£', 'entity' => '&#xA3;', 'discern' => '', 'ltr' => 'true',], 'GEL' => ['title' => 'Lari', 'name' => 'lari', 'code' => 'GEL', 'symbol' => '₾', 'entity' => '&#x20BE;', 'discern' => '', 'ltr' => 'true',], 'GHS' => ['title' => 'Ghana Cedi', 'name' => 'cedi', 'code' => 'GHS', 'symbol' => '₵', 'entity' => '&#x20B5;', 'discern' => 'GH¢', 'ltr' => 'true',], 'GIP' => ['title' => 'Gibraltar Pound', 'name' => 'pound', 'code' => 'GIP', 'symbol' => '£', 'entity' => '&#xA3;', 'discern' => '', 'ltr' => 'true',], 'GMD' => ['title' => 'Dalasi', 'name' => 'dalasi', 'code' => 'GMD', 'symbol' => 'D', 'entity' => '&#x44;', 'discern' => '', 'ltr' => 'true',], 'GNF' => ['title' => 'Guinean Franc', 'name' => 'franc', 'code' => 'GNF', 'symbol' => 'FG', 'entity' => '&#x46;&#x47;', 'discern' => 'GFr', 'ltr' => 'true',], 'GTQ' => ['title' => 'Quetzal', 'name' => 'quetzal', 'code' => 'GTQ', 'symbol' => 'Q', 'entity' => '&#x51;', 'discern' => '', 'ltr' => 'true',], 'GYD' => ['title' => 'Guyana Dollar', 'name' => 'dollar', 'code' => 'GYD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'GY$', 'ltr' => 'true',], 'HKD' => ['title' => 'Hong Kong Dollar', 'name' => 'dollar', 'code' => 'HKD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'HK$', 'ltr' => 'true',], 'HNL' => ['title' => 'Lempira', 'name' => 'lempira', 'code' => 'HNL', 'symbol' => 'L', 'entity' => '&#x4C;', 'discern' => '', 'ltr' => 'true',], 'HRK' => ['title' => 'Kuna', 'name' => 'kuna', 'code' => 'HRK', 'symbol' => 'kn', 'entity' => '&#x6B;&#x6E;', 'discern' => '', 'ltr' => 'true',], 'HTG' => ['title' => 'Gourde', 'name' => 'gourde', 'code' => 'HTG', 'symbol' => 'G', 'entity' => '&#x47;', 'discern' => '', 'ltr' => 'true',], 'HUF' => ['title' => 'Forint', 'name' => 'forint', 'code' => 'HUF', 'symbol' => 'Ft', 'entity' => '&#x46;&#x74;', 'discern' => '', 'ltr' => 'true',], 'IDR' => ['title' => 'Rupiah', 'name' => 'rupiah', 'code' => 'IDR', 'symbol' => 'Rp', 'entity' => '&#x52;&#x70;', 'discern' => '', 'ltr' => 'true',], 'ILS' => ['title' => 'New Israeli Sheqel', 'name' => 'sheqel', 'code' => 'ILS', 'symbol' => '₪', 'entity' => '&#x20AA;', 'discern' => 'NIS', 'ltr' => 'true',], 'INR' => ['title' => 'Indian Rupee', 'name' => 'rupee', 'code' => 'INR', 'symbol' => '₹', 'entity' => '&#x20B9;', 'discern' => '', 'ltr' => 'true',], 'IQD' => ['title' => 'Iraqi Dinar', 'name' => 'dinar', 'code' => 'IQD', 'symbol' => 'د.ع', 'entity' => '&#x62F;&#x2E;&#x639;', 'discern' => '', 'ltr' => 'false',], 'IRR' => ['title' => 'Iranian Rial', 'name' => 'rial', 'code' => 'IRR', 'symbol' => '﷼', 'entity' => '&#xFDFC;', 'discern' => '', 'ltr' => 'false',], 'ISK' => ['title' => 'Iceland Krona', 'name' => 'krona', 'code' => 'ISK', 'symbol' => 'kr', 'entity' => '&#x6B;&#x72;', 'discern' => 'ISK', 'ltr' => 'false',], 'JEP' => ['title' => 'Jersey Pound', 'name' => 'pound', 'code' => 'JEP', 'symbol' => '£', 'entity' => '&#xA3;', 'discern' => 'JEP', 'ltr' => 'true',], 'JMD' => ['title' => 'Jamaican Dollar', 'name' => 'dollar', 'code' => 'JMD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'J$', 'ltr' => 'true',], 'JOD' => ['title' => 'Jordanian Dinar', 'name' => 'dinar', 'code' => 'JOD', 'symbol' => 'د.أ', 'entity' => '&#x62F;&#x2E;&#x623;', 'discern' => '', 'ltr' => 'false',], 'JPY' => ['title' => 'Yen', 'name' => 'yen', 'code' => 'JPY', 'symbol' => '¥', 'entity' => '&#xA5;', 'discern' => 'JP¥', 'ltr' => 'true',], 'KES' => ['title' => 'Kenyan Shilling', 'name' => 'shilling', 'code' => 'KES', 'symbol' => 'KSh', 'entity' => '&#x4B;&#x53;&#x68;', 'discern' => '', 'ltr' => 'true',], 'KGS' => ['title' => 'Som', 'name' => 'som', 'code' => 'KGS', 'symbol' => 'сом', 'entity' => '&#x441;&#x43E;&#x43C;', 'discern' => '', 'ltr' => 'true',], 'KHR' => ['title' => 'Riel', 'name' => 'riel', 'code' => 'KHR', 'symbol' => '៛', 'entity' => '&#x17DB;', 'discern' => '', 'ltr' => 'true',], 'KMF' => ['title' => 'Comorian Franc', 'name' => 'franc', 'code' => 'KMF', 'symbol' => 'CF', 'entity' => '&#x43;&#x46;', 'discern' => '', 'ltr' => 'true',], 'KPW' => ['title' => 'North Korean Won', 'name' => 'won', 'code' => 'KPW', 'symbol' => '₩', 'entity' => '&#x20A9;', 'discern' => '', 'ltr' => 'true',], 'KRW' => ['title' => 'Won', 'name' => 'won', 'code' => 'KRW', 'symbol' => '₩', 'entity' => '&#x20A9;', 'discern' => '', 'ltr' => 'true',], 'KWD' => ['title' => 'Kuwaiti Dinar', 'name' => 'dinar', 'code' => 'KWD', 'symbol' => 'د.ك', 'entity' => '&#x62F;&#x2E;&#x643;', 'discern' => '', 'ltr' => 'false',], 'KYD' => ['title' => 'Cayman Islands Dollar', 'name' => 'dollar', 'code' => 'KYD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'CI$', 'ltr' => 'true',], 'KZT' => ['title' => 'Tenge', 'name' => 'tenge', 'code' => 'KZT', 'symbol' => '₸', 'entity' => '&#x20B8;', 'discern' => '', 'ltr' => 'true',], 'LAK' => ['title' => 'Lao Kip', 'name' => 'kip', 'code' => 'LAK', 'symbol' => '₭', 'entity' => '&#x20AD;', 'discern' => '₭N', 'ltr' => 'true',], 'LBP' => ['title' => 'Lebanese Pound', 'name' => 'pound', 'code' => 'LBP', 'symbol' => 'ل.ل.', 'entity' => '&#x644;&#x2E;&#x644;&#x2E;', 'discern' => 'LL', 'ltr' => 'false',], 'LKR' => ['title' => 'Sri Lanka Rupee', 'name' => 'rupee', 'code' => 'LKR', 'symbol' => '₨', 'entity' => '&#x20A8;', 'discern' => 'LKR', 'ltr' => 'true',], 'LRD' => ['title' => 'Liberian Dollar', 'name' => 'dollar', 'code' => 'LRD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'L$', 'ltr' => 'true',], 'LSL' => ['title' => 'Loti', 'name' => 'loti', 'code' => 'LSL', 'symbol' => 'L', 'entity' => '&#x4C;', 'discern' => '', 'ltr' => 'true',], 'LYD' => ['title' => 'Libyan Dinar', 'name' => 'dinar', 'code' => 'LYD', 'symbol' => '.د', 'entity' => '&#x2E;&#x62F;', 'discern' => 'LD', 'ltr' => 'false',], 'MAD' => ['title' => 'Moroccan Dirham', 'name' => 'dirham', 'code' => 'MAD', 'symbol' => 'د.م.', 'entity' => '&#x62F;&#x2E;&#x645;&#x2E;', 'discern' => 'DH', 'ltr' => 'false',], 'MDL' => ['title' => 'Moldovan Leu', 'name' => 'leu', 'code' => 'MDL', 'symbol' => 'L', 'entity' => '&#x4C;', 'discern' => '', 'ltr' => 'true',], 'MGA' => ['title' => 'Malagasy Ariary', 'name' => 'ariary', 'code' => 'MGA', 'symbol' => 'Ar', 'entity' => '&#x41;&#x72;', 'discern' => '', 'ltr' => 'true',], 'MKD' => ['title' => 'Denar', 'name' => 'denar', 'code' => 'MKD', 'symbol' => 'ден', 'entity' => '&#x434;&#x435;&#x43D;', 'discern' => '', 'ltr' => 'true',], 'MMK' => ['title' => 'Kyat', 'name' => 'kyat', 'code' => 'MMK', 'symbol' => 'K', 'entity' => '&#x4B;', 'discern' => '', 'ltr' => 'true',], 'MNT' => ['title' => 'Tugrik', 'name' => 'tugrik', 'code' => 'MNT', 'symbol' => '₮', 'entity' => '&#x20AE;', 'discern' => '', 'ltr' => 'true',], 'MOP' => ['title' => 'Pataca', 'name' => 'pataca', 'code' => 'MOP', 'symbol' => 'MOP$', 'entity' => '&#x4D;&#x4F;&#x50;&#x24;', 'discern' => '', 'ltr' => 'true',], 'MRU' => ['title' => 'Ouguiya', 'name' => 'ouguiya', 'code' => 'MRU', 'symbol' => 'UM', 'entity' => '&#x55;&#x4D;', 'discern' => '', 'ltr' => 'true',], 'MUR' => ['title' => 'Mauritius Rupee', 'name' => 'rupee', 'code' => 'MUR', 'symbol' => '₨', 'entity' => '&#x20A8;', 'discern' => '', 'ltr' => 'true',], 'MVR' => ['title' => 'Rufiyaa', 'name' => 'rufiyaa', 'code' => 'MVR', 'symbol' => 'Rf.', 'entity' => '&#x52;&#x66;&#x2E;', 'discern' => 'MRf', 'ltr' => 'true',], 'MWK' => ['title' => 'Malawi Kwacha', 'name' => 'kwacha', 'code' => 'MWK', 'symbol' => 'K', 'entity' => '&#x4B;', 'discern' => '', 'ltr' => 'true',], 'MXN' => ['title' => 'Mexican Peso', 'name' => 'peso', 'code' => 'MXN', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'MX$', 'ltr' => 'true',], 'MXV' => ['title' => 'Mexican Unidad de Inversion (UDI)', 'name' => 'udi', 'code' => 'MXV', 'symbol' => '-', 'entity' => '&#x2D;', 'discern' => '', 'ltr' => 'true',], 'MYR' => ['title' => 'Malaysian Ringgit', 'name' => 'ringgit', 'code' => 'MYR', 'symbol' => 'RM', 'entity' => '&#x52;&#x4D;', 'discern' => '', 'ltr' => 'true',], 'MZN' => ['title' => 'Mozambique Metical', 'name' => 'metical', 'code' => 'MZN', 'symbol' => 'MT', 'entity' => '&#x4D;&#x54;', 'discern' => 'MTn', 'ltr' => 'true',], 'NAD' => ['title' => 'Namibia Dollar', 'name' => 'dollar', 'code' => 'NAD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'N$', 'ltr' => 'true',], 'NGN' => ['title' => 'Naira', 'name' => 'naira', 'code' => 'NGN', 'symbol' => '₦', 'entity' => '&#x20A6;', 'discern' => '', 'ltr' => 'true',], 'NIO' => ['title' => 'Cordoba Oro', 'name' => 'cordoba', 'code' => 'NIO', 'symbol' => 'C$', 'entity' => '&#x43;&#x24;', 'discern' => '', 'ltr' => 'true',], 'NOK' => ['title' => 'Norwegian Krone', 'name' => 'krone', 'code' => 'NOK', 'symbol' => 'kr', 'entity' => '&#x6B;&#x72;', 'discern' => '', 'ltr' => 'true',], 'NPR' => ['title' => 'Nepalese Rupee', 'name' => 'rupee', 'code' => 'NPR', 'symbol' => 'रु', 'entity' => '&#x930;&#x941;', 'discern' => '₨', 'ltr' => 'true',], 'NZD' => ['title' => 'New Zealand Dollar', 'name' => 'dollar', 'code' => 'NZD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'NZ$', 'ltr' => 'true',], 'OMR' => ['title' => 'Rial Omani', 'name' => 'rial', 'code' => 'OMR', 'symbol' => 'ر.ع.', 'entity' => '&#x631;&#x2E;&#x639;&#x2E;', 'discern' => 'R.O.', 'ltr' => 'false',], 'PAB' => ['title' => 'Balboa', 'name' => 'balboa', 'code' => 'PAB', 'symbol' => 'B/.', 'entity' => '&#x42;&#x2F;&#x2E;', 'discern' => '', 'ltr' => 'true',], 'PEN' => ['title' => 'Sol', 'name' => 'sol', 'code' => 'PEN', 'symbol' => 'S/', 'entity' => '&#x53;&#x2F;', 'discern' => '', 'ltr' => 'true',], 'PGK' => ['title' => 'Kina', 'name' => 'kina', 'code' => 'PKG', 'symbol' => 'K', 'entity' => '&#x4B;', 'discern' => '', 'ltr' => 'true',], 'PHP' => ['title' => 'Philippine Peso', 'name' => 'peso', 'code' => 'PHP', 'symbol' => '₱', 'entity' => '&#x20B1;', 'discern' => '', 'ltr' => 'true',], 'PKR' => ['title' => 'Pakistan Rupee', 'name' => 'rupee', 'code' => 'PKR', 'symbol' => '₨', 'entity' => '&#x20A8;', 'discern' => '', 'ltr' => 'true',], 'PLN' => ['title' => 'Zloty', 'name' => 'zloty', 'code' => 'PLN', 'symbol' => 'zł', 'entity' => '&#x7A;&#x142;', 'discern' => '', 'ltr' => 'true',], 'PYG' => ['title' => 'Guarani', 'name' => 'guarani', 'code' => 'PYG', 'symbol' => '₲', 'entity' => '&#x20B2;', 'discern' => '', 'ltr' => 'true',], 'QAR' => ['title' => 'Qatari Rial', 'name' => 'riyal', 'code' => 'QAR', 'symbol' => 'ر.ق', 'entity' => '&#x631;&#x2E;&#x642;&#xA;', 'discern' => 'QR', 'ltr' => 'false',], 'RON' => ['title' => 'Romanian Leu', 'name' => 'leu', 'code' => 'RON', 'symbol' => 'L', 'entity' => '&#x4C;', 'discern' => '', 'ltr' => 'false',], 'RSD' => ['title' => 'Serbian Dinar', 'name' => 'dinar', 'code' => 'RSD', 'symbol' => 'дин', 'entity' => '&#x434;&#x438;&#x43D;', 'discern' => '', 'ltr' => 'true',], 'RUB' => ['title' => 'Russian Ruble', 'name' => 'ruble', 'code' => 'RUB', 'symbol' => '₽', 'entity' => '&#x20BD;', 'discern' => '', 'ltr' => 'true',], 'RWF' => ['title' => 'Rwanda Franc', 'name' => 'franc', 'code' => 'RWF', 'symbol' => 'FRw', 'entity' => '&#x46;&#x52;&#x77;', 'discern' => 'R₣', 'ltr' => 'true',], 'SAR' => ['title' => 'Saudi Riyal', 'name' => 'riyal', 'code' => 'SAR', 'symbol' => 'ر.س', 'entity' => '&#x631;&#x2E;&#x633;&#xA;', 'discern' => 'SAR', 'ltr' => 'false',], 'SBD' => ['title' => 'Solomon Islands Dollar', 'name' => 'dollar', 'code' => 'SBD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'SI$', 'ltr' => 'true',], 'SCR' => ['title' => 'Seychelles Rupee', 'name' => 'rupee', 'code' => 'SCR', 'symbol' => '₨', 'entity' => '&#x20A8;', 'discern' => 'SRe', 'ltr' => 'true',], 'SDG' => ['title' => 'Sudanese Pound', 'name' => 'pound', 'code' => 'SDG', 'symbol' => '£', 'entity' => '&#xA3;', 'discern' => '£SD', 'ltr' => 'true',], 'SEK' => ['title' => 'Swedish Krona', 'name' => 'krona', 'code' => 'SEK', 'symbol' => 'kr', 'entity' => '&#x6B;&#x72;', 'discern' => '', 'ltr' => 'true',], 'SGD' => ['title' => 'Singapore Dollar', 'name' => 'dollar', 'code' => 'SGD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'S$', 'ltr' => 'true',], 'SHP' => ['title' => 'Saint Helena Pound', 'name' => 'pound', 'code' => 'SHP', 'symbol' => '£', 'entity' => '&#xA3;', 'discern' => '', 'ltr' => 'true',], 'SLL' => ['title' => 'Leone', 'name' => 'leone', 'code' => 'SLL', 'symbol' => 'Le', 'entity' => '&#x4C;&#x65;', 'discern' => '', 'ltr' => 'true',], 'SOS' => ['title' => 'Somali Shilling', 'name' => 'shilling', 'code' => 'SOS', 'symbol' => 'Sh.So.', 'entity' => '&#x53;&#x68;&#x2E;&#x53;&#x6F;&#x2E;', 'discern' => '', 'ltr' => 'true',], 'SRD' => ['title' => 'Surinam Dollar', 'name' => 'dollar', 'code' => 'SRD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'Sr$', 'ltr' => 'true',], 'STN' => ['title' => 'Dobra', 'name' => 'dobra', 'code' => 'STN', 'symbol' => 'Db', 'entity' => '&#x44;&#x62;', 'discern' => '', 'ltr' => 'true',], 'SSP' => ['title' => 'South Sudanese Pound', 'name' => 'pound', 'code' => 'SSP', 'symbol' => '£', 'entity' => '&#xA3;', 'discern' => 'SS£', 'ltr' => 'true',], 'SYP' => ['title' => 'Syrian Pound', 'name' => 'pound', 'code' => 'SYP', 'symbol' => '£', 'entity' => '&#xA3;', 'discern' => '£S', 'ltr' => 'true',], 'SZL' => ['title' => 'Lilangeni', 'name' => 'lilangeni', 'code' => 'SZL', 'symbol' => 'L', 'entity' => '&#x4C;', 'discern' => '', 'ltr' => 'true',], 'THB' => ['title' => 'Baht', 'name' => 'baht', 'code' => 'THB', 'symbol' => '฿', 'entity' => '&#xE3F;', 'discern' => '', 'ltr' => 'true',], 'TJS' => ['title' => 'Somoni', 'name' => 'somoni', 'code' => 'TJS', 'symbol' => 'SM', 'entity' => '&#x53;&#x4D;', 'discern' => '', 'ltr' => 'true',], 'TMT' => ['title' => 'Turkmenistan New Manat', 'name' => 'manat', 'code' => 'TMT', 'symbol' => 'm', 'entity' => '&#x6D;', 'discern' => '', 'ltr' => 'true',], 'TND' => ['title' => 'Tunisian Dinar', 'name' => 'dinar', 'code' => 'TND', 'symbol' => 'د.ت', 'entity' => '&#x62F;&#x2E;&#x62A;', 'discern' => 'DT', 'ltr' => 'false',], 'TOP' => ['title' => 'Pa’anga', 'name' => 'pa’anga', 'code' => 'TOP', 'symbol' => 'T$', 'entity' => '&#x54;&#x24;', 'discern' => 'PT', 'ltr' => 'true',], 'TRY' => ['title' => 'Turkish Lira', 'name' => 'lira', 'code' => 'TRY', 'symbol' => '₺', 'entity' => '&#x20BA;', 'discern' => '', 'ltr' => 'false',], 'TTD' => ['title' => 'Trinidad and Tobago Dollar', 'name' => 'dollar', 'code' => 'TTD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'TT$', 'ltr' => 'true',], 'TWD' => ['title' => 'New Taiwan Dollar', 'name' => 'dollar', 'code' => 'TWD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'NT$', 'ltr' => 'true',], 'TZS' => ['title' => 'Tanzanian Shilling', 'name' => 'shiling', 'code' => 'TZS', 'symbol' => 'TSh', 'entity' => '&#x54;&#x53;&#x68;', 'discern' => '', 'ltr' => 'true',], 'UAH' => ['title' => 'Hryvnia', 'name' => 'hryvnia', 'code' => 'UAH', 'symbol' => '₴', 'entity' => '&#x20B4;', 'discern' => 'грн', 'ltr' => 'true',], 'UGX' => ['title' => 'Uganda Shilling', 'name' => 'shilling', 'code' => 'UGX', 'symbol' => 'USh', 'entity' => '&#x55;&#x53;&#x68;', 'discern' => '', 'ltr' => 'true',], 'USD' => ['title' => 'United States Dollar', 'name' => 'dollar', 'code' => 'USD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => '', 'ltr' => 'true',], 'UYU' => ['title' => 'Peso Uruguayo', 'name' => 'peso', 'code' => 'UYU', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => '$U', 'ltr' => 'true',], 'UZS' => ['title' => 'Uzbekistan Sum', 'name' => 'sum', 'code' => 'UZS', 'symbol' => 'сум', 'entity' => '&#x441;&#x443;&#x43C;', 'discern' => '', 'ltr' => 'true',], 'VED' => ['title' => 'Bolívar Soberano', 'name' => 'bolívar', 'code' => 'VED', 'symbol' => 'Bs.', 'entity' => '&#x42;&#x73;&#x2E;', 'discern' => '', 'ltr' => 'true',], 'VES' => ['title' => 'Bolívar Soberano', 'name' => 'bolívar', 'code' => 'VES', 'symbol' => 'Bs.S', 'entity' => '&#x42;&#x73;&#x2E;&#x53;', 'discern' => '', 'ltr' => 'true',], 'VND' => ['title' => 'Dong', 'name' => 'dong', 'code' => 'VND', 'symbol' => '₫', 'entity' => '&#x20AB;', 'discern' => '', 'ltr' => 'true',], 'VUV' => ['title' => 'Vatu', 'name' => 'vatu', 'code' => 'VUV', 'symbol' => 'VT', 'entity' => '&#x56;&#x54;', 'discern' => '', 'ltr' => 'true',], 'WST' => ['title' => 'Tala', 'name' => 'tala', 'code' => 'WST', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'WS$', 'ltr' => 'true',], 'XAF' => ['title' => 'CFA Franc BEAC', 'name' => 'franc', 'code' => 'XAF', 'symbol' => 'FCFA', 'entity' => '&#x46;&#x43;&#x46;&#x41;', 'discern' => '', 'ltr' => 'true',], 'XCD' => ['title' => 'East Caribbean Dollar', 'name' => 'dollar', 'code' => 'XCD', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'EC$', 'ltr' => 'true',], 'XDR' => ['title' => 'SDR (Special Drawing Right)', 'name' => 'SDR', 'code' => 'XDR', 'symbol' => 'SDR', 'entity' => '&#x53;&#x44;&#x52;', 'discern' => '', 'ltr' => 'true',], 'XOF' => ['title' => 'CFA Franc BCEAO', 'name' => 'franc', 'code' => 'XOF', 'symbol' => 'CFA', 'entity' => '&#x43;&#x46;&#x41;', 'discern' => '', 'ltr' => 'true',], 'XPF' => ['title' => 'CFP Franc', 'name' => 'franc', 'code' => 'XPF', 'symbol' => '₣', 'entity' => '&#x20A3;', 'discern' => '', 'ltr' => 'true',], 'YER' => ['title' => 'Yemeni Rial', 'name' => 'rial', 'code' => 'YER', 'symbol' => 'ر.ي', 'entity' => '&#x631;&#x2E;&#x64A;', 'discern' => '', 'ltr' => 'false',], 'ZAR' => ['title' => 'Rand', 'name' => 'rand', 'code' => 'ZAR', 'symbol' => 'R', 'entity' => '&#x52;', 'discern' => '', 'ltr' => 'true',], 'ZMW' => ['title' => 'Zambian Kwacha', 'name' => 'kwacha', 'code' => 'ZMW', 'symbol' => 'K', 'entity' => '&#x4B;', 'discern' => 'ZK', 'ltr' => 'true',], 'ZWL' => ['title' => 'Zimdollar', 'name' => 'dollar', 'code' => 'ZWL', 'symbol' => '$', 'entity' => '&#x24;', 'discern' => 'ZWL$', 'ltr' => 'true']];
                if (!empty($_GET['currency'])) die(json_encode($currency[$_GET['currency']]));
                $plans = DB::select('plans');
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $data['currency'] = !empty($_POST['currency']) ? $_POST['currency'] : 'USD';
                    $data['currency_symbol'] = !empty($_POST['currency_symbol']) ? $_POST['currency_symbol'] : null;
                    $data['currency_position'] = isset($_POST['currency_position']) ? $_POST['currency_position'] : null;
                    $data['decimal_places'] = isset($_POST['decimal_places']) && is_numeric($_POST['decimal_places']) ? $_POST['decimal_places'] : 0;
                    $data['tax'] = !empty($_POST['tax']) ? $_POST['tax'] : 0;
                    $data['free_plan'] = !empty($_POST['free_plan']) ? $_POST['free_plan'] : 0;
                    $data['credits_words'] = !empty($_POST['credits_words']) ? $_POST['credits_words'] : 0;
                    $data['credits_images'] = !empty($_POST['credits_images']) ? $_POST['credits_images'] : 0;
                    $data['credits_extended'] = isset($_POST['credits_extended']) ? 1 : 0;
                    $data['credits_reset'] = isset($_POST['credits_reset']) ? 1 : 0;
                    $data['extended_status'] = isset($_POST['extended_status']) ? 1 : 0;
                    if (!$this->license()) $this->redirect("admin/settings");
                    foreach ($data as $key => $val) {
                        DB::update('settings', ['description' => $val], ['name' => $key], 'LIMIT 1');
                    }
                    $this->redirect("admin/settings?tab=$tab", "Your details were changed successfully.");
                }
                break;
            case ("security"):
                $tab = "security";
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $data['registration_status'] = isset($_POST['registration_status']) ? 1 : 0;
                    $data['email_verification'] = isset($_POST['email_verification']) ? 1 : 0;
                    $data['gdpr_status'] = isset($_POST['gdpr_status']) ? 1 : 0;
                    $data['blog_status'] = isset($_POST['blog_status']) ? 1 : 0;
                    $data['frontend_status'] = isset($_POST['frontend_status']) ? 1 : 0;
                    $data['template_status'] = isset($_POST['template_status']) ? 1 : 0;
                    $data['document_status'] = isset($_POST['document_status']) ? 1 : 0;
                    $data['chat_status'] = isset($_POST['chat_status']) ? 1 : 0;
                    $data['article_status'] = isset($_POST['article_status']) ? 1 : 0;
                    $data['rewrite_status'] = isset($_POST['rewrite_status']) ? 1 : 0;
                    $data['editor_status'] = isset($_POST['editor_status']) ? 1 : 0;
                    $data['image_status'] = isset($_POST['image_status']) ? 1 : 0;
                    $data['gtranslate'] = isset($_POST['gtranslate']) ? 1 : 0;
                    $data['tracking_id'] = !empty($_POST['tracking_id']) ? $_POST['tracking_id'] : null;
                    $data['maintenance_status'] = isset($_POST['maintenance_status']) ? 1 : 0;
                    $data['maintenance_message'] = $data['maintenance_status'] && !empty($_POST['maintenance_message']) ? trim($_POST['maintenance_message']) : null;
                    if (!$this->license()) $this->redirect("admin/settings");
                    foreach ($data as $key => $val) {
                        DB::update('settings', ['description' => $val], ['name' => $key], 'LIMIT 1');
                    }

                    if (isset($_POST['black_list'])) {
                        $black_list_words = !empty($_POST['black_list']) ? explode(',', preg_replace('!\s+!', " ", $_POST['black_list'])) : [];
                        DB::delete('blacklists');
                        foreach ($black_list_words as $word) {
                            DB::insert('blacklists', ['words' => trim($word)]);
                        }
                    }

                    if (isset($_POST['device_verification'])) {
                        $user = $this->userDetails(['id' => $this->uid], 'name, email');
                        $setting = $this->settings(['site_name', 'site_email', 'site_url']);
                        $subject = "$setting[site_name] account email verification";
                        $body  = "Hello $user[name]," . PHP_EOL . PHP_EOL;
                        $body .= "This message is to confirm that website $setting[site_name] account login device verification is enabled." . PHP_EOL . PHP_EOL;
                        $to = [$user['email']  => $user['name']];
                        $from = [$setting['site_email'] => $setting['site_name']];
                        $mail = Helper::sendMail($to, $subject, $body, $from);
                        if ($mail) {
                            DB::update('settings', ['description' => 1], ['name' => 'device_verification'], 'LIMIT 1');
                        } else {
                            $this->redirect("admin/settings?tab=$tab", "Account login device verification is not enabled due to mail server not working right now.", "error");
                        }
                    } else {
                        DB::update('settings', ['description' => 0], ['name' => 'device_verification'], 'LIMIT 1');
                    }

                    $this->redirect("admin/settings?tab=$tab", "Your details were changed successfully.");
                }

                $blacklists = DB::select('blacklists', 'words', [], 'ORDER by words');
                $black_list = null;
                if ($blacklists) {
                    foreach ($blacklists as $val) {
                        $black_list .= "$val[words], ";
                    }
                }
                $black_list = $black_list ? trim($black_list, ', ') : null;
                break;
            case ("media"):
                $tab = "media";
                $assets_writeable = is_writeable(DIR . '/assets/img') ? true : false;
                if (!empty($_GET['delete']) && !empty($_GET['sign'])) {
                    $setting = $this->setting(['name' => $_GET['delete']]);
                    if (isset($setting[$_GET['delete']]) && md5(date('d') . key($setting)) == $_GET['sign']) {
                        DB::update('settings', ['description' => null], ['name' => key($setting)], 'LIMIT 1');
                        $this->redirect("admin/settings?tab=media", "Media has been deleted successfully.");
                    }
                }
                if (!empty($_FILES)) {
                    if (!$this->license()) exit;
                    if (!$assets_writeable) exit;
                    if (!empty($_FILES['favicon']['tmp_name'])) {
                        $url = Uploader::asset($_FILES['favicon'], "favicon", 32, 32);
                        if ($url) DB::update('settings', ['description' => $url], ['name' => 'favicon'], 'LIMIT 1');
                    }
                    if (!empty($_FILES['site_logo']['tmp_name'])) {
                        $url = Uploader::asset($_FILES['site_logo'], "logo");
                        if ($url) DB::update('settings', ['description' => $url], ['name' => 'site_logo'], 'LIMIT 1');
                    }
                    if (!empty($_FILES['site_logo_light']['tmp_name'])) {
                        $url = Uploader::asset($_FILES['site_logo_light'], "logo-light");
                        if ($url) DB::update('settings', ['description' => $url], ['name' => 'site_logo_light'], 'LIMIT 1');
                    }
                    if (!empty($_FILES['site_logo_dark']['tmp_name'])) {
                        $url = Uploader::asset($_FILES['site_logo_dark'], "logo-dark");
                        if ($url) DB::update('settings', ['description' => $url], ['name' => 'site_logo_dark'], 'LIMIT 1');
                    }
                    if (!empty($url)) echo json_encode(['url' => $url . '?v=' . time()]);
                    exit;
                }
                break;
            case ("social"):
                $tab = "social";
                $provider_google = DB::select('providers', '*', ['name' => 'Google'], 'LIMIT 1');
                $provider_facebook = DB::select('providers', '*', ['name' => 'Facebook'], 'LIMIT 1');
                $provider_linkedin = DB::select('providers', '*', ['name' => 'Linkedin'], 'LIMIT 1');
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Follow link
                    if (isset($_POST['facebook_link'])) {
                        $data['facebook_link'] = !empty($_POST['facebook_link']) ? $_POST['facebook_link'] : null;
                        $data['twitter_link'] = !empty($_POST['twitter_link']) ? $_POST['twitter_link'] : null;
                        $data['instagram_link'] = !empty($_POST['instagram_link']) ? $_POST['instagram_link'] : null;
                        $data['linkedin_link'] = !empty($_POST['linkedin_link']) ? $_POST['linkedin_link'] : null;
                        $data['demo_link'] = !empty($_POST['demo_link']) ? $_POST['demo_link'] : null;
                        if (!$this->license()) $this->redirect("admin/settings");
                        foreach ($data as $key => $val) {
                            DB::update('settings', ['description' => $val], ['name' => $key], 'LIMIT 1');
                        }
                    }
                    // Google sign in
                    if (isset($_POST['google_client_id'])) {
                        $google_data['key_id'] = !empty($_POST['google_client_id']) ? $_POST['google_client_id'] : null;
                        $google_data['key_secret'] = !empty($_POST['google_client_secret']) ? $_POST['google_client_secret'] : null;
                        $google_data['status'] = isset($_POST['google_status']) ? 1 : 0;
                        if (!$this->license()) $this->redirect("admin/settings");
                        if (!empty($google_data['key_secret']) && strpos($google_data['key_secret'], '***') !== false) unset($google_data['key_secret']);
                        DB::update('providers', $google_data, ['name' => 'Google'], 'LIMIT 1');
                    }
                    // Facebook sign in
                    if (isset($_POST['facebook_app_id'])) {
                        $facebook_data['key_id'] = !empty($_POST['facebook_app_id']) ? $_POST['facebook_app_id'] : null;
                        $facebook_data['key_secret'] = !empty($_POST['facebook_app_secret']) ? $_POST['facebook_app_secret'] : null;
                        $facebook_data['status'] = isset($_POST['facebook_status']) ? 1 : 0;
                        if (!empty($facebook_data['key_secret']) && strpos($facebook_data['key_secret'], '***') !== false) unset($facebook_data['key_secret']);
                        DB::update('providers', $facebook_data, ['name' => 'Facebook'], 'LIMIT 1');
                    }
                    // Linkedin sign in
                    if (isset($_POST['linkedin_client_id'])) {
                        $linkedin_data['key_id'] = !empty($_POST['linkedin_client_id']) ? $_POST['linkedin_client_id'] : null;
                        $linkedin_data['key_secret'] = !empty($_POST['linkedin_client_secret']) ? $_POST['linkedin_client_secret'] : null;
                        $linkedin_data['status'] = isset($_POST['linkedin_status']) ? 1 : 0;
                        if (!empty($linkedin_data['key_secret']) && strpos($linkedin_data['key_secret'], '***') !== false) unset($linkedin_data['key_secret']);
                        DB::update('providers', $linkedin_data, ['name' => 'Linkedin'], 'LIMIT 1');
                    }
                    // Redirect
                    $this->redirect("admin/settings?tab=$tab", "Your details were changed successfully.");
                }
                break;
            case ("testimonials"):
                $tab = "testimonials";
                $testimonials = DB::select('testimonials', '*', [], 'ORDER BY id DESC');
                if (!empty($_GET['id']) && is_string($_GET['id'])) {
                    $result = DB::select('testimonials', '*', ['id' => base64_decode($_GET['id'])]);
                    $testimonial = isset($result[0]) ? $result[0] : null;
                    if (empty($testimonial)) $this->redirect("admin/settings?tab=$tab");
                    if (isset($_GET['delete']) && $_GET['delete'] == md5($testimonial['id'])) {
                        DB::delete('testimonials', ['id' => $testimonial['id']], 'LIMIT 1');
                        $this->redirect("admin/settings?tab=$tab", "Your details were changed successfully.");
                    }

                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateTestimonial'])) {
                        $data['name'] = !empty($_POST['name']) ? trim($_POST['name']) : null;
                        $data['role'] = !empty($_POST['role']) ? trim($_POST['role']) : null;
                        $data['description'] = !empty($_POST['description']) ? $_POST['description'] : null;
                        DB::update('testimonials', $data, ['id' => $testimonial['id']], 'LIMIT 1');
                        $this->redirect("admin/settings?tab=$tab", "Your details were changed successfully.");
                    }
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addTestimonial'])) {
                    $data['name'] = !empty($_POST['name']) ? trim($_POST['name']) : null;
                    $data['role'] = !empty($_POST['role']) ? trim($_POST['role']) : null;
                    $data['description'] = !empty($_POST['description']) ? $_POST['description'] : null;
                    DB::insert('testimonials', $data);
                    $this->redirect("admin/settings?tab=$tab", "Your details were added successfully.");
                }
                break;
            case ("mail"):
                $tab = "mail";
                $setting = $this->setting(['status' => 2]);
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'])) {
                    $settings = $this->settings(['site_name', 'site_email', 'smtp_connection']);
                    $server = isset($settings['smtp_connection']) && $settings['smtp_connection'] == 1 ? 'SMTP' : 'default php';
                    $subject = "Test mail server!";
                    $body  = "Hello," . PHP_EOL . PHP_EOL;
                    $body .= "This message is to confirm that your $settings[site_name] mail server is responding successfully." . PHP_EOL . PHP_EOL;
                    $body .= "Server: " . $server . PHP_EOL;
                    $body .= "Time: " . date('h:i a', time()) . PHP_EOL;
                    $to = [$_POST['email'] => null];
                    $from = [$settings['site_email'] => $settings['site_name']];
                    $mail = Helper::sendMail($to, $subject, $body, $from);
                    if (!$mail) $this->redirect("admin/settings?tab=$tab", 'Sorry, it seems that mail server is not responding.', 'error');
                    $this->redirect("admin/settings?tab=$tab", "We've sent a test email to '$_POST[email]' using $server mail server. Please check your inbox, if test mail arrived in your inbox that means your mail server working successfully.");
                }
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['site_email'])) {
                    $data['site_email'] = !empty($_POST['site_email']) ? $_POST['site_email'] : null;
                    $data['smtp_hostname'] = !empty($_POST['smtp_hostname']) ? trim($_POST['smtp_hostname']) : null;
                    $data['smtp_port'] = isset($_POST['smtp_port']) ? $_POST['smtp_port'] : null;
                    $data['smtp_username'] = !empty($_POST['smtp_username']) ? $_POST['smtp_username'] : null;
                    $data['smtp_password'] = isset($_POST['smtp_password']) ? $_POST['smtp_password'] : null;
                    $data['smtp_encryption'] = !empty($_POST['smtp_encryption']) ? $_POST['smtp_encryption'] : null;
                    $data['smtp_connection'] =  isset($_POST['smtp_connection']) ? 1 : 0;
                    if (!$this->license()) $this->redirect("admin/settings");
                    if (!filter_var($data['site_email'], FILTER_VALIDATE_EMAIL)) $this->redirect("admin/settings?tab=$tab", "Invalid primary email address provided.", "error");
                    if (isset($_POST['smtp_connection'])) {
                        $smtp = new SMTP();
                        //$smtp->do_debug = SMTP::DEBUG_CONNECTION;
                        try {
                            if (empty($data['smtp_hostname']) || empty($data['smtp_port']) || empty($data['smtp_username']) || empty($data['smtp_password'])) {
                                throw new Exception('Missing SMTP information');
                            }
                            if (!$smtp->connect($data['smtp_hostname'], $data['smtp_port'])) {
                                throw new Exception('Connect failed');
                            }
                            if (!$smtp->hello(gethostname())) {
                                throw new Exception('EHLO failed: ' . $smtp->getError()['error']);
                            }
                            $e = $smtp->getServerExtList();
                            if ($data['smtp_encryption'] == 'TLS') {
                                //If server can do TLS encryption, use it
                                if (is_array($e) && array_key_exists('STARTTLS', $e)) {
                                    $tlsok = $smtp->startTLS();
                                    if (!$tlsok) {
                                        throw new Exception('Failed to start encryption: ' . $smtp->getError()['error']);
                                    }
                                    //Repeat EHLO after STARTTLS
                                    if (!$smtp->hello(gethostname())) {
                                        throw new Exception('EHLO (2) failed: ' . $smtp->getError()['error']);
                                    }
                                    //Get new capabilities list, which will usually now include AUTH if it didn't before
                                    $e = $smtp->getServerExtList();
                                }
                            }
                            //If server supports authentication, do it (even if no encryption)
                            if (is_array($e) && array_key_exists('AUTH', $e)) {
                                if (!empty($data['smtp_password']) && strpos($data['smtp_password'], '***') !== false) $data['smtp_password'] = $setting['smtp_password'];
                                if ($smtp->authenticate($data['smtp_username'], $data['smtp_password'])) {
                                    $data['smtp_connection'] =  isset($_POST['smtp_connection']) ? 1 : 0;
                                    $status = 'success';
                                    $message = "SMTP connected! Your details were changed successfully. Please send test mail to confirm that your mail server working as well.";
                                } else {
                                    throw new Exception('Authentication failed: ' . $smtp->getError()['error']);
                                }
                            }
                        } catch (Exception $e) {
                            $data['smtp_connection'] = 0;
                            $status = 'error';
                            $message = 'SMTP connection error! ' . $e->getMessage();
                        }
                        //Whatever happened, close the connection.
                        $smtp->quit();
                    } else {
                        $status = 'success';
                        $message = "Your details were changed successfully. Please send test mail to confirm that your mail server working as well.";
                    }

                    // update info
                    if (!empty($data['smtp_password']) && strpos($data['smtp_password'], '***') !== false) unset($data['smtp_password']);
                    foreach ($data as $key => $val) {
                        DB::update('settings', ['description' => $val], ['name' => $key], 'LIMIT 1');
                    }

                    if (empty($message)) $this->redirect("admin/settings?tab=$tab", "Something went wrong, try again.", "error");
                    $this->redirect("admin/settings?tab=$tab", $message, $status);
                }
                break;
            case ("marketing"):
                $tab = "marketing";
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['commission_rate'])) {
                    $data['maximum_affiliate'] = !empty($_POST['maximum_affiliate']) ? $_POST['maximum_affiliate'] : 0;
                    $data['maximum_referral'] = !empty($_POST['maximum_referral']) ? $_POST['maximum_referral'] : 0;
                    $data['minimum_payout'] = !empty($_POST['minimum_payout']) ? $_POST['minimum_payout'] : 0;
                    $data['commission_rate'] = !empty($_POST['commission_rate']) ? $_POST['commission_rate'] : 0;
                    $data['affiliate_status'] = isset($_POST['affiliate_status']) ? 1 : 0;
                    if (!$this->license()) $this->redirect("admin/settings");
                    foreach ($data as $key => $val) {
                        DB::update('settings', ['description' => $val], ['name' => $key], 'LIMIT 1');
                    }
                    $this->redirect("admin/settings?tab=$tab", "Your details were changed successfully.");
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mailchimp_apikey'])) {
                    $data['mailchimp_apikey'] = !empty($_POST['mailchimp_apikey']) ? $_POST['mailchimp_apikey'] : null;
                    $data['mailchimp_audienceid'] = !empty($_POST['mailchimp_audienceid']) ? trim($_POST['mailchimp_audienceid']) : null;
                    $data['mailchimp_status'] = isset($_POST['mailchimp_status']) ? 1 : 0;
                    if (!$this->license()) $this->redirect("admin/settings");
                    foreach ($data as $key => $val) {
                        DB::update('settings', ['description' => $val], ['name' => $key], 'LIMIT 1');
                    }
                    $this->redirect("admin/settings?tab=$tab", "Your details were changed successfully.");
                }
                break;
            case ("payment"):
                $tab = "payment";
                $payment_gateway = DB::select('gateways', '*', ['type' => 'payment'], 'ORDER BY name ASC');
                if (!empty($_GET['provider'])) {
                    $result = DB::select('gateways', '*', ['provider' => $_GET['provider']], 'LIMIT 1');
                    $gateway = isset($result[0]) ? $result[0] : [];
                    if (!$gateway) $this->redirect("admin/payments");
                    $options = !empty($gateway['options']) ? json_decode($gateway['options'], true) : null;
                    $payment = new Gateway($gateway['provider']);
                    $recurring = empty($payment->gateway->recurring) && !$gateway['recurring'] ? false : true;
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $field = [];
                        foreach ($options as $key => $val) {
                            $field[$key] = $val;
                            if (isset($_POST[$val['key']]) && strpos($_POST[$val['key']], '***') === false) {
                                $field[$key]['value'] = isset($_POST[$val['key']]) ? $_POST[$val['key']] : "";
                            } else {
                                $field[$key]['value'] = $val['value'];
                            }
                        }
                        $data['options'] = json_encode($field);
                        if (!$this->license()) $this->redirect("admin/settings");
                        DB::update('gateways', $data, ['id' => $gateway['id']]);

                        if (empty($payment->gateway)) {
                            DB::update('gateways', ['status' => 0], ['id' => $gateway['id']]);
                            $this->redirect("admin/settings?tab=payment&provider=$_GET[provider]", "Payment gateway not found!", "error");
                        }

                        DB::update('gateways', ['status' => isset($_POST['status']) ? 1 : 0], ['id' => $gateway['id']]);
                        if (isset($_POST['recurring']) && empty($payment->gateway->recurring)) {
                            DB::update('gateways', ['recurring' => 0], ['id' => $gateway['id']]);
                            $this->redirect("admin/settings?tab=payment&provider=$_GET[provider]", "Do not support recurring subscription payment.", "error");
                        }

                        DB::update('gateways', ['recurring' => isset($_POST['recurring']) ? 1 : 0], ['id' => $gateway['id']]);
                        $this->redirect("admin/settings?tab=payment", "Payment gateway has been updated successfully.");
                    }
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['offline_payment_title'])) {
                    $data['offline_payment'] = isset($_POST['offline_payment']) ? 1 : 0;
                    $data['offline_payment_title'] = isset($_POST['offline_payment_title']) ?  $_POST['offline_payment_title'] : null;
                    $data['offline_payment_guidelines'] = isset($_POST['offline_payment_guidelines']) ?  $_POST['offline_payment_guidelines'] : null;
                    $data['offline_payment_recipient'] = isset($_POST['offline_payment_recipient']) ?  $_POST['offline_payment_recipient'] : null;
                    foreach ($data as $key => $val) {
                        DB::update('settings', ['description' => $val], ['name' => $key], 'LIMIT 1');
                    }
                    $this->redirect("admin/settings?tab=$tab", "Your details were changed successfully.");
                }
                break;
            case ("schedule"):
                $tab = "schedule";
                $cronpath = APP . "/Cron.php";
                $interval = "*/5 * * * *";
                $command = "php -q $cronpath >/dev/null 2>&1";
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $data['remove_history'] = isset($_POST['remove_history']) ? 1 : 0;
                    foreach ($data as $key => $val) {
                        DB::update('settings', ['description' => $val], ['name' => $key], 'LIMIT 1');
                    }
                    if ($data['remove_history'] == 1) {
                        $history =  DB::query("SELECT id FROM history WHERE created <= NOW() - INTERVAL 30 DAY ORDER BY created DESC LIMIT 20, 100000");
                        foreach ($history as $val) {
                            DB::delete('history', ['id' => $val['id']]);
                        }
                    }
                    $this->redirect("admin/settings?tab=$tab", "Your details were changed successfully.");
                }
                break;
            case ("openai"):
                $tab = "openai";
                $models = DB::select('models', '*', ['user_id' => 0]);
                $languages = DB::select('languages');
                $tones = DB::select('tones');
                if (!empty($_GET['testApiKey']) && $_GET['testApiKey'] == $this->token) {
                    $setting = $this->settings(['openai_apikey', 'default_chat_model']);
                    if (empty($setting['openai_apikey'])) $this->redirect("admin/settings?tab=$tab&error=Openai ApiKey required. Please enter openai api key.");
                    $model = !empty($setting['default_chat_model']) ? $setting['default_chat_model'] : 'gpt-4o';
                    $messages[0]['role'] = "system";
                    $messages[0]['content'] = "You are a helpful assistant.";
                    $messages[1]['role'] = "user";
                    $messages[1]['content'] = "Hello";
                    $posts['messages'] = $messages;
                    $posts['model'] = $model;
                    $openai = $this->openai('chat/completions', $posts);
                    if (empty($openai)) $this->redirect("admin/settings?tab=$tab&error=Not connected with server, please try again.");
                    if (isset($openai['error'])) $this->redirect("admin/settings?tab=$tab&error=" . $openai['error']['message']);
                    if (!empty($openai['choices'][0]['message']['content'])) {
                        for ($i = 0; $i < 4; $i++) {
                            $results = $this->openai('chat/completions', $posts);
                            if (isset($results['error'])) $this->redirect("admin/settings?tab=$tab&error=API connection successful! " . $results['error']['message']);
                        }
                        if (!empty($results['choices'][0]['message']['content'])) $this->redirect("admin/settings?tab=$tab&success=API connection successful! The platform is ready to use.");
                    }
                    $this->redirect("admin/settings?tab=$tab&error=Something went wrong please try again.");
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['openai_apikey'])) {
                    $data['openai_apikey'] = !empty($_POST['openai_apikey']) ? trim($_POST['openai_apikey']) : null;
                    $data['openai_organization_id'] = !empty($_POST['openai_organization_id']) ? trim($_POST['openai_organization_id']) : null;
                    $setting = $this->settings(['license_key', 'purchase_code']);
                    $domain_name = isset($_SERVER['HTTP_HOST']) ? preg_replace('#^(?:www\.)+(.+\.)#i', '$1', $_SERVER['HTTP_HOST']) : null;
                    if (hash_equals($setting['license_key'], hash_hmac('sha256', $domain_name, $setting['purchase_code']))) {
                        if (!empty($data['openai_apikey']) && strpos($data['openai_apikey'], '***') !== false) unset($data['openai_apikey']);
                        foreach ($data as $key => $val) {
                            DB::update('settings', ['description' => $val], ['name' => $key], 'LIMIT 1');
                        }
                        $this->redirect("admin/settings?tab=$tab&testApiKey=$this->token");
                    }
                    $this->redirect("admin/settings?tab=$tab", "Your details were changed successfully.");
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_default_model'])) {
                    $data['default_chat_model'] = !empty($_POST['default_chat_model']) ? trim($_POST['default_chat_model']) : null;
                    $data['default_analyst_model'] = !empty($_POST['default_analyst_model']) ? trim($_POST['default_analyst_model']) : null;
                    $data['default_article_model'] = !empty($_POST['default_article_model']) ? trim($_POST['default_article_model']) : null;
                    $data['default_image_model'] = !empty($_POST['default_image_model']) ? trim($_POST['default_image_model']) : null;
                    foreach ($data as $key => $val) {
                        DB::update('settings', ['description' => $val], ['name' => $key], 'LIMIT 1');
                    }

                    if (!empty($_POST['default_template_model'])) {
                        $models = DB::select('models', 'id', ['model' => $_POST['default_template_model']], 'LIMIT 1');
                        $modelId =  isset($models[0]['id']) ? $models[0]['id'] : 1;
                        DB::update('templates', ['model' => $modelId]);
                    }

                    $this->redirect("admin/settings?tab=$tab", "Default model has been changed successfully.");
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['modelId'])) {
                    $model = DB::select('models', '*', ['model' => $_POST['modelId']]);
                    if (!$model) {
                        $model_data['name'] = $_POST['modelName'];
                        $model_data['model'] = $_POST['modelId'];
                        $model_data['type'] = $_POST['modelType'];
                        DB::insert('models', $model_data);
                    }
                    $this->redirect("admin/settings?tab=$tab", "New model has been added successfully.");
                }

                if (!empty($_GET['deleteModel']) && is_string($_GET['deleteModel']) && isset($_GET['sign']) && $_GET['sign'] == md5(date('H'))) {
                    DB::delete('models', ['id' => $_GET['deleteModel']], 'LIMIT 1');
                    $this->redirect("admin/settings?tab=$tab", "Model has been deleted successfully.");
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['languageName'])) {
                    $language = DB::select('languages', '*', ['name' => $_POST['languageName']]);
                    if (!$language) {
                        DB::insert('languages', ['name' => $_POST['languageName']]);
                    }
                    $this->redirect("admin/settings?tab=$tab", "New language has been added successfully.");
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateLanguage'])) {
                    DB::update('languages', ['selected' => 0, 'status' => 0]);
                    $languageStatus = isset($_POST['languageStatus']) ? $_POST['languageStatus'] : [];
                    $languageDefault = isset($_POST['default_language'][0]) ? $_POST['default_language'][0] : [];
                    DB::update('languages', ['selected' => 1], ['name' => $languageDefault]);
                    foreach ($languageStatus as $key => $val) {
                        DB::update('languages', ['status' => 1], ['name' => $key]);
                    }
                    $this->redirect("admin/settings?tab=$tab", "Language has been updated successfully.");
                }

                if (!empty($_GET['deleteLanguage']) && is_string($_GET['deleteLanguage']) && isset($_GET['sign']) && $_GET['sign'] == md5(date('H'))) {
                    DB::delete('languages', ['name' => $_GET['deleteLanguage']], 'LIMIT 1');
                    $this->redirect("admin/settings?tab=$tab", "Language has been deleted successfully.");
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['toneName'])) {
                    $tone = DB::select('tones', '*', ['name' => $_POST['toneName']]);
                    if (!$tone) {
                        DB::insert('tones', ['name' => $_POST['toneName']]);
                    }

                    $this->redirect("admin/settings?tab=$tab", "New voice tone has been added successfully.");
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateTone'])) {
                    DB::update('tones', ['status' => 0]);
                    $languageStatus = isset($_POST['toneStatus']) ? $_POST['toneStatus'] : [];
                    foreach ($languageStatus as $key => $val) {
                        DB::update('tones', ['status' => 1], ['name' => $key]);
                    }
                    $this->redirect("admin/settings?tab=$tab", "Voice tone has been uploaded successfully.");
                }

                if (!empty($_GET['deleteTone']) && is_string($_GET['deleteTone']) && isset($_GET['sign']) && $_GET['sign'] == md5(date('H'))) {
                    DB::delete('tones', ['name' => $_GET['deleteTone']], 'LIMIT 1');
                    $this->redirect("admin/settings?tab=$tab", "Voice tone has been deleted successfully.");
                }

                break;
            case ("about"):
                $tab = "about";
                $setting = $this->settings(['purchase_code', 'license_key']);
                $domain_name = isset($_SERVER['HTTP_HOST']) ? preg_replace('#^(?:www\.)+(.+\.)#i', '$1', $_SERVER['HTTP_HOST']) : null;
                $siteKey = base64_encode($domain_name . (!empty($setting['purchase_code']) ? ":$setting[purchase_code]" : null));
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['activationKey'])) {
                    $activationKey = isset($_POST['activationKey']) ? base64_decode($_POST['activationKey']) : null;
                    $key = explode(":", $activationKey);
                    $license_key = !empty($key[0]) ? $key[0] : null;
                    $purchase_code =  !empty($key[1]) ? $key[1] : $setting['purchase_code'];
                    $jwt_key = "jwt" . md5(time() . uniqid());
                    if (hash_equals($license_key, hash_hmac('sha256', $domain_name, $purchase_code))) {
                        DB::update('settings', ['description' => $jwt_key], ['name' => 'jwt_key'], 'LIMIT 1');
                        if ($license_key) DB::update('settings', ['description' => $license_key], ['name' => 'license_key'], 'LIMIT 1');
                        if ($purchase_code) DB::update('settings', ['description' => $purchase_code], ['name' => 'purchase_code'], 'LIMIT 1');
                        $this->redirect("admin/settings?tab=$tab", "Activation success.");
                    }
                    $this->redirect("admin/settings?tab=$tab", "Your provided activation key is invalid.", "error");
                }
                break;
        }

        $setting = $this->setting([]);
        $this->title(ucfirst($tab) . ' setting');
        require_once APP . '/View/Admin/Settings.php';
    }
}
