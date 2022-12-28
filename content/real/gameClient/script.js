var makeTurn = new XMLHttpRequest();

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

	const nameEnemy = document.getElementById("nameEnemy");

	avatarEnemy = document.getElementById('avatarEnemy');

	namePlayerOne_user = "";
	namePlayerTwo_user = params.name_user;

	const field = document.getElementById('field');

	var firstTime = true;

	var updateGame = new XMLHttpRequest();
	updateGame.onload = function()
	{
		if (this.responseText != "NULL")
		{
			avatarEnemy.src = "/real/infrastructure/HTTPhandler.php?request=getAvatar&name_user=" + this.responseText;
			nameEnemy.innerHTML = this.responseText;
			namePlayerOne_user = this.responseText;
			this.open("GET", '/real/infrastructure/HTTPhandler.php?request=updateGame&status=player2&namePlayerOne_user=' + namePlayerOne_user + '&namePlayerTwo_user=' + namePlayerTwo_user);
			this.onload = function()
			{
				if (firstTime)
					firstTime = false;
				else
					field.innerHTML = this.responseText;
				this.open("GET", '/real/infrastructure/HTTPhandler.php?request=updateGame&status=player2&namePlayerOne_user=' + namePlayerOne_user + '&namePlayerTwo_user=' + namePlayerTwo_user);
				if (field.innerHTML.substring(5, 12) == "Победил")
				{
					clearInterval(timer);
					var updateStats = new XMLHttpRequest();
					updateStats.onload = function(){};
					if (field.innerHTML.substring(13, 13 + params.name_user.length) == params.name_user)
					{
						updateStats.open("GET", '/real/infrastructure/HTTPhandler.php?request=updateStats&res=win');
						updateStats.send();
					}
					else
					{
						updateStats.open("GET", '/real/infrastructure/HTTPhandler.php?request=updateStats&res=loss');
						updateStats.send();
					}
					setTimeout(() => window.location.replace("/real/home"), 5000);
				}
				else
				if (field.innerHTML.substring(5, 11) == "Ничья!")
				{
					clearInterval(timer);
					setTimeout(() => window.location.replace("/real/home"), 5000);
				}
			}
		}
		this.open("GET", '/real/infrastructure/HTTPhandler.php?request=updateGame&status=joined');
	}
	updateGame.open("GET", '/real/infrastructure/HTTPhandler.php?request=updateGame&status=joined');
	updateGame.send();

	var timer = setInterval(() => updateGame.send(), 1000);

	var makeTurn = new XMLHttpRequest();

	makeTurn.onload = function(){}
}

function setTile(x, y)
{
	makeTurn.open("GET", '/real/infrastructure/HTTPhandler.php?request=updateGame&status=turn2&x=' + x + '&y=' + y + '&namePlayerOne_user=' + namePlayerOne_user + '&namePlayerTwo_user=' + namePlayerTwo_user);
	makeTurn.send();
}