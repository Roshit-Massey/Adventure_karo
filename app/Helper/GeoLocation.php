<?php

namespace App\Helper;

use Location;
use Illuminate\Http\Request;
use Exception;

/**
 *  
 */
class GeoLocation 
{
	const CALLING_CODES_MAP = ['BD'=>'880','BE'=>'32','BF'=>'226','BG'=>'359','BA'=>'387','BB'=>'1','WF'=>'681','BL'=>'590','BM'=>'1','BN'=>'673','BO'=>'591','BH'=>'973','BI'=>'257','BJ'=>'229','BT'=>'975','JM'=>'1','BW'=>'267','WS'=>'685','BR'=>'55','BS'=>'1','JE'=>'44','BY'=>'375','BZ'=>'501','TN'=>'216','RW'=>'250','RS'=>'381','TL'=>'670','RE'=>'262','TM'=>'993','TJ'=>'992','RO'=>'40','TK'=>'690','GW'=>'245','GU'=>'1','GT'=>'502','GS'=>'500','GR'=>'30','GQ'=>'240','GP'=>'590','JP'=>'81','GY'=>'595','GG'=>'44','GF'=>'594','GE'=>'995','GD'=>'1','GB'=>'44','GA'=>'241','GN'=>'224','GM'=>'220','GL'=>'299','GI'=>'350','GH'=>'233','OM'=>'968','JO'=>'962','HR'=>'385','HT'=>'509','HU'=>'36','HK'=>'852','HN'=>'504','VE'=>'58','PR'=>'1','PS'=>'970','PW'=>'680','PT'=>'351','KN'=>'1','PY'=>'595','IQ'=>'964','PA'=>'507','PF'=>'689','PG'=>'675','PE'=>'51','PK'=>'92','PH'=>'63','PN'=>'872','PL'=>'48','PM'=>'508','ZM'=>'260','RU'=>'7','EE'=>'372','EG'=>'20','ZA'=>'27','EC'=>'593','IT'=>'39','VN'=>'84','SB'=>'677','ET'=>'251','SO'=>'252','ZW'=>'263','SA'=>'966','ES'=>'34','ER'=>'291','ME'=>'382','MD'=>'373','MG'=>'261','MF'=>'590','MA'=>'212','MC'=>'377','UZ'=>'998','MM'=>'95','ML'=>'223','MO'=>'853','MN'=>'976','MH'=>'692','US'=>'1','MU'=>'230','MT'=>'356','MW'=>'265','MV'=>'960','MQ'=>'596','MP'=>'1','MS'=>'1','MR'=>'222','IM'=>'44','UG'=>'256','MY'=>'60','MX'=>'52','AT'=>'43','FR'=>'33','AW'=>'297','SH'=>'290','SJ'=>'47','FI'=>'358','FJ'=>'679','FK'=>'500','FM'=>'691','FO'=>'298','NI'=>'505','NL'=>'31','NO'=>'47','NA'=>'264','VU'=>'678','NC'=>'687','NE'=>'227','NF'=>'672','NG'=>'234','NZ'=>'64','NP'=>'977','NR'=>'674','NU'=>'683','CK'=>'682','CI'=>'225','CH'=>'41','CO'=>'57','CN'=>'86','CM'=>'237','CL'=>'56','CC'=>'61','CA'=>'1','CG'=>'242','CF'=>'236','CD'=>'243','CZ'=>'420','CY'=>'537','CX'=>'61','CR'=>'506','CV'=>'238','CU'=>'53','SZ'=>'268','SY'=>'963','KG'=>'996','KE'=>'254','SR'=>'597','KI'=>'686','KH'=>'855','SV'=>'503','KM'=>'269','ST'=>'239','SK'=>'421','KR'=>'82','SI'=>'386','KP'=>'850','KW'=>'965','SN'=>'221','SM'=>'378','SL'=>'232','SC'=>'248','KZ'=>'77','KY'=>'345','SG'=>'65','SE'=>'46','SD'=>'249','DO'=>'1','DM'=>'1','DJ'=>'253','DK'=>'45','VG'=>'284','DE'=>'49','YE'=>'967','DZ'=>'213','MK'=>'389','UY'=>'598','YT'=>'262','LB'=>'961','LC'=>'1','LA'=>'856','TV'=>'688','TW'=>'886','TT'=>'1','TR'=>'90','LK'=>'94','LI'=>'423','LV'=>'371','TO'=>'676','LT'=>'370','LU'=>'352','LR'=>'231','LS'=>'266','TH'=>'66','TG'=>'228','TD'=>'235','TC'=>'1','LY'=>'218','VA'=>'379','VC'=>'1','AE'=>'971','AD'=>'376','AG'=>'1','AF'=>'93','AI'=>'1','VI'=>'340','IS'=>'354','IR'=>'98','AM'=>'374','AL'=>'355','AO'=>'244','AN'=>'599','AS'=>'1','AR'=>'54','AU'=>'61','IL'=>'972','IO'=>'246','IN'=>'91','TZ'=>'255','AZ'=>'994','IE'=>'353','ID'=>'62','UA'=>'380','QA'=>'974','MZ'=>'258'];

