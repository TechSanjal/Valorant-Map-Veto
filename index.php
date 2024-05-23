<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valorant Map Pick and Ban</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-semibold mb-8 text-center">Valorant Map Pick and Ban System</h1>
        <div id="team-names-form" class="mb-8">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="team1" class="block text-gray-700">Team 1:</label>
                    <input type="text" id="team1"
                        class="w-full px-4 py-2 mt-1 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter Team 1 Name">
                </div>
                <div>
                    <label for="team2" class="block text-gray-700">Team 2:</label>
                    <input type="text" id="team2"
                        class="w-full px-4 py-2 mt-1 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter Team 2 Name">
                </div>
            </div>
            <div class="flex justify-between">
                <button onclick="saveTeamNames()"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save
                    Team Names</button>
                <button onclick="resetTeamNames()"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Reset
                    Team Names</button>
            </div>
        </div>

        <div id="map-pick-ban-form" class="hidden">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="team" class="block text-gray-700">Team:</label>
                    <select id="team"
                        class="w-full px-4 py-2 mt-1 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"></select>
                </div>
                <div>
                    <label for="action" class="block text-gray-700">Action:</label>
                    <select id="action"
                        class="w-full px-4 py-2 mt-1 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        onchange="updateSideSelect()">
                        <option value="Pick">Pick</option>
                        <option value="Ban">Ban</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="map" class="block text-gray-700">Map:</label>
                    <select id="map"
                        class="w-full px-4 py-2 mt-1 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="Bind">Bind</option>
                        <option value="Haven">Haven</option>
                        <option value="Split">Split</option>
                        <option value="Ascent">Ascent</option>
                        <option value="Icebox">Icebox</option>
                        <option value="Breeze">Breeze</option>
                        <option value="Fracture">Fracture</option>
                    </select>
                </div>
                <div>
                    <label for="side" class="block text-gray-700">Opponent Side:</label>
                    <select id="side"
                        class="w-full px-4 py-2 mt-1 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        disabled>
                        <option value="Attack">Attack</option>
                        <option value="Defense">Defense</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-between">
                <button onclick="submitChoice()"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                <button onclick="resetChoices()"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Reset
                    Choices</button>
                <button onclick="resetAll()"
                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Reset
                    All</button>
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
                } else {
                    alert('Failed to reset team names.');
                }
            });
        }

        function loadTeams() {
            fetch('getTeams.php').then(response => response.json()).then(data => {
                if (data.team1 && data.team2) {
                    const teamSelect = document.getElementById('team');
                    teamSelect.innerHTML = `
                        <option value="${data.team1}">${data.team1}</option>
                        <option value="${data.team2}">${data.team2}</option>
                    `;
                }
            });
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
            fetch('getTeams.php').then(response => response.json()).then(data => {
                if (data.team1 && data.team2) {
                    loadTeams();
                    document.getElementById('team-names-form').classList.add('hidden');
                    document.getElementById('map-pick-ban-form').classList.remove('hidden');
                }
            });
        }
    </script>
</body>

</html>
