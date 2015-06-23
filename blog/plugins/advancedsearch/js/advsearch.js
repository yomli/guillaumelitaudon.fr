// adjsearch.js
// compatible IE8, Chrome, FF 3.5, Opera 10, Safari 4
var searchpool = document.getElementById("searchpool");
var searchlist = document.getElementById("searchlist");
var searchresults = document.getElementById("searchresultbox");
var searchresultnb = document.getElementById("searchresultnb");
var recherche = [];

divtags = searchpool.getElementsByTagName("div");
for(i=0;i<divtags.length;i++){
  divid = divtags[i].id.substring(0,7);
  if (divid=='sp-tags'){
    taglist = divtags[i].getElementsByTagName("span");
    for(j=0;j<taglist.length;j++)
      taglist[j].onclick=add_tag_click;
    delete taglist;
  }else if (divid=='sp-cats'){
    taglist = divtags[i].getElementsByTagName("span");
    for(j=0;j<taglist.length;j++)
      taglist[j].onclick=add_cat_click;
    delete taglist;
  }
  delete divid;
}
delete divtags;

document.getElementById("btn_add_date").onclick=add_date_click;
document.getElementById("btn_add_text").onclick=add_text_click;

// Décembre par défaut pour le mois de fin
document.getElementById("sp-date-to").selectedIndex=11;
document.getElementById("sp-date-to-y").value=new Date().getFullYear();