	const COUNTRY_NAME_MAP = ["BD"=>"Bangladesh","BE"=>"Belgium","BF"=>"Burkina Faso","BG"=>"Bulgaria","BA"=>"Bosnia and Herzegovina","BB"=>"Barbados","WF"=>"Wallis and Futuna","BL"=>"Saint Barthelemy","BM"=>"Bermuda","BN"=>"Brunei Darussalam","BO"=>"Bolivia, Plurinational State of","BH"=>"Bahrain","BI"=>"Burundi","BJ"=>"Benin","BT"=>"Bhutan","JM"=>"Jamaica","BV"=>"Bouvet Island","BW"=>"Botswana","WS"=>"Samoa","BQ"=>"Bonaire, Sint Eustatius and Saba","BR"=>"Brazil","BS"=>"Bahamas","JE"=>"Jersey","BY"=>"Belarus","BZ"=>"Belize","RU"=>"Russian Federation","RW"=>"Rwanda","RS"=>"Serbia","TL"=>"Timor-Leste","RE"=>"Reunion","TM"=>"Turkmenistan","TJ"=>"Tajikistan","RO"=>"Romania","TK"=>"Tokelau","GW"=>"Guinea-Bissau","GU"=>"Guam","GT"=>"Guatemala","GS"=>"South Georgia and the South Sandwich Islands","GR"=>"Greece","GQ"=>"Equatorial Guinea","GP"=>"Guadeloupe","JP"=>"Japan","GY"=>"Guyana","GG"=>"Guernsey","GF"=>"French Guiana","GE"=>"Georgia","GD"=>"Grenada","GB"=>"United Kingdom","GA"=>"Gabon","GN"=>"Guinea","GM"=>"Gambia","GL"=>"Greenland","GI"=>"Gibraltar","GH"=>"Ghana","OM"=>"Oman","TN"=>"Tunisia","JO"=>"Jordan","HR"=>"Croatia","HT"=>"Haiti","HU"=>"Hungary","HK"=>"Hong Kong","HN"=>"Honduras","HM"=>"Heard Island and McDonald Islands","VE"=>"Venezuela, Bolivarian Republic of","PR"=>"Puerto Rico","PS"=>"Palestine, State of","PW"=>"Palau","PT"=>"Portugal","KN"=>"Saint Kitts and Nevis","PY"=>"Paraguay","IQ"=>"Iraq","PA"=>"Panama","PF"=>"French Polynesia","PG"=>"Papua New Guinea","PE"=>"Peru","PK"=>"Pakistan","PH"=>"Philippines","PN"=>"Pitcairn","PL"=>"Poland","PM"=>"Saint Pierre and Miquelon","ZM"=>"Zambia","EH"=>"Western Sahara","EE"=>"Estonia","EG"=>"Egypt","ZA"=>"South Africa","EC"=>"Ecuador","IT"=>"Italy","VN"=>"Viet Nam","SB"=>"Solomon Islands","ET"=>"Ethiopia","SO"=>"Somalia","ZW"=>"Zimbabwe","SA"=>"Saudi Arabia","ES"=>"Spain","ER"=>"Eritrea","ME"=>"Montenegro","MD"=>"Moldova, Republic of","MG"=>"Madagascar","MF"=>"Saint Martin (French part)","MA"=>"Morocco","MC"=>"Monaco","UZ"=>"Uzbekistan","MM"=>"Myanmar","ML"=>"Mali","MO"=>"Macao","MN"=>"Mongolia","MH"=>"Marshall Islands","MK"=>"Macedonia, the Former Yugoslav Republic of","MU"=>"Mauritius","MT"=>"Malta","MW"=>"Malawi","MV"=>"Maldives","MQ"=>"Martinique","MP"=>"Northern Mariana Islands","MS"=>"Montserrat","MR"=>"Mauritania","IM"=>"Isle of Man","UG"=>"Uganda","TZ"=>"Tanzania, United Republic of","MY"=>"Malaysia","MX"=>"Mexico","IL"=>"Israel","FR"=>"France","AW"=>"Aruba","SH"=>"Saint Helena, Ascension and Tristan da Cunha","SJ"=>"Svalbard and Jan Mayen","FI"=>"Finland","FJ"=>"Fiji","FK"=>"Falkland Islands (Malvinas)","FM"=>"Micronesia, Federated States of","FO"=>"Faroe Islands","NI"=>"Nicaragua","NL"=>"Netherlands","NO"=>"Norway","NA"=>"Namibia","VU"=>"Vanuatu","NC"=>"New Caledonia","NE"=>"Niger","NF"=>"Norfolk Island","NG"=>"Nigeria","NZ"=>"New Zealand","NP"=>"Nepal","NR"=>"Nauru","NU"=>"Niue","CK"=>"Cook Islands","CI"=>"Cote d\'Ivoire","CH"=>"Switzerland","CO"=>"Colombia","CN"=>"China","CM"=>"Cameroon","CL"=>"Chile","CC"=>"Cocos (Keeling) Islands","CA"=>"Canada","CG"=>"Congo","CF"=>"Central African Republic","CD"=>"Congo, the Democratic Republic of the","CZ"=>"Czech Republic","CY"=>"Cyprus","CX"=>"Christmas Island","CR"=>"Costa Rica","CW"=>"Curacao","CV"=>"Cape Verde","CU"=>"Cuba","SZ"=>"Swaziland","SY"=>"Syrian Arab Republic","SX"=>"Sint Maarten (Dutch part)","KG"=>"Kyrgyzstan","KE"=>"Kenya","SS"=>"South Sudan","SR"=>"Suriname","KI"=>"Kiribati","KH"=>"Cambodia","SV"=>"El Salvador","KM"=>"Comoros","ST"=>"Sao Tome and Principe","SK"=>"Slovakia","KR"=>"Korea, Republic of","SI"=>"Slovenia","KP"=>"Korea, Democratic People\'s Republic of","KW"=>"Kuwait","SN"=>"Senegal","SM"=>"San Marino","SL"=>"Sierra Leone","SC"=>"Seychelles","KZ"=>"Kazakhstan","KY"=>"Cayman Islands","SG"=>"Singapore","SE"=>"Sweden","SD"=>"Sudan","DO"=>"Dominican Republic","DM"=>"Dominica","DJ"=>"Djibouti","DK"=>"Denmark","VG"=>"Virgin Islands, British","DE"=>"Germany","YE"=>"Yemen","DZ"=>"Algeria","US"=>"United States","UY"=>"Uruguay","YT"=>"Mayotte","UM"=>"United States Minor Outlying Islands","LB"=>"Lebanon","LC"=>"Saint Lucia","LA"=>"Lao People\'s Democratic Republic","TV"=>"Tuvalu","TW"=>"Taiwan, Province of China","TT"=>"Trinidad and Tobago","TR"=>"Turkey","LK"=>"Sri Lanka","LI"=>"Liechtenstein","LV"=>"Latvia","TO"=>"Tonga","LT"=>"Lithuania","LU"=>"Luxembourg","LR"=>"Liberia","LS"=>"Lesotho","TH"=>"Thailand","TF"=>"French Southern Territories","TG"=>"Togo","TD"=>"Chad","TC"=>"Turks and Caicos Islands","LY"=>"Libya","VA"=>"Holy See (Vatican City State)","VC"=>"Saint Vincent and the Grenadines","AE"=>"United Arab Emirates","AD"=>"Andorra","AG"=>"Antigua and Barbuda","AF"=>"Afghanistan","AI"=>"Anguilla","VI"=>"Virgin Islands, U.S.","IS"=>"Iceland","IR"=>"Iran, Islamic Republic of","AM"=>"Armenia","AL"=>"Albania","AO"=>"Angola","AQ"=>"Antarctica","AS"=>"American Samoa","AR"=>"Argentina","AU"=>"Australia","AT"=>"Austria","IO"=>"British Indian Ocean Territory","IN"=>"India","AX"=>"Aland Islands","AZ"=>"Azerbaijan","IE"=>"Ireland","ID"=>"Indonesia","UA"=>"Ukraine","QA"=>"Qatar","MZ"=>"Mozambique"];

