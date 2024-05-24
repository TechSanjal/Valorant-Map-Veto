<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valorant Map Pick and Ban</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: #0f1923;
            color: #ece8e1;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #1f2b38;
            border-radius: 8px;
            padding: 20px;
            max-width: 800px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .valorant-title {
            font-family: 'Oswald', sans-serif;
            font-size: 3rem;
            color: #ff4655;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .input,
        .select {
            background: #2c3e50;
            border: none;
            color: #ece8e1;
        }

        .input::placeholder {
            color: #bdc3c7;
        }

        .btn {
            transition: background-color 0.3s ease;
        }

        .btn-blue {
            background-color: #3498db;
        }

        .btn-blue:hover {
            background-color: #2980b9;
        }

        .btn-red {
            background-color: #e74c3c;
        }

        .btn-red:hover {
            background-color: #c0392b;
        }

        .btn-yellow {
            background-color: #f1c40f;
        }

        .btn-yellow:hover {
            background-color: #d4ac0d;
        }

        .selected-map {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container mx-auto py-10">
        <h1 class="valorant-title mb-8 text-center">Valorant Map Pick and Ban System</h1>
        <div id="team-names-form" class="mb-8">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="team1" class="block">Team 1:</label>
                    <input type="text" id="team1" class="input w-full px-4 py-2 mt-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Team 1 Name">
                </div>
                <div>
                    <label for="team2" class="block">Team 2:</label>
                    <input type="text" id="team2" class="input w-full px-4 py-2 mt-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Team 2 Name">
                </div>
            </div>
            <div class="flex justify-between">
                <button onclick="saveTeamNames()" class="btn btn-blue text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save Team Names</button>
                <button onclick="resetTeamNames()" class="btn btn-red text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Reset Team Names</button>
            </div>
        </div>

        <div id="map-pick-ban-form" class="hidden">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="team" class="block">Team:</label>
                    <select id="team" class="select w-full px-4 py-2 mt-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></select>
                </div>
                <div>
                    <label for="action" class="block">Action:</label>
                    <select id="action" class="select w-full px-4 py-2 mt-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="updateSideSelect()">
                        <option value="Pick">Pick</option>
                        <option value="Ban">Ban</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="map" class="block">Map:</label>
                    <select id="map" class="select w-full px-4 py-2 mt-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Bind">Bind</option>
                        <option value="Sunset">Sunset</option>
                        <option value="Split">Split</option>
                        <option value="Ascent">Ascent</option>
                        <option value="Icebox">Icebox</option>
                        <option value="Breeze">Breeze</option>
                        <option value="Lotus">Lotus</option>
                    </select>
                </div>
                <div>
                    <label for="side" class="block">Opponent Side:</label>
                    <select id="side" class="select w-full px-4 py-2 mt-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" disabled>
                        <option value="Attack">Attack</option>
                        <option value="Defense">Defense</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-between">
                <button onclick="submitChoice()" class="btn btn-blue text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                <button onclick="resetChoices()" class="btn btn-red text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Reset Choices</button>
                <button onclick="resetAll()" class="btn btn-yellow text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Reset All</button>
            </div>
        </div>
    </div>

    <script>
        function saveTeamNames() {
            const team1 = document.getElementById('team1').value;
            const team2 = document.getElementById('team2').value;

            if (team1 && team2) {
                fetch('saveTeams.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ team1, team2 })
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        localStorage.setItem('team1', team1);
                        localStorage.setItem('team2', team2);
                        loadTeams();
                        document.getElementById('team-names-form').classList.add('hidden');
                        document.getElementById('map-pick-ban-form').classList.remove('hidden');
                    } else {
                        alert('Failed to save team names.');
                    }
                });
            } else {
                alert('Please enter both team names.');
            }
        }

        function resetTeamNames() {
            fetch('resetTeams.php', {
                method: 'POST'
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    document.getElementById('team1').value = '';
                    document.getElementById('team2').value = '';
                    document.getElementById('team-names-form').classList.remove('hidden');
                    document.getElementById('map-pick-ban-form').classList.add('hidden');
                    localStorage.removeItem('team1');
                    localStorage.removeItem('team2');
                } else {
                    alert('Failed to reset team names.');
                }
            });
        }

        function loadTeams() {
            const team1 = localStorage.getItem('team1');
            const team2 = localStorage.getItem('team2');

            if (team1 && team2) {
                const teamSelect = document.getElementById('team');
                teamSelect.innerHTML = `
                    <option value="${team1}">${team1}</option>
                    <option value="${team2}">${team2}</option>
                `;
            }
        }

        function updateSideSelect() {
            const action = document.getElementById('action').value;
            const sideSelect = document.getElementById('side');
            sideSelect.disabled = (action === 'Ban');
        }

        function submitChoice() {
            const team = document.getElementById('team').value;
            const action = document.getElementById('action').value;
            const map = document.getElementById('map').value;

            const oppositeTeam = (team === localStorage.getItem('team1')) ? localStorage.getItem('team2') : localStorage.getItem('team1');
            const side = action === 'Pick' ? document.getElementById('side').value : '';

            const choice = { team, action, side: action === 'Pick' ? side : '', map, oppositeTeam: action === 'Pick' ? oppositeTeam : '' };
            fetch('submitChoice.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(choice)
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    alert('Choice Submitted!');
                    document.querySelector(`option[value="${map}"]`).classList.add('selected-map');
                } else {
                    alert('Failed to submit choice.');
                }
            });
        }

        function resetChoices() {
            fetch('resetChoices.php', {
                method: 'POST'
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    alert('Choices Reset!');
                    document.querySelectorAll('.selected-map').forEach(el => el.classList.remove('selected-map'));
                } else {
                    alert('Failed to reset choices.');
                }
            });
        }

        function resetAll() {
            resetTeamNames();
            resetChoices();
            alert('All data reset!');
        }

        window.onload = function () {
            const team1 = localStorage.getItem('team1');
            const team2 = localStorage.getItem('team2');

            if (team1 && team2) {
                loadTeams();
                document.getElementById('team-names-form').classList.add('hidden');
                document.getElementById('map-pick-ban-form').classList.remove('hidden');
            }
        }
    </script>
</body>

</html>
