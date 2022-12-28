const skins = document.getElementById("skins");
var showSkins = new XMLHttpRequest();
showSkins.onload = function()
{
	skins.innerHTML = this.responseText;
}

function updateSkin(id_skin)
{
	var updateSkin = new XMLHttpRequest();
	updateSkin.onload = function()
	{
		showSkins.open("GET", '/real/infrastructure/HTTPhandler.php?request=showSkins');
		showSkins.send();
	}
	updateSkin.open("GET", '/real/infrastructure/HTTPhandler.php?request=updateSkin&id_skin=' + id_skin);
	updateSkin.send();
}

function exit()
{
	window.location.replace("/real/authorization");
}

var getSession = new XMLHttpRequest();
getSession.onload = function()
{
	var params = JSON.parse(this.responseText);
	main(params);
}
getSession.open("GET", '/real/infrastructure/HTTPhandler.php?request=$_SESSION');
getSession.send();

function main(params)
{
	const name = document.getElementById("name");
	name.innerHTML = params.name_user;

	var avatar = document.getElementById('avatar');
	avatar.src = "/real/infrastructure/HTTPhandler.php?request=getAvatar";

	var graph = document.getElementById('graph');
	graph.src = "/real/infrastructure/HTTPhandler.php?request=visualiseStats";

	var formAction = document.getElementById('formAction');
	formAction.action = "/real/infrastructure/HTTPhandler.php?request=updateAvatar";

	var hostUser = document.getElementById('hostUser');
	hostUser.value = params.name_user;

	var joinUser = document.getElementById('joinUser');
	joinUser.value = params.name_user;

	const skins = document.getElementById("skins");

	showSkins.open("GET", '/real/infrastructure/HTTPhandler.php?request=showSkins');
	showSkins.send();

	const stats = document.getElementById("stats");

	var showStats = new XMLHttpRequest();
	showStats.onload = function()
	{
		stats.innerHTML = this.responseText;
	}
	showStats.open("GET", '/real/infrastructure/HTTPhandler.php?request=showStats');
	showStats.send();
}