<?php

class AK_Captcha_Image extends AK_Captcha_Abstract {//imagettftext
    //private $namespace;
    private $TTF_folder;
    private $minchars = 4;
    private $maxchars = 4;
    private $minsize = 10; //The minimum font size to use
    private $maxsize = 20; //The maximum font size to use
    private $maxrotation = 25; //The maximum degrees a Char should be rotated. Set it to 30 means a random rotation between -30 and 30.
    private $noise = true; //Background noise On/Off (if is FALSE, a grid will be created)
    private $websafecolors = true; //This will only use the 216 websafe color pallette for the image.
    private $debug = false;
    private $counter_filename = 'captcha_counter.txt';
    private $filename_prefix = 'edem_';
    private $collect_garbage_after = 50; //Number of captchas to generate before garbage collection is done
    private $case_sensitive = false;
    private $validchars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    private $lx; //Picture width
    private $ly; //Picture height
    private $jpegquality = 80; //JPEG Image quality
    private $noisefactor = 9;
    private $nb_noise; //Number of backgrond noise characters
    private $TTF_RANGE; //Holds the list of possible fonts
    private $TTF_file; //Holds the currently selected font filename
    private $chars; //Holds the number of characters in the captcha
    private $public_K;
    private $private_K;
    private $public_key;
    private $filename; //Captcha filename
    private $gd_version; //Holds the version number of the GD-Library
    private $r;
    private $g;
    private $b;

    public function __construct() {
        //$this->namespace = $namespace;
        $this->tempfolder = UPLOAD_PATH.'/imgkey/';
        $this->TTF_folder = CAPTCHA_FONTS_DIR.'/';



        // Test for GD-Library(-Version)
        $this->gd_version = $this->get_gd_version();
        if($this->gd_version == 0) die('There is no GD-Library-Support enabled. The b2evo captcha class cannot be used!');
        if($this->debug) echo "\n<br>-b2evo-Captcha-Debug: The available GD-Library has major version ".$this->gd_version;

        // check vars for min-max-chars and min-max-size
        if($this->minchars > $this->maxchars) {
            $temp = $this->minchars;
            $this->minchars = $this->maxchars;
            $this->maxchars = $temp;
            if($this->debug) echo "\n<br>-b2evo-Captcha-Debug: Arrghh! What do you think I mean with min and max? Switch minchars with maxchars.";
        }
        if($this->minsize > $this->maxsize) {
            $temp = $this->minsize;
            $this->minsize = $this->maxsize;
            $this->maxsize = $temp;
            if($this->debug) echo "\n<br>-b2evo-Captcha-Debug: Arrghh! What do you think I mean with min and max? Switch minsize with maxsize.";
        }


        // check TrueTypeFonts
        $this->TTF_RANGE = array('0');
        if ($handle = opendir($this->TTF_folder)) {
            $i=0;
            while (false !== ($file = readdir($handle))) {
            //You could add a regex to this if to make sure the files are all *.ttf
                //if ($file != '.' && $file != '..') {
                if (substr($file,0,1) != '.') {
                    $this->TTF_RANGE[$i]=$file;
                    if($this->debug) echo "\n<br>-b2evo-Captcha-Debug: Found font file (".$file.')';
                } //else print $file."<br>";
            }
            closedir($handle);
        }
        if(is_array($this->TTF_RANGE)) {
            if($this->debug) echo "\n<br>-b2evo-Captcha-Debug: Checking given TrueType-Array! (".count($this->TTF_RANGE).')';
            $temp = array();
            foreach($this->TTF_RANGE as $k=>$v) {
                if(is_readable($this->TTF_folder.$v)) $temp[] = $v;
            }
            $this->TTF_RANGE = $temp;
            if($this->debug) echo "\n<br>-b2evo-Captcha-Debug: Valid TrueType-files: (".count($this->TTF_RANGE).')';
            if(count($this->TTF_RANGE) < 1) die('No Truetype fonts available for the CaptchaClass.');
        }
        else {
            if($this->debug) echo "\n<br>-b2evo-Captcha-Debug: Check given TrueType-File! (".$this->TTF_RANGE.')';
            if(!is_readable($this->TTF_folder.$this->TTF_RANGE)) die('No Truetypefont available for the b2evo captcha class.');
        }

        // select first TrueTypeFont
        $this->change_TTF();
        if($this->debug) echo "\n<br>-b2evo-Captcha-Debug: Set current TrueType-File: (".$this->TTF_file.")";


        // get number of noise-chars for background if is enabled
        $this->nb_noise = $this->noise ? ($this->chars * $this->noisefactor) : 0;
        if($this->debug) echo "\n<br>-b2evo-Captcha-Debug: Set number of noise characters to: (".$this->nb_noise.')';

        // seed the random number generator if less than php 4.2.0
        if( !function_exists('version_compare') || version_compare(phpversion(), '4.2.0', '< ') ) {
            mt_srand((double)microtime()*1000000);
        }

        // specify counter-filename
        if($this->debug) echo "\n<br>-Captcha-Debug: The counterfilename is (".$this->tempfolder.$this->counter_filename.')';

        // retrieve last counter-value
        $test = $this->txt_counter($this->tempfolder.$this->counter_filename);

        // set and retrieve current counter-value
        $counter = $this->txt_counter($this->tempfolder.$this->counter_filename,TRUE);

        // check if counter works correct
        if(($counter !== FALSE) && ($counter - $test == 1)) {
        // Counter works perfect, =:)
            if($this->debug) echo "\n<br>-Captcha-Debug: Current counter-value is ($counter). Garbage-collector should start at (".$this->collect_garbage_after.')';

            // check if garbage-collector should run
            if($counter >= $this->collect_garbage_after) {
            // Reset counter
                if($this->debug) echo "\n<br>-Captcha-Debug: Reset the counter-value. (0)";
                $this->txt_counter($this->tempfolder.$this->counter_filename,TRUE,0);

                // start garbage-collector
                $this->garbage_collector_error = $this->collect_garbage() ? FALSE : TRUE;
                if($this->debug) echo "\n<br>-Captcha-Debug: ERROR! SOME TRASHFILES COULD NOT BE DELETED!";
            }

        }
        else {
        // Counter-ERROR!
            if($this->debug) echo "\n<br>-Captcha-Debug: ERROR! NO COUNTER-VALUE AVAILABLE!";
        }


    }

