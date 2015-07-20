<?php
if(isset($_POST["contact-username"]) && isset($_POST["contact-email"]) && isset($_POST["contact-message"])) {

	$mail = "guillaume.litaudon@gmail.com";
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
		$passage_ligne = "\r\n";
	else
		$passage_ligne = "\n";

	$message_txt = $_POST["contact-message"] . "\n" . $_POST["contact-username"] . "\n" . $_POST["contact-website"];
	$message_html = "<html><head></head><body>".$_POST["contact-message"]."<br />".$_POST["contact-username"]."<br />".$_POST["contact-website"]."</body></html>";


	$boundary = "-----=".md5(rand());
	if(isset($_POST["contact-subject"]))
		$sujet = "[guillaumelitaudon.fr] : " . $_POST["contact-subject"];
	else
		$sujet = "[guillaumelitaudon.fr] : Un nouveau message du site guillaumelitaudon.fr";

	if($_POST["contact-username"] && !preg_match( "/[\r\n]/", $_POST["contact-email"])) {
        $contactEmail = "From: " . $_POST["contact-email"];     
    } else {
        $contactEmail = "From: " . $mail; 
    }

	$header = "From: \"".$_POST["contact-username"]."\"<".$contactEmail.">".$passage_ligne;
	$header.= "Reply-to: \"".$_POST["contact-username"]."\" <".$contactEmail.">".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

	$message = $passage_ligne."--".$boundary.$passage_ligne;
	$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_txt.$passage_ligne;
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;

	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

	if(isset($_POST["contact-url"]) && $_POST["contact-url"] == '') {
		if(mail($mail,$sujet,$message,$header))
			echo "Votre message a été envoyé.";
		else
			echo "Votre message n'a pas été envoyé.";		
	} else {
		echo "Votre message a été envoyé.";
	}

}
else {
	echo "Votre message n'a pas été envoyé, vous avez oublié de remplir un champ du formulaire.";
}
?>