	const COUNTRY_TO_CODE=["Bangladesh"=>"BD","Belgium"=>"BE","Burkina Faso"=>"BF","Bulgaria"=>"BG","Bosnia and Herzegovina"=>"BA","Barbados"=>"BB","Wallis and Futuna"=>"WF","Saint Barthelemy"=>"BL","Bermuda"=>"BM","Brunei Darussalam"=>"BN","Bolivia, Plurinational State of"=>"BO","Bahrain"=>"BH","Burundi"=>"BI","Benin"=>"BJ","Bhutan"=>"BT","Jamaica"=>"JM","Bouvet Island"=>"BV","Botswana"=>"BW","Samoa"=>"WS","Bonaire, Sint Eustatius and Saba"=>"BQ","Brazil"=>"BR","Bahamas"=>"BS","Jersey"=>"JE","Belarus"=>"BY","Belize"=>"BZ","Russian Federation"=>"RU","Rwanda"=>"RW","Serbia"=>"RS","Timor-Leste"=>"TL","Reunion"=>"RE","Turkmenistan"=>"TM","Tajikistan"=>"TJ","Romania"=>"RO","Tokelau"=>"TK","Guinea-Bissau"=>"GW","Guam"=>"GU","Guatemala"=>"GT","South Georgia and the South Sandwich Islands"=>"GS","Greece"=>"GR","Equatorial Guinea"=>"GQ","Guadeloupe"=>"GP","Japan"=>"JP","Guyana"=>"GY","Guernsey"=>"GG","French Guiana"=>"GF","Georgia"=>"GE","Grenada"=>"GD","United Kingdom"=>"GB","Gabon"=>"GA","Guinea"=>"GN","Gambia"=>"GM","Greenland"=>"GL","Gibraltar"=>"GI","Ghana"=>"GH","Oman"=>"OM","Tunisia"=>"TN","Jordan"=>"JO","Croatia"=>"HR","Haiti"=>"HT","Hungary"=>"HU","Hong Kong"=>"HK","Honduras"=>"HN","Heard Island and McDonald Islands"=>"HM","Venezuela, Bolivarian Republic of"=>"VE","Puerto Rico"=>"PR","Palestine, State of"=>"PS","Palau"=>"PW","Portugal"=>"PT","Saint Kitts and Nevis"=>"KN","Paraguay"=>"PY","Iraq"=>"IQ","Panama"=>"PA","French Polynesia"=>"PF","Papua New Guinea"=>"PG","Peru"=>"PE","Pakistan"=>"PK","Philippines"=>"PH","Pitcairn"=>"PN","Poland"=>"PL","Saint Pierre and Miquelon"=>"PM","Zambia"=>"ZM","Western Sahara"=>"EH","Estonia"=>"EE","Egypt"=>"EG","South Africa"=>"ZA","Ecuador"=>"EC","Italy"=>"IT","Viet Nam"=>"VN","Solomon Islands"=>"SB","Ethiopia"=>"ET","Somalia"=>"SO","Zimbabwe"=>"ZW","Saudi Arabia"=>"SA","Spain"=>"ES","Eritrea"=>"ER","Montenegro"=>"ME","Moldova, Republic of"=>"MD","Madagascar"=>"MG","Saint Martin (French part)"=>"MF","Morocco"=>"MA","Monaco"=>"MC","Uzbekistan"=>"UZ","Myanmar"=>"MM","Mali"=>"ML","Macao"=>"MO","Mongolia"=>"MN","Marshall Islands"=>"MH","Macedonia, the Former Yugoslav Republic of"=>"MK","Mauritius"=>"MU","Malta"=>"MT","Malawi"=>"MW","Maldives"=>"MV","Martinique"=>"MQ","Northern Mariana Islands"=>"MP","Montserrat"=>"MS","Mauritania"=>"MR","Isle of Man"=>"IM","Uganda"=>"UG","Tanzania, United Republic of"=>"TZ","Malaysia"=>"MY","Mexico"=>"MX","Israel"=>"IL","France"=>"FR","Aruba"=>"AW","Saint Helena, Ascension and Tristan da Cunha"=>"SH","Svalbard and Jan Mayen"=>"SJ","Finland"=>"FI","Fiji"=>"FJ","Falkland Islands (Malvinas)"=>"FK","Micronesia, Federated States of"=>"FM","Faroe Islands"=>"FO","Nicaragua"=>"NI","Netherlands"=>"NL","Norway"=>"NO","Namibia"=>"NA","Vanuatu"=>"VU","New Caledonia"=>"NC","Niger"=>"NE","Norfolk Island"=>"NF","Nigeria"=>"NG","New Zealand"=>"NZ","Nepal"=>"NP","Nauru"=>"NR","Niue"=>"NU","Cook Islands"=>"CK","Cote d\'Ivoire"=>"CI","Switzerland"=>"CH","Colombia"=>"CO","China"=>"CN","Cameroon"=>"CM","Chile"=>"CL","Cocos (Keeling) Islands"=>"CC","Canada"=>"CA","Congo"=>"CG","Central African Republic"=>"CF","Congo, the Democratic Republic of the"=>"CD","Czech Republic"=>"CZ","Cyprus"=>"CY","Christmas Island"=>"CX","Costa Rica"=>"CR","Curacao"=>"CW","Cape Verde"=>"CV","Cuba"=>"CU","Swaziland"=>"SZ","Syrian Arab Republic"=>"SY","Sint Maarten (Dutch part)"=>"SX","Kyrgyzstan"=>"KG","Kenya"=>"KE","South Sudan"=>"SS","Suriname"=>"SR","Kiribati"=>"KI","Cambodia"=>"KH","El Salvador"=>"SV","Comoros"=>"KM","Sao Tome and Principe"=>"ST","Slovakia"=>"SK","Korea, Republic of"=>"KR","Slovenia"=>"SI","Korea, Democratic People\'s Republic of"=>"KP","Kuwait"=>"KW","Senegal"=>"SN","San Marino"=>"SM","Sierra Leone"=>"SL","Seychelles"=>"SC","Kazakhstan"=>"KZ","Cayman Islands"=>"KY","Singapore"=>"SG","Sweden"=>"SE","Sudan"=>"SD","Dominican Republic"=>"DO","Dominica"=>"DM","Djibouti"=>"DJ","Denmark"=>"DK","Virgin Islands, British"=>"VG","Germany"=>"DE","Yemen"=>"YE","Algeria"=>"DZ","United States"=>"US","Uruguay"=>"UY","Mayotte"=>"YT","United States Minor Outlying Islands"=>"UM","Lebanon"=>"LB","Saint Lucia"=>"LC","Lao People\'s Democratic Republic"=>"LA","Tuvalu"=>"TV","Taiwan, Province of China"=>"TW","Trinidad and Tobago"=>"TT","Turkey"=>"TR","Sri Lanka"=>"LK","Liechtenstein"=>"LI","Latvia"=>"LV","Tonga"=>"TO","Lithuania"=>"LT","Luxembourg"=>"LU","Liberia"=>"LR","Lesotho"=>"LS","Thailand"=>"TH","French Southern Territories"=>"TF","Togo"=>"TG","Chad"=>"TD","Turks and Caicos Islands"=>"TC","Libya"=>"LY","Holy See (Vatican City State)"=>"VA","Saint Vincent and the Grenadines"=>"VC","United Arab Emirates"=>"AE","Andorra"=>"AD","Antigua and Barbuda"=>"AG","Afghanistan"=>"AF","Anguilla"=>"AI","Virgin Islands, U.S."=>"VI","Iceland"=>"IS","Iran, Islamic Republic of"=>"IR","Armenia"=>"AM","Albania"=>"AL","Angola"=>"AO","Antarctica"=>"AQ","American Samoa"=>"AS","Argentina"=>"AR","Australia"=>"AU","Austria"=>"AT","British Indian Ocean Territory"=>"IO","India"=>"IN","Aland Islands"=>"AX","Azerbaijan"=>"AZ","Ireland"=>"IE","Indonesia"=>"ID","Ukraine"=>"UA","Qatar"=>"QA","Mozambique"=>"MZ"];