    public function generateImage() {
        $this->make_captcha();
        if (!isset($public)) $public = $this->public_key;
        if($public=='') $public = $this->public_key;
        
        $result = str_replace($_SERVER['DOCUMENT_ROOT'],'',$this->tempfolder).$this->filename_prefix.$public.'.jpg';
        
        return $result;
    }
    
    public function validate_submit($image,$attempt) {
        $correct_hash = substr($image,-11,7);
        //$correct_hash = substr($image,-36,32);
        if($this->case_sensitive==0) $attempt = strtoupper($attempt);
        if($this->check_captcha($correct_hash,$attempt)) {
            if($this->debug) echo "\n<br>-Captcha-Debug: Validating submitted form returns: (1)";
            return 1;
        }
        else {
            if($this->debug) echo "\n<br>-Captcha-Debug: Validating submitted form returns: (0)";
            return 0;
        }
    }

    private function make_captcha($private_key='') {
        if($private_key=='') $private_key = $this->generate_keypair();
        $this->setKeystring($private_key);
        // set dimension of image
        //$this->lx = 220;
        $this->lx = (strlen($private_key) + 1) * (int)(($this->maxsize + $this->minsize) / 1.5);
        $this->ly = (int)(2.4 * $this->maxsize);

        if($this->debug) echo "\n<br>-b2evo-Captcha-Debug: Set image dimension to: (".$this->lx.' x '.$this->ly.')';
        if($this->debug) echo "\n<br>-Captcha-Debug: Generate private key: ($private_key)";

        // set number of noise-chars for background if is enabled
        $this->nb_noise = $this->noise ? (strlen($private_key) * $this->noisefactor) : 0;
        if($this->debug) echo "\n<br>-b2evo-Captcha-Debug: Set number of noise characters to: (".$this->nb_noise.')';

        // create Image and set the apropriate function depending on GD-Version & websafecolor-value
        if($this->gd_version >= 2 && !$this->websafecolors) {
            $func1 = 'imagecreatetruecolor';
            $func2 = 'imagecolorallocate';
        }
        else {
            $func1 = 'imageCreate';
            $func2 = 'imagecolorclosest';
        }
        $image = $func1($this->lx,$this->ly);
        if($this->debug) echo "\n<br>-Captcha-Debug: Generate ImageStream with: ($func1())";
        if($this->debug) echo "\n<br>-Captcha-Debug: For colordefinitions we use: ($func2())";


        // Set Backgroundcolor
        $this->random_color(224, 255);
        $back =  @imagecolorallocate($image, $this->r, $this->g, $this->b);
        @ImageFilledRectangle($image,0,0,$this->lx,$this->ly,$back);
        if($this->debug) echo "\n<br>-Captcha-Debug: We allocate one color for Background: (".$this->r.'-'.$this->g.'-'.$this->b.')';

        // allocates the 216 websafe color palette to the image
        if($this->gd_version < 2 || $this->websafecolors) $this->makeWebsafeColors($image);


        // fill with noise or grid
        if($this->nb_noise > 0) {
        // random characters in background with random position, angle, color
            if($this->debug) echo "\n<br>-Captcha-Debug: Fill background with noise: (".$this->nb_noise.')';
            for($i=0; $i < $this->nb_noise; $i++) {
                $size	= intval(mt_rand((int)($this->minsize / 2.3), (int)($this->maxsize / 1.7)));
                $angle	= intval(mt_rand(0, 360));
                $x		= intval(mt_rand(0, $this->lx));
                $y		= intval(mt_rand(0, (int)($this->ly - ($size / 5))));
                $this->random_color(160, 224);
                $color	= $func2($image, $this->r, $this->g, $this->b);
                $text	= chr(intval(mt_rand(45,250)));
                //@ImageTTFText($image, $size, $angle, $x, $y, $color, $this->change_TTF(), $text);
                imagefttext($image, $size, $angle, $x, $y, $color, $this->change_TTF(), $text);
            }
        }
        else {
        // generate grid
            if($this->debug) echo "\n<br>-Captcha-Debug: Fill background with x-gridlines: (".(int)($this->lx / (int)($this->minsize / 1.5)).')';
            for($i=0; $i < $this->lx; $i += (int)($this->minsize / 1.5)) {
                $this->random_color(160, 224);
                $color	= $func2($image, $this->r, $this->g, $this->b);
                @imageline($image, $i, 0, $i, $this->ly, $color);
            }
            if($this->debug) echo "\n<br>-Captcha-Debug: Fill background with y-gridlines: (".(int)($this->ly / (int)(($this->minsize / 1.8))).')';
            for($i=0 ; $i < $this->ly; $i += (int)($this->minsize / 1.8)) {
                $this->random_color(160, 224);
                $color	= $func2($image, $this->r, $this->g, $this->b);
                @imageline($image, 0, $i, $this->lx, $i, $color);
            }
        }

        // generate Text
        if($this->debug) echo "\n<br>-Captcha-Debug: Fill forground with chars and shadows: (".$this->chars.')';
        for($i=0, $x = intval(mt_rand($this->minsize,$this->maxsize)); $i < strlen($private_key); $i++) {
            $text	= substr($private_key, $i, 1);
            $angle	= intval(mt_rand(($this->maxrotation * -1), $this->maxrotation));
            $size	= intval(mt_rand($this->minsize, $this->maxsize));
            $y		= intval(mt_rand((int)($size * 1.5), (int)($this->ly - ($size / 7))));
            $this->random_color(0, 127);
            $color	=  $func2($image, $this->r, $this->g, $this->b);
            $this->random_color(0, 127);
            $shadow = $func2($image, $this->r + 127, $this->g + 127, $this->b + 127);


            //@ImageTTFText($image, $size, $angle, $x + (int)($size / 15), $y, $shadow, $this->change_TTF(), $text);
            imagefttext($image, $size, $angle, $x + (int)($size / 15), $y, $shadow, $this->change_TTF(), $text);
            //@ImageTTFText($image, $size, $angle, $x, $y - (int)($size / 15), $color, $this->TTF_file, $text);
            imagefttext($image, $size, $angle, $x, $y - (int)($size / 15), $color, $this->TTF_file, $text);
            $x += (int)($size + ($this->minsize / 5));
        }
        @ImageJPEG($image, $this->get_filename(), $this->jpegquality);
        $res = file_exists($this->get_filename());
        if($this->debug) echo "\n<br>-Captcha-Debug: Save Image with quality [".$this->jpegquality.'] as ('.$this->get_filename().') returns: ('.($res ? 'TRUE' : 'FALSE').')';
        @ImageDestroy($image);
        if($this->debug) echo "\n<br>-Captcha-Debug: Destroy Imagestream.";
        if(!$res) die('Unable to save captcha-image.');
    }

