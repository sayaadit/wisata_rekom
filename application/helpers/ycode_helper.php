<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**  	
		API Function For Any Purpose Version 1.10
		YCode = Yusza Code Helper
		
		Author 			: Yusza Redityamurti
		Date Created 	: 11 Februari 2015
		Last Edited		: 11 Februari 2015
**/	

//convert string to url friendly
function y_urlf($string) 
{
	//Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
	$string = strtolower($string);
	//Strip any unwanted characters
	$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
	//Clean multiple dashes or whitespaces
	$string = preg_replace("/[\s-]+/", " ", $string);
	//Convert whitespaces and underscore to dash
	$string = preg_replace("/[\s_]/", "-", $string);
	
	return $string;
}

//convert date to another format
function y_convert_date($date, $format='d-m-Y') 
{
	if(empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') 
		return '';
	else
		return date($format, strtotime($date));
}

//convert date to text
function y_date_text($date) 
{
	$date1 	= date('d-m-Y', strtotime($date));
	$exp	= explode('-', $date1);
	
	return $exp[0].' '.y_get_month($exp[1]).' '.$exp[2];
}

//convert date to text
function y_datetime_text($date) 
{
	$date1 	= date('d-m-Y H:i:s', strtotime($date));
	$exp1	= explode(' ', $date1);
	$exp2	= explode('-', $exp1[0]);
	
	return $exp2[0].' '.y_get_month($exp2[1]).' '.$exp2[2].' '.$exp1[1];
}

//time left from two dates
function y_timeleft($date1, $date2) 
{
	$ndate1 = new DateTime($date1);
	$ndate2 = new DateTime($date2);
	
	$diff = $ndate2->diff($ndate1);
	
	return $diff->format('%a Hari, %h Jam');
}

//ellipsis
function y_ellipsis($str, $length='200')
{
	$str = strip_tags(trim($str));
	
	// If the text is already shorter than the max length, then just return unedited text.
	if (strlen($str) <= $length) {
		return $str;
	}
	
	// Find the last space (between words we're assuming) after the max length.
	$last_space = strrpos(substr($str, 0, $length), ' ');
	// Trim
	$trimmed_text = substr($str, 0, $last_space);
	// Add ellipsis.
	//$trimmed_text .= ' ...';
	
	return ucfirst($trimmed_text);
}

function y_get_month($id, $type='full')
{
	if($type == 'full')
		$months = y_month_list();
	else if ($type == 'tri')
		$months = y_month_list_3();
					 
	if (isset ($months[(int) $id]))
		return $months[(int) $id];
	else
		return '';                         
}

function y_month_list()
{
	$months = array( '1' => 'Januari',
					 '2' => 'Februari',
					 '3' => 'Maret',
					 '4' => 'April',
					 '5' => 'Mei',
					 '6' => 'Juni',
					 '7' => 'Juli',
					 '8' => 'Agustus',
					 '9' => 'September',
					 '10' => 'Oktober',
					 '11' => 'November',
					 '12' => 'Desember');
					 
	return $months;                         
}

function y_month_list_3()
{
	$months = array( '1' => 'Jan',
					 '2' => 'Feb',
					 '3' => 'Mar',
					 '4' => 'Apr',
					 '5' => 'Mei',
					 '6' => 'Juni',
					 '7' => 'Juli',
					 '8' => 'Ags',
					 '9' => 'Sep',
					 '10' => 'Okt',
					 '11' => 'Nov',
					 '12' => 'Des');
					 
	return $months;                         
}

function y_pad($int, $pad) 
{
	return str_pad($int, $pad, '0', STR_PAD_LEFT);
}

function y_num_pad($number, $symbol=',')
{
	return number_format(round($number, 0), 0, '.', $symbol);
}

function y_num_idr($number)
{
	return 'Rp. '.y_num_pad($number, '.');
}

function currency_format($number)
{
	return ''.number_format($number,0,',','.');
}

function y_form_radio($name = '', $options = array(), $selected = '', $extra = '', $prefix = '', $sufix = '')
{
	if(empty($selected))
	{
		reset($options);
		$selected = key($options);
	}

	if ($extra != '') $extra = ' '.$extra;
	
	$form = '';
	
	foreach ($options as $key => $val)
	{
		$key = (string) $key;
		$sel = (strtolower($key) == strtolower($selected)) ? ' checked="checked"' : '';
		
		if(!empty($prefix)) $form .= $prefix.' ';
		
		$form .= '<input type="radio" name="'.$name.'" value="'.$key.'"'.$extra.$sel.'> '.$val.' ';
		
		if(!empty($sufix)) $form .= ' '.$sufix.' ';
	}

	return $form;
}

//get url admin
function y_url_admin()
{
	$CI =& get_instance();
	return $CI->config->item('admin_url');
}
	
//is login ?
function y_is_login()
{
	$CI =& get_instance();
	if (!$CI->session->userdata('login')) redirect(y_url_admin().'/login');
}
	
//get info login
function y_info_login()
{
	$CI =& get_instance();
	if ($CI->session->userdata('login')) 
		return $CI->session->userdata('info_login');
	else
		redirect(y_url_admin().'/login');
}
	
//get level login
function y_level_login()
{
	$CI =& get_instance();
	if ($CI->session->userdata('login')) 
		return $CI->session->userdata('level_login');
	else
		redirect(y_url_admin().'/login');
}
	
//get element info login
function y_item_login($item)
{
	$CI =& get_instance();
	if ($CI->session->userdata('login')) 
	{
		$info = $CI->session->userdata('info_login');
		return (isset($info->$item)) ? $info->$item : '';
	}
	else redirect(y_url_admin().'/login');
}

//Embed js and cache them
function y_embed_js($file)
{
	$CI =& get_instance();
	$path1 = realpath(APPPATH);
	$path2 = realpath(APPPATH.'../');
	$js		= $path1.'/views/front/'.$file.'/_'.$file.'.js';
	$cache	= $path2.'/assets/front/js/cache/'.$file.'.min.js';
	
	if(file_exists($js))
	{
		if(file_exists($cache))
		{
			if(filemtime($cache) < filemtime($js))
			{
				$CI->load->library('jsmin');	
				$text 		= file_get_contents($js);
				$text_cache = $CI->jsmin->minify($text);
				
				file_put_contents($cache, $text_cache);
			}
		}
		else
		{
			$CI->load->library('jsmin');	
			$CI->load->helper('file');
			$text 		= file_get_contents($js);
			$text_cache = $CI->jsmin->minify($text);
			
			file_put_contents($cache, $text_cache);
		}
	
		return 'assets/front/js/cache/'.$file.'.min.js';
	}
	else
	{
		return '';	
	}
}

function y_num_text($number)
{
	$number = str_replace('.', '', $number);
	if ( ! is_numeric($number)) return $number;
	$base    = array('nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan');
	$numeric = array('1000000000000000', '1000000000000', '1000000000000', 1000000000, 1000000, 1000, 100, 10, 1);
	$unit    = array('kuadriliun', 'triliun', 'biliun', 'milyar', 'juta', 'ribu', 'ratus', 'puluh', '');
	$str     = null;
	$i = 0;
	if ($number == 0)
	{
		$str = 'nol';
	}
	else
	{
		while ($number != 0)
		{
			$count = (int)($number / $numeric[$i]);
			if ($count >= 10)
			{
				$str .= y_num_text($count) . ' ' . $unit[$i] . ' ';
			}
			elseif ($count > 0 && $count < 10)
			{
				$str .= $base[$count] . ' ' . $unit[$i] . ' ';
			}
			$number -= $numeric[$i] * $count;
			$i++;
		}
		$str = preg_replace('/satu puluh (\w+)/i', '\1 belas', $str);
		$str = preg_replace('/satu (ribu|ratus|puluh|belas)/', 'se\1', $str);
		$str = preg_replace('/\s{2,}/', ' ', trim($str));
	}
	return $str;	
}

function y_greeting($lang='id', $suffix='no')
{
	$h 		= date('H');
	$return = '';
	if($suffix) $return .= ($lang == 'id') ? 'Selamat ' : 'Good ';
	
	if($h > 0 && $h <= 12)
		$return .= ($lang == 'id') ? 'Pagi' : 'Morning';
	if($h > 12 && $h <= 17)
		$return .= ($lang == 'id') ? 'Siang' : 'Afternoon';
	if($h > 17 && $h <= 20)
		$return .= ($lang == 'id') ? 'Sore' : 'Evening';
	if($h > 20 && $h <= 24)
		$return .= ($lang == 'id') ? 'Malam' : 'Night';
		
	echo $return;
}

function y_url_cat($id, $url)
{
	return base_url().'category/'.$id.'/'.$url;
}

function y_url_read($id, $url)
{
	return base_url().'read/'.$id.'/'.$url;
}

function y_url_gallery($id, $url)
{
	return base_url().'soc/gallery/'.$id.'/'.$url;
}

function y_url_tag($id, $url)
{
	return base_url().'soc/category/'.$id.'/'.$url;
}

function y_image($image_path, $preset='') 
{
	$ci = &get_instance();
	
	// load the allowed image presets
	$sizes = $ci->config->item("thumb");
	
	$pathinfo = pathinfo($image_path);
	
	if(empty($preset) || !isset($sizes[$preset]))
	{
		if(!empty($image_path) && file_exists($image_path))
			$new_path = $image_path;
		else			
			$new_path = 'assets/frontend/images/default/no-images.jpg';
	}
	else 
	{
		if(!empty($image_path))
		{
			$tmp_new = $pathinfo["dirname"] . "/" . $pathinfo["filename"] . "-" . $sizes[$preset]['name'] . "." . $pathinfo["extension"];
			if(file_exists($tmp_new))
				$new_path = $tmp_new;
			else			
				$new_path = 'assets/frontend/images/default/no-images-'.$sizes[$preset]['name'].'.jpg';
		}
		else
			$new_path = 'assets/frontend/images/default/no-images-'.$sizes[$preset]['name'].'.jpg';
	}
	
	return $new_path;
}

function y_weather()
{
	$icons = array(
				"01d" => "clear-sky-d",
				"02d" => "few-clouds-d",
				"03d" => "scattered-clouds-d",
				"04d" => "broken-clouds-d",
				"09d" => "shower-rain-d",
				"10d" => "rain-d",
				"11d" => "thunderstorm-d",
				"13d" => "snow-d",
				"50d" => "mist-d",
				"01n" => "clear-sky-n",
				"02n" => "few-clouds-n",
				"03n" => "scattered-clouds-n",
				"04n" => "broken-clouds-n",
				"09n" => "shower-rain-n",
				"10n" => "rain-n",
				"11n" => "thunderstorm-n",
				"13n" => "snow-n",
				"50n" => "mist-n"
			);
	$h = date('H');
	
	if($h >= 3 && $h <= 18) //awan
		$icon = $icons['02d'];
	else
		$icon = $icons['02n'];
	
	
	return array('icon' => $icon, 'c' => '25');
	
	/*$CI =& get_instance();
	if (!$CI->session->userdata('weather'))
	{
		$txt = file_get_contents('http://api.openweathermap.org/data/2.5/weather?id=1650357&units=metric&appid=9f75d0df865e1f0fe4dacc992452e987');
		$json = json_decode($txt);
		echo 'aa';
		/*echo '<pre>';
		print_r($json);
		echo '</pre>';*
		
		$weather = $json->weather;
		$c = $json->main->temp;
		
		
		
		$data = array('weather' => array('icon' => $icons[$weather[0]->icon], 'c' => $c));
		$CI->session->set_userdata($data);	
	}
	
	return $CI->session->userdata('weather');*/
}

function y_type_images($id)
{
	$array = array(0 => 'unknown',
				   1 => 'gif',
				   2 => 'jpeg',
				   3 => 'png',
				   4 => 'swf',
				   5 => 'psd',
				   6 => 'bmp',
				   7 => 'tiff_ii',
				   8 => 'tiff_mm',
				   9 => 'jpc',
				   10 => 'jp2',
				   11 => 'jpx',
				   12 => 'jb2',
				   13 => 'swc',
				   14 => 'iff',
				   15 => 'wbmp',
				   16 => 'xbm',
				   17 => 'ico',
				   18 => 'count');
				   
	if(isset($array[$id]))
		return $array[$id];
	else
		return '';
}

function y_menu_class($mode)
{
	if($mode == 'mobile')
		return '';
	else
		return 'td-menu-item td-normal-menu';
}

function y_menu_icon($mode)
{
	if($mode == 'mobile')
		return '<i class="td-icon-menu-right td-element-after"></i>';
	else
		return '';
}
?>