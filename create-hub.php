<?php
// Voeg hier de autoloader en eventuele benodigde bestanden toe
require_once 'classes/HubManager.php';

// Zorg ervoor dat de HubManager klasse beschikbaar is
$hubManager = new HubManager();

// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aanname: je hebt formuliervelden 'hub_id' en 'hub_data'
    $hubId = $_POST['hub_id'] ?? null;
    $hubData = $_POST['hub_data'] ?? null;
    
   // Controleer of de hub ID en data zijn ingevuld
    if ($hubId && $hubData) {
      // Probeer de hub aan te maken
        try {
            $hubManagers->createHub($hubId, $hubData);
            echo "Hub '{$hubId}' is succesvol aangemaakt.";
            // Voer hier eventuele andere acties uit, zoals het doorsturen van de gebruiker naar een andere pagina
        } catch (Exception $e) {
            // Log eventuele fouten en geef een foutmelding weer
            error_log($e->getMessage());
            echo "Er is een fout opgetreden bij het aanmaken van de hub.";
        }
    } else {
        echo "Hub ID en data zijn vereist.";
    }
} else {
   
    ?>
    <form action="create-hub.php" method="post">
        Hub Name: <input type="text" name="hub_id">
        Hub Location: <textarea name="hub_data"></textarea>
        <input type="submit" value="Create Hub">
    </form>
    <?php
}