    private function makeWebsafeColors(&$image) {
    //$a = array();
        for($r = 0; $r <= 255; $r += 51) {
            for($g = 0; $g <= 255; $g += 51) {
                for($b = 0; $b <= 255; $b += 51) {
                    $color = imagecolorallocate($image, $r, $g, $b);
                //$a[$color] = array('r'=>$r,'g'=>$g,'b'=>$b);
                }
            }
        }
        if($this->debug) echo "\n<br>-Captcha-Debug: Allocate 216 websafe colors to image: (".imagecolorstotal($image).')';
    //return $a;
    }

    private function random_color($min,$max) {
        $this->r = intval(mt_rand($min,$max));
        $this->g = intval(mt_rand($min,$max));
        $this->b = intval(mt_rand($min,$max));
    //echo ' ('.$this->r.'-'.$this->g.'-'.$this->b.') ';
    }

    private function change_TTF() {
        if(is_array($this->TTF_RANGE)) {
            $key = array_rand($this->TTF_RANGE);
            $this->TTF_file = $this->TTF_folder.$this->TTF_RANGE[$key];
        }
        else {
            $this->TTF_file = $this->TTF_folder.$this->TTF_RANGE;
        }
        return $this->TTF_file;
    }


    private function check_captcha($correct_hash,$attempt) {
    // when check, destroy picture on disk
        if(file_exists($this->get_filename($correct_hash))) {
            $res = @unlink($this->get_filename($correct_hash)) ? 'TRUE' : 'FALSE';
            if($this->debug) echo "\n<br>-Captcha-Debug: Delete image (".$this->get_filename($correct_hash).") returns: ($res)";
        }
        // print substr(md5($attempt),0,7).'('.$attempt.')---'.$correct_hash;
        $res = ((string)substr(md5($attempt),0,7)===$correct_hash) ? 'TRUE' : 'FALSE';
        if($this->debug) echo "\n<br>-Captcha-Debug: Comparing public with private key returns: ($res)";
        return $res == 'TRUE' ? TRUE : FALSE;
    }


