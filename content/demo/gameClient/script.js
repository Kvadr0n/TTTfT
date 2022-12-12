var params = new URLSearchParams(window.location.search);

const name = document.getElementById("name");
name.innerHTML = params.get('name_user');

var avatar = document.getElementById('avatar');
avatar.src = "/demo/infrastructure/HTTPhandler.php?request=getAvatar&name_user=" + params.get('name_user');

const nameEnemy = document.getElementById("nameEnemy");

var avatarEnemy = document.getElementById('avatarEnemy');

var namePlayerOne_user = "";
var namePlayerTwo_user = params.get('name_user');

const field = document.getElementById('field');

var firstTime = true;

var updateGame = new XMLHttpRequest();
updateGame.onload = function()
{
	if (this.responseText != "NULL")
	{
		avatarEnemy.src = "/demo/infrastructure/HTTPhandler.php?request=getAvatar&name_user=" + this.responseText;
		nameEnemy.innerHTML = this.responseText;
		namePlayerOne_user = this.responseText;
		this.open("GET", '/demo/infrastructure/HTTPhandler.php?name_game='+ params.get('name_game') + '&pass_game=' + params.get('pass_game') + '&request=updateGame&status=player2&namePlayerOne_user=' + namePlayerOne_user + '&namePlayerTwo_user=' + namePlayerTwo_user);
		this.onload = function()
		{
			if (firstTime)
				firstTime = false;
			else
				field.innerHTML = this.responseText;
			this.open("GET", '/demo/infrastructure/HTTPhandler.php?name_game='+ params.get('name_game') + '&pass_game=' + params.get('pass_game') + '&request=updateGame&status=player2&namePlayerOne_user=' + namePlayerOne_user + '&namePlayerTwo_user=' + namePlayerTwo_user);
			if (field.innerHTML.substring(5, 12) == "Победил")
			{
				clearInterval(timer);
				var updateStats = new XMLHttpRequest();
				updateStats.onload = function(){};
				if (field.innerHTML.substring(13, 13 + params.get('name_user').length) == params.get('name_user'))
				{
					updateStats.open("GET", '/demo/infrastructure/HTTPhandler.php?request=updateStats&res=win&name_user=' + params.get('name_user'));
					updateStats.send();
				}
				else
				{
					updateStats.open("GET", '/demo/infrastructure/HTTPhandler.php?request=updateStats&res=loss&name_user=' + params.get('name_user'));
					updateStats.send();
				}
				setTimeout(() => window.location.replace("/demo/home/?name_user=" + params.get('name_user')), 5000);
			}
		}
	}
	this.open("GET", '/demo/infrastructure/HTTPhandler.php?name_game='+ params.get('name_game') + '&pass_game=' + params.get('pass_game') + '&request=updateGame&status=joined');
}
updateGame.open("GET", '/demo/infrastructure/HTTPhandler.php?name_game='+ params.get('name_game') + '&pass_game=' + params.get('pass_game') + '&request=updateGame&status=joined');
updateGame.send();

var timer = setInterval(() => updateGame.send(), 1000);

var makeTurn = new XMLHttpRequest();

makeTurn.onload = function(){}

function setTile(x, y)
{
	makeTurn.open("GET", '/demo/infrastructure/HTTPhandler.php?name_game='+ params.get('name_game') + '&pass_game=' + params.get('pass_game') + '&request=updateGame&status=turn2&x=' + x + '&y=' + y + '&namePlayerOne_user=' + namePlayerOne_user + '&namePlayerTwo_user=' + namePlayerTwo_user);
	makeTurn.send();
}