	public static function findLocation($ip)
	{
		// $endpoint = "http://api.ipstack.com/{$ip}?access_key=".env('IP_STACK_ACCESS_KEY');
		$endpoint = "https://ipinfo.io/{$ip}?token=".env('IP_INFO_ACCESS_KEY');
		$client = new \GuzzleHttp\Client();
		$response = $client->request('GET', $endpoint);
		$statusCode = $response->getStatusCode();
		$content = $response->getBody();
		$content = json_decode($content, true);
		if($statusCode == 200 && $content && (isset($content['country_code']) || $content['country']) != null){
			return (isset($content['country_code']) ? $content['country_code'] : $content['country'] );
		}else{
			\Log::info('IP STACK IS NOT WORKING.');
			return 'IN';
		}
	}

	public static function location()
	{
		try {
			if(isset($_COOKIE['C0uin-tryC0cle'])){
				return $_COOKIE['C0uin-tryC0cle'];
			}else {
				$ip = \Request::getclientip();
				return self::findLocation($ip);
			}
	    } catch (\Exception $e) {
	    	return 'IN';
	    }
	}

	public static function isIndia() {
		return GeoLocation::location()=='IN' ? true : false;
	}

	public static function getCallingCode(){
		return self::CALLING_CODES_MAP[self::location()];
	}

	public static function getOnlyCode($code){
		return '+'.self::CALLING_CODES_MAP[$code];
	}

	public static function getCountryName(){
		return self::COUNTRY_NAME_MAP[self::location()];
	}

	public static function getCountryCode($country){
		return self::COUNTRY_TO_CODE[$country];
	}

	public static function getCountryNameByCode($country_code){
		return self::COUNTRY_NAME_MAP[$country_code];
    }
    
    public static function getIp(){
        $ip = \Request::getclientip();
        return $ip ? $ip : \Request::ip();
    }
    
    public static function getDetailsUsingIp($ip){
        return \Location::get($ip);
	}
}