    private function get_filename($public='') {
        if (!isset($public)) $public=$this->public_key;
        if($public=='') $public=$this->public_key;
        return $this->tempfolder.$this->filename_prefix.$public.'.jpg';
    }


    private function get_filename_url($public="") {
        if (!isset($public)) $public=$this->public_key;
        if($public=='') $public = $this->public_key;
        return str_replace($_SERVER['DOCUMENT_ROOT'],'',$this->tempfolder).$this->filename_prefix.$public.'.jpg';
    }

    private function get_gd_version() {
        if (!function_exists('imagejpeg')) {
            $gd_version_number = 0;
        } else {
            static $gd_version_number = null;
            if($gd_version_number === null) {
                ob_start();
                phpinfo(8);
                $module_info = ob_get_contents();
                ob_end_clean();
                if(preg_match("/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i", $module_info, $matches)) {
                    $gd_version_number = $matches[1];
                }
                else {
                    $gd_version_number = 0;
                }
            }
        }
        return $gd_version_number;
    }

    public function generate_keypair() {
        $key = '';
        $this->chars = mt_rand($this->minchars,$this->maxchars);
        for($i=0; $i < $this->chars; $i++) {
            $key .= $this->validchars{mt_rand(0,strlen($this->validchars) - 1)};
        }
        if($this->case_sensitive==0) $key = strtoupper($key);
        $this->public_key = substr(md5($key),0,7);
        if($this->debug) echo "\n<br>-Captcha-Debug: Generate Keys, private key is: (".$key.')';
        if($this->debug) echo "\n<br>-Captcha-Debug: Generate Keys, public key is: (".$this->public_key.')';
        return $key;
    }

    public function txt_counter($filename,$add=FALSE,$fixvalue=FALSE) {
        if(is_file($filename) ? TRUE : touch($filename)) {
            if(is_readable($filename) && is_writable($filename)) {
                $fp = @fopen($filename, 'r');
                if($fp) {
                    $counter = (int)trim(fgets($fp));
                    fclose($fp);

                    if($add) {
                        if($fixvalue !== FALSE) {
                            $counter = (int)$fixvalue;
                        }
                        else {
                            $counter++;
                        }
                        $fp = @fopen($filename, 'w');
                        if($fp) {
                            fputs($fp,$counter);
                            fclose($fp);
                            return $counter;
                        }
                        else return FALSE;
                    }
                    else {
                        return $counter;
                    }
                }
                else return FALSE;
            }
            else return FALSE;
        }
        else return FALSE;
    }

    public function collect_garbage() {
        $OK = FALSE;
        $captchas = 0;
        $trashed = 0;
        if($handle = @opendir($this->tempfolder)) {
            $OK = TRUE;
            while(false !== ($file = readdir($handle))) {
                if(!is_file($this->tempfolder.$file)) continue;
                // check for name-prefix, extension and filetime
                if(substr($file,0,strlen($this->filename_prefix)) == $this->filename_prefix) {
                    if(strrchr($file, '.') == '.jpg') {
                        $captchas++;
                        if((time() - filemtime($this->tempfolder.$file)) >= $this->maxlifetime) {
                            $trashed++;
                            $res = @unlink($this->tempfolder.$file);
                            if(!$res) $OK = FALSE;
                        }
                    }
                }
            }
            closedir($handle);
        }
        if($this->debug) echo "\n<br>-Captcha-Debug: There are ($captchas) captcha-images in tempfolder, where ($trashed) are seems to be lost.";
        return $OK;
    }


    

}