// snippet pour afficher l'image X de suppression d'une sélection
//var html_img_del = '<img src="/data/images/search_delete.png" alt="Supprimer" onclick="del_search(this)" onmouseover="this.parentNode.className=\'hover\'" onmouseout="this.parentNode.className=\'\' "class="sl-del">';
//var html_img_ou = '<img src="/data/images/search_ou.png" alt="ou" onclick="switch_search(this)" class="sl-ou" onmouseover="this.src=\'/data/images/search_et.png\'" onmouseout="this.src=\'/data/images/search_ou.png\'">';
//<img src="/data/images/search_et.png" alt="et" class="sl-et">
var html_img_del = '<div onclick="del_search(this)" onmouseover="this.parentNode.className=\'hover\'" onmouseout="this.parentNode.className=\'\' "class="sl-del"></div>';
var html_img_ou = '<div onclick="switch_search(this)" class="sl-ou" onmouseover="this.className=\'sl-ou hover\'" onmouseout="this.className=\'sl-ou\'"></div>';
var html_img_et = '<div class="sl-et"></div>';
var xmlhttp;
if (window.XMLHttpRequest) {
  xmlhttp = new XMLHttpRequest();
} else { // code for IE6, IE5
  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange = function() {
  if (xmlhttp.readyState == 4 ) {
    if(xmlhttp.status == 200){
      display_results(xmlhttp.responseText);
      searchresults.parentNode.className="";
    }else{ //if(xmlhttp.status == 400) {
      searchresults.parentNode.className="error";
      searchresults.innerHTML="Une erreur est survenue pendant la recherche";
    }
  }
}  //function xmlhttp.onreadystatechange
    
function go_search(){
  searchresultnb.innerHTML = '&nbsp;&nbsp;&nbsp;';
  searchresults.parentNode.className="loading";
  
  xmlhttp.open("POST", "index.php?ajax_advsearch", true);
  xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xmlhttp.send('q='+JSON.stringify(recherche));
} //function go_search

function display_results(results){
  searchresults.parentNode.style.display = 'block';
  var contenu = [];
  //results = eval("(function(){return " + results + ";})()");
  if (results && results!=''){
    results = JSON.parse(results);
  }
  if (!results || results == '' || results.length==0){
    searchresults.innerHTML = 'Aucun résultat pour cette recherche';
    searchresultnb.innerHTML = '0';
    return false;
  }

  searchresultnb.innerHTML = results.length - 1;
  for (i=1;i<results.length;i++){
    template = (results[i].tpl)?results[i].tpl:results[0].tpl;
    template = template.replace('#art_date',results[i].date);
    template = template.replace('#art_title',results[i].title);
    template = template.replace('#art_url',results[i].url);
    if (results[i].vignette) template = template.replace('#art_vignette',results[i].vignette);
    if (results[i].chapo) template = template.replace('#art_chapo',results[i].chapo);
    contenu.push(template);
  } //for (i=0;i<results.length;i++)
  searchresults.innerHTML = contenu.join('');
} //function display_results

function add_text_click(obj){
var target = (obj && obj.target)?obj.target:window.event.srcElement;
var textfield = document.getElementById("sp-text-i");
if (textfield.value=='') return;
  add_search(target.parentNode.id,
             textfield.value,
             textfield.value);
} //function add_text_click

function add_date_click(obj){
  var target = (obj && obj.target)?obj.target:window.event.srcElement;
  var select_from = document.getElementById("sp-date-from");
  var select_from_y = document.getElementById("sp-date-from-y");
  var select_to = document.getElementById("sp-date-to");
  var select_to_y = document.getElementById("sp-date-to-y");
  if (select_from.value==select_to.value && select_from_y.value==select_to_y.value){
  add_search(target.parentNode.id,
             ''+select_from_y.value+select_from.value+'-'+select_to_y.value+select_to.value,
             'en '+select_from.options[select_from.selectedIndex].text+' '+select_from_y.options[select_from_y.selectedIndex].text);  
  }else{
  add_search(target.parentNode.id,
             ''+select_from_y.value+select_from.value+'-'+select_to_y.value+select_to.value,
             'de '+select_from.options[select_from.selectedIndex].text+' '+select_from_y.options[select_from_y.selectedIndex].text+' à '+select_to.options[select_to.selectedIndex].text+' '+select_to_y.options[select_to_y.selectedIndex].text);
  }
} //function add_date_click

function add_tag_click(obj){
  var target = (obj && obj.target)?obj.target:window.event.srcElement;
  add_search(target.parentNode.id,target.innerHTML,target.innerHTML);
} //function add_tag_click

function add_cat_click(obj){
  var target = obj.target || window.event.srcElement;
  add_search(target.parentNode.id,target.getAttribute("catid"),target.innerHTML);
} //function add_cat_click

function get_cat_label(cat){
  switch(cat.substring(0,7)){
    case 'sp-tags':
      label=(cat=='sp-tags')?'Mot clé':cat.substring(8).replace('_',' ');
      break;
    case 'sp-cats':
      label='Catégorie';
      break;    
    case 'sp-date':
      label='Publié';
      break;      
    case 'sp-text':
      label='Contenant';
      break;      
    default:
      label='yu???';
  };
  return label;
}

function add_search(cat,valeur,label){
itemid=-1;
// Affichage du bloc si masqué
searchlist.style.display = 'block';

// recherche si déja une ligne
  found = false;
  for(i=recherche.length-1;i>=0;i--)
    if(recherche[i] && recherche[i].cat==cat){
      itemid=i;

// Check si valeur déja présente
      for(j=0;j<recherche[i].values.length;j++)
        if (recherche[i].values[j] == valeur)
          return false;  
    
      break; //exit for
    }

// Catégorie non présente, nouvelle ligne
    if (itemid<0){
      itemid = recherche.length;
// Recherche du libellé de la catégorie
      cat_label = get_cat_label(cat);  
  
      recherche[itemid] = {cat:cat, labels:[],values:[]};
      searchlist.innerHTML+='<div id="sl-div-'+itemid+'">'+html_img_et+'<div class="sl-lbl">'+cat_label+' :</div><span class="sl-itm" itemid="'+itemid+','+recherche[itemid].values.length+'"><span>'+label+html_img_del+'</span></span></div>';    

// Catégorie déja présente, on append
    }else{
      document.getElementById('sl-div-'+itemid).innerHTML+='<span class="sl-itm" itemid="'+itemid+','+recherche[itemid].values.length+'">'+html_img_ou+'<span>'+label+html_img_del+'</span></span>';    
    }
    recherche[itemid].values.push(valeur);
    recherche[itemid].labels.push(label);

// Résultats correspondants
    go_search();
} //function add_search

function switch_search(obj2){
  obj = obj2.parentNode;
  itemid_old = obj.getAttribute('itemid').split(',');
  itemid_new = recherche.length;
  recherche[itemid_new] = {cat:recherche[itemid_old[0]].cat, labels:[],values:[]};

  cat_label = get_cat_label(recherche[itemid_new].cat);

  recherche[itemid_new].values.push(recherche[itemid_old[0]].values[itemid_old[1]]);
  recherche[itemid_new].labels.push(recherche[itemid_old[0]].labels[itemid_old[1]]);

  del_search(obj2,true);

  searchlist.innerHTML+='<div id="sl-div-'+itemid_new+'">'+html_img_et+'<div class="sl-lbl">'+cat_label+' :</div><span class="sl-itm" itemid="'+itemid_new+',0"><span>'+recherche[itemid_new].labels[0]+html_img_del+'</span></span></div>';
} //function switch_search

function del_search(obj,parent){
  parent = parent || false;
  if (!parent)
    obj = obj.parentNode;
  obj = obj.parentNode;
  var parent = obj.parentNode;
  var itemid = obj.getAttribute('itemid').split(',');
  
// Suppression de l'élément du dom
  parent.removeChild(obj);

// Nettoyage variable recherche
  if (recherche[itemid[0]].labels.length==1){
    delete recherche[itemid[0]];
  }else{
    delete recherche[itemid[0]].labels[itemid[1]];
    var reste = false;
    for(i=0;i<recherche[itemid[0]].labels.length;i++)
      if (recherche[itemid[0]].labels[i])
        reste = true;
    if (reste){
      delete recherche[itemid[0]].values[itemid[1]];
    }else{
      delete recherche[itemid[0]];
    }
  }
  
// Si plus d'élément sur la cat, suppression de la cat
  if (parent.getElementsByTagName('span').length<=1){
    parent.parentNode.removeChild(parent);
    // Recherche si plus d'éléments du tout on masque les div searchlist et searchresult
    if (searchlist.getElementsByTagName('div').length==0){
      recherche = [];
      searchlist.style.display='none';
      searchresult.style.display='none';
      return false;
    }
  }
  
// Résultats correspondants  
  go_search();
} //function del_search