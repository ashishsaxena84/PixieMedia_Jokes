<?php

namespace PixieMedia\Jokes\Cron;

class Joke
{
	protected $logger;

	public function __construct(
		\Psr\Log\LoggerInterface $loggerInterface
	) {
		$this->logger = $loggerInterface;
	}

	public function execute() {

	    $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('jokes');
        // start api calling
        $service_url = 'https://api.chucknorris.io/jokes/search?query=beard';
        $handle = curl_init();

        curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($handle, CURLOPT_URL, $service_url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

        $apiResult = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        $resultObjts = json_decode($apiResult, true);

        if($resultObjts['total']){
            foreach ($resultObjts['result'] as $key => $data) {

                $id         = $data['id'];
                $value      = $data['value'];
                $url        = $data['url'];
                $icon_url   = $data['icon_url'];
                $updated_at = $data['updated_at'];
                $created_at = $data['created_at'];    

                $query = $connection->select()->from($tableName,['joke_id'])->where('id = ?', $id);
                
                $fetchData = $connection->fetchRow($query);

                if(empty($fetchData['joke_id'])){

                    $sql = "INSERT INTO $tableName SET ";
                    $sql .= "id = :ID, ";
                    $sql .= "value = :VALUE, ";
                    $sql .= "url = :URL, ";
                    $sql .= "icon_url = :ICONURL, ";
                    $sql .= "updated_at = :UPDATEDAT, ";
                    $sql .= "created_at = :CREATEDAT";
                    $binds = array(
                        'ID' => $id,
                        'VALUE' => $value,
                        'URL' => $url,
                        'ICONURL' => $icon_url,
                        'UPDATEDAT' => $updated_at,
                        'CREATEDAT' => $created_at
                    );
                }else{
                    
                    $sql = "UPDATE $tableName SET ";
                    $sql .= "id = :ID, ";
                    $sql .= "value = :VALUE, ";
                    $sql .= "url = :URL, ";
                    $sql .= "icon_url = :ICONURL, ";
                    $sql .= "updated_at = :UPDATEDAT, ";
                    $sql .= "created_at = :CREATEDAT";
                    $sql .= " WHERE joke_id = :JOKEID";
                    $binds = array(
                        'ID' => $id,
                        'VALUE' => $value,
                        'URL' => $url,
                        'ICONURL' => $icon_url,
                        'UPDATEDAT' => $updated_at,
                        'CREATEDAT' => $created_at,
                        'JOKEID' => $fetchData['joke_id']
                    );   
                }
                
                $connection->query($sql, $binds);       

            } 
        }

	}
}