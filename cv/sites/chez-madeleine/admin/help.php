<?php if($cm->isLogged()){ ?>
<h3>Aide</h3>
<div id="content-admin">
<p>Je veux…
	<ul>
		<li><a href="#configurerSite">Configurer mon site <span style="font-family:'Chez Madeleine', Georgia, serif;font-size:1.4em;font-weight:normal">Chez Madeleine</span></a></li>
		<ul>
			<li><a href="#modifierIdentifiants">Modifier mes identifiants de connexion</a></li>
			<li><a href="#positionnerSite">Positionner au mieux mon site dans les moteurs de recherche</a></li>
		</ul>
		<li><a href="#majPages">Mettre à jour les pages de mon site <span style="font-family:'Chez Madeleine',Georgia,serif;font-size:1.4em;font-weight:normal">Chez Madeleine</span></a></li>
			<ul>
				<li><a href="#titre">Insérer un titre</a></li>
				<li><a href="#image">Insérer une image</a></li>
				<li><a href="#video">Insérer une vidéo/de l'audio/une animation Flash</a></li>
				<li><a href="#abreviation">Donner une explication succinte au visiteur</a></li>
				<li><a href="#font">Écrire avec la police <span style="font-family:'Chez Madeleine', Georgia, serif;font-size:1.4em;font-weight:normal">Chez Madeleine</span></a></li>
				<li><a href="#ancres">Faire un menu tel que celui-ci</a></li>
			</ul>
		<li><a href="#contact">Contacter le développeur de mon site</a></li>
	</ul>
</p>
<h4><a href="" name="configurerSite"></a>Configurer mon site <span style="font-family:'Chez Madeleine', Georgia, serif;font-size:1.4em;">Chez Madeleine</span></h4>
<p>L'accès à la configuration du site se fait via le lien <a href="index.php?config" title="Accès à la configuration">Configuration</a> du menu d'administration sur votre droite.</p>

<h5><a href="" name="modifierIdentifiants"></a>Modifier mes identifiants de connexion</h5>
<p>Vous pouvez aisément modifier vos identifiants de connexion via la page de <a href="index.php?config" title="Accès à la configuration">Configuration</a> en rectifiant les champs <i>Identifiant</i> et <i>Mot de passe</i>. Vos identifiants actuels sont : <b><?php echo $cm->user_login;?></b> avec le mot de passe <b><?php echo $cm->user_password;?></b>.</p>

<h5><a href="" name="positionnerSite"></a>Positionner au mieux mon site dans les moteurs de recherche</h5>
<p>Les moteurs de recherche tiennent compte de deux champs stockés dans les pages web : les balises meta <i>description</i> et <i>keywords</i>. Vous pouvez configurer ces balises depuis la page de <a href="index.php?config" title="Accès à la configuration">Configuration</a> en modifiant les champs <i>Description</i> et <i>Mots-clés</i> respectivement.</p>
<p>La description du site sera alors utilisée lors de l'affichage du résultat dans un moteur de recherche. Les mots-clés, quant à eux, servent à renseigner le moteur de recherche sur les termes les plus propices à mener vers votre site. Ils doivent être séparés par des virgules.</p>

<h4><a href="" name="majPages"></a>Mettre à jour les pages de mon site <span style="font-family:'Chez Madeleine', Georgia, serif;font-size:1.4em;">Chez Madeleine</span></h4>
<p>Mettre à jour les pages de votre site se fait en trois étapes :
	<ol>
		<li>Accédez à la page que vous souhaitez mettre à jour ;</li>
		<li>Cliquez sur le contenu à modifier, une barre d'outils apparait alors ;</li>
		<li>Changez le contenu, puis cliquez sur l'icone <img src="admin/images/enregistrer.png" alt="Enregistrer" />.</li>
	</ol>
Vous pouvez simplement déplacer horizontalement la barre d'outils avec la souris pour qu'elle ne cache par le contenu à modifier.
</p>

<h5><a href="" name="titre"></a>Insérer un titre</h5>
<p>Sélectionnez votre texte, puis cliquez sur le menu déroulant <img src="admin/images/paragraphe.png" alt="Paragraphe" /> pour choisir un <i>Titre</i>. Il y a plusieurs niveaux de titres, allant par ordre décroissant de 1 à 6. Pour des raisons de cohérence sémantique, il est conseillé de ne pas insérer de titres en-dessous du niveau 3 compris, puisque le niveau 1 est utilisé pour le titre du site, le niveau 2 pour son sous-titre et le niveau 3 pour le titre des pages.</p>

<h5><a href="" name="image"></a>Insérer une image</h5>
<p>Positionnez le curseur à l'endroit désiré, puis cliquez sur l'icone <img src="admin/images/image.png" alt="Insérer/éditer l'image" />. Une boite de dialogue s'ouvre alors.</p>
<p>Pour <i>uploader</i> une image depuis votre ordinateur, cliquez sur l'icone <img src="admin/images/parcourir.png" alt="Parcourir" />. Une seconde boite de dialogue s'ouvre. Cliquez sur <img src="admin/images/chargerfichier.png" alt="Charger un fichier" /> puis en face de la ligne <img src="admin/images/fichier.png" alt="Choisissez votre(vos) fichier(s):" />. Choisissez votre image, patientez lors de son upload, puis cliquez sur le bouton <img src="admin/images/fermer.png" alt="fermer" />. Il ne vous reste plus qu'à choisir votre image dans la galerie et cliquer sur le bouton <img src="admin/images/inserer1.png" alt="Insérer" />. Vous remarquerez alors que le champ <i>URL de l'image</i> de la boite de dialogue <i>Insérer/éditer une image</i> est rempli. Il suffit alors de cliquer sur le bouton <img src="admin/images/inserer2.png" alt="Insérer" /> pour incorporer l'image.</p>
<br />
<p>Pour des raisons de temps de chargement du site, il est recommandé de ne pas uploader d'images de taille supérieure à 800 par 600 pixels. Sauf exception, une image en 640 par 480 pixels est amplement suffisante pour vos visiteurs. Rappelons également qu'une image redimensionnée depuis l'interface de votre site ne perd pas en poids, seul son affichage change.</p>

<h5><a href="" name="video"></a>Insérer une vidéo/de l'audio/une animation Flash</h5>
<p>Cliquez sur l'icone <img src="admin/images/media.png" alt="Insérer un média incorporé" />. Une boite de dialogue s'ouvre, il suffit de cliquer sur l'onglet <i>Source</i> et d'y coller le code <span style="font-variant:small-caps;">html</span> fourni par la plateforme vidéo/audio/flash.</p><br />
<p>Exemple : la vidéo Youtube disponible <a href="http://www.youtube.com/watch?v=f-7idLc-Xak" title="Georges Brassens - La Mauvaise Réputation">ici</a> offre, par le biais du bouton <i>Intégrer</i> le code suivant :

<pre>
&lt;iframe width="420" height="315" <br />src="http://www.youtube.com/embed/f-7idLc-Xak"<br />
frameborder="0" allowfullscreen&gt;&lt;/iframe&gt;
</pre>

Ce code, une fois collé dans l'onglet <i>Source</i>, affichera la vidéo ainsi :
</p>
<iframe width="420" height="315" src="http://www.youtube.com/embed/f-7idLc-Xak" frameborder="0" allowfullscreen></iframe>

<h5><a href="" name="abreviation"></a>Donner une explication succinte au visiteur</h5>
<p>Il est possible de donner une courte explication au visiteur par le biais des abréviations. Sélectionnez du texte, puis cliquez sur l'icone, une boite de dialogue s'ouvre. Renseignez le champ <i>Titre</i> pour enfin cliquer sur le bouton <img src="admin/images/inserer2.png" alt="Insérer" />.</p><br />
<p>Exemple d'utilisation :<br />
<pre>Faux-filet sauté sauce <abbr title="Vin rouge de Toscane">Chianti</abbr> sur lit de purée.</pre>
</p>

<h5><a href="" name="font"></a>Écrire avec la police <span style="font-family:'Chez Madeleine', Georgia, serif;font-size:1.4em;">Chez Madeleine</span></h5>
<p>La police <span style="font-family:'Chez Madeleine', Georgia, serif;font-size:1.4em;">Chez Madeleine</span> peut être utilisée via l'icone <img src="admin/images/style.png" alt="Éditer la feuille de style (CSS)" /> une fois le texte sélectionné. Dans la boite de dialogue qui s'ouvre, il suffit de remplir le champ <i>Police</i> avec la <i>(valeur)</i> :
<pre>
'Chez Madeleine', Georgia, serif
</pre>
Comme la police <span style="font-family:'Chez Madeleine', Georgia, serif;font-size:1.4em;">Chez Madeleine</span> semble posséder une <abbr title="Hauteur du tracé d'un caractère bas-de-casse">hauteur d'x</abbr> plus petite que la police Georgia utilisée sur le reste du site, il est recommandé de changer également sa taille dans la boite de dialogue à <b>1.4em</b> afin qu'elle reste pleinement lisible.<br />
À noter : il ne faut pas se soucier du fait que la police ne semble pas changer dans l'interface d'administration. Si les étapes précédentes ont été respectées, la police apparaitra bien pour les visiteurs. Il suffit de se déconnecter de l'administration pour s'en apercevoir.
</p>

<h5><a href="" name="ancres"></a>Faire un menu tel que celui de cette page</h5>
<p>Ce menu est un simple menu à ancres. Il est réalisable en 8 étapes :
	<ol>
		<li>Créez une liste avec l'icone <img src="admin/images/liste.png" alt="Liste à puces" />, ce sera votre menu ;</li>
		<li>Insérez le texte de la page, en y incluant des titres correspondant à votre menu ;</li>
		<li>Placez le curseur devant un titre, cliquez sur l'icone <img src="admin/images/ancre.png" alt="Insérer/éditer une ancre" />;</li>
		<li>Tapez un texte quelconque dans le champ <i>Nom de l'ancre</i>, il s'agit simplement d'une étiquette. Attention toutefois à ne pas taper deux fois le même nom d'ancre ;</li>
		<li>Recommencez les étapes 3 et 4 pour chaque titre ;</li>
		<li>Sélectionnez un item de votre menu, cliquez sur l'icone <img src="admin/images/lien.png" alt="Insérer/éditer le lien" />;</li>
		<li>Dans le champ <i>URL du lien</i>, tapez le nom de l'ancre correspondante précédé d'un dièse (exemple : <b>#test</b>) ;</li>
		<li>Recommencez les étapes 6 et 7 pour chaque item du menu.</li>
	</ol>
</p>

<h4><a href="" name="contact"></a>Contacter le développeur de mon site</h4>
<p>Pour toute question supplémentaire, Guillaume <span style="font-variant:small-caps;">Litaudon</span> reste à votre disposition à l'adresse <br /><a href="mailto:guillaume.litaudon@gmail.com" title="">guillaume.litaudon@gmail.com</a><br />
14, rue du Beuvron<br />
41120 Ouchamps.</p>
<?php } ?>
