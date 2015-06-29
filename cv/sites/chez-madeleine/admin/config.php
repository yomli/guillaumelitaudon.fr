<?php if($cm->isLogged()){ ?>
<h3>Configuration</h3>
<div id="content-admin">
	<form method="post" action="index.php?config">
		<fieldset>
			<legend>Connexion</legend>
			<label for="user_login">Identifiant : </label><input type="text" name="user_login" id="user_login" value="<?php echo $cm->user_login;?>"/><br />
			<label for="user_password">Mot de passe : </label><input type="text" name="user_password" id="user_password" value="<?php echo $cm->user_password;?>"/><br />
		</fieldset>
		<fieldset>
			<legend>Site</legend>
			<label for="cm_title">Sous-titre : </label><input type="text" name="cm_title" id="cm_title" value="<?php echo $cm->cm_title;?>"/><br />
			<label for="cm_description">Description : </label><textarea rows="5" name="cm_description" id="cm_description"><?php echo $cm->cm_description;?></textarea><br />
			<label for="cm_keywords">Mots-clés : </label><input type="text" name="cm_keywords" id="cm_keywords" value="<?php echo $cm->cm_keywords;?>"/><br />	
		</fieldset>
		<fieldset>
			<legend>Mentions légales</legend>
			<p>La loi du 21 juin 2004 oblige les sites internet français à informer les internautes. Les entreprises doivent mentionner « leur dénomination ou leur raison sociale et leur siège social, leur numéro de téléphone et, s'il s'agit d'entreprises assujetties aux formalités d'inscription au registre du commerce et des sociétés ou au répertoire des métiers, le numéro de leur inscription, leur capital social, l'adresse de leur siège social » (à inscrire dans le champ <i>Propriétaire</i></p>
			<label for="cm_webmaster">Webmaster : </label><input type="text" name="cm_webmaster" id="cm_webmaster" value="<?php echo $cm->cm_webmaster;?>"/><br />
			<p></p>
			<label for="cm_proprietaire">Propriétaire : </label><textarea rows="5" name="cm_proprietaire" id="cm_proprietaire"><?php echo $cm->cm_proprietaire;?></textarea><br />
			<label for="cm_hebergeur">Hébergeur : </label><input type="text" name="cm_hebergeur" id="cm_hebergeur" value="<?php echo $cm->cm_hebergeur;?>"/><br />	
		</fieldset>
 <p><input type="submit" name="save" value="Enregistrer" class="submit"/></p>
</form>

<?php } ?>