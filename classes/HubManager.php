
<?php
require_once 'interfaces/iHub.php';
class HubManagers {
    private $hubs = [];
// Create hub
    public function createHub($id, $data) {
        $this->hubs[$id] = new HubLocation($id, $data);
        echo "Hub '{$id}' created successfully.\n";
    }
// Remove hub
    public function removeHub($id) {
        if (isset($this->hubs[$id])) {
            unset($this->hubs[$id]);
            echo "Hub '{$id}' removed successfully.\n";
        } else {
            echo "Hub '{$id}' not found.\n";
        }
    }
    // Get hub data
    public function getHubData($id) {
        if (isset($this->hubs[$id])) {
            return $this->hubs[$id]->data;
        } else {
            return "Hub '{$id}' not found.\n";
        }
    }
}
