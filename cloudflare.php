<?php
/**
 * Developed by: Mahdi Hazaveh <mahdi@hazaveh.net>
 * Date: 8/18/16
 * Time: 12:25 PM
 */


class CloudFlareController {

    public $client;
    public $zones = [];
    public $dns = [];


    public function __construct($email, $api)
    {
        $this->client = new Cloudflare\Api($email, $api);
        $this->getZones();
        //$this->getDNS($this->zones);
        //dump($this->client);
    }

    public function getZones() {
        $zones = new Cloudflare\Zone($this->client);
        //dump($zones->zones(null,null,null,1000));
        $zones = $zones->zones(null,null,null,1000)->result;
        $this->setZones($zones);
        return $zones;

    }

    public function getDNS($zones, $originalIP, $newIP) {
        $dns = new Cloudflare\Zone\Dns($this->client);
        $changesToBeMade = [];
        foreach ($zones as $zone) {
            $records = $dns->list_records($zone, null, null, $originalIP);
            if (!empty($records->result)) {
                //dump($records->result);
                foreach($records->result as $item) {
                    $changesToBeMade[] = [
                        'type' => $item->type,
                        'name' => $item->name,
                        'oldIP' => $item->content,
                        'newIP' => $newIP
                    ];
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode($changesToBeMade);

    }

    public function setZones($zones){
        foreach ($zones as $zone) {
            $this->zones[] = $zone->id;
        }
    }

    public function doReplace($zones, $originalIP, $newIP, $logLocation){
        $dns = new Cloudflare\Zone\Dns($this->client);
        foreach ($zones as $zone) {
            $records = $dns->list_records($zone, null, null, $originalIP);
            if (!empty($records->result)) {
                //dump($records->result);
                foreach($records->result as $item) {
                    //dump($item);
                    $dns->update($item->zone_id, $item->id, $item->type, $item->name, $newIP, $item->ttl, $item->proxied, null, null);
                    $this->log($logLocation, $item, $newIP);
                    sleep(1);
                }
            }
        }
    }

    public function log($location, $record, $newip) {
        $log = '[' . date("Y-m-d H:i:s") . ']: changing ' . $record->name . ' ip from ' . $record->content . ' to ' . $newip . PHP_EOL;
        file_put_contents($location . '/log.log', $log, FILE_APPEND);
    }


}