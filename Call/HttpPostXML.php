<?php
/**
 * Created by PhpStorm.
 * User: Ahmad
 * Date: 8/8/2016
 * Time: 4:05 PM
 */

namespace Lsw\ApiCallerBundle\Call;


class HttpPostXML extends CurlCall implements ApiCallInterface
{
    /**
     * {@inheritdoc}
     */
    public function generateRequestData()
    {
        //dump($this->requestObject[0]);exit;
        return $this->requestObject[0];
    }

    /**
     * {@inheritdoc}
     */
    public function parseResponseData()
    {
        if($this->asAssociativeArray) {
            $xml = simplexml_load_string($this->responseData);
            $json = json_encode($xml);
            $this->responseObject = json_decode( $json, TRUE );
        } else {
            $this->responseObject = $this->responseData;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function makeRequest($curl, $options)
    {

        $curl->setopt(CURLOPT_URL, $this->url);
        $curl->setopt(CURLOPT_POST, 1);
        $curl->setopt(CURLOPT_POSTFIELDS, $this->generateRequestData());

        $curl->setoptArray($options);
        $this->curlExec($curl);
    }

}
