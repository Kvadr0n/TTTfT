var params = new URLSearchParams(window.location.search);

const name = document.getElementById("name");
name.innerHTML = params.get('name_user');

var avatar = document.getElementById('avatar');
avatar.src = "/demo/infrastructure/HTTPhandler.php?request=getAvatar&name_user=" + params.get('name_user');

var graph = document.getElementById('graph');
graph.src = "/demo/infrastructure/HTTPhandler.php?request=visualiseStats&name_user=" + params.get('name_user');

var formAction = document.getElementById('formAction');
formAction.action = "/demo/infrastructure/HTTPhandler.php?request=updateAvatar&name_user=" + params.get('name_user');

var hostUser = document.getElementById('hostUser');
hostUser.value = params.get("name_user");

var joinUser = document.getElementById('joinUser');
joinUser.value = params.get("name_user");

const skins = document.getElementById("skins");

var showSkins = new XMLHttpRequest();
showSkins.onload = function()
{
	skins.innerHTML = this.responseText;
}
showSkins.open("GET", '/demo/infrastructure/HTTPhandler.php?name_user=' + params.get('name_user') + '&request=showSkins');
showSkins.send();

const stats = document.getElementById("stats");

var showStats = new XMLHttpRequest();
showStats.onload = function()
{
	stats.innerHTML = this.responseText;
}
showStats.open("GET", '/demo/infrastructure/HTTPhandler.php?name_user=' + params.get('name_user') + '&request=showStats');
showStats.send();

function updateSkin(id_skin)
{
	var updateSkin = new XMLHttpRequest();
	updateSkin.onload = function()
	{
		showSkins.open("GET", '/demo/infrastructure/HTTPhandler.php?name_user=' + params.get('name_user') + '&request=showSkins');
		showSkins.send();
	}
	updateSkin.open("GET", '/demo/infrastructure/HTTPhandler.php?name_user=' + params.get('name_user') + '&request=updateSkin&id_skin=' + id_skin);
	updateSkin.send();
}

function exit()
{
	window.location.replace("/demo/authorization");
}