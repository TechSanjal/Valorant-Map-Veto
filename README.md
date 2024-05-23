# Valorant Map Pick and Ban System

A web application for managing and displaying Valorant map picks and bans between two teams. This project is built using PHP and JavaScript and can be hosted on a PHP-enabled server.

## Features

- Enter and save team names.
- Pick or ban maps for each team.
- Display the results of the map picks and bans.
- Reset team names and map choices.
- Dynamic updates with animations for the latest choices.

## Installation

### Prerequisites

- A web server with PHP support (e.g., Apache, Nginx).
- PHP 7.0 or later.

### Setup

1. Clone the repository to your web server's root directory:

   ```bash
   git clone https://github.com/TechSanjal/valorant-map-pick-ban.git
   cd valorant-map-pick-ban
   ```

2. Ensure the web server has write permissions to the project directory to allow PHP to create and modify `teams.json` and `choices.json` files.

## Usage

### Enter Team Names

1. Open `index.php` in your browser.
2. Enter the names of Team 1 and Team 2.
3. Click "Save Team Names" to save the team names and proceed to the map pick/ban form.

### Pick/Ban Maps

1. Select the team, action (Pick or Ban), and the map.
2. If the action is "Pick", select the opponent's side (Attack or Defense).
3. Click "Submit" to save the choice.
4. Choices will be stored and can be reset using the "Reset Choices" button.

### View Results

1. Open `display.php` in your browser to view the results of the map picks and bans.
2. The display will automatically refresh every 5 seconds to show the latest choices.

### Reset Data

- Use the "Reset Team Names" button to clear the saved team names.
- Use the "Reset Choices" button to clear the saved map choices.
- Use the "Reset All" button to clear both team names and map choices.

## File Structure

/path/to/your/project/
├── index.php
├── display.php
├── saveTeams.php
├── resetTeams.php
├── getTeams.php
├── submitChoice.php
├── resetChoices.php
├── getChoices.php
├── teams.json (auto-generated)
├── choices.json (auto-generated)

## Contributing

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -m 'Add some feature'`).
5. Push to the branch (`git push origin feature-branch`).
6. Open a Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact

If you have any questions or suggestions, please feel free to contact me at [hello@wiser.com.np].

---

Thank you for using the Valorant Map Pick and Ban System! Enjoy your matches!
