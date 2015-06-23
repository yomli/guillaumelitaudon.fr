<?php if(!defined('PLX_ROOT')) exit; ?>

<h2>Aide</h2>
<h3>Fichier d&#039;aide du plugin Advanced Search</h3>
<h4>Introduction</h4>
<p>Il y a un paramétrage optionel à faire afin de personaliser le fonctionnement. Sinon il suffit d'appeler le hook de la recherche rapide</p>
<p>Le plugin nécessite javascript.</p>
<h4>Paramètres</h4>
<ul>
<li>URL : l'adresse pour appeler la page de recherche multicritere et la page de résultat. Par défaut "search". C'est a dire "votresite"/search </li>
<li>TEMPLATE : nom du template utilisé par la page de recherche multicritere. Par défaut static.php</li>
<li>TITLE : Titre de la page de recherche. Par défaut "Recherche"</li>
<li>MAXTAG : Le nombre maximum de tags affiché dans la page de recherche. Par défaut 50. Laisser vide pour ne pas avoir de limite et afficher tous les tags</li>
<li>YEARFROM : Année de départ pour la liste déroulante des années de recherche. Laisser vide pour que le plugin recherche l'année du premier article</li>
<li>YEARTO : Année de fin pour la liste déroulante des années de recherche. Laisser vide pour que le plugin prenne l'année en cours</li>
</ul>

<h4>Mise en place</h4>
<p>Le hook a utiliser pour afficher le champ de recherche rapide est </p>
<pre>
&lt;?php eval($plxShow->callHook('quick_display')); ?&gt;
</pre>

<p>Il est également possible d'afficher la recherche multicritère sur la page de son choix avec le hook suivant :</p>
<pre>
&lt;?php eval($this->callHook('advsearch_display')); ?&gt;
</pre>