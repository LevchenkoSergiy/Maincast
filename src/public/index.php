<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати турнір</title>
</head>
<body>
<h1>Додати турнір</h1>
<form action="TournamentHandler.php" method="post">
    <label for="title">Назва турніру:</label><br/>
    <input type="text" id="title" name="title" required><br/><br/>

    <label for="gameType">Тип гри:</label><br/>
    <select id="gameType" name="gameType" required>
        <option value="CS:GO">CS:GO</option>
        <option value="DOTA2">DOTA2</option>
        <option value="Valorant">Valorant</option>
    </select><br/><br/>

    <label for="stage">Стадія турніру:</label><br/>
    <select id="stage" name="stage" required>
        <option value="Contenders">Contenders</option>
        <option value="Main stage">Main stage</option>
        <option value="Playoffs">Playoffs</option>
        <option value="Final">Final</option>
    </select><br/><br/>

    <label for="prizePool">Prize pool:</label><br/>
    <input type="number" id="prizePool" name="prizePool" step="0.01" required><br/><br/>

    <label for="isLive">Live:</label><br/>
    <input type="checkbox" id="isLive" name="isLive"><br/><br/>

    <label for="description">Опис турніру:</label><br/>
    <textarea id="description" name="description" rows="5" cols="33" required></textarea><br/><br/>

    <label for="startDate">Дата початку турніру:</label><br/>
    <input type="date" id="startDate" name="startDate" required><br/><br/>

    <label for="endDate">Дата завершення турніру:</label><br/>
    <input type="date" id="endDate" name="endDate" required><br/><br/>

    <label for="url">Посилання на детальнішу інформацію:</label><br/>
    <input type="url" id="url" name="url"><br/><br/>

    <button type="submit">Надіслати</button>
</form>
</body>
</html>
