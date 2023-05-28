<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
Use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Login\LoginRequest;

trait Service
{
    public static function auth_check(){
        if(!Auth::check()){
            Session::flash('error','Login First! Then See thee Dashboard!');
            return redirect('login');
        }
    }
    public static function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == 'K') {
            return $miles * 1.609344;
        } elseif ($unit == 'N') {
            return $miles * 0.8684;
        } else {
            return $miles;
        }
    }


    public static function timeLeft($passTime)
    {
        //echo $time;
        $time = time() - $passTime;
        $year = floor($time / (365 * 24 * 60 * 60));
        $month = floor($time / (30 * 24 * 60 * 60));
        $week = floor($time / (7 * 24 * 60 * 60));
        $day = floor($time / (24 * 60 * 60));
        $hour = floor($time / (60 * 60));
        $minute = floor(($time / 60) % 60);
        $seconds = $time % 60;
        if ($year != 0) {
            return $year.' year ago';
        } elseif ($month != 0) {
            return $month.' month ago';
        } elseif ($week != 0) {
            return $week.' week ago';
        } elseif ($day != 0) {
            return $day.' day ago';
        } elseif ($hour != 0) {
            return $hour.' hour ago';
        } elseif ($minute != 0) {
            return $minute.' minutes ago';
        } else {
            return $seconds.' seconds ago';
        }
        //return $hour.' hour '.$minute.' minutes '.$seconds.' seconds ago';
    }

    public static function stringSubstr($string)
    {
        if (! empty($string)) {
            if (strlen($string) > 41) {
                $string = substr($string, 0, 41).'...';

                return $string;
            } else {
                return $string;
            }
        } else {
            return null;
        }
    }

    public static function stringSubstrLimit($string = null, $limit = null)
    {
        if (! empty($string) && ! empty($limit)) {
            if (strlen($string) > $limit) {
                $string = substr($string, 0, $limit).'...';

                return $string;
            } else {
                return $string;
            }
        } else {
            return null;
        }
    }

    public static function randomString($length = 50)
    {
        $str = '';
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '10000'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }

        return $str;
    }

    public function secretString($length = 15)
    {
        $str = '';
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '1000'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }

        return $str;
    }

    public static function randomRemebberToken($length = 36)
    {
        $str = '';
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '100000'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }

        return $str;
    }

    public static function checkInToday($time)
    {
        if (! $time) {
            return false;
        }
        $date = date('Y-m-d', $time);
        $now = date('Y-m-d');
        $tomorrow = date('Y-m-d', time() + strtotime('tomorrow'));
        $day_after_tomorrow = date('Y-m-d', time() + strtotime('tomorrow + 1 day'));
        if ($date == $now) {
            return 1;
        } elseif ($date == $tomorrow) {
            return 2;
        } elseif ($date == $day_after_tomorrow) {
            return 3;
        } else {
            return 4;
        }
    }

    public function getUniqueSlug(\Illuminate\Database\Eloquent\Model $model, $value)
    {
        $slug = \Illuminate\Support\Str::slug($value);
        $slugCount = count($model->whereRaw("slug REGEXP '^{$slug}(-[0-9]+)?$' and id != '{$model->id}'")->get());

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }

    public static function slug_create($value = null)
    {
        if (empty($value)) {
            return;
        }
        $str = strtolower(trim($value));
        $str1 = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str2 = preg_replace('/-+/', '-', $str1);

        return rtrim($str2, '-');
    }

    public function get_extension($file)
    {
        $extension = end(explode('.', $file));

        return $extension ? $extension : false;
    }

    public function getDiscount($rate = null, $amount = null)
    {
        $discount = 0;
        if (empty($amount)) {
            return $discount;
        }
        $discount = ($rate * $amount) / 100;

        return $discount;
    }

    //random image get
    public static function randomProfileImage()
    {
        $images = [
            'public/front/img/people/1.png',
            'public/front/img/people/2.png',
            'public/front/img/people/3.png',
            'public/front/img/people/4.png',
            'public/front/img/people/5.png',
            'public/front/img/people/6.png',
            'public/front/img/people/7.png',
            'public/front/img/people/8.png',
            'public/front/img/people/9.png',
            'public/front/img/people/10.png',
            'public/front/img/people/11.png',
            'public/front/img/people/12.png',
            'public/front/img/people/13.png',
            'public/front/img/people/14.png',
            'public/front/img/people/15.png',
            'public/front/img/people/16.png',
            'public/front/img/people/17.png',
            'public/front/img/people/18.png',
            'public/front/img/people/19.png',
            'public/front/img/people/20.png',
        ];
        $random = mt_rand(0, count($images) - 1);

        return $images[$random];
    }

    //get tag for profile
    public static function getTagsProfile($str = null)
    {
        if (empty($str)) {
            return false;
        }
        $strArray = explode(',', $str);

        return $strArray;
    }

    public static function getCountries()
    {
        $arr = [
            'BD' => 'Bangladesh',
            'CN' => 'China',
            'EE' => 'Estonia',
            'FI' => 'Finland',
            'FR' => 'France',
            'DE' => 'Germany',
            'IN' => 'India',
            'IE' => 'Ireland',
            'JP' => 'Japan',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'MY' => 'Malaysia',
            'NL' => 'Netherlands',
            'NZ' => 'New Zealand',
            'NO' => 'Norway',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'QA' => 'Qatar',
            'SA' => 'Saudi Arabia',
            'RS' => 'Serbia',
            'SG' => 'Singapore',
            'ES' => 'Spain',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'TW' => 'Taiwan',
            'TH' => 'Thailand',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
        ];

        return $arr;
    }

    public static function industryType()
    {
        $arr = [
            'Basic' => 'Basic Industries',
            'Finance' => 'Finance',
            'Capital' => 'Capital Goods',
            'Healthcare' => 'Healthcare',
            'Consumer' => 'Consumer Durables',
            'Miscellaneous' => 'Miscellaneous',
            'Food' => 'Food',
            'Farm' => 'Farm',
            'Hotel' => 'Hotel',
            'Shop' => 'Shop',
            'IT' => 'IT',
            'Freelance' => 'Freelance',
        ];

        return $arr;
    }
    public static function getUserRole(){
        $arr = [
            array(
                'id'=>1,
                'value'=>'superAdmin',
                'name'=>'Super Admin'
            ),
            array(
                'id'=>2,
                'value'=>'branchManager',
                'name'=>'Branch Manager'
            ),
            array(
                'id'=>3,
                'value'=>'counselor',
                'name'=>'Counselor'
            ),
            array(
                'id'=>4,
                'value'=>'frontOfficer',
                'name'=>'Front Officer'
            ),
        ];
        return $arr;
    }

    public static function job_status()
    {
        $arr = [
            'Full' => 'Full Time',
            'Part' => 'Part Time',
            'Contract' => 'Contract Job',
            'Freelance' => 'Freelance',
        ];

        return $arr;
    }

    public static function getTotalApplicants($str = null)
    {
        if (empty($str)) {
            return 0;
        }
        $strArray = explode(',', $str);

        return count($strArray);
    }

    public static function is_job_apply($str = null, $user_id = null)
    {
        if (empty($str) && empty($user_id)) {
            return false;
        }
        $strArray = explode(',', $str);
        foreach ($strArray as $row) {
            if ($user_id == $row) {
                return true;
            }
        }

        return false;
    }

    public static function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
        ]);
    }

    public static function getAllCountries()
    {
        $countries = ['Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antarctica', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegowina', 'Botswana', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territory', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo', 'Congo, the Democratic Republic of the', 'Cook Islands', 'Costa Rica', "Cote d'Ivoire", 'Croatia (Hrvatska)', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands (Malvinas)', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'France Metropolitan', 'French Guiana', 'French Polynesia', 'French Southern Territories', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard and Mc Donald Islands', 'Holy See (Vatican City State)', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran (Islamic Republic of)', 'Iraq', 'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', "Korea, Democratic People's Republic of", 'Korea, Republic of', 'Kuwait', 'Kyrgyzstan', "Lao, People's Democratic Republic", 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libyan Arab Jamahiriya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia, The Former Yugoslav Republic of', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia, Federated States of', 'Moldova, Republic of', 'Monaco', 'Mongolia', 'Montserrat', 'Morocco', 'Mozambique', 'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'Netherlands Antilles', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Reunion', 'Romania', 'Russian Federation', 'Rwanda', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia (Slovak Republic)', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia and the South Sandwich Islands', 'Spain', 'Sri Lanka', 'St. Helena', 'St. Pierre and Miquelon', 'Sudan', 'Suriname', 'Svalbard and Jan Mayen Islands', 'Swaziland', 'Sweden', 'Switzerland', 'Syrian Arab Republic', 'Taiwan, Province of China', 'Tajikistan', 'Tanzania, United Republic of', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'United States Minor Outlying Islands', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Venezuela', 'Vietnam', 'Virgin Islands (British)', 'Virgin Islands (U.S.)', 'Wallis and Futuna Islands', 'Western Sahara', 'Yemen', 'Yugoslavia', 'Zambia', 'Zimbabwe'];

        return $countries;
    }

    public static function get_invite_token($length = 56)
    {
        $str = '';
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '50'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }

        return $str;
    }
    public static function createDirectory(string $path): string
    {
        $path = public_path($path);

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
    //get set lead question
    public static function get_lead_questions(){
        $data = array(
            "whats_your_nationality_",
            "which_course_are_you_interested_",
            "whats_your_last_qualifications",
            "how_long_are_you_in_the_uk_",
            "whats_your_level_of_english_",
            "preferred_campus_location_in_england",
            "do_you_have_ielts_tofel_or_pte",
            "intrested_level_of_study",
            "your_study_gap",
            "your_city_",
            "preferred_time_to_call_you",
            "when_did_you_finish_your_last_qualification",
            "which_degree_are_you_interested_to_study_in",
            "city",
            "do_you_have_ielts__pte__toefl",
            "have_you_ever_received_student_finance_in_the_uk",
            "preferred_time_to_call_",
            "do_you_have_ielts__oietc__moi",
            "preferred_time_to_call",
            "venue_you_preferred_to_attend",
            "your_dream_destination",
        );
        return $data;
    }
    //make question ans answer smoothly
    public static function makeSentense($str=NULL){
        if(!$str){
            return false;
        }
        $makeStrArray = explode("_",$str);
        $makeSentense = implode(" ",$makeStrArray);
        return ucwords($makeSentense);
    }
    //return all nationalities
    public static function nationalities(){
            $nationals = array(
                'Afghan',
                'Albanian',
                'Algerian',
                'American',
                'Andorran',
                'Angolan',
                'Antiguans',
                'Argentinean',
                'Armenian',
                'Australian',
                'Austrian',
                'Azerbaijani',
                'Bahamian',
                'Bahraini',
                'Bangladeshi',
                'Barbadian',
                'Barbudans',
                'Batswana',
                'Belarusian',
                'Belgian',
                'Belizean',
                'Beninese',
                'Bhutanese',
                'Bolivian',
                'Bosnian',
                'Brazilian',
                'British',
                'Bruneian',
                'Bulgarian',
                'Burkinabe',
                'Burmese',
                'Burundian',
                'Cambodian',
                'Cameroonian',
                'Canadian',
                'Cape Verdean',
                'Central African',
                'Chadian',
                'Chilean',
                'Chinese',
                'Colombian',
                'Comoran',
                'Congolese',
                'Costa Rican',
                'Croatian',
                'Cuban',
                'Cypriot',
                'Czech',
                'Danish',
                'Djibouti',
                'Dominican',
                'Dutch',
                'East Timorese',
                'Ecuadorean',
                'Egyptian',
                'Emirian',
                'Equatorial Guinean',
                'Eritrean',
                'Estonian',
                'Ethiopian',
                'Fijian',
                'Filipino',
                'Finnish',
                'French',
                'Gabonese',
                'Gambian',
                'Georgian',
                'German',
                'Ghanaian',
                'Greek',
                'Grenadian',
                'Guatemalan',
                'Guinea-Bissauan',
                'Guinean',
                'Guyanese',
                'Haitian',
                'Herzegovinian',
                'Honduran',
                'Hungarian',
                'I-Kiribati',
                'Icelander',
                'Indian',
                'Indonesian',
                'Iranian',
                'Iraqi',
                'Irish',
                'Israeli',
                'Italian',
                'Ivorian',
                'Jamaican',
                'Japanese',
                'Jordanian',
                'Kazakhstani',
                'Kenyan',
                'Kittian and Nevisian',
                'Kuwaiti',
                'Kyrgyz',
                'Laotian',
                'Latvian',
                'Lebanese',
                'Liberian',
                'Libyan',
                'Liechtensteiner',
                'Lithuanian',
                'Luxembourger',
                'Macedonian',
                'Malagasy',
                'Malawian',
                'Malaysian',
                'Maldivan',
                'Malian',
                'Maltese',
                'Marshallese',
                'Mauritanian',
                'Mauritian',
                'Mexican',
                'Micronesian',
                'Moldovan',
                'Monacan',
                'Mongolian',
                'Moroccan',
                'Mosotho',
                'Motswana',
                'Mozambican',
                'Namibian',
                'Nauruan',
                'Nepali',
                'New Zealander',
                'Nicaraguan',
                'Nigerian',
                'Nigerien',
                'North Korean',
                'Northern Irish',
                'Norwegian',
                'Omani',
                'Pakistani',
                'Palauan',
                'Panamanian',
                'Papua New Guinean',
                'Paraguayan',
                'Peruvian',
                'Polish',
                'Portuguese',
                'Qatari',
                'Romanian',
                'Russian',
                'Rwandan',
                'Saint Lucian',
                'Salvadoran',
                'Samoan',
                'San Marinese',
                'Sao Tomean',
                'Saudi',
                'Scottish',
                'Senegalese',
                'Serbian',
                'Seychellois',
                'Sierra Leonean',
                'Singaporean',
                'Slovakian',
                'Slovenian',
                'Solomon Islander',
                'Somali',
                'South African',
                'South Korean',
                'Spanish',
                'Sri Lankan',
                'Sudanese',
                'Surinamer',
                'Swazi',
                'Swedish',
                'Swiss',
                'Syrian',
                'Taiwanese',
                'Tajik',
                'Tanzanian',
                'Thai',
                'Togolese',
                'Tongan',
                'Trinidadian/Tobagonian',
                'Tunisian',
                'Turkish',
                'Tuvaluan',
                'Ugandan',
                'Ukrainian',
                'Uruguayan',
                'Uzbekistani',
                'Venezuelan',
                'Vietnamese',
                'Welsh',
                'Yemenite',
                'Zambian',
                'Zimbabwean'
        );
        return $nationals;
    }
    public static function get_user_role(){
        $roles = [
            array(
                'id'=>1,
                'key'=>'counselor',
                'val'=>'Counselor',
            ),
            array(
                'id'=>2,
                'key'=>'branchManager',
                'val'=>'Branch Manager',
            ),
            array(
                'id'=>3,
                'key'=>'frontOfficer',
                'val'=>'Front Officer',
            ),
            array(
                'id'=>4,
                'key'=>'superAdmin',
                'val'=>'Super Admin',
            ),
        ];
        return $roles;
    }
    //get company country
    public static function get_company_country(){
        $country = array(
            'United Kingdom',
            'United States',
            'Australia',
            'Canada',
            'Bangladesh',
            'Dubai',
        );
        return $country;
    }
    //get country list
    public static function countries(){
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        return $countries;
    }
    //get total roles
    public static function get_roles(){
        $roles = [
            array(
                'key'=>'admin',
                'val'=>'Super Admin',
            ),
            array(
                'key'=>'adminManager',
                'val'=>'Admission Manager',
            ),
            array(
                'key'=>'teacher',
                'val'=>'Teacher',
            ),
            
        ];
        return $roles;
    }
    //priority list 
    public static function priority(){
        $list = array(
            'Low',
            'Medium',
            'High',
        );
        return $list;
    }
    public static function task_status(){
        $status = [
            array(
                'id'=>0,
                'val'=>'Pending'
            ),
            array(
                'id'=>1,
                'val'=>'Ongoing'
            ),
            array(
                'id'=>2,
                'val'=>'Progress'
            ),
            array(
                'id'=>3,
                'val'=>'Complete'
            ),
            array(
                'id'=>4,
                'val'=>'Cancel'
            ),
        ];
        return $status;
    }
}
