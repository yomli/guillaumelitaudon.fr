<?php
$MYPAGER_INFO = <<<EOT
		<sup>*</sup>Le nombre maxi de boutons affichés est égal à : 2 x delta + 3.
			</p><p>
				<sup>**</sup>Pour mieux contrôler l'emplacement du navigateur dans le flux de la page HTML, le code suivant peut être utilisé pour les thèmes dans les scripts article*.php :
			</p>
<code>
&lt;?php eval(\$plxShow->callHook('showArticlesBar')); ?&gt;
</code>
			<p>
				Sinon il sera inséré en fin de page.
EOT;

$LANG = array(
'L_MYPAGER_DELTA'=>'Valeur delta (<i>compris entre 1 et 10</i>)<sup>*</sup>',
'L_MYPAGER_BUTTONS'=>'Afficher les boutons &lt;&lt; et &gt;&gt;',
'L_MYPAGER_DISPLAY_PAGE'=>'Afficher le mot Page',
'L_MYPAGER_DIRECT_PAGE'=>'Saisir un n° de page',
'L_MYPAGER_DIRECT_PAGE_LABEL'=>'Aller à la page',
'L_MYPAGER_PAGE'=>'Pages ',
'L_MYPAGER_INFO'=>$MYPAGER_INFO,
'L_MYPAGER_NUMBER_ERROR'=>'Le numéro de page doit être compris entre 2 et ',
'L_MYPAGER_ARTICLES_NAVIGATOR'=>'Activer le navigateur d\'articles<sup>**</sup>',
'L_MYPAGER_FIRST_PAGE'=>"Vous êtes déjà sur la première page !",
'L_MYPAGER_LAST_PAGE'=>"Vous êtes déjà sur la dernière page !"
);
?>
