<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valorant Map Pick and Ban - Results</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <!-- Importing a similar font -->
    <style>
        @font-face {
            font-family: 'Montserrat';
            src: url('https://fonts.cdnfonts.com/s/12002/BurbankBigCondensed-Bold.woff') format('woff');
            /* Use actual Valorant font if available */
        }

        body {
            font-family: 'Montserrat', sans-serif;
            /* Fallback font */
            background: transparent;
            /* Make the background transparent */
        }

        .map-box {
            position: relative;
            overflow: hidden;
            border-radius: 0.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 12vw;
            height: 20vw;
            max-width: 200px;
            max-height: 300px;
            background: url('https://images.prismic.io/rivalryglhf/3965b309-0510-4285-8aab-596753ed6ec9_Valorant-Maps.webp') no-repeat center center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-family: 'Montserrat', 'Oswald', sans-serif;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .map-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0.5rem;
            display: none;
            /* Hide initially */
        }

        .map-info {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            color: white;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            /* Hide initially */
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .map-info .team {
            margin-top: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 1rem;
        }

        .map-info .side {
            margin-bottom: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.7rem;
        }

        .map-name {
            display: none;
            /* Hide initially */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        /* Animation for data change */
        .animate-change {
            animation: bounceIn 1s ease forwards;
            /* Ensure animation plays only once */
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }

            50% {
                opacity: 1;
                transform: scale(1.05);
            }

            70% {
                transform: scale(0.9);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body class="text-white">
    <div class="container mx-auto py-10">
        <h1 class="text-5xl font-bold mb-12 text-center">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-yellow-500"></span>
        </h1>
        <div id="maps-container" class="flex flex-nowrap justify-center gap-4 overflow-x-auto">
            <!-- 7 map boxes with default states -->
            <?php
            for ($i = 0; $i < 7; $i++) {
                echo '<div class="map-box" data-map="">
                    <img src="" alt="">
                    <div class="map-info">
                        <div class="team"></div>
                        <div class="side"></div>
                        <div class="map-name"></div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <script>
        const mapsData = {
            "Lotus": "https://wiser.com.np/map/maps/Loading_Screen_Lotus.webp",
            "Bind": "https://wiser.com.np/map/maps/Loading_Screen_Bind.webp",
            "Split": "https://wiser.com.np/map/maps/Loading_Screen_Split.webp",
            "Ascent": "https://wiser.com.np/map/maps/Loading_Screen_Ascent.webp",
            "Icebox": "https://wiser.com.np/map/maps/Loading_Screen_Icebox.webp",
            "Breeze": "https://wiser.com.np/map/maps/Loading_Screen_Breeze.webp",
            "Sunset": "https://wiser.com.np/map/maps/Loading_Screen_Sunset.webp",
            "Fracture":"https://wiser.com.np/map/maps/Loading_Screen_Fracture.webp"
        };

        let previousChoices = [];

        function loadChoices() {
            fetch('getChoices.php')
                .then(response => response.json())
                .then(choices => {
                    console.log('Choices received:', choices); // Log the received choices
                    const container = document.getElementById('maps-container');

                    choices.forEach(choice => {
                        let mapBox = Array.from(container.children).find(box => box.dataset.map === choice.map);

                        if (!mapBox) {
                            // Use the next available empty map box
                            mapBox = Array.from(container.children).find(box => box.dataset.map === "");
                            mapBox.dataset.map = choice.map;
                        }

                        if (mapBox) {
                            const imgEl = mapBox.querySelector('img');
                            const teamEl = mapBox.querySelector('.team');
                            const sideEl = mapBox.querySelector('.side');
                            const mapNameEl = mapBox.querySelector('.map-name');

                            console.log('Updating map box:', {
                                map: choice.map,
                                team: choice.team,
                                action: choice.action,
                                side: choice.side,
                                oppositeTeam: choice.oppositeTeam
                            });

                            imgEl.src = mapsData[choice.map];
                            imgEl.alt = choice.map;
                            imgEl.style.display = 'block';
                            mapNameEl.textContent = choice.map;
                            mapNameEl.style.display = 'block';
                            teamEl.textContent = `${choice.team} ${choice.action === 'Pick' ? 'picked' : 'banned'}`;
                            sideEl.textContent = choice.action === 'Pick' ? `${choice.oppositeTeam} chose ${choice.side}` : '';
                            mapBox.querySelector('.map-info').style.opacity = 1; // Show the map info
                            mapBox.style.background = 'none'; // Remove the gradient background

                            // Check if the choice is new or updated
                            const isUpdated = !previousChoices.some(prev => 
                                prev.map === choice.map && 
                                prev.team === choice.team && 
                                prev.action === choice.action && 
                                prev.side === choice.side && 
                                prev.oppositeTeam === choice.oppositeTeam
                            );

                            if (isUpdated) {
                                // Add animation class for the updated map box
                                mapBox.classList.add('animate-change');

                                // Remove the animation class after the animation completes
                                mapBox.addEventListener('animationend', () => {
                                    mapBox.classList.remove('animate-change');
                                }, { once: true }); // Ensure the event listener is removed after it runs
                            }
                        }
                    });

                    // Update previous choices
                    previousChoices = JSON.parse(JSON.stringify(choices));
                })
                .catch(error => console.error('Error fetching choices:', error));
        }

        window.onload = function () {
            loadChoices();
            setInterval(loadChoices, 5000); // Refresh every 5 seconds
        }
    </script>
</body>

</html>
