<?php

class chezMadeleineConfig
{
    public $file = 'userconfig.php';

    public function __construct()
    {
        $this->file = CM_DATAS . $this->file;
    }

    public function save(){
	$datas = array(
                'user_login' => $_POST['user_login'],
                'user_password' => $_POST['user_password'],
				'cm_description' => $_POST['cm_description'],
				'cm_title' => $_POST['cm_title'],
				'cm_keywords' => $_POST['cm_keywords'],
				'cm_proprietaire' => $_POST['cm_proprietaire'],
				'cm_webmaster' => $_POST['cm_webmaster'],	
				'cm_hebergeur' => $_POST['cm_hebergeur']	
            );

	return $datas;

    }

    public function write($datas)
    {
        $out = '<?php if (!class_exists("chezMadeleineConfig")) die("just config");';
        $out.= "\n";

        foreach ($datas as $key=>$value)
        {
            $value = strtr($value, array('$' => '\\$', '"' => '\\"'));
            $out .= '$cm->'.$key.' = "'.$value."\";\n";
        }

        $out.= '?>';

        if (!@file_put_contents($this->file, $out))
            return false;

        return true;
    }
}

?>
